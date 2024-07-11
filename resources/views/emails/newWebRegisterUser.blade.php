<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<style>
		.container {
			background-color: #fff;
			width: 60%;
			margin: 2% auto 0 auto;
			font-size: 20px !important;
		}

		.email-footer {
			margin-top: 10px;
		}

		.credential-table {
			margin-top: 10px;
			margin-bottom: 10px;
			display: table;
			border: 1px solid black;
			width: 70%;
			text-align: left;
		}

		.credential-table tr td,
		.credential-table thead th {
			border: none;
		}

		.credential-table tr th {
			font-size: 18px;
		}

		.ios-link,
		.android-link {
			display: inline-block;
		}

		.ios-link img,
		.android-link img {
			width: 200px;
		}

		.store-link {
			margin-bottom: 10px;
		}
	</style>
</head>

<body>

	<div class="body">
		<div class="container center-block">
			<div class="email-head">
				<div class="email-name block">
					@lang('api/api_v1/email.dear') <b>{{$user->first_name}}</b><br><br>
				</div>
			</div>

			<div class="email-body mt-3">
				<p>@lang('api/api_v1/email.web_reg_pera_1')
					<br>
					@lang('api/api_v1/email.web_reg_pera_2')
				</p><br>
				<div class="store-link">
					<div class="ios-link">
						<a href="{{ config('app.ios_app_ink') }}" target="_blank">
							<img src="{{ url('assets/images/app-stor.png') }}" alt="ios-link-image">
						</a>
					</div>
					<div class="android-link">
						<a href="{{ config('app.android_app_link') }}" target="_blank">
							<img src="{{  url('assets/images/google-play.png') }}" alt="android-link-image">
						</a>
					</div>
				</div>
				<p>@lang('api/api_v1/email.web_reg_pera_3')</p>
				<b>@lang('api/api_v1/email.login_credential'):</b> <br>
				<table class="credential-table">
					<tr>
						<th>@lang('api/api_v1/email.user') @lang('api/api_v1/email.email')</th>
						<th>@lang('api/api_v1/email.password')</th>
					</tr>
					<tr>
						<td>{{$user->email}}</td>
						<td>{{$password}}</td>
					</tr>
				</table>
				<p>
					@lang('api/api_v1/email.web_reg_pera_4')
				</p>
				<p>@lang('api/api_v1/email.web_reg_pera_5')</p>

				<a href="{{ trans('api/api_v1/email.web_link') }}">
					<i>{{ trans('api/api_v1/email.web_link') }}</i></a>
			</div>

			<div class="email-footer mt-2">
				@lang('api/api_v1/email.thank_you')
				<br>
				@lang('api/api_v1/email.from_name')
			</div>
		</div>
	</div>
</body>

</html>