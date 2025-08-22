<header id="js-header" class="u-header u-header--static">
  <div class="u-header__section u-header__section--light g-bg-white g-transition-0_3 g-py-10">
    <nav class="js-mega-menu navbar navbar-expand-lg hs-menu-initialized hs-menu-horizontal">
      <div class="container">
        <!-- Responsive Toggle Button -->
        <button class="navbar-toggler navbar-toggler-right btn g-line-height-1 g-brd-none g-pa-0 g-pos-abs g-top-minus-3 g-right-0" type="button" aria-label="Toggle navigation" aria-expanded="false" aria-controls="navBar" data-toggle="collapse" data-target="#navBar">
          <span class="hamburger hamburger--slider">
        <span class="hamburger-box">
          <span class="hamburger-inner"></span>
          </span>
          </span>
        </button>
        <!-- End Responsive Toggle Button -->
        <input class="form-control" type="hidden" id="luna_id" value="<?=isset($login_user) ? $login_user->id: '' ?>"/>
        <input class="form-control" type="hidden" id="now" value="<?=isset($now) ? $now: '' ?>"/>

        <!-- Logo -->
          <div class=" no-padding ">
            <div class="col-xs-12 col-sm-8 col-md-5 col-lg-4" style="text-align: center; margin: 0px auto!important; float: left!important;">
              <img width="180" src="<?= base_url('img/ktx_img/logo.jpg') ?>" >
            </div>
          </div>
        <!-- End Logo -->

      </div>
    </nav>
  </div>
</header>
