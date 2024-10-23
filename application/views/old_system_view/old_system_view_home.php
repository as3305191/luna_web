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

<head>
  <?php $this -> load -> view("old_system_view/old_system_view_head")  ?>
</head>

<body>
  <main>
    <!-- Header -->
    <?php $this -> load -> view("old_system_view/old_system_view_header")  ?>
    <!-- End Header -->

    <section class="g-mb-100">
      <div class="container">
        <div class="row">

          <!-- Coach Sidebar -->
          <?php $this -> load -> view("old_system_view/old_system_view_sidebar")  ?>
          <!-- End Coach Sidebar -->

          <!-- Profile Content -->
          <div class="col-lg-9">
            <!-- Overall Statistics -->
           


            <!-- Profile Content -->
            <div class="col-lg-12">
              <!-- Overall Statistics -->
              <div class="" >

              <!-- Product Table Panel -->
              <div class="card border-0">
                <div class="card-header d-flex align-items-center justify-content-between g-bg-gray-light-v5 border-0 g-mb-15">
                  <h3 class="h6 mb-0">
                      <i class="icon-directions g-pos-rel g-top-1 g-mr-5"></i> 所有學員
                    </h3>

                </div>

                <div class="card-block g-pa-0">
                  <!-- Product Table -->
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
                  <!-- End Product Table -->
                </div>
               
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
                  <!-- End Product Table -->
                </div>

              </div>
              <!-- End Product Table Panel -->
            </div>
            <!-- End Profile Content -->
            </div>
          </div>
          <!-- End Profile Content -->
        </div>
      </div>
    </section>

    <!-- Footer -->
    <?php $this -> load -> view("old_system_view/old_system_view_footer")  ?>
    <!-- End Footer -->
  </main>

<div class="u-outer-spaces-helper"></div>

</body>
</html>


<?php $this -> load -> view("old_system_view/old_system_view_script")  ?>

<script>
  var baseUrl = '<?=base_url('')?>';

  


</script>
