<?php

namespace App\Http\Controllers\API;

use App\Events\NewUserRegistredEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResourse;
use App\Mail\WebNewRegisterUserEmail;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Lcobucci\JWT\Parser;
use stdClass;

class UserController extends Controller
{
    private $lang_path = "api/api_v1/user.";
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
        if ($validator->fails()) {
            $this->response['message'] = $validator->errors()->first();
            return response()->json($this->response, 200);
        }
        try {

            $user_email = Str::lower($request->email);

            $user_check = User::where('email', $user_email)->first();
            if ($user_check) {
                // the user already exists
                $this->response['message'] = trans($this->lang_path . 'user_already_exist');
                return response($this->response, 200);
            }

            // if (isset($request['referral'])) {
            //     $referal_user_detail = User::where('referral', $request['referral'])->first();
            //     if (!$referal_user_detail) {
            //         $this->response['message'] = "Referral code invalid";
            //         return response($this->response, 200);
            //     }
            // }

            // set user trial over expire data
            //* get trial expiry date for the register user
            $app_trial_period = env('APP_TRIAL_DAYS', '5');
            $user_trial_expiry_date = Carbon::now()->addDays($app_trial_period);



            $user = User::create([
                'first_name' => $request['first_name'],
                'email' =>   $user_email,
                'status' => User::activeStatus,
                'account_status' => User::trial,
                'password' => Hash::make($request['password']),
                'trial_expiry_date' => $user_trial_expiry_date
            ]);

            //! created an event on register the user
            event(new NewUserRegistredEvent($user));

            // insert refreal history  
            // if ($request['referral']) {
            //     $this->insertReferralHistoryDetails($user->id, $referal_user_detail->id, $request['referral']);
            // }
            // insert user device details
            // $this->insertDeviceDetails($token, $request['id']);

            $token = $user->createToken('Api access token')->accessToken;
            return response(array(
                'data' => new UserResourse($user, $token),
                'status' => 1,
                'message' => trans($this->lang_path . 'user_registred')
            ), 200);
        } catch (\Exception $ex) {
            $this->response['message'] = trans($this->lang_path . 'something_went_wrong');
            return response($this->response, 500);
        }
    }



    /**
     * login the user
     * @param email
     * @param password
     * @return userResourse 
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $this->response['message'] = $validator->errors()->first();
            return response()->json($this->response, 200);
        }
        try {
            $user_email = Str::lower($request->email);

            if (Auth::attempt(['email' => $user_email, 'password' => request('password')])) {
                $user = User::where('email', $user_email)->first();

                //* if user have any previous token then delete then
                if ($user->AuthAccessToken) {
                    $user->AuthAccessToken()->delete();
                }
                // change user status if trial expired
                if (Carbon::now() > $user->trial_expiry_date && $user->account_status == User::inActiveStatus) {
                    $user->account_status = User::trialOver;
                    $user->save();
                }

                $token = $user->createToken('Api access token')->accessToken;
                $login_message = ($user->account_status == User::trialOver) ? trans($this->lang_path . 'trial_period_over') : trans($this->lang_path . 'success_login');

                return (new UserResourse($user, $token))->additional([
                    'status' => 1,
                    'message' => $login_message
                ]);
            } else {

                $this->response['message'] = trans($this->lang_path . 'incorrect_credentials');
                return response($this->response, 200);
            }
        } catch (\Exception $ex) {
            $this->response['message'] = trans($this->lang_path . 'something_went_wrong');
            return response($this->response, 500);
        }
    }



    /**
     * logout the user
     * @param requestToken
     * @return suceesMessage
     */
    public function logout(Request $request)
    {
        try {
            if (Auth::check()) {
                Auth::user()->AuthAccessToken()->delete();
                $this->response['status'] = 1;
                $this->response['message'] = trans($this->lang_path . 'loggeg_out');
                return response($this->response, 200);
            }
        } catch (\Exception $ex) {
            $this->response['message'] = trans($this->lang_path . 'something_wrong');
            return response($this->response, 500);
        }
    }

    /**
     * change the user password 
     * @param email
     * @return message
     */
    public function changePassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'password' => ['required'],
            'old_password' => ['required'],
        ]);
        if ($validator->fails()) {
            $this->response['message'] = $validator->errors()->first();
            return response()->json($this->response, 200);
        }
        try {
            $user = Auth::user();


            $old_password = $request['old_password'];
            if ($user) {
                if (!Hash::check($old_password, $user->password)) {
                    $this->response['message'] = trans($this->lang_path . 'old_password_not_matched');
                    return response($this->response, 200);
                }
            }
            $user->update(['password' => Hash::make($request['password'])]);
            $this->response['message'] = trans($this->lang_path . 'password_updated');
            $this->response['status'] = 1;
            return response()->json($this->response, 200);
        } catch (\Exception $ex) {
            $this->response['message'] = trans($this->lang_path . 'something_went_wrong');
            return response($this->response, 500);
        }
    }

    /**
     * this function used change password when user forgot about it
     * @param email
     * @return message
     */
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            $this->response['message'] = $validator->errors()->first();
            return response()->json($this->response, 200);
        }
        try {
            $random_password = Str::random(8);

            $user = User::where('email', $request['email'])->first();
            if (!$user) {
                $this->response['message'] =  trans($this->lang_path . 'user_not_found');
                return response($this->response, 200);
            }

            $user->update(['password' => Hash::make($random_password)]);


            Mail::send('emails/forgot-password-email', array('user' => $user, 'password' => $random_password), function ($message) use ($user) {
                $message->to($user->email)
                    ->subject(trans($this->lang_path . 'new_user_email_subject'));
            });

            $this->response['message'] = trans($this->lang_path . 'password_send_in_email');
            $this->response['status'] = 1;
            return response($this->response, 200);
        } catch (\Exception $ex) {
            $this->response['message'] = trans($this->lang_path . 'something_went_wrong');
            return response($this->response, 500);
        }
    }

    /**
     * check activation of the user
     */
    public function checkActivation(Request $request)
    {
        $user = Auth::user();
        $this->response['status'] = 1;
        $this->response['message'] = trans($this->lang_path . 'welcome_back');
        if ($user->status == User::trialOver) {
            $this->response['message'] = trans($this->lang_path . 'trial_period_over');
        }

        return (new UserResourse($user, $request->bearerToken()))->additional($this->response);
    }

    /**
     * register the user from web
     */

    public function webUserRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
        if ($validator->fails()) {
            $this->response['message'] = $validator->errors()->first();
            return response()->json($this->response, 200);
        }
        try {

            $user_email = Str::lower($request->email);

            $user_check = User::where('email', $user_email)->first();
            if ($user_check) {
                // the user already exists
                $this->response['message'] = trans($this->lang_path . 'user_already_exist');
                return response($this->response, 200);
            }

            //* get trial expiry date for the register user
            $app_trial_period = env('APP_TRIAL_DAYS', '5');
            $user_trial_expiry_date = Carbon::now()->addDays($app_trial_period);

            $user = User::create([
                'first_name' => $request['first_name'],
                'last_name' => ($request['last_name']) ? $request['last_name'] : "",
                'email' =>   $user_email,
                'status' => User::activeStatus,
                'account_status' => User::trial,
                'password' => Hash::make($request['password']),
                'referral' => Str::random(6),
                'location' => $request['location'],
                'otp' => Str::random(8),
                'trial_expiry_date' => $user_trial_expiry_date
            ]);
            // // created an event on register the user
            Mail::to($user->email)->send(new WebNewRegisterUserEmail($user, $request['password']));

            return [
                'status' => 1,
                'message' => trans($this->lang_path . 'user_registred')
            ];
        } catch (\Exception $ex) {
            $this->response['message'] = trans($this->lang_path . 'something_went_wrong');
            return response($this->response, 500);
        }
    }
}
