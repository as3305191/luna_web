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
  .element {
    /* border: 5px solid; */
    position: absolute;
    top: 110%;
    left: 50%;
    transform: translate(-50%, 700%);
    padding: 10px;
  }
  .element_top {
    /* border: 5px solid; */
    position: absolute;
    /* top: 20%; */
    left: 50%;
    transform: translate(-50%, 10%);
    padding: 10px;
  }
  .t_center {
    text-align: center;
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
  <?php $this -> load -> view("sing/old_system_view_head")  ?>
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
          <div class="col-lg-4 g-mb-60">
          <div class="u-shadow-v21 g-brd-around g-brd-gray-light-v4 rounded g-pa-25">
            <div class="text-center mb-5">
              <span class="u-icon-v2 g-width-50 g-height-50 g-color-white g-bg-black g-font-size-18 rounded-circle mb-3">
                  <i class="icon-communication-116 u-line-icon-pro"></i>
                </span>
              <h2 class="h4 g-color-black">排行榜</h2>
              <hr class="g-brd-gray-light-v4">

              <?php $i=1; ?>
              <?php foreach ($ticket_array as $each_key => $each_val): ?>
                <?php if ($each_key==$winner): ?>
                  <div class="mb-4">
                    <h4 class=""><div class="t_center"><a href="#winnerModal" role="button" data-toggle="modal" class="btn btn-md u-btn-gradient-v1 g-mr-10 g-mb-15">第1名</a><span class="float-right g-ml-10"><?=$each_val!=='0' ? $each_val:0?></span></div></h4>
                    <div class="js-hr-progress-bar progress g-height-4 rounded-0">
                      <div class="js-hr-progress-bar-indicator progress-bar" role="progressbar" style="width: <?= $each_val>0 ? intval(($each_val/$all_ticket)*100): 0 ?>%;" aria-valuenow="<?= $each_val>0 ? intval(($each_val/$all_ticket)*100) : 0 ?>;" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                  <?php $i++; ?>
                <?php else : ?>
                  <div class="mb-4">
                    <h4 class="h6 t_center">第<?= $i ?>名<span class="float-right g-ml-10"><?=$each_val!=='0' ? $each_val:0?></span></h4>
                    <div class="js-hr-progress-bar progress g-height-4 rounded-0">
                      <div class="js-hr-progress-bar-indicator progress-bar" role="progressbar" style="width: <?= $each_val>0 ? intval(($each_val/$all_ticket)*100) :0 ?>%;" aria-valuenow="<?= $each_val>0 ? intval(($each_val/$all_ticket)*100): 0 ?>;" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                  <?php $i++; ?>
                <?php endif; ?>
              <?php endforeach; ?>
            </div>


          
          </div>
        </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <!-- End Footer -->
  </main>

  <div class="modal fade" id="winnerModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">


			<!-- <div class="modal-header">
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
					<i class="fa fa-close"></i> 關閉
				</button>
			</div> -->
			<div class="modal-body" id="edit-modal-body">
     


      <div class="g-brd-around--md g-brd-gray-light-v4 text-center g-pa-10 g-px-30--lg g-py-40--lg">
        <span class="d-block g-color-gray-dark-v4 g-font-size-40 g-mb-15">
          <i class="icon-education-087 u-line-icon-pro"></i>
        </span>
          <h3 class="h5 g-color-black g-mb-10">Web Design &amp; Development</h3>
          <p class="g-color-gray-dark-v4">We strive to embrace and drive change in our industry which allows us to keep our clients relevant and ready to adapt.</p>
          <ul class="list-unstyled g-px-30 g-mb-0 ">
          <?php foreach ($winner_name as $each): ?>
            <li class="g-brd-bottom g-brd-gray-light-v3 g-py-10 div_center"><?= $each ?></li>
          <?php endforeach; ?>

          </ul>
       
        </div> 

			</div>
			<div class="modal-footer">
			
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
					<i class="fa fa-close"></i> 關閉
				</button>
			</div>
		</div>
	</div>
</div>
<div class="u-outer-spaces-helper"></div>

</body>
</html>


<?php $this -> load -> view("old_system_view/old_system_view_script")  ?>
<script>

  function show_winner() {
		
	};
</script>
