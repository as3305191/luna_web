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
            </div>


            <?php $i=1; ?>
            <?php foreach ($ticket_array as $each_key => $each_val): ?>
              <?php if ($each_key==$winner): ?>
                <div class="mb-4">
                  <h4 class="h6">第1名<span class="float-right g-ml-10"><?=$each_val?></span></h4>
                  <div class="js-hr-progress-bar progress g-height-4 rounded-0">
                    <div class="js-hr-progress-bar-indicator progress-bar" role="progressbar" style="width: <?= $each_val!==0 ? floor($each_val/$allticket)*100 : 0 ?>%;" aria-valuenow="<?= $each_val!==0 ? floor($each_val/$allticket)*100 : 0 ?>" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
                <?php $i++; ?>
              <?php else : ?>
                <div class="mb-4">
                  <h4 class="h6">第<?= $i ?>名<span class="float-right g-ml-10"><?=$each_val?></span></h4>
                  <div class="js-hr-progress-bar progress g-height-4 rounded-0">
                    <div class="js-hr-progress-bar-indicator progress-bar" role="progressbar" style="width: <?= $each_val!==0 ? floor($each_val/$allticket)*100 : 0 ?>%;" aria-valuenow="<?= $each_val!==0 ? floor($each_val/$allticket)*100 : 0 ?>" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
                <?php $i++; ?>
              <?php endif; ?>
            <?php endforeach; ?>
            <!-- Progress Bars -->
            <div class="mb-4">
              <h4 class="h6">Web Design <span class="float-right g-ml-10">84%</span></h4>
              <div class="js-hr-progress-bar progress g-height-4 rounded-0">
                <div class="js-hr-progress-bar-indicator progress-bar" role="progressbar" style="width: 84%;" aria-valuenow="84" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>

            <div class="mb-4">
              <h4 class="h6">PHP/WordPress <span class="float-right g-ml-10">57%</span></h4>
              <div class="js-hr-progress-bar progress g-height-4 rounded-0">
                <div class="js-hr-progress-bar-indicator progress-bar" role="progressbar" style="width: 57%;" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>

          
          </div>
        </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <!-- End Footer -->
  </main>

<div class="u-outer-spaces-helper"></div>

</body>
</html>


<?php $this -> load -> view("old_system_view/old_system_view_script")  ?>
<script>
 
</script>
