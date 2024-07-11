<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'email', 'status','account_status','password', 'trial_expiry_date'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    // user status
    const inActiveStatus = '0';
    const activeStatus = '1';

    // user payment status
    const trial = '0';
    const purchased = '1';
    const trialOver = '2';

    // app modes
    const live = 'live';
    const test = 'test';


    //* --------------relationships ---------------------

    public function AuthAccessToken()
    {
        return $this->hasMany('App\OauthAccessToken');
    }

    // * --------------end of relationships--------------

}
