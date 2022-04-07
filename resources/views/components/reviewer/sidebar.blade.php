<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index3.html" class="brand-link">
        <img src="{{asset('dist/img/AdminLTELogo.png')}}" alt="Admin dashboard" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name', 'Journalism') }}</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                    <a href="/" class="nav-link">
                        <i class="fas fa-tachometer"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-header">Journal</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                        Manage Journals
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="{{route('reviewer.journal.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p> List of Journals</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('reviewer/my-work/approved') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Approved Journals</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('reviewer/my-work/rejected') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Rejected Journals</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>

