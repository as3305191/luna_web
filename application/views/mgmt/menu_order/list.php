<div class="col-md-12 col-xs-12 col-sm-12" id="top_title" style="padding:10px 0px;background-color:#DCDCDC;position:relative;z-index:3">
    <div class="col-md-12 col-xs-12 col-sm-12" style="font-size: 12pt; color:#0d0d56">
        <div onclick="currentApp.backTo()" style="color:#2E95BC;cursor:pointer;display:inline-block">任務管理列表</div>
        <div style="display:inline-block">
            <span>></span>
            <span><?= isset($item) ?'編輯任務:'. $item -> account : '建立任務'  ?></span>
        </div>
    </div>
</div>
<div class="col-sm-12" id="edit-modal-body">
    <header>
        <style>
          body {
              color: #003355;
          }
          section{
            margin-bottom: 15px;
          }
        </style>
    </header>

    <div class="col-md-12 col-xs-12 col-sm-12" style="padding:10px 0px;">
        <div class="col-md-12 col-xs-12 col-sm-12 no-padding" style="">
            <span style="font-size: 16pt; color:#094169">建立任務</span>
        </div>
    </div>
    <form role="form" id="new_missions" method="post" class="form-horizontal">
        <section class="col-md-12 col-xs-12 col-sm-12" style="padding: 17px 17px;border:1px solid #ccc;background-color: #fff;">
            <div class="col-md-12 no-padding">
                <div class="col-md-6">
                    <label for="" class="mb15">指派對象</label>
                    <div class="input-group col-md-10">
                        <select name="mission_target_type" id="mission_target_type" class="form-control">
                            <option value="1">執行人員</option>
                            <option value="2">傳揚管理人員</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6" style="padding-bottom:20px">
                    <label for="" class="mb15">任務分類</label>
                    <div class="input-group col-md-10">
                        <select name="mission_cate" id="mission_cate" class="form-control">
                            <?php foreach ($mission_cate as $mc): ?>
                            <option value="<?=$mc -> id?>">
                                <?=$mc -> name?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <hr/>
                <div class="only_user">
                    <div class="col-md-6">
                        <label for="" class="mb15">專案名稱</label>
                        <div class="input-group col-md-10">
                            <select name="project_name" id="project_name" class="select2" onchange="changeProject()" style="width:100%">
                                <option selected disabled style="display:none">請選擇</option>
                                <?php foreach ($all_projects as $ap): ?>
                                <option value="<?=$ap -> id?>">
                                    <?=$ap -> project_name?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="" class="mb15">職務</label>
                        <div class="input-group col-md-10">
                            <select name="duties" id="duties" class="form-control">
                                <option selected disabled style="display:none">請選擇</option>
                                <?php foreach ($p_duties as $pd): ?>
                                <option value="<?=$pd -> id?>">
                                    <?=$pd -> job_title?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="col-md-12 col-xs-12 col-sm-12" style="padding: 17px 17px;border:1px solid #ccc;background-color: #fff;">
            <div class="col-md-6 no-padding">
                <div class="col-md-12" style="padding-bottom:15px">
                    <label for="" class="mb15">任務名稱</label>
                    <div class="input-group col-md-10">
                        <input name="mission_title" class="form-control" value="" placeholder="輸入名稱" id="mission_title">
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="" class="mb15">任務內容</label>
                    <div class="input-group col-md-10">
                        <textarea class="form-control" name="mission_content" id="mission_content" placeholder="輸入任務內容" rows="5" style="resize:none"></textarea>
                    </div>
                </div>
            </div>
            <div class="col-md-6 no-padding">
                <div id="itp" style="display:none">
                    <div id="mission_temp_div">
                        <div class="col-md-12">
                            <label for="" class="mb15">選項</label>
                        </div>
                        <div class="col-md-12 mission_itp_temp" style="padding-bottom:15px;">
                            <div class="input-group col-md-10" style="position:relative">
                                <label for="" class="" style="color:#4AA99E">選項1</label>
                                <input name="mission_itp" class="form-control mission_itp" value="" >
                                <i class="fa fa-trash" style="position:absolute;right:-20px;bottom:10px"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12" style="margin-bottom:15px">
                        <button class="btn btn-outline-warning" id="add_mission_itp" type="button">增加空白選項</button>
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="" class="mb15">日期時間</label>
                    <div class="input-group col-md-12">
                        <div class="col-md-6" style="padding:0px 15px 0px 0px">
                            <input class="form-control inline date-input dt_picker" id="mission_date" placeholder="YYYY-MM-DD" value="<?=date('Y-m-d')?>" name="mission_date"/>
                            <img src="<?=base_url('img/proj_new/cala.svg')?>" style="height:16px;position:absolute;right:20px;top:9px;z-index:3">
                        </div>
                        <div class="col-md-4 no-padding">
                            <input class="form-control inline date-input dt_picker_t" id="mission_time" placeholder="HH:MM" value="<?=date('H:i')?>" name="mission_time"/>
                            <img src="<?=base_url('img/proj_new/clock.svg')?>" style="height:16px;position:absolute;right:5px;top:9px;z-index:3">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="col-md-12 col-xs-12 col-sm-12" style="padding: 17px 17px;border:1px solid #ccc;background-color: #fff;">
            <div class="col-md-12 no-padding">
                <div class="col-md-12">
                    <label for="" class="mb15">指派對象</label>
                    <div class="input-group col-md-10">
                        <input type="hidden" id="select_list_id" value="">
                        <input type="hidden" id="pwsd_select_id" value="">
                        <input type="hidden" id="ff" value="">
                        <span style="color:grey" id="select_list">未選擇</span>
                    </div>
                </div>
                <div class="col-md-12">
                    <button class="btn btn-outline-warning" id="add_mission_target" type="button">選擇/變更對象</button>
                </div>
            </div>
        </section>
        <div class="col-md-12 col-xs-12 col-sm-12 no-padding" style="margin-top:10px">
            <button type="submit" style="float:right;border-radius:5px;font-size:14px;padding:10px" class="btn btn-warning">建立任務</button>
        </div>
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
