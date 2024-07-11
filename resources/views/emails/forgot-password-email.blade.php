@php
$language_path = 'api/api_v1/email.';
@endphp
<style>
     .container {
          background-color: #fff;
          width: 60%;
          margin: 5% auto 0 auto;
          font-size: 25px !important;
     }

     .email-footer {
          margin-top: 10px;
     }
</style>
<div class="main-body">
     <div class="container center-block" style="background-color: #fff; width: 60%; margin:2% auto 0 auto;">
          <div class="email-head">
               <div class="email-name block">
                    {{ trans( $language_path.'hi') }} :- {{$user->first_name}} <br>
                    {{ trans( $language_path.'your_password_reset') }}<br>
               </div>
          </div>
          <div class="email-body mt-3">
               <p>{{ trans( $language_path.'your_new_password_is') }} :- <b>{{$password}}</b></p>
               <p>
                    {{ trans( $language_path.'more_details_visit_link') }}:-
                    <a href="{{ trans( $language_path.'web_link') }}">{{ trans( $language_path.'web_link') }}</a>
               </p>
          </div>

          <div class="email-footer mt-2">
               {{ trans( $language_path.'thank_you') }}
               <br>
               {{ trans( $language_path.'from_name') }}
          </div>
     </div>
</div>    