<?php

namespace App\Http\Middleware;

use App\User;
use Carbon\Carbon;
use Closure;

class CheckUserTrial
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
    $user = auth()->user();
    if (Carbon::now() > $user->trial_expiry_date && $user->account_status == User::trial) {
      $user->account_status = User::trialOver;
      $user->save();
    }
    return $next($request);
  }
}
