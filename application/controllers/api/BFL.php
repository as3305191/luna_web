<?php
class BFL extends MY_Base_Controller
{
    public function test_b_l()
    {
        $i = 0;
        while ($i < 3600) {
            $i++;
            //secho "<script>window.onload = function() {document.location.href=https://www.butterfly-love.com.tw';};";
            echo "<script>document.location.href='https://www.butterfly-love.com.tw';</script>";
            //echo "<script>window.open('https://www.butterfly-love.com.tw');</script>";
            //header("https://www.butterfly-love.com.tw");
            //sleep(1);
        }
    }
}