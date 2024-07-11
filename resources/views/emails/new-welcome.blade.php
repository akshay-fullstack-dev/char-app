<style>
	.container {
		background-color: #fff;
		width: 60%;
		margin: 2% auto 0 auto;
		font-size: 23px !important;
	}

	.email-footer {
		margin-top: 10px;
	}
</style>
<div class="body">
	<div class="container center-block">
		<div class="email-head">
			<div class="email-name block">
				@lang('api/api_v1/email.dear') <b>{{$user->first_name}}</b><br><br>
			</div>
		</div>

		<div class="email-body mt-3">
			<p>@lang('api/api_v1/email.register_pera_1')
				<br>@lang('api/api_v1/email.register_pera_2')</p>
			<p>@lang('api/api_v1/email.register_pera_3')</p>
			<p>@lang('api/api_v1/email.register_pera_4')</p>

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