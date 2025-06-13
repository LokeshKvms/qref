<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Qref - Smart Expense Tracker</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }

            .fade-in {
                animation: fadeIn 1s ease-in-out;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>
    </head>

    <body class="antialiased bg-gray-50 text-gray-800">

        <!-- Top Navigation -->
        <nav class="w-full fixed top-0 left-0 bg-gray-50 border-b z-10">
            <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
                <!-- Logo -->
                <a href="{{ url('/') }}" class="flex items-center space-x-2">
                    <img src="{{ asset('https://placehold.co/42/374151/f3f4f6?font=lora&text=Q') }}" alt="Qref Logo"
                        class="h-8 w-auto mr-1 rounded-lg transition-all ease-in-out hover:rounded-[20px] hover:scale-105 hover:shadow-lg" />
                    <span class="text-xl font-bold text-gray-700">Qref</span>
                </a>

                <!-- Auth Links -->
                @if (Route::has('login'))
                    <div class="space-x-4">
                        @auth
                            <a href="{{ url('/links') }}"
                                class="text-md text-gray-700 hover:text-gray-600">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-md text-gray-700 hover:text-gray-600">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="text-md text-gray-700 hover:text-gray-600 ml-2">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="min-h-screen flex items-center justify-center text-center bg-white px-6 fade-in pt-24">
            <div>
                <h1 class="text-5xl md:text-6xl font-bold text-gray-700 mb-6">All Your Links, One Smart Place</h1>
                <p class="text-lg md:text-xl text-gray-600 mb-8 max-w-xl mx-auto">
                    Save, edit, organize, and search your links effortlessly with Qref — your personal link manager.
                </p>
                <a href="{{ route('register') }}"
                    class="inline-block px-8 py-4 bg-gray-600 text-white text-lg font-semibold rounded-md shadow hover:bg-gray-700 transition">
                    Get Started for Free
                </a>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-20 bg-gray-100">
            <div class="max-w-6xl mx-auto px-6 text-center">
                <h2 class="text-4xl font-bold text-gray-800 mb-12">Features You’ll Love</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                    <div class="bg-white p-8 rounded-lg shadow-md hover:shadow-xl transition duration-300">
                        <div class="text-gray-500 text-3xl mb-4">🔗</div>
                        <h3 class="text-xl font-semibold mb-2">Easy Link Management</h3>
                        <p class="text-gray-600">Add, edit, and delete your links quickly and effortlessly.</p>
                    </div>

                    <div class="bg-white p-8 rounded-lg shadow-md hover:shadow-xl transition duration-300">
                        <div class="text-gray-500 text-3xl mb-4">🔍</div>
                        <h3 class="text-xl font-semibold mb-2">Powerful Search</h3>
                        <p class="text-gray-600">Find any link fast using keywords, tags, or filters.</p>
                    </div>

                    <div class="bg-white p-8 rounded-lg shadow-md hover:shadow-xl transition duration-300">
                        <div class="text-gray-500 text-3xl mb-4">💾</div>
                        <h3 class="text-xl font-semibold mb-2">Organize Your Links</h3>
                        <p class="text-gray-600">Group and tag your links for quick access anytime, anywhere.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Why Choose Qref Section -->
        <section class="py-20 bg-white">
            <div class="max-w-5xl mx-auto px-6 text-center">
                <h2 class="text-4xl font-bold text-gray-800 mb-12">Why Qref?</h2>
                <div class="space-y-10 md:space-y-0 md:grid md:grid-cols-3 md:gap-10">
                    <div class="p-6 border rounded-lg shadow-sm hover:shadow-md transition duration-300">
                        <div class="text-indigo-600 text-4xl mb-4">⚡</div>
                        <h3 class="text-2xl font-semibold mb-2">Fast & Intuitive</h3>
                        <p class="text-gray-600">Manage your links with ease and speed from any device.</p>
                    </div>

                    <div class="p-6 border rounded-lg shadow-sm hover:shadow-md transition duration-300">
                        <div class="text-indigo-600 text-4xl mb-4">🔒</div>
                        <h3 class="text-2xl font-semibold mb-2">Secure & Private</h3>
                        <p class="text-gray-600">Your links stay private and safe — no sharing without your consent.</p>
                    </div>

                    <div class="p-6 border rounded-lg shadow-sm hover:shadow-md transition duration-300">
                        <div class="text-indigo-600 text-4xl mb-4">📱</div>
                        <h3 class="text-2xl font-semibold mb-2">Sync Across Devices</h3>
                        <p class="text-gray-600">Access and manage your links anywhere, anytime.</p>
                    </div>
                </div>
            </div>
        </section>


        <!-- Footer -->
        <footer class="bg-white border-t mt-20 pl-10">
            <div
                class="max-w-7xl mx-auto px-6 py-10 flex flex-col md:flex-row justify-between items-center text-sm text-gray-600">

                <!-- Logo -->
                <a href="{{ url('/') }}" class="flex items-center space-x-3 mb-4 md:mb-0">
                    <img src="{{ asset('https://placehold.co/42/374151/f3f4f6?font=lora&text=T') }}" alt="Qref Logo"
                        class="h-8 w-auto rounded-lg transition-all ease-in-out hover:rounded-[20px] hover:scale-105 hover:shadow-lg" />
                    <span class="text-xl font-extrabold text-gray-800 tracking-wide">Qref</span>
                </a>

                <!-- Copyright -->
                <p class="text-center md:text-left text-gray-500">&copy; 2025 Qref. All rights reserved.</p>

                <!-- Important Notice Link -->
                <div class="mt-4 md:mt-0">
                    <a href="#" class="text-red-600 font-semibold hover:underline transition duration-200">
                        Terms & Conditions
                    </a>
                </div>

            </div>
        </footer>

    </body>

</html>
