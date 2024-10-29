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
  .btn_unsuccess_text {
    color:black;
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
                      <i class="icon-directions g-pos-rel g-top-1 g-mr-5"></i> 剩餘金額: <p id="user_money"><?=$total_old_user_ewallet ?></p>
                  </h3>
                </div>
                <div class="card-block g-pa-0" >
                  <?php if(count($store_list)>0): ?>
                    <?php if(count($store_list)==1): ?>
                      <button class="btn_active btn-success text-light menu_btn menu_<?= $store_list[0]->id ?>" style="border-radius: 5px; padding: 10px; width: 220px; height: 48px;" onclick="menu_click('<?= $store_list[0]->id ?>','<?= $store_list[0]->new_img_address ?>')">&nbsp;<?= $store_list[0]->store ?></button>
                      <input type="hidden" class="form-control" id="store_id" value="<?= $store_list[0]->id ?>">
                    <?php else: ?>	
                      <button class="btn_active btn-success text-light menu_btn menu_<?= $store_list[0]->id ?>" style="border-radius: 5px; padding: 10px; width: 220px; height: 48px;" onclick="menu_click('<?= $store_list[0]->id ?>','<?= $store_list[0]->new_img_address ?>')">&nbsp;<?= $store_list[0]->store ?></button>
                      <input type="hidden" class="form-control" id="store_id" value="<?= $store_list[0]->id ?>">
                      <?php for ($i=1;$i<count($store_list);$i++) : ?>                      
                        <button class="btn_unsuccess menu_btn menu_<?= $store_list[$i]->id ?>" style="border-radius: 5px; padding: 10px; width: 220px; height: 48px;" onclick="menu_click('<?= $store_list[$i]->id ?>','<?= $store_list[$i]->new_img_address ?>')">&nbsp;<?= $store_list[$i]->store ?></button>
                        <?php endfor ?>
                    <?php endif?>
                    <div id="img_album" class="g-pos-rel" style="padding:10px 0px 6px 12px;">
            
                    </div>
                  <?php endif?>
                  
                </div>
                <div class="card-block g-pa-0" >
                  <table id="dt_list" class="table table-bordered u-table--v2">
                    <thead class="text-uppercase g-letter-spacing-1">
                      <tr>
                        <th class="g-font-weight-300 g-color-black dt_list_th" style="min-width: 100px"></th>
                        <th class="g-font-weight-300 g-color-black dt_list_th" style="min-width: 100px">品名</th>
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
  $(document).ready(function() {
    var c_store_list = <?= count($store_list)?> ;
    if( c_store_list >0 ){
      	img_album('<?= $store_list[0]->new_img_address ?>');
    }
    load_already_order();

  })
  
  var old_user_id = '<?=$old_user_id?>';
  var baseUrl = '<?=base_url('')?>';
    function menu_click(id,new_img_address) {
      $('#store_id').val('');
        $('.menu_img').addClass('menu_img_unsuccess');
        $('.menu_img_'+id).removeClass('menu_img_unsuccess');
        // $('.menu_btn').removeClass('btn_active');
        $('.menu_btn').removeClass('btn_active btn-success');
        $('.menu_btn').addClass('btn_unsuccess text-light');
        $('.menu_'+id).removeClass('btn_unsuccess text-light');
        $('.menu_'+id).addClass('btn_active btn-success');
        $('#store_id').val(id);
        img_album(new_img_address);
    }

    function img_album(address) {
      $('#img_album').empty();
      var img_html =
              '<a class="js-fancybox d-block" href="javascript:;"  data-fancybox="lightbox-gallery--01" data-src="http://'+address+'" data-speed="350" data-caption="Lightbox Gallery">'+
              '<img class="img-fluid" width="300" height="400" src="http://'+address+'" alt="">'+
              '</a>';
      $('#img_album').append(img_html);
    }
    function add_order() {
      var url = baseUrl + 'old_system_view/old_system_view_home/order_meal'; // the script where you handle the form input.
      
      var id = $('#item_id').val();
      var store_id = $('#store_id').val();
      var order_name = $('#order_name').val();
      var note = $('#note').val();
      var amount = $('#amount').val();
      $.ajax({
        type : "POST",
        url : url,
        data : {
          id: id,
          store_id: store_id,
          usid: old_user_id,
          order_name: order_name,
          note: note,
          amount: amount,
        },
        success : function(data) {
          if(data) {
            re_total_money();
            // load_already_order();
          }
        }
      });
    }

    function load_already_order() {
      $('#dt_list_body').empty();
      var url = baseUrl + 'old_system_view/old_system_view_home/finish_order'; // the script where you handle the form input.
      $.ajax({
        type : "POST",
        url : url,
        data : {
          usid: old_user_id,
        },
        success : function(d) {
          if(d.success=='already') {
            $.each(d.finish_list, function(){
              var me = this;
              console.log(me.id);
              console.log(me.orderitem);
              console.log(me.notice);
              console.log(me.price);
            });
          }
        }
      });
    }

    function re_total_money() {
      $('#user_money').empty();
      var url = baseUrl + 'old_system_view/old_system_view_home/re_money'; // the script where you handle the form input.
      $.ajax({
        type : "POST",
        url : url,
        data : {
          usid: old_user_id,
        },
        success : function(data) {
          if(data) {
            $('#user_money').append(data['total_old_user_ewallet']);
          }
        }
      });

    }

</script>
