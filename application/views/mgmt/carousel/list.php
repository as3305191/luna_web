<head>
    <link rel="stylesheet" type="text/css" href="<?= base_url("vendor/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css") ?>">
    <style>
    
		html, body {
			margin:0;
			padding:0;
            position:relative;
            background-color:black;
            overflow: hidden;
		}

		.news_container {
			height:100%;
			width:100%;
			position:absolute;
            text-align:-webkit-center;
            top:50%;
            transform: translateY(-35%);
		}

		.news_container p img {
			max-height:50%;
			width:80%;
        }

    </style>
</head>
<div class="news_container owl-carousel carousel-theme-full ">
    <?php foreach($items as $each): ?>
        <?php if($each->news_style_id =='9'): ?>
            <div style="padding:0px 0px 0px 0px;height:100vh;width:100vw;margin: 0 auto;" >
                <?= isset($each->content) ? $each->content : '' ?> 
            </div>
        <?php else: ?>
            <div style="padding:0px 0px 0px 0px;height:100vh;width:100vw;margin: 0 auto;" >
                <div style="font-size:30px;color:white;" >
                    <?= isset($each) ? $each -> news_style_name : '' ?> 
                </div>

                <div style="font-size:25px;color:white;" >
                    <?= isset($each) ? $each -> title : '' ?> 
                </div>

                <div style="font-size:20px;color:white;text-align:left;width:80%" >
                    <?= isset($each) ? $each -> content : '' ?>
                </div>
            </div>
        <?php endif?>
    <?php endforeach ?>
</div>
<script src="<?= base_url('js/libs/jquery-2.1.1.min.js') ?>"></script>
<script src="<?= base_url("vendor/OwlCarousel2-2.3.4/dist/owl.carousel.min.js") ?>"></script>
<script type="text/javascript">
    $(document).on('ready', function () {
        $('.owl-carousel').owlCarousel({
            items: 4,
            autoplay: 5000,
            loop:true,
            center:true,
            merge:true,
            itemsDesktop : [1199,3],
            itemsDesktopSmall : [979,3],
        });
    
    });

</script>