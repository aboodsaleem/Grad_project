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
				<li>
					<a href="{{ route('admin.dashboard') }}" class="has-arrow">
						<div class="parent-icon"><i class='bx bx-home-circle'></i>
						</div>
						<div class="menu-title">Dashboard</div>
					</a>
                </li>


                <li class="menu-label">Web Apps</li>
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-category"></i>
						</div>
						<div class="menu-title">Email</div>
					</a>
					<ul>
						<li> <a href="app-emailbox.html"><i class="bx bx-right-arrow-alt"></i>Inbox</a>
						</li>
						<li> <a href="app-chat-box.html"><i class="bx bx-right-arrow-alt"></i>Read</a>
						</li>
						<li> <a href="{{ route('admin.email_compose') }}"><i class="bx bx-right-arrow-alt"></i>Compose</a>
						</li>

					</ul>
				</li>

                <li class="menu-label">Role</li>
				<li class="@if (Request::segment(2) == 'users') active @endif">
					<a href="{{ route('admin.users.list') }}">
						<div class="parent-icon"><i class="bx bx-folder"></i>
						</div>
						<div class="menu-title">Users</div>
					</a>
				</li>
{{--
				<li class="menu-label">Component</li>

				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class='bx bx-cart'></i>
						</div>
						<div class="menu-title">Category</div>
					</a>
					<ul>
						<li> <a href=""><i class="bx bx-right-arrow-alt"></i>All Categories</a>
						</li>
						<li> <a href=""><i class="bx bx-right-arrow-alt"></i>Create Categories</a>
						</li>
                        {{-- <li> <a href="{{ route('admin.categories.trashed') }}"><i class="bx bx-right-arrow-alt"></i>Trashed Categories</a>
						</li> --}}
{{--
					</ul>
				</li>

                <li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class='bx bx-cart'></i>
						</div>
						<div class="menu-title">Service</div>
					</a>
					<ul>
						<li> <a href=""><i class="bx bx-right-arrow-alt"></i>All Services</a>
						</li>
						<li> <a href=""><i class="bx bx-right-arrow-alt"></i>Create Services</a>
						</li>
                        {{-- <li> <a href="{{ route('admin.services.trashed') }}"><i class="bx bx-right-arrow-alt"></i>Trashed Services</a>
						</li> --}}
{{--
					</ul>
				</li>

                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class='bx bx-calendar'></i></div>
                        <div class="menu-title">Bookings</div>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('admin.bookings.index') }}">
                                <i class="bx bx-right-arrow-alt"></i>All Bookings
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <i class="bx bx-right-arrow-alt"></i>Create Booking
                            </a>
                        </li>
                    </ul>
                </li> --}}





				<li class="menu-label">Others</li>
				<li>
					<a href="https://codervent.com/rukada/documentation/index.html" target="_blank">
						<div class="parent-icon"><i class="bx bx-folder"></i>
						</div>
						<div class="menu-title">Documentation</div>
					</a>
				</li>

			</ul>
			<!--end navigation-->
		</div>
