<head>
    <link rel="stylesheet" type="text/css" href="<?= base_url("vendor/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css") ?>">

    <style>

    </style>

</head>
<div class="tab-content">
	<div class="tab-pane active" id="list_page">

		<!-- widget grid -->
		<section id="widget-grid" class="">

			<!-- row -->
			<div class="row">

				<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget">
						<header>
							<div class="widget-toolbar pull-left">
								<div class="btn-group">
									<!-- <button onclick="currentApp.doEdit(0)" class="btn dropdown-toggle btn-xs btn-success" data-toggle="dropdown">
										<i class="fa fa-plus"></i>新增
									</button> -->
								</div>
							</div>
						</header>

						<!-- widget div-->
						<div>

							<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->

							</div>
							<!-- end widget edit box -->

							<!-- widget content -->
							<div class="widget-body no-padding">

                                <div class="owl-carousel carousel-theme-full">
                                <div class="slide s1" >
                                    <div class="news_img_1">
                                        <?php if(!empty($carousel_id[0]) && $carousel_id[0]): ?>
                                            <img src="<?= base_url('api/images/get/'.$carousel_id[0].'/thumb') ?>"  alt="">
                                        <?php else: ?>
                                            <img src="<?= base_url('api/images/get/319/thumb') ?>"  alt="">
                                        <?php endif ?>
                                    </div>
                                    <div class="news_img_2">
                                        <?php if(!empty($carousel_id[1]) && $carousel_id[1]): ?>
                                            <img src="<?= base_url('api/images/get/'.$carousel_id[1].'/thumb') ?>"  alt="">
                                        <?php else: ?>
                                            <img src="<?= base_url('api/images/get/319/thumb') ?>"  alt="">
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div class="slide ">
                                    <div class="news_img_1">
                                        <?php if(!empty($carousel_id[2]) && $carousel_id[2]): ?>
                                            <img src="<?= base_url('api/images/get/'.$carousel_id[2].'/thumb') ?>"  alt="">
                                        <?php else: ?>
                                            <img src="<?= base_url('api/images/get/319/thumb') ?>"  alt="">
                                        <?php endif ?>
                                    </div>
                                    <div class="news_img_2">
                                        <?php if(!empty($carousel_id[3]) && $carousel_id[3]): ?>
                                            <img src="<?= base_url('api/images/get/'.$carousel_id[3].'/thumb') ?>"  alt="">
                                        <?php else: ?>
                                            <img src="<?= base_url('api/images/get/319/thumb') ?>"  alt="">
                                        <?php endif ?>
                                    </div>
                                </div>
                                </div>

							</div>
							<!-- end widget content -->

						</div>
						<!-- end widget div -->

					</div>
					<!-- end widget -->

				</article>
				<!-- WIDGET END -->

			</div>

			<!-- end row -->

		</section>
		<!-- end widget grid -->
	</div>

</div>
<script src="<?= base_url("vendor/OwlCarousel2-2.3.4/dist/owl.carousel.min.js") ?>"></script>
<script src="<?= base_url('js/libs/jquery-2.1.1.min.js') ?>"></script>
<script src="<?= base_url('js/libs/jquery-ui-1.10.3.min.js') ?>"></script>
<script>
    $(function() {
        $('.owl-carousel').owlCarousel({
            items: 1,
            loop: false
        });
    });
</script>