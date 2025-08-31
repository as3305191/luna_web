<style>
@media only screen and (max-width: 750px) {
	.dt_list_th{
	  min-width: 67px !important;
	}
  .dt_list_th_big{
	  min-width: 100px !important;
	}
}
</style>

<!DOCTYPE html>
<html lang="en">


<body>
  <main>

    <!-- End Header -->

    <section class="g-mb-100">
      <div class="container">
        <div class="row">

          <!-- End luna Sidebar -->

          <!-- Profile Content -->
          <div class="col-lg-9">
            <!-- Overall Statistics -->
            <div class="row g-mb-40">
              <div class="col-md-6 g-mb-30 g-mb-0--md">
                <div class="g-bg-cyan g-color-white g-pa-25">
                  <header class="d-flex text-uppercase g-mb-40">
                    <i class="icon-people align-self-center display-4 g-mr-20"></i>

                    <!-- <div class="g-line-height-1">
                      <h4 class="h5">線上商城</h4>
                      <div class="js-counter g-font-size-30" data-comma-separated="true"><?=$count_today?></div>
                    </div> -->
                  </header>

                  <!-- <div class="d-flex justify-content-between text-uppercase g-mb-25">
                    <div class="g-line-height-1">
                      <h5 class="h6 g-font-weight-600">3天未上秤學員</h5>
											<button class="js-counter g-font-size-16" data-comma-separated="true" style="background-color:#00FF00;cursor:pointer" onclick="show_lose_3days(<?= isset($members_lose_3days) ? 1: 0 ?>)"><?=$count_members_lose_3days?></button>
                    </div> -->

                  </div>
                </div>
              </div>

              <!-- <div class="col-md-6 g-mb-30 g-mb-0--md">
                <div class="g-bg-purple g-color-white g-pa-25">
                  <header class="d-flex text-uppercase g-mb-40">
                    <i class="icon-layers align-self-center display-4 g-mr-20"></i>

                    <div class="g-line-height-1">
                      <h4 class="h5">幫助幾人</h4>
                      <div class="js-counter g-font-size-30" data-comma-separated="true"><?=$count_help_people?></div>

                    </div>
                  </header>

                  <div class="d-flex justify-content-between text-uppercase g-mb-25">
                    <div class="g-line-height-1">
                      <h5 class="h6 g-font-weight-600">幾天</h5>
                      <div class="js-counter g-font-size-16" data-comma-separated="true"><?=$days?></div>
                    </div>

                    <div class="text-right g-line-height-1">
                      <h5 class="h6 g-font-weight-600">總共減脂</h5>
                      <div class="g-font-size-16" data-comma-separated="true">
                        <span><?=doubleval($help_fat_rate_change)?></span>
                      </div>
                    </div>
                  </div>
              </div> -->
            </div>


            <!-- Profile Content -->
            <div class="col-lg-12">
              <!-- Overall Statistics -->
              <div class="" >

              <!-- Product Table Panel -->
              <!-- <div class="card border-0">
                <div class="card-header d-flex align-items-center justify-content-between g-bg-gray-light-v5 border-0 g-mb-15">
                  <h3 class="h6 mb-0">
                      <i class="icon-directions g-pos-rel g-top-1 g-mr-5"></i> 所有學員
                    </h3>

                </div>

                <div class="card-block g-pa-0">
                  
                  <div class="table-responsive">
                    <table id="dt_list" class="table table-bordered u-table--v2">
                      <thead class="text-uppercase g-letter-spacing-1">
                        <tr>
                          <th class="g-font-weight-300 g-color-black dt_list_th" style="min-width: 100px">照片</th>
                          <th class="g-font-weight-300 g-color-black dt_list_th" style="min-width: 100px">學員</th>
                          <th class="g-font-weight-300 g-color-black dt_list_th" style="min-width: 100px">年齡</th>
                          <th class="g-font-weight-300 g-color-black dt_list_th" style="min-width: 100px">身高</th>
                          <th class="g-font-weight-300 g-color-black dt_list_th" style="min-width: 100px">性別</th>
                          <th class="g-font-weight-300 g-color-black dt_list_th" style="min-width: 100px">體重</th>
                          <th class="g-font-weight-300 g-color-black dt_list_th_big" style="min-width: 100px">體重變化</th>
                          <th class="g-font-weight-300 g-color-black dt_list_th_big" style="min-width: 100px">脂肪變化</th>
                          <th class="g-font-weight-300 g-color-black dt_list_th_big" style="min-width: 100px">肥胖程度</th>
                        </tr>
                      </thead>
                      <tbody id="dt_list_body">
                      </tbody>
                    </table>
                  </div>

                </div>
                <nav class="text-center" aria-label="Page Navigation">
                  <ul class="list-inline">
                    <?php
                      for ($i=1;$i<=$page;$i++){
                    ?>
                    <?php $j=$i?>

                      <?php if ($i==1): ?>
                        <li class="list-inline-item float-sm-left">
                          <a class="u-pagination-v1__item u-pagination-v1-4 g-rounded-50 g-pa-7-16" onclick="for_table(<?=$j?>)" aria-label="Previous">
                            <span aria-hidden="true">
                              <i class="fa fa-angle-left g-mr-5"></i> 最前頁
                            </span>
                            <span class="sr-only">Previous</span>
                          </a>
                        </li>
                      <?php else: ?>
                      <?php endif; ?>


                      <?php if ($i==1): ?>
                        <li class="list-inline-item g-hidden-sm-down" >
                          <a class="u-pagination-v1__item u-pagination-v1-4 u-pagination-v1-4--active g-rounded-50 g-pa-7-14 s<?=$i?>"  onclick="for_table(<?=$i?>)">
                        <?php echo $i?></a></li>
                      <?php else: ?>
                        <li class="list-inline-item g-hidden-sm-down" >
                          <a class="u-pagination-v1__item u-pagination-v1-4 g-rounded-50 g-pa-7-14 s<?=$i?>"  onclick="for_table(<?=$i?>)">
                        <?php echo $i?></a></li>
                      <?php endif; ?>


                      <?php if ($i==$page): ?>
                        <li class="list-inline-item float-sm-right">
                          <a class="u-pagination-v1__item u-pagination-v1-4 g-rounded-50 g-pa-7-16" onclick="for_table(<?=$j?>)" aria-label="Next">
                            <span aria-hidden="true">
                              最後頁 <i class="fa fa-angle-right g-ml-5"></i>
                            </span>
                            <span class="sr-only">下一頁</span>
                          </a>
                        </li>
                      <?php else: ?>
                      <?php endif; ?>

                        <?php } ?>

                  </ul>
                </nav>
                <div class="card-header d-flex align-items-center justify-content-between g-bg-gray-light-v5 border-0 g-mb-15">
                  <h3 class="h6 mb-0">
                      <i class="icon-directions g-pos-rel g-top-1 g-mr-5"></i> 學員今日體重
                  </h3>
                </div>

                <div class="card-block g-pa-0" style="">
                  <section>
										<label class="label">學員名稱</label>
											<input type="text" id="member_name" style="border-color:#787774;">
                      <button type="button" class="btn btn-danger btn-sm" onclick="search_member()">
                        搜尋
                      </button>
									</section>
                  <div class="table-responsive">
                    <table id="dt_list_for_today_w" class="table table-bordered u-table--v2">
                      <thead class="text-uppercase g-letter-spacing-1">
                        <tr>
                          <th class="g-font-weight-300 g-color-black" style="min-width: 100px">學員名稱</th>
                          <th class="g-font-weight-300 g-color-black" style="min-width: 100px">體重</th>
                          <th class="g-font-weight-300 g-color-black" style="min-width: 100px">體脂率</th>
                          <th class="g-font-weight-300 g-color-black" style="min-width: 200px">時間</th>

                        </tr>
                      </thead>
                      <tbody id="list_for_today_w">
                      </tbody>
                    </table>
                  </div>
                 
                </div>

              </div> -->
              <!-- End Product Table Panel -->
            </div>
            <!-- End Profile Content -->
            </div>
          </div>
          <!-- End Profile Content -->
        </div>
      </div>
    </section>

   
  </main>

<div class="u-outer-spaces-helper"></div>

</body>
</html>


<script>

</script>
