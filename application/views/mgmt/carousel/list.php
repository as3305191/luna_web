<head>
    <link rel="stylesheet" type="text/css" href="<?= base_url("vendor/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css") ?>">
    <style>
       /* .middle {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -45%);
        } */

        /* .slide {
            width: 20%;
            height: 100%;
            transition: 1s;
        } */

		html, body {
			margin:0;
			padding:0;
		}

		.news_container {
			height:100%;
			width:100%;
			/* border: 1px solid green; */
			position:fixed;
			/* background: url(image/login.jpg) no-repeat; */
			top: 50%;
			left: 50%;
			margin: -50% 0 0 50%;
		}

		.news_container p img {
			height:40%;
			width:80%;
        }

    </style>
</head>
<div class="news_container owl-carousel carousel-theme-full " style="background-color:black;">
    <div style="padding:0px 0px 0px 0px;height:100vh;width:100vw;margin: 0 auto;" >
		<?= isset($items) ? $items[0] -> content : '' ?> 
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