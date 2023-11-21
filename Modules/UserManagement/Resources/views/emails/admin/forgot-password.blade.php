@component('mail::message')

Click button to change password.

@component('mail::button', ['url' => $url])
Change Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent