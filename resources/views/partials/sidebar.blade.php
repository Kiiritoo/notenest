<div class="flex flex-col h-full">
    <!-- Logo -->
    <div class="p-4">
        <h1 class="text-2xl font-bold text-purple-600">NoteNest</h1>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 p-4 overflow-y-auto">
        <div class="space-y-2">
            <!-- Regular User Menu -->
            <div class="mb-4">
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center space-x-3 p-2 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-purple-100 text-purple-600' : 'text-gray-600 hover:bg-purple-50' }}">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Dashboard</span>
                </a>
            </div>

            <!-- Admin Menu -->
            @if(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())
                <div class="mb-4">
                    <p class="px-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Admin</p>
                    <div class="mt-2 space-y-2">
                        <a href="{{ route('admin.dashboard') }}" 
                           class="flex items-center space-x-3 p-2 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-purple-100 text-purple-600' : 'text-gray-600 hover:bg-purple-50' }}">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            <span>Admin Dashboard</span>
                        </a>
                        <a href="{{ route('admin.users') }}" 
                           class="flex items-center space-x-3 p-2 rounded-lg {{ request()->routeIs('admin.users*') ? 'bg-purple-100 text-purple-600' : 'text-gray-600 hover:bg-purple-50' }}">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1z"/>
                            </svg>
                            <span>Users</span>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </nav>

    <!-- User Info -->
    <div class="p-4 border-t border-gray-100">
        <div class="flex items-center space-x-3">
            <div class="bg-purple-100 p-2 rounded-full">
                <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                <p class="text-xs text-purple-600 font-medium">{{ ucfirst(Auth::user()->role) }}</p>
            </div>
        </div>
    </div>
</div> 