<?php $lang = $this -> session -> userdata('lang'); ?>
<?php require_once(APPPATH."views/lang/$lang.php"); ?>
<!DOCTYPE html>

<head>
    <!-- Vender  -->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>patent_vendor/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>patent_vendor/icon-line-pro/style.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>patent_vendor/icon-line/css/simple-line-icons.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>patent_vendor/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>patent_vendor/fancybox/jquery.fancybox.css">
    <!-- Koko CSS  -->
    <!-- <link rel="stylesheet" type="text/css" href="<?= base_url() ?>patent_css/base.css"> -->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>patent_css/layout.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>patent_css/global.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>patent_css/module.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>patent_css/component.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets_co/assets_/css/styles.multipage-real-estate.css">
</head>


<html lang="en-us" id="extr-page">
	<head>
		<meta charset="utf-8">
		<title>訊息交換系統</title>
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<!-- #CSS Links -->
		<!-- Basic Styles -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?= base_url('css/bootstrap.min.css') ?>">
		<link rel="stylesheet" type="text/css" media="screen" href="<?= base_url('css/font-awesome.min.css') ?>">

		<!-- SmartAdmin Styles : Caution! DO NOT change the order -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?= base_url() ?>css/smartadmin-production-plugins.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?= base_url() ?>css/smartadmin-production.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?= base_url() ?>css/smartadmin-skins.min.css">

		<!-- SmartAdmin RTL Support -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?= base_url() ?>css/smartadmin-rtl.min.css">

		<!-- We recommend you use "your_style.css" to override SmartAdmin
		     specific styles this will also ensure you retrain your customization with each SmartAdmin update.
		<link rel="stylesheet" type="text/css" media="screen" href="css/your_style.css"> -->

		<!-- Demo purpose only: goes with demo.js, you can delete this css when designing your own WebApp -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?= base_url() ?>css/demo.min.css">

		<!-- #FAVICONS -->
		<link rel="icon" type="image/png" href="<?= base_url('img/heart_failure/image.png')  ?>" />

		<!-- #APP SCREEN / ICONS -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?= base_url() ?>css/my.css">

		<!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">

		<style>
			body, html {
			    height: 100%;
			}

			label.error {
				color: red;
			}

			.blurry {
				cursor: pointer;
			}

			body {
				background: url(<?= base_url('img/ktx_img/login_img/login_img_'.$num.'.jpg')  ?>) no-repeat center center fixed!important;				
				-webkit-background-size: cover!important;
				-moz-background-size: cover!important;
				-o-background-size: cover!important;
				background-size: cover!important;
			}
			#main {
				background: none!important;
			}
			.mb-10 {
				margin-bottom: 10px;
			}
		</style>
	</head>

	<body class="animated fadeInDown" >
		<div id="main" role="main">

			<!-- MAIN CONTENT -->
			<div id="content" class="container">

				<div class="row center mb-10">
					<div class=" no-padding ">
						<div class="col-xs-12 col-sm-8 col-md-5 col-lg-4" style="text-align: center; margin: 0px auto!important; float: none!important;">
							<img width="120" src="<?= base_url('img/ktx_img/logo.jpg') ?>" >
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-8 col-md-5 col-lg-4" style="margin: 0px auto!important; float: none!important;">
						<div class="well no-padding">
							<form action="" id="login-form" class="smart-form client-form" method="post">
								<header>
								 登入
								</header>

								<fieldset>

									<section>
										<label class="label">帳號</label>
										<label class="input"> <i class="icon-append fa fa-user"></i>
											<input type="text" required name="account">
											<b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> 請輸入帳號</b></label>
									</section>

									<section>
										<label class="label">密碼</label>
										<label class="input"> <i class="icon-append fa fa-lock"></i>
											<input type="password" name="password">
											<b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> 請輸入密碼</b> </label>
									</section>

									<section>
										<label class="label">驗證碼</label>
										<label class="input"> <i class="icon-append fa fa-lock"></i>
											<input type="text" required name="captcha" autocomplete="off">
											<b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> 請輸入驗證碼</b> </label>
											<div id="c_img"><?php echo $captcha['image']; ?></div>
											<a class="blurry" id="newPic" onclick="getPic();">看不清楚，換一張</a>
									</section>

								</fieldset>
								<footer>
									<button type="submit" class="btn btn-primary">
										登入
									</button>
								</footer>
							</form>
						</div>

					</div>
				</div>
			</div>

		</div>

		<!--================================================== -->

		<!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
		<script src="<?= base_url() ?>js/plugin/pace/pace.min.js"></script>

	    <!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
		<script> if (!window.jQuery) { document.write('<script src="<?= base_url() ?>js/libs/jquery-2.1.1.min.js"><\/script>');} </script>

		<script> if (!window.jQuery.ui) { document.write('<script src="<?= base_url() ?>js/libs/jquery-ui-1.10.3.min.js"><\/script>');} </script>

		<!-- IMPORTANT: APP CONFIG -->
		<script src="<?= base_url() ?>js/app.config.js"></script>

		<!-- JS TOUCH : include this plugin for mobile drag / drop touch events
		<script src="js/plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script> -->

		<!-- BOOTSTRAP JS -->
		<script src="<?= base_url() ?>js/bootstrap/bootstrap.min.js"></script>

		<!-- JQUERY VALIDATE -->
		<script src="<?= base_url() ?>js/plugin/jquery-validate/jquery.validate.min.js"></script>

		<!-- JQUERY MASKED INPUT -->
		<script src="<?= base_url() ?>js/plugin/masked-input/jquery.maskedinput.min.js"></script>

		<!--[if IE 8]>

			<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>

		<![endif]-->

		<!-- MAIN APP JS FILE -->
		<script src="<?= base_url() ?>js/app.min.js"></script>
		<script src="<?= base_url() ?>js/app/login.js"></script>

		<script type="text/javascript">
			runAllForms();

			$(function() {
				// Validation
				$("#login-form").validate({
					// Rules for form validation
					rules : {
						account : {
							required : true
						},
						password : {
							required : true,
							minlength : 3,
							maxlength : 20
						}
					},

					// Messages for form validation
					messages : {
						account : {
							required : '請輸入帳號'
						},
						password : {
							required : '請輸入密碼'
						},
						captcha : {
							required : '請輸入驗證碼'
						}

					},
					// Ajax form submition
					submitHandler : function(form) {
						$.ajax({
							type: "POST",
							url: '<?= base_url('app/login/do_login') ?>',
							data: $("#login-form").serialize(), // serializes the form's elements.
							success: function(data)
							{
								// alert(data);

								if(data.msg) {
									alert(data.msg);
								} else {
									if(data.menu_order>0){
										location.href = "<?= base_url('app/#mgmt/menu_order') ?>";
									} else{
										location.href = "<?= base_url('/app/home/') ?>";
									}
								}
							}
						});
					},

					// Do not change code below
					errorPlacement : function(error, element) {
						error.insertAfter(element.parent());
					}
				});
			});

			function getPic(){
				$.ajax({
			    type: 'GET',
			    url: '<?= base_url('login/refresh_captcha') ?>',
			    data: { },
			    dataType: 'json',
			    success: function (data) {
						 $('#c_img').html(data.captcha.image);
			    }
				});
		};


		$('#add_key').click(function() {
	layer.open({
		type:2,
		title:'',
		closeBtn:0,
		area:['400px','200px'],
		shadeClose:true,
		content:'<?=base_url('mgmt/patent/new_key')?>'
    })
});
		</script>

	</body>
</html>
