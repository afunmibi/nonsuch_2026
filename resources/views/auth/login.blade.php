<x-guest-layout>
    <div class="max-w-md mx-auto w-full">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold gradient-text mb-2">Welcome Back</h2>
            <p class="text-gray-500">Sign in to your account to continue</p>
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                <input id="email" 
                       type="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required 
                       autofocus 
                       autocomplete="username"
                       class="form-input"
                       placeholder="you@example.com">
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs text-sky-600 hover:text-sky-500 font-semibold">
                            Forgot password?
                        </a>
                    @endif
                </div>
                <input id="password" 
                       type="password" 
                       name="password" 
                       required 
                       autocomplete="current-password"
                       class="form-input"
                       placeholder="••••••••">
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-sky-600 shadow-sm focus:ring-sky-500">
                <label for="remember_me" class="ml-2 text-sm text-gray-600">Remember me</label>
            </div>

            <div>
                <button type="submit" class="btn-primary w-full py-3">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Sign In
                </button>
            </div>


        </form>
    </div>
</x-guest-layout>