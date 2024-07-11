<?php
return [
	'register_email_subject_line' => 'Congratulations! Odyssey Download Successful',

	//common email text
	'dear' => 'Dear',
	'hi' => 'Hi',
	'thank_you' => 'Thank you',
	'login_credential' => 'Login Credentials ',
	'user' => 'User',
	'email' => 'Email',
	'password' => 'Password',
	'from_name' => 'Insight Health Apps.',
	'web_link' => 'https://www.insighthealthapps.com/products/the-odyssey-app',
	//--------------register email content---------------------

	'register_pera_1' => 'This email is to confirm that you have successfully downloaded the ' . config('app.name') . '. Your free trial has officially begun and we look forward to hearing from you.',

	'register_pera_2' => 'Be sure to remember your login details (email and password) This is required to login to the ' . config('app.name') . '.',

	'register_pera_3' => 'The ' . config('app.name') . ' offers a ' . env('APP_TRIAL_DAYS', '5') . ' day free trial. After that you will be prompted to purchase the ' . config('app.name') . '.',

	'register_pera_4' => 'To learn more or to complete the purchase of the ' . config('app.name') . ' please click on the link below',


	//-----------------web end register email-------------------
	'web_reg_pera_1' => 'This email is to confirm that you have successfully purchased the  ' . config('app.name') . '. ',

	'web_reg_pera_2' => 'To download the ' . config('app.name') . ' please click on the download links below.',

	'web_reg_pera_3' => 'Be sure to remember your login details (email and password) This is required to login to the ' . config('app.name') . '.',

	'web_reg_pera_4' => 'The Odyssey offers a ' . env('APP_TRIAL_DAYS', '5') . ' day free trial which you can share with anyone. After that you will be prompted to purchase the Odyssey',

	'web_reg_pera_5' => 'To learn more or to complete the purchase of the ' . config('app.name') . ' please click on the link below',



	//------------------- forgot password email content --------------

	'your_new_password_is' => 'Your new Password is',
	'more_details_visit_link' => 'For more details or to purchase the Odyssey please click on this link',
	'your_password_reset' => 'Your password has been reset.',
];
