<header class="page-topbar" id="header">
	<div class="navbar navbar-fixed">
		<nav class="<?php echo $top_nav_layout; ?>">
			<div class="nav-wrapper">
				<div class="header-search-wrapper hide-on-med-and-down"><i class="material-icons">search</i>
					<input class="header-search-input z-depth-2" type="text" name="Search" placeholder="Search" data-search="template-list">
					<ul class="search-list collection display-none"></ul>
				</div>
				<ul class="navbar-list right">
					<?php /*?>
		  	<li class="dropdown-language"><a class="waves-effect waves-block waves-light translation-button" href="#" data-target="translation-dropdown"><span class="flag-icon flag-icon-gb"></span></a></li>
		  <?php */ ?>
					<li class="hide-on-med-and-down"><a class="waves-effect waves-block waves-light toggle-fullscreen" href="javascript:void(0);"><i class="material-icons">settings_overscan</i></a></li>
					<li class="hide-on-large-only search-input-wrapper"><a class="waves-effect waves-block waves-light search-button" href="javascript:void(0);"><i class="material-icons">search</i></a></li>
					<?php /*?>
					<li><a class="waves-effect waves-block waves-light notification-button" href="javascript:void(0);" data-target="notifications-dropdown"><i class="material-icons">notifications_none<small class="notification-badge">5</small></i></a></li>
					<?php */ ?>
					<li><a class="waves-effect waves-block waves-light profile-button" href="javascript:void(0);" data-target="profile-dropdown"><span class="avatar-status avatar-online"><img src="<?php echo $directory_path; ?>/app-assets/images/avatar/avatar-7.png" alt="avatar"><i></i></span></a></li>
					<?php /*?>
		  <li><a class="waves-effect waves-block waves-light sidenav-trigger" href="#" data-target="slide-out-right"><i class="material-icons">format_indent_increase</i></a></li>
		  <?php */ ?>
				</ul>
				<!-- translation-button-->
				<ul class="dropdown-content" id="translation-dropdown">
					<li class="dropdown-item"><a class="grey-text text-darken-1" href="#!" data-language="en"><i class="flag-icon flag-icon-gb"></i> English</a></li>
					<li class="dropdown-item"><a class="grey-text text-darken-1" href="#!" data-language="fr"><i class="flag-icon flag-icon-fr"></i> French</a></li>
					<li class="dropdown-item"><a class="grey-text text-darken-1" href="#!" data-language="pt"><i class="flag-icon flag-icon-pt"></i> Portuguese</a></li>
					<li class="dropdown-item"><a class="grey-text text-darken-1" href="#!" data-language="de"><i class="flag-icon flag-icon-de"></i> German</a></li>
				</ul>
				<!-- notifications-dropdown-->
				<?php /*?>
		<ul class="dropdown-content" id="notifications-dropdown">
		  <li>
			<h6>NOTIFICATIONS<span class="new badge">5</span></h6>
		  </li>
		  <li class="divider"></li>
		  <li><a class="black-text" href="#!"><span class="material-icons icon-bg-circle cyan small">add_shopping_cart</span> A new order has been placed!</a>
			<time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">2 hours ago</time>
		  </li>
		  <li><a class="black-text" href="#!"><span class="material-icons icon-bg-circle red small">stars</span> Completed the task</a>
			<time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">3 days ago</time>
		  </li>
		  <li><a class="black-text" href="#!"><span class="material-icons icon-bg-circle teal small">settings</span> Settings updated</a>
			<time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">4 days ago</time>
		  </li>
		  <li><a class="black-text" href="#!"><span class="material-icons icon-bg-circle deep-orange small">today</span> Director meeting started</a>
			<time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">6 days ago</time>
		  </li>
		  <li><a class="black-text" href="#!"><span class="material-icons icon-bg-circle amber small">trending_up</span> Generate monthly report</a>
			<time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">1 week ago</time>
		  </li>
		</ul>
		<?php */ ?>
				<!-- profile-dropdown-->
				<ul class="dropdown-content" id="profile-dropdown">
					<li><a class="grey-text text-darken-1" href="?string=<?php echo encrypt("module=admin_profile&page=listing") ?>"><i class="material-icons">person_outline</i> Profile</a></li>
					<li class="divider"></li>
					<li>
						<a class="grey-text text-darken-1" href="?string=<?php echo encrypt("module=change_password_admin&page=listing") ?>">
							<i class="material-icons">lock_outline</i> Password
						</a>
					</li>
					<li class="divider"></li>
					<li><a class="grey-text text-darken-1" href="signout"><i class="material-icons">keyboard_tab</i> Logout</a></li>
					<?php /*
		   <li><a class="grey-text text-darken-1" href="#"><i class="material-icons">chat_bubble_outline</i> Chat</a></li>
		  <li><a class="grey-text text-darken-1" href="#"><i class="material-icons">help_outline</i> Help</a></li>
		  <li><a class="grey-text text-darken-1" href="#"><i class="material-icons">lock_outline</i> Lock</a></li>
		  <?php */ ?>
				</ul>
			</div>
			<nav class="display-none search-sm">
				<div class="nav-wrapper">
					<form id="navbarForm">
						<div class="input-field search-input-sm">
							<input class="search-box-sm mb-0" type="search" required="" id="search" placeholder="Search" data-search="template-list">
							<label class="label-icon" for="search"><i class="material-icons search-sm-icon">search</i></label><i class="material-icons search-sm-close">close</i>
							<ul class="search-list collection search-list-sm display-none"></ul>
						</div>
					</form>
				</div>
			</nav>
		</nav>
	</div>
</header>