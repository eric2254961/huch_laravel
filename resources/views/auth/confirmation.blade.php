<x-guest-layout>
    <div class="mt-4 text-center">
        <h2>{{ __('Registration Successful!') }}</h2>
        <p>{{ __('Your account has been created successfully.') }}</p>
        <div class="mt-4">
            <a href="{{ route('register') }}" class="btn btn-primary">{{ __('Register Another User') }}</a>
            <a href="{{ route('login') }}" class="btn btn-secondary">{{ __('Login') }}</a>
        </div>
    </div>
</x-guest-layout>