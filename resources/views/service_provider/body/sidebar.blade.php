	<div class="sidebar-wrapper" data-simplebar="true">
			<div class="sidebar-header">
				<div>
					<img src="{{ asset('adminbackend/assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
				</div>
				<div>
					<h4 class="logo-text">Services Provider Dashboard</h4>
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

				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-category"></i>
						</div>
						<div class="menu-title">Application</div>
					</a>
					<ul>
						<li> <a href="app-emailbox.html"><i class="bx bx-right-arrow-alt"></i>Email</a>
						</li>
						<li> <a href="app-chat-box.html"><i class="bx bx-right-arrow-alt"></i>Chat Box</a>
						</li>
						<li> <a href="app-file-manager.html"><i class="bx bx-right-arrow-alt"></i>File Manager</a>
						</li>
						<li> <a href="app-contact-list.html"><i class="bx bx-right-arrow-alt"></i>Contatcs</a>
						</li>
						<li> <a href="app-to-do.html"><i class="bx bx-right-arrow-alt"></i>Todo List</a>
						</li>
						<li> <a href="app-invoice.html"><i class="bx bx-right-arrow-alt"></i>Invoice</a>
						</li>
						<li> <a href="app-fullcalender.html"><i class="bx bx-right-arrow-alt"></i>Calendar</a>
						</li>
					</ul>
				</li>


				<li class="menu-label">Component</li>

				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class='bx bx-cart'></i>
						</div>
						<div class="menu-title">Category</div>
					</a>
					<ul>
						<li> <a href="{{ route('provider.categories.index') }}"><i class="bx bx-right-arrow-alt"></i>All Categories</a>
						</li>
						<li> <a href="{{ route('provider.categories.create') }}"><i class="bx bx-right-arrow-alt"></i>Create Categories</a>
						</li>
                        {{-- <li> <a href="{{ route('admin.categories.trashed') }}"><i class="bx bx-right-arrow-alt"></i>Trashed Categories</a>
						</li> --}}

					</ul>
				</li>

                <li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class='bx bx-cart'></i>
						</div>
						<div class="menu-title">Service</div>
					</a>
					<ul>
						<li> <a href="{{ route('provider.services.index') }}"><i class="bx bx-right-arrow-alt"></i>All Services</a>
						</li>
						<li> <a href="{{ route('provider.services.create') }}"><i class="bx bx-right-arrow-alt"></i>Create Services</a>
						</li>
                        {{-- <li> <a href="{{ route('admin.services.trashed') }}"><i class="bx bx-right-arrow-alt"></i>Trashed Services</a>
						</li> --}}

					</ul>
				</li>






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
