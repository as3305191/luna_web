<head>
  
    <style>
        .slide-container {
            width: 500px;
            height: 300px;
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

    <div class="slide-container middle">
        <div class="slide-wrap">
            <input type="radio" name="r" id="r1" checked>
            <input type="radio" name="r" id="r2">
            <input type="radio" name="r" id="r3">
            <input type="radio" name="r" id="r4">
            <input type="radio" name="r" id="r5">
            <div class="slide s1">
                <img src="<?= base_url('img/ktx_img/logo.jpg') ?>" alt="">
            </div>
            <div class="slide">
                <img src="<?= base_url('img/ktx_img/logo.jpg') ?>" alt="">
            </div>
            <div class="slide">
                <img src="<?= base_url('img/ktx_img/logo.jpg') ?>" alt="">
            </div>
            <div class="slide">
                <img src="<?= base_url('img/ktx_img/logo.jpg') ?>" alt="">
            </div>
            <div class="slide">
                <img src="<?= base_url('img/ktx_img/logo.jpg') ?>" alt="">
            </div>

            <div class="navigation">
                <label class="bar" for="r1"></label>
                <label class="bar" for="r2"></label>
                <label class="bar" for="r3"></label>
                <label class="bar" for="r4"></label>
                <label class="bar" for="r5"></label>
            </div>
        </div>
    </div>

<input type="radio" class="s1" name="r" id="r1" checked>
<input type="radio" class="s1" name="r" id="r2">
<input type="radio" class="s1" name="r" id="r3">
<input type="radio" class="s1" name="r" id="r4">
<input type="radio" class="s1" name="r" id="r5">

<div class="navigation">
    <label class="bar" for="r1"></label>
    <label class="bar" for="r2"></label>
    <label class="bar" for="r3"></label>
    <label class="bar" for="r4"></label>
    <label class="bar" for="r5"></label>
</div>
