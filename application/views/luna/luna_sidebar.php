<div class="col-lg-3 g-mb-50 g-mb-0--lg">

  <!-- User Image -->
  <div class="u-block-hover g-pos-rel">
    <figure>
      <img class="img-fluid w-100 u-block-hover__main--zoom-v1" src="<?= base_url('img/luna/luna.jpg') ?>" alt="Image Description">
    </figure>
  </div>

  <!-- 剩餘點數（會自動更新） -->
  <div class="card g-my-15">
    <div class="card-block g-px-15 g-py-12 d-flex align-items-center justify-content-between">
      <span class="small g-color-gray-dark-v5">剩餘點數</span>
      <strong id="mallPoint" class="h5 mb-0 mono">—</strong>
    </div>
  </div>

  <!-- Sidebar Navigation -->
  <div class="list-group list-group-border-0 g-mb-40">
    <a href="<?= base_url("luna/luna_home") ?>" class="list-group-item justify-content-between luna_home">
      <span><i class="icon-home g-pos-rel g-top-1 g-mr-8"></i> 主頁</span>
    </a>

    <a href="<?= base_url("luna/luna_mall") ?>" class="list-group-item list-group-item-action justify-content-between luna_mall">
      <span><i class="icon-settings g-pos-rel g-top-1 g-mr-8"></i> 線上商城</span>
    </a>

    <?php if ($userlv==2): ?>
      <a href="<?= base_url("luna/luna_gm_product_set") ?>" class="list-group-item list-group-item-action justify-content-between luna_gm_product_set">
        <span><i class="icon-settings g-pos-rel g-top-1 g-mr-8"></i> GM商城設定</span>
      </a>
    <?php endif; ?>

    <a href="<?= base_url("luna/login/logout") ?>" class="list-group-item list-group-item-action justify-content-between">
      <span><i class="icon-logout g-pos-rel g-top-1 g-mr-8"></i> 登出</span>
    </a>
  </div>
  <!-- End Sidebar Navigation -->
</div>

<script>
(function bootWhenReady(){
  function boot(){
    if (!window.jQuery) { setTimeout(boot, 60); return; }
    (function($){
      const API_POINT = '<?= site_url("luna/luna_gm_product_set/balance") ?>';
      const $mp = $('#mallPoint');
      if (!$mp.length) return;

      let lastVal = null;
      function nf(n){ return new Intl.NumberFormat('zh-Hant-TW').format(n); }

      function refreshPoint(){
        $.getJSON(API_POINT, function(res){
          if (!res || !res.ok) return;
          const v = parseInt(res.mall_point || 0, 10);
          if (v !== lastVal) {
            lastVal = v;
            $mp.text(nf(v)).stop(true,true).fadeOut(80).fadeIn(80);
          }
        });
      }

      // 對外公開：可在任一頁面執行 window.dispatchEvent(new Event('mallpoint:refresh'))
      window.addEventListener('mallpoint:refresh', refreshPoint);

      // 進頁面先撈一次，之後每 8 秒輪詢；回到分頁/視窗 focus 也會刷新
      refreshPoint();
      const t = setInterval(refreshPoint, 8000);
      document.addEventListener('visibilitychange', ()=>{ if(!document.hidden) refreshPoint(); });
      window.addEventListener('focus', refreshPoint);
      window.addEventListener('beforeunload', ()=> clearInterval(t));
    })(jQuery);
  }
  if (document.readyState === 'complete') boot();
  else window.addEventListener('load', boot);
})();
</script>
