@if (isset($errorCode))
	<div class="message error">
		@lang('errors.'.$errorCode)
	</div>

@endif

