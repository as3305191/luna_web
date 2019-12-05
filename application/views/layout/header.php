<!-- #HEADER -->
<header id="header">
	<div id="logo-group">

		<!-- PLACE YOUR LOGO HERE -->
		<span id="logo">
			<img src="<?= base_url() ?>img/body_fat/logo/logo_1.png" alt="body_fat">
		</span>
		<!-- END LOGO PLACEHOLDER -->
	</div>

	<style>
	.marquee {
		position:absolute;
		width: 100%;
		overflow: hidden;
		border: 1px solid #ccc;
		background: #ccc;
		height: 20px;
		overflow: hidden;
	}

	.marquee div {
		position:absolute;
		top: 30px;
	}

	#bank_alert {
		position: absolute;
		top:32px!important;
		left: 50px;
		right:100px;
		top:10px;
		max-width:400px;
		color:#AAFFFF;
		height:20px;
	}

	.blink_me {
  	animation: blinker 2s linear infinite;
	}

	@keyframes blinker {
	  50% { opacity: 0; }
	}

	#main {
		min-height: 100vh;
	}
	</style>


	<!-- #TOGGLE LAYOUT BUTTONS -->
	<!-- pulled right: nav area -->
	<div class="pull-right">

		<!-- collapse menu button -->
		<div id="hide-menu" class="btn-header pull-right">
			<span> <a href="javascript:void(0);" data-action="toggleMenu" title="Collapse Menu"><i class="fa fa-reorder"></i></a> </span>
		</div>
		<!-- end collapse menu -->

		<!-- logout button -->
		<div id="logout" class="btn-header transparent pull-right">
			<span> <a href="<?=isset($login_store_id)?'loginS/logout':'login/logout'?>" title="Sign Out" data-action="userLogout" data-logout-msg="You can improve your security further after logging out by closing this opened browser"><i class="fa fa-sign-out"></i></a> </span>
		</div>
		<!-- end logout button -->

		<!-- fullscreen button -->
		<div id="fullscreen" class="btn-header transparent pull-right">
			<span> <a href="javascript:void(0);" data-action="launchFullscreen" title="Full Screen"><i class="fa fa-arrows-alt"></i></a> </span>
		</div>
		<!-- end fullscreen button -->

	</div>
	<!-- end pulled right: nav area -->

</header>
<!-- END HEADER -->
