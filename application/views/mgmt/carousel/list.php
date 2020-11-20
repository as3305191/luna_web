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

<div style="padding:0px 0px 0px 0px;height:100vh;width:100vw;margin: 0 auto;" >
        <!-- <?php if(!empty($items)): ?>
            <?php foreach($items as $each): ?>
                <div style="padding:0px 0px 0px 0px;height:100vh;width:100vw;margin: 0 auto;" >

                <?php if($each->news_style_id =='9'): ?>
                    <div style="padding:0px 0px 0px 0px;height:100vh;width:100vw;margin: 0 auto;" >

                        <?= isset($each->content) ? $each->content : '' ?> 
                    </div>

                <?php else: ?>
                    <div style="padding:0px 0px 0px 0px;height:100vh;width:100vw;margin: 0 auto;" >
                        <div style="font-size:16px;color:white;" >
                            <?= isset($each->content) ? $each->news_style_name : '' ?> 
                        </div>

                        <div style="font-size:16px;color:white;" >
                            <?= isset($each->content) ? $each->title : '' ?> 
                        </div>

                        <div style="font-size:16px;color:white;" >
                            <?= isset($each->content) ? $each->content : '' ?> 
                        </div>

                    </div>

                <?php endif?>
            <?php endforeach ?>
        <?php endif?> -->
    </div>


    <div style="padding:0px 0px 0px 0px;height:100vh;width:100vw;margin: 0 auto;" >
        <div style="font-size:16px;color:white;" >
        <?= isset($items) ? $items[1] -> news_style_name : '' ?> 
        </div>

        <div style="font-size:16px;color:white;" >
        <?= isset($items) ? $items[1] -> title : '' ?> 
        </div>

        <div style="font-size:16px;color:white;" >
		<?= isset($items) ? $items[1] -> content : '' ?>
        </div>

    </div>


</div>
<script src="<?= base_url('js/libs/jquery-2.1.1.min.js') ?>"></script>
<script defer src="<?= base_url("vendor/OwlCarousel2-2.3.4/dist/owl.carousel.min.js") ?>"></script>
<script type="text/javascript">
$(document).on('ready', function () {
    $('.owl-carousel').owlCarousel({
        items: 1,
        // autoplay: true,
        // loop:true,
        // center:true,
        // merge:true,
    });
});

</script>