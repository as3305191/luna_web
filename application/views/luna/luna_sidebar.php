<div class="col-lg-3 g-mb-50 g-mb-0--lg">

  <!-- User Image -->
  <div class="u-block-hover g-pos-rel">
    <figure>
      <img class="img-fluid w-100 u-block-hover__main--zoom-v1" src="<?= base_url('img/body_fat/logo/logo_body_fat.png') ?>" alt="Image Description">
    </figure>

  </div>
  <!-- User Image -->

  <!-- Sidebar Navigation -->
  <div class="list-group list-group-border-0 g-mb-40">
    <!-- Overall -->

    <a href="<?= base_url("luna/luna_home") ?>" class="list-group-item justify-content-between luna_home">
      <span><i class="icon-home g-pos-rel g-top-1 g-mr-8"></i> 主頁</span>
    </a>


    <a href="<?= base_url("luna/luna_mall") ?>" class="list-group-item list-group-item-action justify-content-between luna_mall">
      <span><i class="icon-settings g-pos-rel g-top-1 g-mr-8"></i> 線上商城</span>
    </a>
    
     <?php if ($userlv==2): ?>
        <!-- <a href="<?= base_url("luna/luna_gmtool") ?>" class="list-group-item list-group-item-action justify-content-between luna_gmtool">
          <span><i class="icon-settings g-pos-rel g-top-1 g-mr-8"></i> GM發道具</span>
        </a> -->
         <a href="<?= base_url("luna/luna_gm_product_set") ?>" class="list-group-item list-group-item-action justify-content-between luna_gm_product_set">
          <span><i class="icon-settings g-pos-rel g-top-1 g-mr-8"></i> GM商城設定</span>
        </a>
      <?php endif; ?>
   
    <a href="<?= base_url("luna/login/logout") ?>" class="list-group-item list-group-item-action justify-content-between">
      <span><i class="icon-logout g-pos-rel g-top-1 g-mr-8"></i> 登出</span>
    </a>
    <!-- End Settings -->
  </div>
  <!-- End Sidebar Navigation -->
</div>
