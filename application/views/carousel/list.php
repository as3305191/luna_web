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
            width: 500px;
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
            transform: translate(-50%, -50%);
        }

        .slide {
            width: 20%;
            height: 100%;
            transition: 1s;
        }

        .slide img {
            width: 100%;
            height: 100%;
        }

        .news_img_1{
            margin:0;
            padding:0;
            height:50%;
            width:100%;
            position: absolute;
        }

        .news_img_2{
            margin:0;
            padding:30px;
            height:50%;
            width:100%;
            position: absolute;
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

        /* .s1 {
            animation: loop 12s linear infinite;
        } */

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
                <div class="news_img_1" style="padding: 10px 0px 10px 0px">
                    <img src="<?= base_url('api/images/get/315/thumb') ?>" style="margin:auto;" alt="">
                </div>
                <div class="news_img_2" style="padding: 855px 0px 10px 0px">
                    <img src="<?= base_url('api/images/get/314/thumb') ?>" style="margin:auto;" alt="">
                </div>
            </div>
            <div class="slide">
                <img src="<?= base_url('api/images/get/314/thumb') ?>" alt="">
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

   


