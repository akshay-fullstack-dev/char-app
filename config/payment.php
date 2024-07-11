<?php
return [
  // test keys
  "ios_test_url" => env("IOS_TEST_URL", "https://sandbox.itunes.apple.com/verifyReceipt"),
  "test_ios_secret"=> env("TEST_IOS_SECRET",""),


  // live keys
  "ios_live_url" => env("IOS_LIVE_URL", "https://buy.itunes.apple.com/verifyReceipt"),
  "live_ios_secret" => env("LIVE_IOS_SECRET", ""),


  // google client data

  'client_id'=>env("GOOGLE_CLIENT_ID",""),
  'client_secret'=>env("GOOGLE_CLIENT_SECRET",""),
  'redirect_uri'=>env("GOOGLE_REDIRECT_URI",""),
  'refresh_token'=>env("GOOGLE_REFRESH_TOKEN",""),
  'google_app_name'=>env("GOOGLE_APP_NAME",""),
];
