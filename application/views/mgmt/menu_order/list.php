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
        <button class="btn-success text-light btn_active menu_1" style="border-radius: 5px; padding: 10px; width: 160px; height: 48px;" onclick="backStep1()">菜單1</button>
        <!-- <button class="btn-warning text-light" style="border-radius: 5px; padding: 10; width: 160px; height: 48px; background-color: #FFD835; color: #f56b10;">場次設定</button> -->
        <button class="btn-light text-light btn_unsuccess menu_2" style="border-radius: 5px; padding: 10px; width: 160px; height: 48px;">菜單2</button>
        <button class="btn-light text-light btn_unsuccess menu_3" style="border-radius: 5px; padding: 10px; width: 160px; height: 48px;">菜單3</button>
       
       
        <hr/>
    </div>
    <form role="form" id="menu_1" action="" name="step-1" method="post" autocomplete="off" style="padding:0px 13px">
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">品項</label>
					<div class="col-md-6" id="patnet_status" >
						<textarea type="text" require class="form-control" rows="3" id="inventor" name="inventor" style="resize:none;width:100%" ><?= isset($item) ? $item -> inventor : '' ?></textarea>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">備注</label>
					<div class="col-md-6">
						<textarea type="text" require class="form-control" rows="3" id="inventor" name="inventor" style="resize:none;width:100%" ><?= isset($item) ? $item -> inventor : '' ?></textarea>
					</div>
				</div>
			</fieldset>
		
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">總金額</label>
					<div class="col-md-6">
						<input type="text" required class="form-control" name="s_menu_style_id"  id="s_menu_style_id" value="<?= isset($item) ? $item -> menu_style_id : 0 ?>"  />
					</div>
				</div>
			</fieldset>
    </form>

<?php $this -> load -> view('general/delete_modal'); ?>
<script type="text/javascript">
	

	loadScript(baseUrl + "js/class/BaseAppClass.js", function(){
		loadScript(baseUrl + "js/app/menu_order/list.js", function(){
			currentApp = new menuorderAppClass(new BaseAppClass({}));
			
		});
	});

	
</script>
