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





				<li class="menu-label">service_provider setup</li>
				<li>
					<a class="has-arrow" href="javascript:;">

				    <div class="menu-title">service_provider status</div>
					</a>
					<ul>
						<li> <a href="{{ route('active.provider') }}"><i class="bx bx-right-arrow-alt"></i>service_provider active</a>
						</li>
						<li> <a href="{{ route('inactive.provider') }}"><i class="bx bx-right-arrow-alt"></i>service_provider inactive</a>
						</li>

					</ul>
				</li>
                
			</ul>

			<!--end navigation-->
		</div>
