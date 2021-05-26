<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <div class="c-sidebar-brand d-md-down-none">
        {{ config('app.name', 'Laravel') }}
    </div>
    <ul class="c-sidebar-nav ps">
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="/">
                Dashboard
            </a>
        </li>
		<li class="c-sidebar-nav-item">
			<a class="c-sidebar-nav-link" href="{{ route('user.journal.create') }}">
				Submit Journal
			</a>
		</li>
        <li class="c-sidebar-nav-dropdown">
            <a class="c-sidebar-nav-dropdown-toggle" href="#">
                Journal
            </a>
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" href="{{ route('user.journal.index') }}">
                        All
                    </a>
                </li>
                <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ url('user/journals/pending') }}">
                        Pending
                    </a>
                </li>
                <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ url('user/journals/rejected') }}">
                        Rejected
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</div>
