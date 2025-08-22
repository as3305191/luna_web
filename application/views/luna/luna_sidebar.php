<div class="col-lg-3 g-mb-50 g-mb-0--lg">

  <!-- User Image -->
  <div class="u-block-hover g-pos-rel">
    <figure>
      <img class="img-fluid w-100 u-block-hover__main--zoom-v1" src="<?= base_url('img/body_fat/logo/logo_body_fat.png') ?>" alt="Image Description">
    </figure>



    <!-- User Info -->
    <!-- <span class="g-pos-abs g-top-20 g-left-0">
        <a class="btn btn-sm u-btn-primary rounded-0" href="#">Johne Doe</a>
        <small class="d-block g-bg-black g-color-white g-pa-5">Project Manager</small>
      </span> -->
    <!-- End User Info -->
  </div>
  <!-- User Image -->

  <!-- Sidebar Navigation -->
  <div class="list-group list-group-border-0 g-mb-40">
    <!-- Overall -->

    <a href="<?= base_url("luna/luna_home") ?>" class="list-group-item justify-content-between luna_home">
      <span><i class="icon-home g-pos-rel g-top-1 g-mr-8"></i> 主頁</span>
      <!-- <span class="u-label g-font-size-11 g-bg-white g-color-main g-rounded-20 g-px-10">2</span> -->
    </a>

    <!-- Settings -->
    <!-- <a href="<?= base_url("luna/luna_setting") ?>" class="list-group-item list-group-item-action justify-content-between luna_setting">
      <span><i class="icon-settings g-pos-rel g-top-1 g-mr-8"></i> 設定</span>
    </a> -->
    <!-- <a href="<?= base_url("luna/member_weight_today") ?>" class="list-group-item list-group-item-action justify-content-between member_weight_today">
      <span><i class="icon-settings g-pos-rel g-top-1 g-mr-8"></i> 今日上秤學員顯示列表</span>
    </a> -->
    <a href="<?= base_url("luna/member_lose_3day") ?>" class="list-group-item list-group-item-action justify-content-between member_lose_3day">
      <span><i class="icon-settings g-pos-rel g-top-1 g-mr-8"></i> 3天未上秤學員列表</span>
    </a>
    <a href="<?= base_url("luna/member_weight_last_day") ?>" class="list-group-item list-group-item-action justify-content-between member_weight_last_day">
      <span><i class="icon-settings g-pos-rel g-top-1 g-mr-8"></i> 所有學員最後一天減脂紀錄</span>
    </a>
    <!-- <a href="<?= base_url("luna/login/logout") ?>" class="list-group-item list-group-item-action justify-content-between">
      <span><i class="icon-logout g-pos-rel g-top-1 g-mr-8"></i> 登出</span>
    </a> -->
    <!-- End Settings -->
  </div>
  <!-- End Sidebar Navigation -->
</div>
