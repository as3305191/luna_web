<style>
  /* 用於實現類似 fadeOut 和 fadeIn 的效果 */
  #mallPoint.fade-out {
    opacity: 0;
    transition: opacity 0.08s ease-in-out;
  }

  #mallPoint.fade-in {
    opacity: 1;
    transition: opacity 0.08s ease-in-out;
  }
</style>
<div class="col-lg-3 g-mb-50 g-mb-0--lg">

  <!-- User Image -->
  <div class="u-block-hover g-pos-rel">
    <figure>
      <img class="img-fluid w-100 u-block-hover__main--zoom-v1" src="<?= base_url('img/luna/luna01.png') ?>" alt="Image Description">
    </figure>
  </div>

  <!-- 剩餘點數（會自動更新） -->
  <div class="card g-my-15">
    <li class="list-group-item d-flex justify-content-between align-items-center">
      剩餘點數
      <span id="mallPoint" class="mono">--</span>
    </li>
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
    if (!window.fetch) { setTimeout(boot, 60); return; }
    (function(){
      const API_POINT = '<?= site_url("luna/luna_gm_product_set/balance") ?>';
      const mp = document.getElementById('mallPoint');
      if (!mp) return;

      let lastVal = null;
      function nf(n){ return new Intl.NumberFormat('zh-Hant-TW').format(n); }

      function refreshPoint(){
        fetch(API_POINT)
          .then(response => response.json())
          .then(res => {
            if (!res || !res.ok) return;
            const v = parseInt(res.mall_point || 0, 10);
            if (v !== lastVal) {
              lastVal = v;
              mp.textContent = nf(v);
              // 代替 fadeOut 和 fadeIn 的效果
              mp.classList.add('fade-out');
              setTimeout(() => {
                mp.classList.remove('fade-out');
                mp.classList.add('fade-in');
              }, 80);
              setTimeout(() => mp.classList.remove('fade-in'), 160); // 清除 fade-in class
            }
          })
          .catch(error => {
            console.error('Error fetching mall point:', error);
          });
      }

      // 觸發刷新
      window.addEventListener('mallpoint:refresh', refreshPoint);

      // 首次載入頁面後馬上刷新，然後每 8 秒刷新一次；回到分頁或視窗 focus 時也刷新
      refreshPoint();
      const t = setInterval(refreshPoint, 8000);
      document.addEventListener('visibilitychange', () => {
        if (!document.hidden) refreshPoint();
      });
      window.addEventListener('focus', refreshPoint);
      window.addEventListener('beforeunload', () => clearInterval(t));
    })();
  }
  if (document.readyState === 'complete') boot();
  else window.addEventListener('load', boot);
})();

</script>
