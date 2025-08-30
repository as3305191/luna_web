<script src="<?= base_url() ?>luna_1/assets/vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url() ?>luna_1/assets/vendor/jquery-migrate/jquery-migrate.min.js"></script>
<script src="<?= base_url() ?>luna_1/assets/vendor/popper.js/popper.min.js"></script>
<script src="<?= base_url() ?>luna_1/assets/vendor/bootstrap/bootstrap.min.js"></script>


<!-- JS Implementing Plugins -->
<script src="<?= base_url() ?>luna_1/assets/vendor/appear.js"></script>
<script src="<?= base_url() ?>luna_1/assets/vendor/hs-megamenu/src/hs.megamenu.js"></script>
<script src="<?= base_url() ?>luna_1/assets/vendor/malihu-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- JS Unify -->
<script src="<?= base_url() ?>luna_1/assets/js/hs.core.js"></script>
<script src="<?= base_url() ?>luna_1/assets/js/helpers/hs.hamburgers.js"></script>
<script src="<?= base_url() ?>luna_1/assets/js/components/hs.header.js"></script>
<script src="<?= base_url() ?>luna_1/assets/js/components/hs.tabs.js"></script>
<script src="<?= base_url() ?>luna_1/assets/js/components/hs.counter.js"></script>
<script src="<?= base_url() ?>luna_1/assets/js/components/hs.progress-bar.js"></script>
<script src="<?= base_url() ?>luna_1/assets/js/components/hs.rating.js"></script>
<script src="<?= base_url() ?>luna_1/assets/js/components/hs.scrollbar.js"></script>
<script src="<?= base_url() ?>luna_1/assets/js/components/hs.go-to.js"></script>
<script src="<?= base_url('js/plugin/bootstrap-fileinput/js/fileinput.js') ?>"></script>

<!-- JS Customization -->
<script src="<?= base_url() ?>luna_1/assets/js/custom.js"></script>

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
      const BAL_URL = '<?= site_url("luna/luna_gm_product_set/balance") ?>';

  // 這個函式給全站共用，mall/首頁/側欄都能用
  window.refreshMallPoint = function refreshMallPoint(){
    const el = document.getElementById('mallPoint');
    if (!el) return; // 沒有這個元素就跳過
    fetch(BAL_URL, {
      method: 'GET',
      credentials: 'include',
      headers: {'X-Requested-With':'XMLHttpRequest', 'Accept':'application/json'}
    })
    .then(r => r.ok ? r.json() : null)
    .then(j => {
      if (!j) return;
      // 後端每次會回最新 CSRF，一併更新（你已有 setCsrfPair 的話就用它）
      if (typeof setCsrfPair === 'function') {
        if (j.csrf_name && j.csrf_hash) setCsrfPair(j.csrf_name, j.csrf_hash);
        if (j.csrf && j.csrf.name && j.csrf.hash) setCsrfPair(j.csrf.name, j.csrf.hash);
      }
      if (j.ok && typeof j.mall_point !== 'undefined') {
        try {
          el.textContent = new Intl.NumberFormat('zh-Hant-TW').format(j.mall_point);
        } catch(_){ el.textContent = j.mall_point; }
      }
    })
    .catch(()=>{});
  };

  // 首次載入 + 每 10 秒刷新一次
  try { window.refreshMallPoint(); } catch(_){}
  setInterval(function(){ try{ window.refreshMallPoint(); }catch(_){}} , 10000);
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
