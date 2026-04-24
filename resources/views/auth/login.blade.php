<x-guest-layout>

    <x-auth-session-status class="status" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="retro-form">
        @csrf

        <!-- Email -->
        <div class="form-group">
            <x-input-label for="email" :value="__('Email')" class="label"/>

            <x-text-input
                id="email"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                autocomplete="username"
                class="input"
            />

            <x-input-error :messages="$errors->get('email')" class="error"/>
        </div>

        <!-- Password -->
        <div class="form-group">
            <x-input-label for="password" :value="__('Password')" class="label"/>

            <x-text-input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                class="input"
            />

            <x-input-error :messages="$errors->get('password')" class="error"/>
        </div>

        <!-- Remember -->
        <div class="remember">
            <label>
                <input id="remember_me" type="checkbox" name="remember">
                Remember me
            </label>
        </div>

        <div class="actions">

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="link">
                    Forgot your password?
                </a>
            @endif

            <x-primary-button class="btn">
                Log in
            </x-primary-button>

        </div>
    </form>

</x-guest-layout>