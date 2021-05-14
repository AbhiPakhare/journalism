<header class="c-header c-header-light c-header-fixed c-header-with-subheader">
    <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show">
        <i class="fas fa-bars"></i>
    </button>
    <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
        <i class="fas fa-bars"></i>
    </button>
    <div class="c-header-nav d-md-down-none">
        <p class="c-header-nav-item m-0"> Welcome, {{auth()->user()->name}}</p>
    </div>
    <ul class="c-header-nav ml-auto mr-4">
        <li class="c-header-nav-item dropdown">
           <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="true">
              {{ auth()->user()->name }}
           </a>
           <div class="dropdown-menu dropdown-menu-right pt-0 ">
              <div class="dropdown-header bg-light py-2"><strong>Account</strong></div>
              <a
                class="dropdown-item"
                href="{{ route('logout') }}"
                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
              </a>
           </div>
        </li>
     </ul>
     <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</header>
