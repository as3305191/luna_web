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
                      <i class="icon-directions g-pos-rel g-top-1 g-mr-5"></i> 餐廳
                  </h3>
                  <h3 class="h6 mb-0">
                      <i class="icon-directions g-pos-rel g-top-1 g-mr-5"></i> 剩餘金額: <?=$total_old_user_ewallet ?>
                  </h3>
                </div>
                <div class="card-block g-pa-0" >
                  <table id="dt_list" class="table table-bordered u-table--v2">
                    <thead class="text-uppercase g-letter-spacing-1">
                      <tr>
                        <th class="g-font-weight-300 g-color-black dt_list_th" style="min-width: 100px">餐點名稱</th>
                        <th class="g-font-weight-300 g-color-black dt_list_th" style="min-width: 100px">備註</th>
                        <th class="g-font-weight-300 g-color-black dt_list_th_big" style="min-width: 100px">價錢</th>
                      </tr>
                      <tr>
									<td class="min50" style="border-right:none;"></td>
									<td class="min120" style="border-right:none;">
										<div class="input-group col-md-12">
											<select id="menu_name" class="form-control">
												
											</select> 
										</div>
									</td>
									<td style="border-right:none;">
										<div class="input-group col-md-12">
											<input type="text" class="form-control" id="order_name" placeholder="品項">
										</div>
									</td>

									<td style="border-right:none;">
										<div class="input-group col-md-10">
											<input type="text" class="form-control" id="note" placeholder="備註">
										</div>
									</td>
									<td style="border-right:none;">
										<div class="input-group col-md-12">
											<input type="text" class="form-control" id="amount" placeholder="金錢總額">
										</div>
                    <button type="button" class="btn btn-sm btn-primary" onclick="add_order()"><i class="fa fa-plus-circle fa-lg"></i></button>
									</td>
								</tr>
                    </thead>
                    <tbody id="dt_list_body">

                    </tbody>
                  </table>
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
