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
            transform: translateY(-45%);
		}

		.news_container p img {
			max-height:45%;
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
            <?php if($each->news_style_id =='3'): ?>
                <div style="padding:0px 0px 0px 0px;height:100vh;width:100vw;margin: 0 auto;" >
                    <div style="font-size:50px;color:red;" >
                        <?= isset($each) ? $each -> news_style_name : '' ?> 
                    </div>
                    <div style="font-size:30px;color:white;" >
                        <span style="color:white;">每秒成本:  </span><span style="color:red;" id="cost"><?= isset($cost) ? $cost : '' ?></span>
                    </div>
                    <div style="font-size:40px;color:white;width:80%; text-align:left;transform: translateX(25%)" >
                        <p>
                             <span style="color:white;text-align:left;">今年累積:  </span><span style="color:red;margin-left:10px;" id="counter_year"><?= isset($during_now_s) ? $during_now_s : '' ?></span>
                        </p>
                        <p>
                            <span style="color:white;text-align:left;">本月累積:  </span><span style="color:red;margin-left:10px;" id="counter_month"><?= isset($during_m_now_s) ? $during_m_now_s : '' ?></span>
                        </p>
                        <p>
                            <span style="color:white;text-align:left;">今日累積:  </span><span style="color:red;margin-left:10px;" id="counter_today"><?= isset($during_today_now_s) ? $during_today_now_s : '' ?></span>
                        </p>
                    </div>
                </div>
            <?php else: ?>
                <div style="padding:0px 0px 0px 0px;height:100vh;width:100vw;margin: 0 auto;" >
                    <div style="font-size:30px;color:red;" >
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
        <?php endif?>
    <?php endforeach ?>

</div>
<script src="<?= base_url('js/libs/jquery-2.1.1.min.js') ?>"></script>
<script src="<?= base_url("vendor/OwlCarousel2-2.3.4/dist/owl.carousel.min.js") ?>"></script>
<script type="text/javascript">

var counter = parseFloat('<?= $during_now_s?>');
var counter_m = parseFloat('<?= $during_m_now_s?>');
var counter_today = parseFloat('<?= $during_today_now_s?>');
var cost = parseFloat('<?= $cost?>');
var counter_add =  parseFloat(counter+=cost);
var counter_add_m =  parseFloat(counter_m+=cost);
var counter_add_today =  parseFloat(counter_today+=cost);

function count_cost(){
    $('#counter_year').text(counter_add.toFixed(2)); 
    $('#counter_month').text(counter_add_m.toFixed(2)); 
    $('#counter_today').text(counter_add_today.toFixed(2)); 
}

    $(document).on('ready', function () {
        setInterval(function() { 
            count_cost();  
        }, 1000);

        $('.owl-carousel').owlCarousel({
            loop:true,
            items: 1,
            autoplay: 1000,
            center:true,
            merge:true,
            lazyFollow:true,
            // rewind:true,
        });
              
    });

</script>