<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResourse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    private $token;

    public function __construct($resource, $token = "")
    {
        parent::__construct($resource);
        $this->token = $token;
    }
    public function toArray($request)
    {
        //trial time is in milliseconds
        $trial_time = floor((strtotime($this->trial_expiry_date) - strtotime(date('Y-m-d H:i:s')))) * 1000;
        return [
            "firstName" => $this->first_name,
            "email" => $this->email,
            "isVerified" => ($this->email_verified_at) ? 1  : 0,
            "status" => (int) $this->status,
            "accessToken" => $this->token,
            "accountStatus" => (int) $this->account_status,
            "trialDaysLeft" => $trial_time > 0 ? $trial_time : 0
        ];
    }
}
