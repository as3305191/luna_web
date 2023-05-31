<style>
  .s_sum {
  	display: none;
  }
</style>
<div>
    <header>
</header>
    <div class="col-md-12 col-xs-12 col-sm-12" style="padding:10px 20px 10px 13px;">
        <div class="col-md-12 col-xs-12 col-sm-12 " style="padding:0px 0px 6px 0px;">
            <span style="font-size: 16pt;color:#0d0d56">開放的菜單</span>
        </div>
        <button class="btn-success text-light btn_active step1" style="border-radius: 5px; padding: 10px; width: 160px; height: 48px;" onclick="backStep1()">菜單1</button>
        <!-- <button class="btn-warning text-light" style="border-radius: 5px; padding: 10; width: 160px; height: 48px; background-color: #FFD835; color: #f56b10;">場次設定</button> -->
        <button class="btn-light text-light btn_unsuccess step2" style="border-radius: 5px; padding: 10px; width: 160px; height: 48px;">菜單2</button>
        <button class="btn-light text-light btn_unsuccess step3" style="border-radius: 5px; padding: 10px; width: 160px; height: 48px;">菜單3</button>
       
       
        <hr/>
    </div>
    <form role="form" id="step-1" action="" name="step-1" method="post" autocomplete="off" style="padding:0px 13px">
      
    </form>

</div>
<?php $this -> load -> view('general/delete_modal'); ?>
<script type="text/javascript">
	

	loadScript(baseUrl + "js/class/BaseAppClass.js", function(){
		loadScript(baseUrl + "js/app/menu_order/list.js", function(){
			currentApp = new menuorderAppClass(new BaseAppClass({}));
			
		});
	});

	
</script>
