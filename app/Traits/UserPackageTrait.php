<?php

namespace App\Traits;

trait UserPackageTrait
{
	private function get_google_api_access_token(array $google_app_data)
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://www.googleapis.com/oauth2/v4/token",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_SSL_VERIFYPEER, false,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => json_encode($google_app_data),
			CURLOPT_HTTPHEADER => array(
				"Content-Type: application/json",
				"Accept-Charset: UTF-8"
			),
		));

		$output = curl_exec($curl);
		$headers_info = curl_getinfo($curl);
		curl_close($curl);
		if ($output === false || $headers_info['http_code'] != '200') {
			// echo '<pre>';
			// print_r(curl_error($curl));
			// echo '</pre>';
			// exit();
			return false;
		}

		$response = json_decode($output, true);
		return $response['access_token'];
	}


	private function get_purchase_details($product_id, $app_name, $receipt, $api_access_token)
	{
		$verification_url = "https://www.googleapis.com/androidpublisher/v3/applications/$app_name/purchases/subscriptions/$product_id/tokens/" . $receipt;

		$curl = curl_init($verification_url);
		curl_setopt($curl, CURLOPT_URL, $verification_url);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt(
			$curl,
			CURLOPT_HTTPHEADER,
			array(
				'Authorization: Bearer ' . $api_access_token
			)
		);

		$output = curl_exec($curl);
		$headers_info = curl_getinfo($curl);
		curl_close($curl);

		if ($output === false || $headers_info['http_code'] != '200') {
			return false;
		}
		return true;
	}
}
