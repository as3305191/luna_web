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
</script>

<script>
/* ---- Mall 點數輪詢：純 GET，避免 CSRF 造成逾時 ---- */
(function () {
  // 後端 balance endpoint（允許 GET）
  var BAL_URL = '<?= site_url("luna/luna_gm_product_set/balance") ?>';

  // 小工具：安全 NumberFormat
  function nf(n) { try { return new Intl.NumberFormat('zh-Hant-TW').format(n); } catch (e) { return n; } }

  // 從回應自動同步 CSRF（之後其他 POST 會用到）
  function syncCsrfFrom(resp) {
    try {
      if (!resp) return;
      // 你的專案同時可能回 {csrf:{name,hash}} 或 {csrf_name, csrf_hash}
      if (resp.csrf && resp.csrf.name && resp.csrf.hash && typeof setCsrfPair === 'function') {
        setCsrfPair(resp.csrf.name, resp.csrf.hash);
      } else if (resp.csrf_name && resp.csrf_hash && typeof setCsrfPair === 'function') {
        setCsrfPair(resp.csrf_name, resp.csrf_hash);
      }
    } catch (_) { /* 靜默 */ }
  }

  // 真的去拉點數
  function refreshMallPoint() {
    var el = document.getElementById('mallPoint');
    if (!el) return; // 頁面沒有就當沒這回事（不報錯）
    fetch(BAL_URL, {
      method: 'GET',
      headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
      credentials: 'include'
    })
    .then(function (r) { return r.ok ? r.json() : null; })
    .then(function (j) {
      if (!j) return;
      syncCsrfFrom(j);
      if (j.ok && typeof j.mall_point !== 'undefined') {
        el.textContent = nf(j.mall_point);
      }
    })
    .catch(function(){ /* 靜默 */ });
  }

  // 讓別頁也能手動呼叫（可選）
  window.refreshMallPoint = refreshMallPoint;

  // DOM Ready 後就跑一次，之後每 10 秒跑一次
  if (window.jQuery) {
    jQuery(function(){ try { refreshMallPoint(); } catch (_) {} });
  } else {
    // 沒 jQuery 也不會炸
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', function(){ try { refreshMallPoint(); } catch (_) {} });
    } else {
      try { refreshMallPoint(); } catch (_) {}
    }
  }
  setInterval(function(){ try { refreshMallPoint(); } catch(_) {} }, 10000);
})();
</script>
