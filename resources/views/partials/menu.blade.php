    <div
        class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        @if (Route::has('login'))
            <div class="flex sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                @auth
                    @if (auth()->user()->hasRole('admin'))
                        <a href="{{ url('/admindash') }}" wire:navigate
                            class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                            {{ __('messages.dashboard') }}</a>
                    @else
                        <a href="{{ url('/messages') }}" wire:navigate
                            class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                            Üzenetek</a>

                        @if (auth()->user()->role == 'company')
                            <a href="{{ url('/shops') }}" wire:navigate
                                class="ml-5 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                                Boltok</a>
                        @endif
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit" onclick="event.preventDefault();  this.closest('form').submit();"
                            class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 cursor-pointer">
                            {{--  <i data-lucide="toggle-right" onclick="event.preventDefault();  this.closest('form').submit();"
                                class="w-4 h-4 mr-2"></i> --}} {{ __('Logout') }} </button>


                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                        {{ __('messages.login') }}</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                            {{ __('messages.register') }}</a>
                    @endif
                @endauth
            </div>
        @endif
