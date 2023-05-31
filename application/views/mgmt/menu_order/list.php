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
            <span style="font-size: 16pt;color:#0d0d56">開案</span>
        </div>
        <button class="btn-success text-light btn_active step1" style="border-radius: 5px; padding: 10px; width: 160px; height: 48px;" onclick="backStep1()">專案資訊</button>
        <!-- <button class="btn-warning text-light" style="border-radius: 5px; padding: 10; width: 160px; height: 48px; background-color: #FFD835; color: #f56b10;">場次設定</button> -->
        <button class="btn-light text-light btn_unsuccess step2" style="border-radius: 5px; padding: 10px; width: 160px; height: 48px;">場次設定</button>
        <button class="btn-light text-light btn_unsuccess step3" style="border-radius: 5px; padding: 10px; width: 160px; height: 48px;">店點及KPI設定</button>
        <div style="float:right">
            <form method="post" id="import_form" enctype="multipart/form-data">
              <label for="file" id="w_file" class="btn btn-outline-warning" style="border-radius: 5px; padding: 10px; width: 160px; height: 48px; line-height: 28px;display:none">匯入場次表</label>
              <input type="file" name="file" class="btn btn-outline-warning" style="display:none" id="file" accept=".xls, .xlsx" />
            </form>
        </div>
        <div id="download_ws" style="float:right;display:none">
          <a href="<?=base_url('files/test_excels.xlsx')?>" download class="btn btn-info" id="end_project" style="float:right;margin-right:10px;width: 160px;line-height: 28px; height: 48px;color:white;background-color:#FF9030">下載場次範本</a>
        </div>
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
