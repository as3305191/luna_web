<style>
.slide-container {
    width: 500px;
    height: 300px;
  	overflow: hidden;
}
.middle {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
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
}
</style>

<div class="slide-container middle">
    <div class="slide-wrap">
        <div class="slide">
            <img src="<?= base_url('img/ktx_img/logo.jpg') ?>" alt="">
        </div>
        <div class="slide">
            <img src="<?= base_url('img/ktx_img/logo.jpg') ?>" alt="">
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
