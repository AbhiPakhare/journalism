<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <div class="c-sidebar-brand d-md-down-none">
        {{ config('app.name', 'Laravel') }}
    </div>
    <ul class="c-sidebar-nav ps ">
        <li class="c-sidebar-nav-title">Journal</li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{route('manager.dashboard')}}">
                Submitted Journals
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{route('manager.show-approved-journals')}}">
                Approved Journals
            </a>
        </li>
        <li class="c-sidebar-nav-title">Staff</li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{route('manager.show-staffs')}}">
                List Of Staff
            </a>
        </li>
     
    </ul>
    
</div>
