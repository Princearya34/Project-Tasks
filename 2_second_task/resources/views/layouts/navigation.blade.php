<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="no-underline">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @auth
                        @role('admin') 
                            <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')" class="no-underline">
                                {{ __('Manage Users') }}
                            </x-nav-link>

                            <x-nav-link :href="route('projects.index')" :active="request()->routeIs('projects.*')" class="no-underline">
                                {{ __('Manage Projects') }}
                            </x-nav-link>

                            <x-nav-link :href="route('roles.index')" :active="request()->routeIs('roles.*')" class="no-underline">
                                {{ __('Manage Roles') }}
                            </x-nav-link>
                        @endrole

                        @unless(auth()->user()->hasRole('admin'))
                            <!-- View Profile for Normal Users Only -->
                            <x-nav-link :href="route('users.profile')" :active="request()->routeIs('users.profile')" class="no-underline">
                                {{ __('View Profile') }}
                            </x-nav-link>
                        @endunless
                    @endauth
                </div>
            </div>

            @auth
                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')" class="no-underline">
                                {{ __('Profile Settings') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();" class="no-underline">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            @endauth
        </div>
    </div>
</nav>

<!-- Custom CSS to Remove Underlines -->
<style>
    .no-underline {
        text-decoration: none !important;
    }
</style>
