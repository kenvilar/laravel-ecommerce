Hello {{ $user->name }}!
You've changed your email, so we need you to verify this email address. Please click the link below
{{ route('resend', $user->verification_token) }}