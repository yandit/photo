@component('mail::message')
# Confirm Email Address

<p>
  For security purposes, we need you to verify your email address before continuing on our platform.
</p>

@component('mail::button', ['url' => $url])
Verify Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
