<!DOCTYPE html>
<html lang="en">
<head>
  <?php $this->load->view("luna/luna_head") ?>
  <style>
    /* 純畫面強化樣式：卡片網格與商品樣式 */
    .shop-toolbar{gap:.75rem}
    .product-card{transition:transform .15s ease, box-shadow .15s ease}
    .product-card:hover{transform:translateY(-2px); box-shadow:0 10px 20px rgba(0,0,0,.07)}
    .product-thumb{aspect-ratio: 1/1; background:#f8f9fa; display:flex; align-items:center; justify-content:center; border-radius:.5rem; overflow:hidden}
    .product-thumb img{max-width:100%; height:auto}
    .price{font-weight:700}
    .badge-chip{border-radius:999px; font-size:.75rem; padding:.25rem .6rem}
    .category-tabs .nav-link{border-radius:999px}
    .category-tabs .nav-link.active{background: #2c7be5; color:#fff}
    .cursor-pointer{cursor:pointer}
  </style>
</head>
<body>
<main>
  <!-- Header -->
  <?php $this->load->view("luna/luna_header") ?>
  <!-- End Header -->

  <section class="g-mb-100">
    <div class="container">
      <div class="row">

        <!-- luna Sidebar -->
        <?php $this->load->view("luna/luna_sidebar") ?>
        <!-- End luna Sidebar -->

        <!-- Content -->
        <div class="col-lg-9">
          <div class="card border-0">
            <div class="card-header d-flex align-items-center justify-content-between g-bg-gray-light-v5 border-0">
              <div>
                <h3 class="h5 mb-1"><i class="icon-bag g-mr-5"></i> 商城（純畫面 Demo）</h3>
                <small class="g-color-gray-dark-v5">分類瀏覽 / 搜尋 / 假資料展示</small>
              </div>
              <div class="shop-toolbar d-flex align-items-center flex-wrap">
                <div class="input-group" style="min-width:240px">
                  <input id="shop-search" type="text" class="form-control" placeholder="搜尋商品關鍵字…">
                  <span class="input-group-btn">
                    <button class="btn btn-secondary" type="button"><i class="fa fa-search"></i></button>
                  </span>
                </div>
                <div class="dropdown">
                  <button class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-filter g-mr-5"></i> 篩選</button>
                  <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" data-sort="popular" href="#">熱門優先</a>
                    <a class="dropdown-item" data-sort="new" href="#">最新上架</a>
                    <a class="dropdown-item" data-sort="price_asc" href="#">價格由低到高</a>
                    <a class="dropdown-item" data-sort="price_desc" href="#">價格由高到低</a>
                  </div>
                </div>
              </div>
            </div>

            <div class="card-block g-pt-20 g-pb-10 g-px-20">
              <!-- 分類 Tabs -->
              <ul class="nav nav-pills category-tabs g-mb-25" role="tablist">
                <li class="nav-item g-mr-10 g-mb-10"><a class="nav-link active" data-toggle="tab" href="#tab-equipment" role="tab">裝備道具 (Equipment)</a></li>
                <li class="nav-item g-mr-10 g-mb-10"><a class="nav-link" data-toggle="tab" href="#tab-accessories" role="tab">配件道具 (Accessories)</a></li>
                <li class="nav-item g-mr-10 g-mb-10"><a class="nav-link" data-toggle="tab" href="#tab-costume" role="tab">時裝外觀 (Costume)</a></li>
                <li class="nav-item g-mr-10 g-mb-10"><a class="nav-link" data-toggle="tab" href="#tab-consumable" role="tab">消耗品 (Consumable)</a></li>
              </ul>

              <!-- 商品網格 -->
              <div class="tab-content">
                <!-- Equipment -->
                <div class="tab-pane fade show active" id="tab-equipment" role="tabpanel">
                  <div class="row" id="grid-equipment">
                    <!-- demo items -->
                    <?php for($i=1;$i<=8;$i++): ?>
                    <div class="col-sm-6 col-md-4 col-xl-3 g-mb-20 product-col" data-name="鋼鐵長劍 <?=$i?>" data-price="<?=1000+$i*25?>">
                      <div class="u-shadow-v18 g-bg-white g-rounded-10 g-pa-15 product-card h-100 d-flex flex-column">
                        <div class="product-thumb g-mb-10">
                          <img src="https://via.placeholder.com/300x300?text=Equipment+<?=$i?>" alt="equipment<?=$i?>">
                        </div>
                        <div class="d-flex align-items-center justify-content-between g-mb-5">
                          <span class="badge badge-primary badge-chip">ATK +<?=10+$i?></span>
                          <span class="price g-color-primary">$<?=number_format(1000+$i*25)?></span>
                        </div>
                        <h4 class="h6 g-mb-10 text-truncate" title="鋼鐵長劍 <?=$i?>">鋼鐵長劍 <?=$i?></h4>
                        <p class="g-color-gray-dark-v5 g-font-size-12 g-mb-15">稀有度：R　需求等級：<?=10+$i?></p>
                        <div class="mt-auto d-flex align-items-center justify-content-between">
                          <button class="btn btn-sm btn-primary"><i class="fa fa-shopping-cart g-mr-5"></i> 加入購物車</button>
                          <span class="g-color-gray-dark-v5 g-font-size-12"><i class="fa fa-fire g-mr-5"></i> 熱賣中</span>
                        </div>
                      </div>
                    </div>
                    <?php endfor; ?>
                  </div>
                </div>

                <!-- Accessories -->
                <div class="tab-pane fade" id="tab-accessories" role="tabpanel">
                  <div class="row" id="grid-accessories">
                    <?php for($i=1;$i<=8;$i++): ?>
                    <div class="col-sm-6 col-md-4 col-xl-3 g-mb-20 product-col" data-name="魔力戒指 <?=$i?>" data-price="<?=600+$i*20?>">
                      <div class="u-shadow-v18 g-bg-white g-rounded-10 g-pa-15 product-card h-100 d-flex flex-column">
                        <div class="product-thumb g-mb-10">
                          <img src="https://via.placeholder.com/300x300?text=Accessories+<?=$i?>" alt="accessory<?=$i?>">
                        </div>
                        <div class="d-flex align-items-center justify-content-between g-mb-5">
                          <span class="badge badge-success badge-chip">INT +<?=5+$i?></span>
                          <span class="price g-color-primary">$<?=number_format(600+$i*20)?></span>
                        </div>
                        <h4 class="h6 g-mb-10 text-truncate" title="魔力戒指 <?=$i?>">魔力戒指 <?=$i?></h4>
                        <p class="g-color-gray-dark-v5 g-font-size-12 g-mb-15">稀有度：SR　需求等級：<?=8+$i?></p>
                        <div class="mt-auto d-flex align-items-center justify-content-between">
                          <button class="btn btn-sm btn-primary"><i class="fa fa-shopping-cart g-mr-5"></i> 加入購物車</button>
                          <span class="g-color-gray-dark-v5 g-font-size-12"><i class="fa fa-star g-mr-5"></i> 精選</span>
                        </div>
                      </div>
                    </div>
                    <?php endfor; ?>
                  </div>
                </div>

                <!-- Costume -->
                <div class="tab-pane fade" id="tab-costume" role="tabpanel">
                  <div class="row" id="grid-costume">
                    <?php for($i=1;$i<=8;$i++): ?>
                    <div class="col-sm-6 col-md-4 col-xl-3 g-mb-20 product-col" data-name="復古風外套 <?=$i?>" data-price="<?=800+$i*30?>">
                      <div class="u-shadow-v18 g-bg-white g-rounded-10 g-pa-15 product-card h-100 d-flex flex-column">
                        <div class="product-thumb g-mb-10">
                          <img src="https://via.placeholder.com/300x300?text=Costume+<?=$i?>" alt="costume<?=$i?>">
                        </div>
                        <div class="d-flex align-items-center justify-content-between g-mb-5">
                          <span class="badge badge-info badge-chip">時裝</span>
                          <span class="price g-color-primary">$<?=number_format(800+$i*30)?></span>
                        </div>
                        <h4 class="h6 g-mb-10 text-truncate" title="復古風外套 <?=$i?>">復古風外套 <?=$i?></h4>
                        <p class="g-color-gray-dark-v5 g-font-size-12 g-mb-15">顏色：隨機　期限：永久</p>
                        <div class="mt-auto d-flex align-items-center justify-content-between">
                          <button class="btn btn-sm btn-primary"><i class="fa fa-shopping-cart g-mr-5"></i> 加入購物車</button>
                          <span class="g-color-gray-dark-v5 g-font-size-12"><i class="fa fa-magic g-mr-5"></i> 外觀</span>
                        </div>
                      </div>
                    </div>
                    <?php endfor; ?>
                  </div>
                </div>

                <!-- Consumable -->
                <div class="tab-pane fade" id="tab-consumable" role="tabpanel">
                  <div class="row" id="grid-consumable">
                    <?php for($i=1;$i<=8;$i++): ?>
                    <div class="col-sm-6 col-md-4 col-xl-3 g-mb-20 product-col" data-name="強效恢復藥水 <?=$i?>" data-price="<?=120+$i*5?>">
                      <div class="u-shadow-v18 g-bg-white g-rounded-10 g-pa-15 product-card h-100 d-flex flex-column">
                        <div class="product-thumb g-mb-10">
                          <img src="https://via.placeholder.com/300x300?text=Potion+<?=$i?>" alt="potion<?=$i?>">
                        </div>
                        <div class="d-flex align-items-center justify-content-between g-mb-5">
                          <span class="badge badge-danger badge-chip">HP +<?=200+$i*20?></span>
                          <span class="price g-color-primary">$<?=number_format(120+$i*5)?></span>
                        </div>
                        <h4 class="h6 g-mb-10 text-truncate" title="強效恢復藥水 <?=$i?>">強效恢復藥水 <?=$i?></h4>
                        <p class="g-color-gray-dark-v5 g-font-size-12 g-mb-15">冷卻：<?=max(0, 20-$i)?> 秒　堆疊：99</p>
                        <div class="mt-auto d-flex align-items-center justify-content-between">
                          <button class="btn btn-sm btn-primary"><i class="fa fa-shopping-cart g-mr-5"></i> 加入購物車</button>
                          <span class="g-color-gray-dark-v5 g-font-size-12"><i class="fa fa-bolt g-mr-5"></i> 即時使用</span>
                        </div>
                      </div>
                    </div>
                    <?php endfor; ?>
                  </div>
                </div>
              </div>
              <!-- /商品網格 -->

              <hr class="g-my-20">

              <!-- 分頁（純畫面） -->
              <nav class="text-center" aria-label="Page Navigation">
                <ul class="list-inline mb-0">
                  <li class="list-inline-item">
                    <a class="u-pagination-v1__item u-pagination-v1-4 g-rounded-50 g-pa-7-16 disabled" href="#" aria-disabled="true">
                      <span aria-hidden="true"><i class="fa fa-angle-left g-mr-5"></i> 最前頁</span>
                    </a>
                  </li>
                  <li class="list-inline-item g-hidden-sm-down"><a class="u-pagination-v1__item u-pagination-v1-4 u-pagination-v1-4--active g-rounded-50 g-pa-7-14" href="#">1</a></li>
                  <li class="list-inline-item g-hidden-sm-down"><a class="u-pagination-v1__item u-pagination-v1-4 g-rounded-50 g-pa-7-14" href="#">2</a></li>
                  <li class="list-inline-item g-hidden-sm-down"><a class="u-pagination-v1__item u-pagination-v1-4 g-rounded-50 g-pa-7-14" href="#">3</a></li>
                  <li class="list-inline-item">
                    <a class="u-pagination-v1__item u-pagination-v1-4 g-rounded-50 g-pa-7-16" href="#" aria-label="Next">
                      <span aria-hidden="true">最後頁 <i class="fa fa-angle-right g-ml-5"></i></span>
                    </a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
        <!-- /Content -->
      </div>
    </div>
  </section>

  <!-- Footer -->
  <?php $this->load->view("luna/luna_footer") ?>
  <!-- End Footer -->
</main>

<div class="u-outer-spaces-helper"></div>

<?php $this->load->view("luna/luna_script") ?>
<script>
  // ==== 純前端：搜尋 + 假排序（僅視覺效果） ====
  (function(){
    var $search = $('#shop-search');

    function filterBySearch() {
      var q = ($search.val()||'').toLowerCase().trim();
      $('.tab-pane.active .product-col').each(function(){
        var name = ($(this).data('name')+'').toLowerCase();
        $(this).toggle(name.indexOf(q) !== -1);
      });
    }

    $search.on('input', filterBySearch);

    // Demo sort（僅重新排 DOM）
    $('.dropdown-menu [data-sort]').on('click', function(e){
      e.preventDefault();
      var mode = $(this).data('sort');
      var $activeGrid = $('.tab-pane.active .row');
      var items = $activeGrid.children('.product-col').get();

      items.sort(function(a,b){
        var pa = parseInt($(a).data('price')||0,10);
        var pb = parseInt($(b).data('price')||0,10);
        if(mode==='price_asc') return pa - pb;
        if(mode==='price_desc') return pb - pa;
        if(mode==='new') return Math.random() > .5 ? 1 : -1; // 假隨機
        return Math.random() > .5 ? 1 : -1; // popular -> 假隨機
      });

      $.each(items, function(_, el){ $activeGrid.append(el); });
    });

    // 切換分頁時重置搜尋
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(){
      $search.val('');
      $('.product-col').show();
    });
  })();
</script>
</body>
</html>
