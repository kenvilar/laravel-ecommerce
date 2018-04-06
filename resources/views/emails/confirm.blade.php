@component('mail::message')
    # Hello {{ $user->name }}!

    You've changed your email, so we need you to verify this email address. Please click the button below

    @component('mail::button', ['url' => route('verify', $user->verification_token)])
        Verify Account
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
