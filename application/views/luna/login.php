<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Title -->
  <title>Luna登入</title>

  <!-- Required Meta Tags Always Come First -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <!-- Favicon -->
  <link rel="shortcut icon" href="<?= base_url() ?>luna_1/favicon.ico">
  <!-- Google Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800">
  <!-- CSS Global Compulsory -->
  <link rel="stylesheet" href="<?= base_url() ?>luna_1/assets/vendor/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>luna_1/assets/vendor/icon-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>luna_1/assets/vendor/icon-hs/style.css">
  <link rel="stylesheet" href="<?= base_url() ?>luna_1/assets/vendor/animate.css">
  <link rel="stylesheet" href="<?= base_url() ?>luna_1/assets/vendor/hs-megamenu/src/hs.megamenu.css">
  <link rel="stylesheet" href="<?= base_url() ?>luna_1/assets/vendor/hamburgers/hamburgers.min.css">

  <!-- CSS Unify -->
  <link rel="stylesheet" href="<?= base_url() ?>luna_1/assets/css/unify-core.css">
  <link rel="stylesheet" href="<?= base_url() ?>luna_1/assets/css/unify-components.css">
  <link rel="stylesheet" href="<?= base_url() ?>luna_1/assets/css/unify-globals.css">

  <!-- CSS Customization -->
  <link rel="stylesheet" href="<?= base_url() ?>luna_1/assets/css/custom.css">
</head>

<body>
  <main>



    <!-- Header -->
    <header id="js-header" class="u-header u-header--static">
    </header>
    <!-- End Header -->

    <!-- Breadcrumbs -->
    <section class="">

    </section>
    <!-- End Breadcrumbs -->

    <!-- Login -->
    <section class="container g-py-100">
      <div class="row justify-content-center">
        <div class="col-sm-8 col-lg-5">
          <div class="g-brd-around g-brd-gray-light-v4 rounded g-py-40 g-px-30">
            <header class="text-center mb-4">
              <h2 class="h2 g-color-black g-font-weight-600">Luna登入</h2>
            </header>

            <!-- Form -->
            <form class="g-py-15" id="login-form">
              <div class="mb-4">
                <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">帳號:</label>
                <input class="form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15" required name="account" type="text" placeholder="請輸入帳號">
              </div>

              <div class="g-mb-35">
                <div class="row justify-content-between">
                  <div class="col align-self-center">
                    <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Password:</label>
                  </div>
                </div>
                <input class="form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15 mb-3" name="password" type="password" placeholder="請輸入密碼">
                <div class="row justify-content-between">

                  <div class="col-4 align-self-center text-right">
                    <button class="btn btn-md u-btn-primary rounded g-py-13 g-px-25" type="submit">登入</button>
                  </div>
                </div>
              </div>
            </form>
            <!-- End Form -->
          </div>
        </div>
      </div>
    </section>
    <!-- End Login -->
    <!-- End Copyright Footer -->

  </main>

  <div class="u-outer-spaces-helper"></div>

  <!-- JS Global Compulsory -->
  <script src="<?= base_url() ?>luna_1/assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?= base_url() ?>luna_1/assets/vendor/jquery-migrate/jquery-migrate.min.js"></script>
  <script src="<?= base_url() ?>luna_1/assets/vendor/popper.js/popper.min.js"></script>
  <script src="<?= base_url() ?>luna_1/assets/vendor/bootstrap/bootstrap.min.js"></script>


  <!-- JS Implementing Plugins -->
  <script src="<?= base_url() ?>luna_1/assets/vendor/hs-megamenu/src/hs.megamenu.js"></script>

  <!-- JS Unify -->
  <script src="<?= base_url() ?>luna_1/assets/js/hs.core.js"></script>
  <script src="<?= base_url() ?>luna_1/assets/js/components/hs.header.js"></script>
  <script src="<?= base_url() ?>luna_1/assets/js/helpers/hs.hamburgers.js"></script>
  <script src="<?= base_url() ?>luna_1/assets/js/components/hs.tabs.js"></script>
  <script src="<?= base_url() ?>luna_1/assets/js/components/hs.go-to.js"></script>

  <!-- JS Customization -->
  <script src="<?= base_url() ?>luna_1/assets/js/custom.js"></script>
  <script src="<?= base_url() ?>js/plugin/jquery-validate/jquery.validate.min.js"></script>
  <!-- JS Plugins Init. -->
  <script>

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
  							url: '<?= base_url('luna/login/do_login') ?>',
  							data: $("#login-form").serialize(), // serializes the form's elements.
  							success: function(data)
  							{
  									if(data.msg) {
  										alert(data.msg);
  									} else {
  										location.href = "<?= base_url('luna/luna_home') ?>";
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


   

  </script>

</body>

</html>
