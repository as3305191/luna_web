<head>
    <style>
        html, body {
            margin:0;
            padding:0;
        }

        .container {
            height:100%;
            width:100%;
            position:fixed;
            background-color:black ;
        }

        .slide-container {
            /* max-width: 500vh; */
            height: 100%;
            overflow: hidden;
        }

        .slide-wrap {
            display: flex;
            width: 500%;
            height: 100%;
        }

        .middle {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -45%);
        }

        .slide {
            width: 20%;
            height: 100%;
            transition: 1s;
        }

        .news_img_1{
            width: 90%;
            height: 40%;
            margin-left: auto;
            margin-right: auto;
            text-align:center;
            padding:0px 0px 10px 0px;
        }

        .news_img_2{
            width: 90%;
            height: 40%;
            margin-left: auto;
            margin-right: auto;           
            text-align:center;
            padding:10px 0px 0px 0px;
        }

        .news_img_1 img {
            width: 60vh;
            height: 40vh;
            z-index:9999;
            /* position: absolute; */
            margin-left: auto;
            margin-right: auto;
            
        }

        .news_img_2 img {
            width: 60vh;
            height: 40vh;
            z-index:9999;
            margin-left: auto;
            margin-right: auto;

            /* position: absolute; */
            /* bottom: 10%; */

        }

        .navigation {
            position: absolute;
            left: 50%;
            bottom: 30px;
            transform: translateX(-50%);
            display: flex;
        }

        .bar {
            width: 20px;
            height: 10px;
            border: 3px white solid;
            margin-left: 10px;
            cursor: pointer;
            transition: 0.5s;
        }

        .bar:hover {
            background: white;
        }

        input[name="r"] {
            position: absolute;
            visibility: hidden;
        }

        #r1:checked~.s1 {
            margin-left: 0;
        }

        #r2:checked~.s1 {
            margin-left: -20%;
        }

        #r3:checked~.s1 {
            margin-left: -40%;
        }

        #r4:checked~.s1 {
            margin-left: -60%;
        }

        #r5:checked~.s1 {
            margin-left: -80%;
        }

        .s1 {
            animation: loop 12s linear infinite;
        }

        @keyframes loop {
            0% {
                margin-left: 0;
            }
            15% {
                margin-left: 0;
            }
            /* 停留1500ms */
            20% {
                margin-left: -20%;
            }
            /* 切换500ms 位移-20% */
            35% {
                margin-left: -20%;
            }
            40% {
                margin-left: -40%;
            }
            55% {
                margin-left: -40%;
            }
            60% {
                margin-left: -60%;
            }
            75% {
                margin-left: -60%;
            }
            80% {
                margin-left: -80%;
            }
            95% {
                margin-left: -80%;
            }
            100% {
                margin-left: 0;
            }
            /* 复位到第一张图片 */
        }
    </style>
</head>
<div class="container">
<div class="slide-container middle">
        <div class="slide-wrap">
            <input type="radio" name="r" id="r1" checked>
            <input type="radio" name="r" id="r2">
            <input type="radio" name="r" id="r3">
            <input type="radio" name="r" id="r4">
            <input type="radio" name="r" id="r5">
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
            <div class="slide">
                <img src="<?= base_url('api/images/get/1/thumb') ?>" alt="">
            </div>
            <div class="slide">
                <img src="<?= base_url('api/images/get/2/thumb') ?>" alt="">
            </div>
            <div class="slide">
                <img src="<?= base_url('api/images/get/3/thumb') ?>" alt="">
            </div>

            <div class="navigation" style="display:none">
                <label class="bar" for="r1"></label>
                <label class="bar" for="r2"></label>
                <label class="bar" for="r3"></label>
                <label class="bar" for="r4"></label>
                <label class="bar" for="r5"></label>
            </div>
        </div>
    </div>

<input type="radio" class="s1" name="r" id="r1" style="display:none" checked>
<input type="radio" class="s1" name="r" id="r2" style="display:none" >
<input type="radio" class="s1" name="r" id="r3" style="display:none" >
<input type="radio" class="s1" name="r" id="r4" style="display:none" >
<input type="radio" class="s1" name="r" id="r5" style="display:none" >
</div>

<script>

</script>
   


