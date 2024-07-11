<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\UserPackage;
use App\Traits\UserPackageTrait;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use stdClass;

class UserPackageController extends Controller
{
    // traits 
    use UserPackageTrait;

    // class variables
    private $response;
    private $_lang_path =  "api/api_v1/subscription.";
    private $_app_mode = User::test;

    public function __construct(Request $request)
    {
        $app_mode = strtolower($request->header('App-Mode'));
        $this->_app_mode = ($app_mode == User::live) ? User::live : User::test;
    }

    private function validationData()
    {
        // validation request data
        return [
            'receipt' => 'required',
            'product_id' => 'required',
            'order_id' => 'required',
            'platform' => 'required|integer|in:0,1',
            'price' => 'required|integer'
        ];
    }


    public function purchaseSubscription(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validationData());
        if ($validator->fails()) {
            $this->response['message'] = $validator->errors()->first();
            return response()->json($this->response, 200);
        }
        try {
            $user = auth()->user();
            // if user already purchased then return from here wih already purchased message
            if ($user->account_status == User::purchased) {
                $this->response['message'] = trans($this->_lang_path . "already_paid");
                return ($this->response);
            }

            // ------------for android user------------------
            if ($request->platform == UserPackage::ANDROID_PLATFORM) {
                $response_data = $this->verifyAndroidReceipt($request->receipt, $request->product_id);
            }
            // ios payment process
            else if ($request->platform == UserPackage::IOS_PLATFORM) {
                $ios_url = '';
                $ios_key = '';
                if ($this->_app_mode == User::live) {
                    $ios_url = config('payment.ios_live_url');
                    $ios_key = config('payment.live_ios_secret');
                } else {
                    $ios_url = config('payment.ios_test_url');
                    $ios_key = config('payment.test_ios_secret');
                }
                $response_data = $this->getIosScriptData($ios_url, $request->receipt, $ios_key);
            } else {
                $this->response['status'] = 1;
                $this->response['message'] = trans($this->_lang_path . "not_valid_platform");
                return response($this->response, 200);
            }


            /**
             * if package verified then we need add the user package details and change the user status sto paid
             */
            if ($response_data == true) {
                $user->account_status = User::purchased;
                $user->save();
                $package_details = [
                    'user_id' => $user->id,
                    'receipt' => $request->receipt,
                    'price' => $request->price,
                    'product_id' => $request->product_id,
                    'app_mod' => $this->_app_mode,
                    'platform' => $request->platform,
                    'order_id' => $request->order_id,
                ];

                UserPackage::create($package_details);
                $this->_response['status'] = 1;
                $this->_response['message'] = trans($this->_lang_path . "package_purchased");
                return response($this->_response, 200);
            } else {
                $this->_response['status'] = 0;
                $this->_response['message'] = trans($this->_lang_path . 'cannot_validate_receipt');
                return response($this->_response, 200);
            }
        } catch (\Exception $ex) {
            $this->_response['message'] = trans($this->_lang_path . 'something_went_wrong');
            return response($this->_response, 500);
        }
    }

    private function getIosScriptData($ios_url, $receipt, $ios_key)
    {
        $ch = curl_init($ios_url);
        $data_string = json_encode(array(
            'receipt-data' => $receipt,
            'password' => $ios_key,
            'exclude-old-transactions' => 1
        ));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string)
            )
        );
        $output = curl_exec($ch);
        curl_close($ch);
        $decoded = json_decode($output, TRUE);
        return $decoded;
    }


    /**
     * this function is used to verify the android reciept
     *
     * @param  string $receipt
     * @param string $product_id
     * @return void
     */
    private function verifyAndroidReceipt($receipt, $product_id = '')
    {
        $google_app_data = array(
            'grant_type' => 'refresh_token',
            'client_id' => config('payment.client_id'),
            'client_secret' => config('payment.client_secret'),
            'redirect_uri' => config('payment.redirect_uri'),
            'refresh_token' => config('payment.refresh_token'),
        );

        $api_access_token = $this->get_google_api_access_token($google_app_data);
        // if there is no access token then return false
        if ($api_access_token == false)
            return false;

        $package_detais = $this->get_purchase_details($product_id, config('payment.google_app_name'), $receipt, $api_access_token);
        if ($package_detais == false) {
            return false;
        }
        return true;
    }
}
