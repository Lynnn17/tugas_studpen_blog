<nav class="bg-gray-800 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <div class="text-white text-xl font-bold">
            <a href="{{ url('/') }}">MyWebsite</a>
        </div>

        <!-- Mobile menu button -->
        <div class="lg:hidden">
            <button id="navbar-toggle" class="text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7">
                    </path>
                </svg>
            </button>
        </div>

        <!-- Menu Items -->
        <div id="navbar-menu" class="hidden lg:flex lg:items-center space-x-6">
            <a href="/" class="text-gray-300 hover:text-white">Home</a>


            @auth

                <a href="{{ route('categories.index') }}" class="text-gray-300 hover:text-white">Categories</a>
                <a href="{{ route('posts.index') }}" class="text-gray-300 hover:text-white">Posts</a>
            @endauth

            @guest
                <a href="{{ route('login') }}" class="text-gray-300 hover:text-white">Login</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="text-gray-300 hover:text-white">Register</a>
                @endif
            @else
                <!-- User Icon -->
                <div class="relative">
                    <button id="user-menu-button" class="flex items-center text-gray-300 focus:outline-none">
                        <img class="w-8 h-8 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="User Icon">
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="user-menu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2">
                        <a href="{{ route('dashboard') }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Dashboard</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-200">Logout</button>
                        </form>
                    </div>
                </div>
            @endguest
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="lg:hidden hidden">
        <a href="/" class="block text-gray-300 hover:text-white px-4 py-2">Home</a>
        <a href="/about" class="block text-gray-300 hover:text-white px-4 py-2">About</a>

        @guest
            <a href="{{ route('login') }}" class="block text-gray-300 hover:text-white px-4 py-2">Login</a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="block text-gray-300 hover:text-white px-4 py-2">Register</a>
            @endif
        @else
            <a href="{{ route('dashboard') }}" class="block text-gray-300 hover:text-white px-4 py-2">Dashboard</a>
            <form action="{{ route('logout') }}" method="POST" class="block px-4 py-2">
                @csrf
                <button type="submit" class="text-gray-300 hover:text-white w-full text-left">Logout</button>
            </form>
        @endguest
    </div>
</nav>

<script>
    document.getElementById('navbar-toggle').onclick = function() {
        document.getElementById('navbar-menu').classList.toggle('flex');
        document.getElementById('mobile-menu').classList.toggle('hidden');
    };

    document.getElementById('user-menu-button').onclick = function() {
        document.getElementById('user-menu').classList.toggle('hidden');
    };
</script>
