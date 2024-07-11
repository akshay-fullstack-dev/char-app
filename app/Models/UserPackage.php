<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPackage extends Model
{
    const IOS_PLATFORM = 0;
    const ANDROID_PLATFORM = 1;
    protected $guarded = [];
}
