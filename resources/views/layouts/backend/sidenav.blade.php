<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                @if (auth()->user()->hasRole('Administrator'))
                @include('layouts.backend.sidebarAdmin')
                @else
                @include('layouts.backend.sidebarUser')
                @endif
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
