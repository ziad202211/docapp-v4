<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Include your CSS files here -->
    <link rel="stylesheet" href="{{ asset('css/sign-in.css') }}">
</head>
<body>
    <div class="guest-layout">
        <div class="auth-card">
            <!-- Login Label -->
            <h2 class="text-2xl font-semibold text-gray-800 ">Login</h2>


            <div class="logo">
                <!-- <a href="/">
                    <img src="application-logo.svg" class="w-20 h-20 text-gray-500" />
                </a> -->
            </div>

            <!-- Session Status -->
            @if(session('status'))
                <div class="mb-4">{{ session('status') }}</div>
            @endif

            <!-- Validation Errors -->
            @if($errors->any())
                <div class="mb-4">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email">{{ __('Email') }}</label>
                    <input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ old('email') }}" required autofocus />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label for="password">{{ __('Password') }}</label>
                    <input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <button type="submit" class="ml-3">
                        {{ __('Log in') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
