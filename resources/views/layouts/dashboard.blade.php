<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NoteNest - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-purple-100 to-indigo-200 min-h-screen">
    <!-- Mobile Menu Backdrop -->
    <div id="mobileMenuBackdrop" class="fixed inset-0 bg-gray-600 bg-opacity-50 backdrop-blur-sm hidden z-40 lg:hidden"></div>

    <div class="min-h-screen flex">
        <!-- Sidebar - Desktop -->
        <div class="hidden lg:flex w-64 bg-white shadow-lg relative z-30">
            @include('partials.sidebar')
        </div>

        <!-- Sidebar - Mobile -->
        <div id="mobileSidebar" class="fixed inset-y-0 left-0 transform -translate-x-full lg:hidden w-64 bg-white shadow-lg z-50 transition-transform duration-300">
            @include('partials.sidebar')
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-h-screen">
            <!-- Navbar -->
            <nav class="bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-30">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16 items-center">
                        <!-- Mobile menu button -->
                        <button id="mobileMenuButton" class="lg:hidden rounded-md p-2 text-gray-600 hover:bg-purple-50">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>

                        <h1 class="text-xl md:text-2xl font-bold text-gray-900">@yield('title')</h1>

                        <!-- Profile Dropdown -->
                        <div class="relative">
                            <button id="profileButton" class="flex items-center space-x-3 focus:outline-none">
                                <div class="bg-purple-100 p-2 rounded-full">
                                    <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <span class="hidden md:block text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                            </button>

                            <!-- Dropdown Menu -->
                            <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50">
                                <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50">Profile</a>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-purple-50">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="flex-1 p-4 md:p-6 overflow-x-hidden">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Modals -->
    @yield('modals')

    <script>
        // Mobile menu functionality
        const mobileMenuButton = document.getElementById('mobileMenuButton');
        const mobileSidebar = document.getElementById('mobileSidebar');
        const mobileMenuBackdrop = document.getElementById('mobileMenuBackdrop');

        mobileMenuButton.addEventListener('click', () => {
            mobileSidebar.classList.toggle('-translate-x-full');
            mobileMenuBackdrop.classList.toggle('hidden');
        });

        mobileMenuBackdrop.addEventListener('click', () => {
            mobileSidebar.classList.add('-translate-x-full');
            mobileMenuBackdrop.classList.add('hidden');
        });

        // Profile dropdown functionality
        const profileButton = document.getElementById('profileButton');
        const profileDropdown = document.getElementById('profileDropdown');

        profileButton.addEventListener('click', () => {
            profileDropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', (e) => {
            if (!profileButton.contains(e.target) && !profileDropdown.contains(e.target)) {
                profileDropdown.classList.add('hidden');
            }
        });
    </script>
</body>
</html> 