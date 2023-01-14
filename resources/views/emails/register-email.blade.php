@component('mail::message')
# Register Successfully


@component('mail::button', ['url' => route('welcome')])
Visit Website
@endcomponent

Thanks, {{  $user->name }} for your registration
@endcomponent
