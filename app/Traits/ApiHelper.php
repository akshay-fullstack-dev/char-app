<?php

use Illuminate\Support\Str;

trait ApiHelper
{
  // jsut generate the random otp
  public function createOTP()
  {
    $otp = rand(100000, 999999);
    return $otp;
  }
}
