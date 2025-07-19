@component('mail::message')
# Hello {{ $user->username }},

🎉 Welcome to **{{ config('app.name') }}**!

We're excited to have you on board. Here are your account details:

- **Email:** {{ $user->email }}
- **Role:** {{ ucfirst($user->role) }}
- **Status:** {{ ucfirst($user->status) }}

@component('mail::button', ['url' => url('/login')])
Login to Your Account
@endcomponent

If you have any questions or need support, feel free to reply to this email.

Thanks,<br>
The {{ config('app.name') }} Team
@endcomponent
