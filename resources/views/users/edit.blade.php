<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('users.update', $user) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Role -->
                        <div id="role_container">
                            <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                            <select id="role" name="role" required onchange="toggleHospitalSelector()" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin (Executive)</option>
                                <option value="gm" {{ old('role', $user->role) == 'gm' ? 'selected' : '' }}>General Manager (GM)</option>
                                <option value="md" {{ old('role', $user->role) == 'md' ? 'selected' : '' }}>Medical Director (MD)</option>
                                <option value="ud" {{ old('role', $user->role) == 'ud' ? 'selected' : '' }}>Underwriter (UD)</option>
                                <option value="cm" {{ old('role', $user->role) == 'cm' ? 'selected' : '' }}>Case Manager (CM)</option>
                                <option value="cc" {{ old('role', $user->role) == 'cc' ? 'selected' : '' }}>Care Coordinator (CC)</option>
                                <option value="accounts" {{ old('role', $user->role) == 'accounts' ? 'selected' : '' }}>Accounts Department</option>
                                <option value="hr" {{ old('role', $user->role) == 'hr' ? 'selected' : '' }}>HR Manager</option>
                                <option value="it" {{ old('role', $user->role) == 'it' ? 'selected' : '' }}>IT Support</option>
                                <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>General Staff</option>
                                <option value="hcp" {{ old('role', $user->role) == 'hcp' ? 'selected' : '' }}>Healthcare Provider (HCP)</option>
                            </select>
                            @error('role')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Hospital Association (Conditional) -->
                        <div id="hospital_selector" class="hidden">
                            <label for="hcp_id" class="block text-sm font-medium text-gray-700">Associate with Hospital</label>
                            <select id="hcp_id" name="hcp_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">Select Hospital</option>
                                @foreach($hospitals as $hospital)
                                    <option value="{{ $hospital->id }}" {{ old('hcp_id', $user->hcp_id) == $hospital->id ? 'selected' : '' }}>
                                        {{ $hospital->hcp_name }} ({{ $hospital->hcp_location }})
                                    </option>
                                @endforeach
                            </select>
                            @error('hcp_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Update User</button>
                            <a href="{{ route('users.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleHospitalSelector() {
            const roleSelect = document.getElementById('role');
            const hospitalDiv = document.getElementById('hospital_selector');
            
            if (roleSelect.value === 'hcp') {
                hospitalDiv.classList.remove('hidden');
            } else {
                hospitalDiv.classList.add('hidden');
                document.getElementById('hcp_id').value = '';
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleHospitalSelector();
        });
    </script>
</x-app-layout>
