<x-guest-layout>
    <div class="max-w-md mx-auto w-full">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold gradient-text mb-2">Create Account</h2>
            <p class="text-gray-500">Join our healthcare community today</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Full Name</label>
                <input id="name" 
                       type="text" 
                       name="name" 
                       value="{{ old('name') }}" 
                       required 
                       autofocus 
                       autocomplete="name"
                       class="form-input"
                       placeholder="John Doe">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
                <input id="email" 
                       type="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required 
                       autocomplete="username"
                       class="form-input"
                       placeholder="you@example.com">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                <input id="password" 
                       type="password" 
                       name="password" 
                       required 
                       autocomplete="new-password"
                       class="form-input"
                       placeholder="••••••••">
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">Confirm Password</label>
                <input id="password_confirmation" 
                       type="password" 
                       name="password_confirmation" 
                       required 
                       autocomplete="new-password"
                       class="form-input"
                       placeholder="••••••••">
                @error('password_confirmation')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Role -->
            <div>
                <label for="role" class="block text-sm font-semibold text-gray-700 mb-1">Role</label>
                <input id="role" 
                       type="text" 
                       name="role" 
                       value="{{ old('role') }}" 
                       required 
                       class="form-input"
                       placeholder="e.g. admin, staff, custom-role">
                @error('role')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-2">
                <button type="submit" class="btn-primary w-full py-3">
                    <i class="fas fa-user-plus mr-2"></i>
                    Create Account
                </button>
            </div>

            <div class="text-center mt-6">
                <p class="text-sm text-gray-600">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-indigo-500">
                        Sign in instead
                    </a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>