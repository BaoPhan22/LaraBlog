<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $metaTitle ?: 'LaraBlog' }}</title>
    <meta name="author" content="Bao Phan">
    <meta name="description" content="{{ $metaDescription }}">

    <!-- Tailwind -->
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet"> --}}


    <!-- AlpineJS -->
    {{-- <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script> --}}
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"
        integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>

    @livewireStyles
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white font-family-karla">



    <!-- Text Header -->
    <header class="w-full container mx-auto">
        <div class="flex flex-col items-center py-12">
            <a class="font-bold text-gray-800 uppercase hover:text-gray-700 text-5xl" href="{{ route('index') }}">
                LaraBlog
            </a>
            <p class="text-lg text-gray-600">
                By BaoPhan - Filament - LiveWire - TailwindCSS
            </p>
        </div>
    </header>

    <!-- Topic Nav -->
    <nav class="w-full py-4 border-t border-b bg-gray-100" x-data="{ open: false }">
        <div class="block sm:hidden">
            <a href="#"
                class="md:hidden text-base font-bold uppercase text-center flex justify-center items-center"
                @click="open = !open">
                Topics <i :class="open ? 'fa-chevron-down' : 'fa-chevron-up'" class="fas ml-2"></i>
            </a>
        </div>
        <div :class="open ? 'block' : 'hidden'" class="w-full flex-grow sm:flex sm:items-center sm:w-auto">
            <div
                class="w-full container mx-auto flex flex-col sm:flex-row items-center justify-between text-sm font-bold uppercase mt-0 px-6 py-2">
                <div>
                    <a href="{{ route('index') }}"
                        class="hover:bg-blue-600 hover:text-white rounded py-2 px-4 mx-2 {{ request('index') ? 'bg-blue-600 text-white' : '' }}">Trang chủ</a>

                    @foreach ($categories as $item)
                        <a href="{{ route('byCategory', $item) }}"
                            class="hover:bg-blue-600 hover:text-white rounded py-2 px-4 mx-2 {{ request('category') && request('category')->slug === $item->slug ? 'bg-blue-600 text-white' : '' }}">{{ $item->title }}</a>
                    @endforeach

                    {{-- <a href="{{ route('index') }}"
                        class="hover:bg-blue-600 hover:text-white rounded py-2 px-4 mx-2">Về chúng tôi</a> --}}
                </div>
                <div>
                    @if (!Auth::check())
                        <a href="{{ route('login') }}"
                            class="hover:bg-blue-600 hover:text-white rounded py-2 px-4 mx-2">Đăng nhập</a>
                        <a href="{{ route('register') }}"
                            class="bg-blue-600 text-white rounded py-2 px-4 mx-2">Đăng ký</a>
                    @else
                        <div class="flex sm:items-center sm:ml-6">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button
                                        class="hover:bg-blue-600 hover:text-white flex items-center rounded py-2 px-4 mx-2">
                                        <div>{{ Auth::user()->name }}</div>

                                        <div class="ml-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link :href="route('profile.edit')">
                                        {{ __('Thông tin của tôi') }}
                                    </x-dropdown-link>

                                    <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf

                                        <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                            {{ __('Đăng xuất') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </nav>


    <div class="container mx-auto flex flex-wrap py-6">

        {{ $slot }}

    </div>

    <footer class="w-full border-t bg-white pb-12">

        <div class="w-full container mx-auto flex flex-col items-center">
            <div class="uppercase py-6">&copy; LaraBlog</div>
        </div>
    </footer>

    @livewireScripts
</body>

</html>
