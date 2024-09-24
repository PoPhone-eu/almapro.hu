  <nav class="side-nav">
      <ul>

          <li>
              <a href="/admindash" wire:navigate class="side-menu">
                  <div class="side-menu__icon"> <i data-lucide="home"></i> </div>
                  <div class="side-menu__title"> Vezérlőpult </div>
              </a>
          </li>

          <li>
              <a href="/products" wire:navigate class="side-menu">
                  <div class="side-menu__icon"> <i data-lucide="box"></i> </div>
                  <div class="side-menu__title"> Termékek </div>
              </a>
          </li>

          <li>
              <a href="/banners" wire:navigate class="side-menu">
                  <div class="side-menu__icon"> <i data-lucide="box"></i> </div>
                  <div class="side-menu__title"> Bannerek </div>
              </a>
          </li>

          <li>
              <a href="javascript:;" class="side-menu">
                  <div class="side-menu__icon"> <i data-lucide="users"></i> </div>
                  <div class="side-menu__title">
                      Eladók
                      <div class="side-menu__sub-icon"> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                              height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                              stroke-linecap="round" stroke-linejoin="round" icon-name="chevron-down"
                              data-lucide="chevron-down" class="lucide lucide-chevron-down">
                              <polyline points="6 9 12 15 18 9"></polyline>
                          </svg> </div>
                  </div>
              </a>
              <ul class="side-menu__sub-open" style="display: block;">
                  {{--  <li>
                      <a href="/personal" wire:navigate class="side-menu">
                          <div class="side-menu__icon"> <i data-lucide="chevron-down"></i> </div>
                          <div class="side-menu__title"> Regisztrált Vásárlók </div>
                      </a>
                  </li> --}}
                  <li>
                      <a href="/companies" wire:navigate class="side-menu">
                          <div class="side-menu__icon"> <i data-lucide="chevron-down"></i> </div>
                          <div class="side-menu__title"> Kereskedők </div>
                      </a>
                  </li>
                  <li>
                      <a href="/privates" wire:navigate class="side-menu">
                          <div class="side-menu__icon"> <i data-lucide="chevron-down"></i> </div>
                          <div class="side-menu__title"> Magánszemélyek </div>
                      </a>
                  </li>
                  <li>
                      <a href="/invoices-table" wire:navigate class="side-menu">
                          <div class="side-menu__icon"> <i data-lucide="chevron-down"></i> </div>
                          <div class="side-menu__title"> Számlák </div>
                      </a>
                  </li>
              </ul>
          </li>

          <li>
              <a href="javascript:;" class="side-menu">
                  <div class="side-menu__icon"> <i data-lucide="trello"></i> </div>
                  <div class="side-menu__title">
                      Beállítások
                      <div class="side-menu__sub-icon"> <i data-lucide="chevron-down"></i> </div>
                  </div>
              </a>
              <ul class="side-menu__sub-open" style="display: block;">
                  <li>
                      <a href="/attributes" wire:navigate class="side-menu">
                          <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                          <div class="side-menu__title"> Termékjellemzők </div>
                      </a>
                  </li>
                  <li>
                      <a href="/categories" wire:navigate class="side-menu">
                          <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                          <div class="side-menu__title"> Kategóriák </div>
                      </a>
                  </li>
                  <li>
                      <a href="/sitesettings" wire:navigate class="side-menu">
                          <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                          <div class="side-menu__title"> Weboldal beállítások </div>
                      </a>
                  </li>
                  <li>
                      <a href="/apikeys" wire:navigate class="side-menu">
                          <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                          <div class="side-menu__title"> API kulcsok </div>
                      </a>
                  </li>
                  <li>
                      <a href="/legaldocuments" wire:navigate class="side-menu">
                          <div class="side-menu__icon"> <i data-lucide="chevron-down"></i> </div>
                          <div class="side-menu__title"> Dokumentumok </div>
                      </a>
                  </li>
                  <li>
                      <a href="/admins" wire:navigate class="side-menu">
                          <div class="side-menu__icon"> <i data-lucide="chevron-down"></i> </div>
                          <div class="side-menu__title"> Adminok </div>
                      </a>
                  </li>
              </ul>
          </li>

      </ul>
  </nav>
