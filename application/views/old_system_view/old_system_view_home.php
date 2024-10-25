<style>
  .s_sum {
  	display: none;
  }
  .menu_img_unsuccess {
  	display: none;
  }
  .hide_s_i {
  	display: none;
  }
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
  <link rel="stylesheet" href="<?= base_url('assets/vendor/fancybox/jquery.fancybox.min.css'); ?>" />

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
                  <?php if(count($store_list)==1): ?>
                    <button class="btn_active btn-success text-light  menu_btn menu_<?= $store_list[0]->id ?>" style="border-radius: 5px; padding: 10px; width: 220px; height: 48px;" onclick="menu_click(<?= $store_list[0]->id ?>)">&nbsp;<?= $store_list[0]->store ?></button>
                    <input type="hidden" class="form-control" id="menu_id" value="<?= $store_list[0]->id ?>">
                  <?php else: ?>	
                    <button class="btn_active btn-success text-light  menu_btn menu_<?= $store_list[0]->id ?>" style="border-radius: 5px; padding: 10px; width: 220px; height: 48px;" onclick="menu_click(<?= $store_list[0]->id ?>)">&nbsp;<?= $store_list[0]->store ?></button>
                    <input type="hidden" class="form-control" id="menu_id" value="<?= $store_list[0]->id ?>">
                    <?php for ($i=1;$i<count($store_list);$i++) : ?>
                      <button class="btn-light text-light btn_unsuccess menu_btn menu_<?= $store_list[$i]->id ?>" style="border-radius: 5px; padding: 10px; width: 220px; height: 48px;" onclick="menu_click(<?= $store_list[$i]->id ?>)">&nbsp;<?= $store_list[$i]->store ?></button>
                    <?php endfor ?>
                  <?php endif?>
                <div id="img_album" class="g-pos-rel" style="padding:10px 0px 6px 12px;">
					
					      </div>
                <div class="card-block g-pa-0" >
                  <table id="dt_list" class="table table-bordered u-table--v2">
                    <thead class="text-uppercase g-letter-spacing-1">
                      <tr>
                        <th class="g-font-weight-300 g-color-black dt_list_th" style="min-width: 100px"></th>
                        <th class="g-font-weight-300 g-color-black dt_list_th" style="min-width: 100px">餐點名稱</th>
                        <th class="g-font-weight-300 g-color-black dt_list_th" style="min-width: 100px">備註</th>
                        <th class="g-font-weight-300 g-color-black dt_list_th_big" style="min-width: 100px">價錢</th>
                      </tr>
                      <tr>
									<td class="min50" style="border-right:none;"></td>
									
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
                      <button type="button" class="btn btn-sm btn-primary" onclick="add_order()"><i class="fa fa-plus-circle fa-lg"></i></button>
                    </div>
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
<script src="<?= base_url() ?>assets/vendor/fancybox1/jquery.fancybox.min.js"></script>
<script>
  var baseUrl = '<?=base_url('')?>';
	function menu_click(id) {
			//   document.getElementById(id).show();
			$('.menu_img').addClass('menu_img_unsuccess');
			$('.menu_img_'+id).removeClass('menu_img_unsuccess');
			// $('.menu_btn').removeClass('btn_active');
			$('.menu_btn').removeClass('btn_active btn-success ');
			$('.menu_btn').addClass('btn_unsuccess');
			$('.menu_'+id).removeClass('btn_unsuccess');
			$('.menu_'+id).addClass('btn_active btn-success ');
	}

	function img_album() {
		$.ajax({
			url: '<?= base_url() ?>' + 'mgmt/menu_order/find_all_open_menu',
			type: "POST",
			data: {
				id: $('#menu_id').val()
			},
			success: function(data) {

				$('#img_album').empty();

				var img_album_html =
				'<div id="album" style="display:flex;" class="js-carousel g-pt-6 g-mx-2" data-infinite="true" data-slides-show="5" data-slides-scroll="1" data-rows="1" data-responsive=\'[{"breakpoint": 1200,"settings": {"slidesToShow": 5} }, {"breakpoint": 992,"settings": {"slidesToShow": 4}}, {"breakpoint": 768,"settings": { "slidesToShow": 1}}, { "breakpoint": 576,"settings": {"slidesToShow": 1}}, {"breakpoint": 446,"settings": { "slidesToShow": 1}}]\'>'+
				'</div>';
				$('#img_album').append(img_album_html);
				var menu_note ='';
				if(data.note!=""&&data.note!=null&&data.note!=undefined){
						
					menu_note='<div class="" style="color:#a90329;">備註: '+data.note+'</div>';
				}
				$('#img_album').append(menu_note);
				
				

				$.each(data.list_image, function() {
					var me = this;
					var img_html =
					'<div class="js-slide g-px-3">'+
						'<a class="js-fancybox d-block" href="javascript:;" data-fancybox="lightbox-gallery--01" data-src="<?= base_url() ?>api/images/get/'+me+'" data-speed="350" data-caption="Lightbox Gallery">'+
						'<img class="img-fluid" width="300" height="400" src="<?= base_url() ?>api/images/get/'+me+'/thumb" alt="Image Description">'+
						'</a>'+
					'</div>';
					$('#album').append(img_html);					
       	 		});
				
				
			}
		});
	}
	img_album();

</script>
