<nav x-data="{ open: false }" class="w-56 bg-white border-r border-gray-100 h-screen flex flex-col">

    <!-- Logo Section -->
    <div class="p-4 border-b border-gray-100 flex justify-center">
        <a href="{{ route('dashboard') }}">
            <x-application-logo class="h-9 w-auto fill-current text-gray-800" />
        </a>
    </div>

    <!-- Navigation Links Section -->
    <div class="flex-1 p-4 space-y-2 flex flex-col items-center">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="block">
            {{ __('Dashboard') }}
        </x-nav-link>
    </div>

    <!-- Settings Dropdown Section -->
    <div class="p-4 border-t border-gray-100 flex justify-center">
        <x-dropdown align="top" width="48">
            <x-slot name="trigger">
                <button class="w-full flex items-center justify-between gap-2 px-4 py-2.5 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-100 transition-colors duration-150">
                    <span class="truncate">{{ Auth::user()->name }}</span>
                    @svg('heroicon-s-arrow-up-right', 'h-4 w-4 text-gray-400 flex-shrink-0')
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-dropdown-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</nav>
