<title>MiniStore - Apple</title>
<link rel="shortcut icon" type="image/x-icon"
    href="https://th.bing.com/th/id/R.66dacd13d1a786cad40e9197159da06a?rik=6q8PoTr4wsCZCg&pid=ImgRaw&r=0">
<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <img width="100px"style="margin-bottom: 50px"
                src="https://th.bing.com/th/id/R.66dacd13d1a786cad40e9197159da06a?rik=6q8PoTr4wsCZCg&pid=ImgRaw&r=0">
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-jet-button>
                    {{ __('Email Password Reset Link') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
