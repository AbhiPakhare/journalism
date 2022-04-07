<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index3.html" class="brand-link">
        <img src="{{asset('dist/img/AdminLTELogo.png')}}" alt="Admin dashboard" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="fas fa-tachometer"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p>
                            Manager
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="{{ route('admin.manager.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create Manager</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.manager.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List of Managers</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-edit"></i>
                        <p>
                            Reviewer
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="{{ route('admin.reviewer.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create reviewer</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.reviewer.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List of reviewers</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-list"></i>
                        <p>
                            category
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="{{ route('admin.category.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create category</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.category.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List of categories</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.list-of-users') }}" class="nav-link">
                        <i class="nav-icon far fa-users-cog"></i>
                        <p>
                            List of Users
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.show-approved-journals') }}" class="nav-link">
                        <i class="nav-icon fas fa-check-circle"></i>
                        <p>
                            Approved Journals
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>