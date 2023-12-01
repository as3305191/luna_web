<?php $this->load->view('layout/head'); ?>
<style>
     :root {
            --speed: 8s;
            --ring: #3a4ebb;
            --line: 0.5vmin;
            --spin: spin var(--speed) linear 0s infinite;
        }
        body {
            margin: 0;
            padding: 0;
            width: 100vw;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background:#000;
            overflow: hidden;
        }
        @keyframes spin {
            100% {
                transform: rotate(-360deg);
            }
        }
        .protect_content {
            width: 30vmin;
            height: 30vmin;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .protect_content div {
            border-radius: 50%;
            position: relative;
            width: 50%;
            height: 50%;
            box-shadow: 0 0 0 var(--line) var(--ring) inset;
            box-sizing: border-box;
            animation: var(--spin);
        }
        .protect_content>div>div {
            --ring: #60b2f3;
            left: 26%;
            width: 48%;
            height: 48%;
        }
        .protect_content>div>div>div {
            --ring: #3f6dcc;
            left: -33%;
            width: 170%;
            height: 170%;
        }
        .protect_content>div>div>div>div {
            --ring: #93d1fc;
            left: 29%;
            width: 40%;
            height: 40%;
        }
        .protect_content>div>div>div>div>div {
            --ring: #4597ef;
            left: -50%;
            width: 100%;
            height: 100%;
        }
        .protect_content>div>div>div>div>div>div {
            --ring: #aacbdb;
            left: 36.5%;
            width: 28%;
            height: 28%;
        }
</style>
  <div class="protect_content">
        <div>
            <div>
                <div>
                    <div>
                        <div>
                            <div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <?php $this->load->view('layout/plugins'); ?> -->
    <script type="text/javascript">
      document.onmousemove=function(){
        parent.is_protect=0;
        var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
        parent.layer.close(index);	
      };
       
    </script>

