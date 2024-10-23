<script src="<?= base_url() ?>old_system_view_1/assets/vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url() ?>old_system_view_1/assets/vendor/jquery-migrate/jquery-migrate.min.js"></script>
<script src="<?= base_url() ?>old_system_view_1/assets/vendor/popper.js/popper.min.js"></script>
<script src="<?= base_url() ?>old_system_view_1/assets/vendor/bootstrap/bootstrap.min.js"></script>


<!-- JS Implementing Plugins -->
<script src="<?= base_url() ?>old_system_view_1/assets/vendor/appear.js"></script>
<script src="<?= base_url() ?>old_system_view_1/assets/vendor/hs-megamenu/src/hs.megamenu.js"></script>
<script src="<?= base_url() ?>old_system_view_1/assets/vendor/malihu-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- JS Unify -->
<script src="<?= base_url() ?>old_system_view_1/assets/js/hs.core.js"></script>
<script src="<?= base_url() ?>old_system_view_1/assets/js/helpers/hs.hamburgers.js"></script>
<script src="<?= base_url() ?>old_system_view_1/assets/js/components/hs.header.js"></script>
<script src="<?= base_url() ?>old_system_view_1/assets/js/components/hs.tabs.js"></script>
<script src="<?= base_url() ?>old_system_view_1/assets/js/components/hs.counter.js"></script>
<script src="<?= base_url() ?>old_system_view_1/assets/js/components/hs.progress-bar.js"></script>
<script src="<?= base_url() ?>old_system_view_1/assets/js/components/hs.rating.js"></script>
<script src="<?= base_url() ?>old_system_view_1/assets/js/components/hs.scrollbar.js"></script>
<script src="<?= base_url() ?>old_system_view_1/assets/js/components/hs.go-to.js"></script>
<script src="<?= base_url('js/plugin/bootstrap-fileinput/js/fileinput.js') ?>"></script>

<!-- JS Customization -->
<script src="<?= base_url() ?>old_system_view_1/assets/js/custom.js"></script>

<!-- JS Plugins Init. -->
<script>
  $(document).on('ready', function () {
      // initialization of go to
      $.HSCore.components.HSGoTo.init('.js-go-to');

      // initialization of tabs
      $.HSCore.components.HSTabs.init('[role="tablist"]');

      // initialization of counters
      var counters = $.HSCore.components.HSCounter.init('[class*="js-counter"]');

      // initialization of rating
      $.HSCore.components.HSRating.init($('.js-rating'), {
        spacing: 2
      });

      // initialization of HSScrollBar component
      $.HSCore.components.HSScrollBar.init( $('.js-scrollbar') );
    });

    $(window).on('load', function () {
      // initialization of header
      $.HSCore.components.HSHeader.init($('#js-header'));
      $.HSCore.helpers.HSHamburgers.init('.hamburger');

      // initialization of HSMegaMenu component
      $('.js-mega-menu').HSMegaMenu({
        event: 'hover',
        pageContainer: $('.container'),
        breakpoint: 991
      });

      // initialization of horizontal progress bars
      setTimeout(function () { // important in this case
        var horizontalProgressBars = $.HSCore.components.HSProgressBar.init('.js-hr-progress-bar', {
          direction: 'horizontal',
          indicatorSelector: '.js-hr-progress-bar-indicator'
        });
      }, 1);
    });

    $(window).on('resize', function () {
      setTimeout(function () {
        $.HSCore.components.HSTabs.init('[role="tablist"]');
      }, 200);
    });

    var now_page = $('#now').val();
    $('.'+now_page).addClass('active');
</script>
