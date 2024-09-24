  <div
      class="top-bar-boxed h-[70px] md:h-[65px] z-[51] border-b border-white/[0.08] mt-12 md:mt-0 -mx-3 sm:-mx-8 md:-mx-0 px-3 md:border-b-0 relative md:fixed md:inset-x-0 md:top-0 sm:px-8 md:px-10 md:pt-10 md:bg-gradient-to-b md:from-slate-100 md:to-transparent dark:md:from-darkmode-700">
      <div class="h-full flex items-center">
          <!-- BEGIN: Logo -->
          <a href="/admindash" wire:navigate class="logo -intro-x hidden md:flex xl:w-[180px] block">
              {{-- <img alt="{{ config('app.name') }}" class="logo__image w-6" src="/dist/images/logo.svg"> --}}
              <span class="logo__text text-white text-lg ml-3"> {{ config('app.name') }} </span>
          </a>
          <!-- END: Logo -->
          <!-- BEGIN: Breadcrumb -->
          <nav aria-label="breadcrumb" class="-intro-x h-[45px] mr-auto">
              <ol class="breadcrumb breadcrumb-light">
                  {{--  <li class="breadcrumb-item"><a href="/admindash" wire:navigate></a></li>
                  <li class="breadcrumb-item active" aria-current="page">Vezérlőpult</li> --}}
              </ol>
          </nav>
          <!-- END: Breadcrumb -->
          <!-- BEGIN: Search -->
          <div class="intro-x relative mr-3 sm:mr-6">
              <div class="search hidden sm:block">
                  <input type="text" class="search__input form-control border-transparent" placeholder="Search...">
                  <i data-lucide="search" class="search__icon dark:text-slate-500"></i>
              </div>
          </div>
          <!-- END: Search -->
          <!-- BEGIN: Notifications -->
          {{--  <livewire:admin.notifications.user-subscription-notify> --}}
          <!-- END: Notifications -->
          <!-- BEGIN: Account Menu -->
          <div class="intro-x dropdown w-8 h-8">
              <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in scale-110"
                  role="button" aria-expanded="false" data-tw-toggle="dropdown">
                  <img alt="{{ config('app.name') }}" src="/dist/images/profile-5.jpg">
              </div>
              <div class="dropdown-menu w-56">
                  <ul
                      class="dropdown-content bg-primary/80 before:block before:absolute before:bg-black before:inset-0 before:rounded-md before:z-[-1] text-white">
                      <li class="p-2">
                          <div class="font-medium">{{ auth()->user()->name }}</div>
                          <div class="text-xs text-white/60 mt-0.5 dark:text-slate-500">{{ auth()->user()->post }}
                          </div>
                      </li>
                      <li>
                          <hr class="dropdown-divider border-white/[0.08]">
                      </li>
                      <li>
                          <a href="javascript:;" wire:navigate class="dropdown-item hover:bg-white/5"> <i
                                  data-lucide="user" class="w-4 h-4 mr-2"></i> Profile </a>
                      </li>
                      <li>
                          <hr class="dropdown-divider border-white/[0.08]">
                      </li>
                      <form method="POST" action="{{ route('logout') }}">
                          @csrf
                          <li>
                              <button type="submit" class="dropdown-item hover:bg-white/5 cursor-pointer"> <i
                                      data-lucide="toggle-right"
                                      onclick="event.preventDefault();  this.closest('form').submit();"
                                      class="w-4 h-4 mr-2"></i> {{ __('Logout') }} </button>

                          </li>
                      </form>
                  </ul>
              </div>
          </div>
          <!-- END: Account Menu -->
      </div>
  </div>
