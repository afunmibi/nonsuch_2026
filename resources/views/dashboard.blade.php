<x-app-layout>
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-indigo-100 rounded-lg">
                    <i class="fas fa-user-md text-indigo-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Total HCPs</p>
                    <p class="text-2xl font-semibold text-gray-900">248</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-users text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Active Patients</p>
                    <p class="text-2xl font-semibold text-gray-900">1,429</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i class="fas fa-file-invoice text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Pending Bills</p>
                    <p class="text-2xl font-semibold text-gray-900">67</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Monthly Revenue</p>
                    <p class="text-2xl font-semibold text-gray-900">$89.2k</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('hcps.index') }}" class="flex flex-col items-center p-4 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors">
                    <i class="fas fa-user-plus text-indigo-600 text-2xl mb-2"></i>
                    <span class="text-sm font-medium text-indigo-900">Add HCP</span>
                </a>
                <a href="{{ route('enrolments.create') }}" class="flex flex-col items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                    <i class="fas fa-user-plus text-green-600 text-2xl mb-2"></i>
                    <span class="text-sm font-medium text-green-900">Enroll Patient</span>
                </a>
                <a href="{{ route('bill-vetting.create') }}" class="flex flex-col items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors">
                    <i class="fas fa-file-invoice-dollar text-yellow-600 text-2xl mb-2"></i>
                    <span class="text-sm font-medium text-yellow-900">New Bill</span>
                </a>
                <a href="{{ route('logRequests.create') }}" class="flex flex-col items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                    <i class="fas fa-file-alt text-purple-600 text-2xl mb-2"></i>
                    <span class="text-sm font-medium text-purple-900">Log Request</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Recent Activity</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="p-2 bg-indigo-100 rounded-lg">
                            <i class="fas fa-user-md text-indigo-600 text-sm"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-gray-900">New HCP registered: Dr. Sarah Johnson</p>
                            <p class="text-xs text-gray-500">2 hours ago</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="p-2 bg-green-100 rounded-lg">
                            <i class="fas fa-users text-green-600 text-sm"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-gray-900">Patient enrollment completed: John Doe</p>
                            <p class="text-xs text-gray-500">4 hours ago</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="p-2 bg-yellow-100 rounded-lg">
                            <i class="fas fa-file-invoice text-yellow-600 text-sm"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-gray-900">Bill #1234 approved for processing</p>
                            <p class="text-xs text-gray-500">6 hours ago</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">System Overview</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">System Status</span>
                        <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Operational</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Database</span>
                        <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Healthy</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Last Backup</span>
                        <span class="text-sm text-gray-900">2 hours ago</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Active Sessions</span>
                        <span class="text-sm text-gray-900">12</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
