<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ asset('adminbackend/assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">Admin Dashboard</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">

        <li class="@if (Request::segment(2) == 'dashboard') active @endif">
            <a href="{{ route('admin.dashboard') }}">
                <div class="parent-icon"><i class='bx bx-home-circle'></i></div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>

        <li class="menu-label">service_provider setup</li>
				<li>
					<a class="has-arrow" href="javascript:;">

				    <div class="menu-title">service_provider status</div>
					</a>
					<ul>
						<li> <a href="{{ route('admin.active.provider') }}"><i class="bx bx-right-arrow-alt"></i>service_provider active</a>
						</li>
						<li> <a href="{{ route('admin.inactive.provider') }}"><i class="bx bx-right-arrow-alt"></i>service_provider inactive</a>
						</li>

					</ul>
				</li>


        <li class="menu-label">Web Apps</li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-category"></i></div>
                <div class="menu-title">Email</div>
            </a>
            <ul>
                <li> <a href="app-emailbox.html"><i class="bx bx-right-arrow-alt"></i>Inbox</a></li>
                <li> <a href="app-chat-box.html"><i class="bx bx-right-arrow-alt"></i>Read</a></li>
                <li> <a href="{{ route('admin.email_compose') }}"><i class="bx bx-right-arrow-alt"></i>Compose</a></li>
            </ul>
        </li>

        <li class="menu-label">Role</li>

        <li class="@if (Request::segment(2) == 'users') active @endif">
            <a href="{{ route('admin.users.list') }}">
                <div class="parent-icon"><i class='fas fa-users fs-5 text-muted'></i></div>
                <div class="menu-title">Users</div>
            </a>
        </li>

        <!-- إضافة قائمة الخدمات -->
        <li class="menu-label">Component</li>
        <li class="@if (Request::segment(2) == 'services') active @endif">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fas fa-tools fs-5 text-muted"></i></div>
                <div class="menu-title">Services</div>
            </a>
            <ul>
                <li><a href="{{ route('admin.services.index') }}"><i class="bx bx-right-arrow-alt"></i>All Services</a></li>
                <li><a href="{{ route('admin.services.create') }}"><i class="bx bx-right-arrow-alt"></i>Add Service</a></li>
            </ul>
        </li>

        <li class="@if (Request::segment(2) == 'bookings') active @endif">
            <a href="{{ route('admin.bookings.index') }}">
                <div class="parent-icon"><i class='fas fa-calendar-check fs-5 text-muted'></i></div>
                <div class="menu-title">Bookings</div>
            </a>
        </li>

        <li class="menu-label">Others</li>
        <li>
            <a href="https://codervent.com/rukada/documentation/index.html" target="_blank">
                <div class="parent-icon"><i class="bx bx-folder"></i></div>
                <div class="menu-title">Documentation</div>
            </a>
        </li>

    </ul>
    <!--end navigation-->
</div>

