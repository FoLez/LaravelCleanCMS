<nav class="sidebar">
      <div class="sidebar-header px-2">
          <div class="row h-100 w-100 flex-nowrap m-0">
              <div class="col d-flex justify-content-center align-items-center">
                  <button class="sidebar-toggler button-unstyled" onclick="adminFunctions.toggleSidebar()">
                      <i class="far fa-bars"></i>
                  </button>
              </div>
          </div>
      </div>
      <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item">
                <x-components.admin.sidenav-link link="{{route('admin.home')}}">
                    <x-slot name="icon">
                        <i class="far fa-home-alt"></i>
                    </x-slot>
                    Статистика
                </x-components.admin.sidenav-link>
            </li>
            <li class="nav-item">
                <x-components.admin.sidenav-link link="{{route('admin.pages.list')}}">
                    <x-slot name="icon">
                        <i class="fal fa-list"></i>
                    </x-slot>
                    Страницы
                </x-components.admin.sidenav-link>
            </li>
            <li class="nav-item">
                <x-components.admin.sidenav-link link="{{route('admin.menu.list')}}">
                    <x-slot name="icon">
                        <i class="fad fa-server"></i>
                    </x-slot>
                    Меню
                </x-components.admin.sidenav-link>
            </li>
            @if(env('USE_LANGUAGE'))
            <li class="nav-item">
                <x-components.admin.sidenav-link link="{{route('admin.languages.list')}}">
                    <x-slot name="icon">
                        <i class="fal fa-language fs-4"></i>
                    </x-slot>
                    Языки
                </x-components.admin.sidenav-link>
            </li>
            @endif
            <li class="nav-item">
                <x-components.admin.sidenav-link link="{{route('admin.settings')}}">
                    <x-slot name="icon">
                        <i class="fal fa-cog"></i>
                    </x-slot>
                    Настройки
                </x-components.admin.sidenav-link>
            </li>

            <li class="nav-item">
                <x-components.admin.sidenav-link link="{{route('admin.logout')}}">
                    <x-slot name="icon">
                        <i class="fal fa-sign-out-alt" style="transform: rotate(180deg)"></i>
                    </x-slot>
                    Выйти
                </x-components.admin.sidenav-link>
            </li>
        </ul>
      </div>
    </nav>
