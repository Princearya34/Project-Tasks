<x-guest-layout>
    <div class="h-screen flex items-center justify-center bg-gray-100 overflow-hidden">
        <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-lg">
            <h2 class="text-2xl font-semibold text-center text-gray-700">{{ __('Login') }}</h2>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" class="font-semibold" />
                    <x-text-input id="email" class="block mt-1 w-full p-2 border rounded-md focus:ring focus:ring-indigo-300" 
                                  type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" class="font-semibold" />
                    <x-text-input id="password" class="block mt-1 w-full p-2 border rounded-md focus:ring focus:ring-indigo-300" 
                                  type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
                </div>

                <div class="mt-6 flex justify-between items-center">
                    <a class="text-sm text-indigo-600 hover:underline" href="{{ route('register') }}">
                        {{ __('Register') }}
                    </a>
                    <x-primary-button class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* Prevent scrolling */
        html, body {
            overflow: hidden;
        }
    </style>
</x-guest-layout>
