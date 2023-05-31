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
        <section class="col-md-12 col-xs-12 col-sm-12" style="padding: 17px 0px;border:1px solid #ccc">
            <input type="hidden" id="p_id" style="display:none" value="<?=isset($item) ? $item -> id : ''?>">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="" class="control-label">開案申請日期*</label>
                    <div class="input-group col-md-6">
                        <input class="form-control inline date-input dt_picker " id="project_application_time" placeholder="YYYY-MM-DD" value="<?=date('Y-m-d')?>" name="project_application_time" style="width:100%;"/>
                        <img src="<?=base_url('img/proj_new/cala.svg')?>" style="height:16px;position:absolute;right:20px;top:9px;z-index:3">
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="" class="control-label">客戶名稱*</label>
                    <div class="input-group col-md-6" style="position:relative">
                        <select class="" name="custom_name" id="custom_name">
                          <optgroup label="請先選擇客戶分類">
                            <option selected disabled style="display: none;color:grey">請選擇</option>
                          </optgroup>
                            <!-- <?php foreach ($customs as $c): ?>
                            <option value="<?=$c -> id?>" <?= isset($item) && $item -> custom_name == $c -> id ? 'selected' : '' ?>>
                                <?=$c -> name_cn ?>
                            </option>
                            <?php endforeach; ?> -->
                        </select>
                        <span id="custom_alert" style="color:red;position:absolute;right:-120px;top:5px;display:none">請先選擇客戶分類</span>
                    </div>
                </div>
                <?php if ($dp -> view_custom == 1): ?>
                  <div class="form-group" style="float:left">
                      <a href="#mgmt/customs" style="color:#2E95BC">選單中找不到需要的客戶嗎?前往客戶資料管理</a>
                  </div>
                <?php endif; ?>

            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="" class="control-label">客戶分類*</label>
                    <div class="input-group col-md-6">
                        <select class="form-control" name="custom_cate" id="custom_cate" onchange="change_customcate()">
                          <option selected disabled style="display: none;color:grey">請選擇</option>
                            <?php foreach ($custom_cate as $cc): ?>
                            <option value="<?=$cc -> id?>" <?= isset($item) && $item -> custom_cate == $cc -> id ? 'selected' : '' ?>>
                                <?=$cc -> cate_name ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <hr class="clearfix"/>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-bottom:10px">
              品牌及產品*
            </div>
            <div class="col-sm-12" style="padding-bottom: 10px;">
                <div id="product_cate_list">
                    <div class="card-body">
                        <div class="product-list product-cate-list">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>產品分類</th>
                                        <th>品牌</th>
                                        <th>產品名稱</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="search">
                        <button type="button" class="btn btn-outline-warning add_product" name="button">新增產品</button>
                    </div>
                </div>
            </div>
        </section>
        <hr/>
        <section class="col-md-12 col-xs-12 col-sm-12 sec1" style="padding: 17px 0px;border:1px solid #ccc">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="" class="control-label">專案負責AT*</label>
                    <div class="input-group col-md-6 fif">
                      <div class="input-group col-md-6" style="width:49%">
                        <input type="hidden" style="display:none" name="project_at" value="<?=isset($item) ? $item -> project_at : ''?>" id="project_at">
                        <input class="form-control" name="project_at_c"  id="project_at_c" value="<?=isset($item) ? $item -> project_at_c : ''?>" onclick="open_d()">
                      </div>
                      <div class="input-group col-md-6" style="width:49%">
                        <select class="form-control" name="project_at_sub" id ="project_at_sub">
                          <option disabled selected style="display:none">請先選擇部門</option>
                        </select>
                      </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="" class="control-label">專案分類*</label>
                    <div class="input-group col-md-6">
                        <select class="form-control" style="width:100%" name="project_cate" id="project_cate" >
                            <optgroup label="請選擇">
                                <?php foreach ($project_cate as $pc): ?>
                                <option value="<?=$pc -> id?>" <?= isset($item) && $item -> project_cate == $pc -> id ? 'selected' : '' ?>>
                                    <?=$pc -> cate ?>
                                </option>
                                <?php endforeach; ?>
                            </optgroup>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="" class="control-label">專案負責人*</label>
                    <div class="input-group col-md-6 fif">
                      <div class="input-group col-md-6" style="width:49%">
                        <input type="hidden" style="display:none" name="project_manager" value="<?=isset($item) ? $item -> project_manager : ''?>" id="project_manager">
                        <input class="form-control" name="project_manager_c" id="project_manager_c" value="<?=isset($item) ? $item -> project_manager_c : ''?>" onclick="open_d2()">
                      </div>
                      <div class="input-group col-md-6" style="width:49%">
                        <select class="form-control" name="project_manager_sub" id ="project_manager_sub">
                          <option disabled selected style="display:none">請先選擇部門</option>
                        </select>
                      </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="" class="control-label">專案型態*</label>
                    <div class="input-group col-md-6">
                        <select class="form-control" style="width:100%" name="project_type" id="project_type" >
                            <optgroup label="請選擇">
                                <?php foreach ($project_type as $pt): ?>
                                <option value="<?=$pt -> id?>" <?= isset($item) && $item -> project_type == $pt -> id ? 'selected' : '' ?>>
                                    <?=$pt -> type ?>
                                </option>
                                <?php endforeach; ?>
                            </optgroup>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="" class="control-label">專案名稱*</label>
                    <div class="input-group col-md-6">
                        <input class="form-control" name="project_name" type="text" placeholder="輸入專案名稱" >
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="" class="control-label">專案進度*</label>
                    <div class="input-group col-md-6">
                        <select class="form-control" name="project_status" >
                            <option value="3" <?=isset($item) && $item == 3 ? 'selected':''?>>執行</option>
                            <option value="1" <?=isset($item) && $item == 1 ? 'selected':''?>>機會</option>
                            <option value="2" <?=isset($item) && $item == 2 ? 'selected':''?>>開發</option>
                            <!-- <option value="-1" <?=isset($item) && $item < 0 ? 'selected':''?>>取消</option> -->
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="" class="control-label">專案卡號*</label>
                    <div class="input-group col-md-6">
                        <span><?= isset($item) ? $item -> project_catd_no : '--'?></span>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="" class="control-label">專案收入*</label>
                    <div class="input-group col-md-6">
                        <input class="form-control" name="project_revenue" type="number" placeholder="輸入內容" >
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="" class="control-label">毛利率(%)*</label>
                    <div class="input-group col-md-6">
                        <input class="form-control" name="project_profit_margin" type="number" placeholder="輸入內容" >
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="" class="control-label">專案毛利*</label>
                    <div class="input-group col-md-6">
                        <input class="form-control" name="project_gross_profit" type="number" placeholder="輸入內容" >
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="" class="control-label">備註</label>
                    <div class="input-group col-md-6">
                        <textarea class="form-control" rows="1" name="note" placeholder="輸入內容" style="resize:none;width:100%"></textarea>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="" class="control-label">專案開始日期*</label>
                    <div class="input-group col-md-6">
                        <div class="input-group">
                          <input class="form-control inline date-input dt_picker" id="start_time" placeholder="YYYY-MM-DD" name="start_time"/>
                          <img src="<?=base_url('img/proj_new/cala.svg')?>" style="height:16px;position:absolute;right:20px;top:9px;z-index:3">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="" class="control-label">專案結束日期*</label>
                    <div class="input-group col-md-6">
                      <div class="input-group">
                        <input class="form-control inline date-input dt_picker" id="end_time" placeholder="YYYY-MM-DD" name="end_time"/>
                        <img src="<?=base_url('img/proj_new/cala.svg')?>" style="height:16px;position:absolute;right:20px;top:9px;z-index:3">
                      </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="col-md-12 col-xs-12 col-sm-12 no-padding" style="margin-top:10px">
            <button type="submit" style="float:right;border-radius:5px;background-color:#45BA71;border-color:#308F57;font-size:14px;padding:10px" class="btn btn-success submit">儲存專案資訊</button>
        </div>
    </form>
    <!-- step2 -->
    <form role="form" id="step-2" style="display:none;padding:0px 13px">
        <ul class="nav nav-tabs" role="tablist">

            <li class="nav-item">
              <button type="button" id="plus-tab" class="nav-link" style="cursor:pointer;border:0;background-color:rgba(0,0,0,0)" aria-controls="" aria-expanded="true">新增職務樣板</button>
            </li>
        </ul>
        <!-- Step 2 === tabs -->
        <div id="myTabContent" class="tab-content">
            <section class="tab-pane fade in padding-10 no-padding-bottom active" id="s_template" style="display: none;padding: 17px 0px">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="" class="control-label">職務分類*</label>
                        <div class="input-group col-md-6">
                            <select name="duties" required class="form-control change-name">
                                <option selected disabled style="display:none">請選擇</option>
                                <?php foreach ($job_title as $jt): ?>
                                <option value="<?=$jt -> id?>" <?= isset($item) && $item -> duties == $jt -> id ? 'selected' : '' ?>>
                                    <?=$jt -> title ?>
                                    <?=$jt -> sub_title?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="" class="control-label">招募人員條件(性別／年齡／長相／身高／體重)*</label>
                        <div class="input-group col-md-6">
                            <textarea class="form-control" required name="invite_note" rows="3" placeholder="請輸入條件" style="resize:none;width:100%"></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="" class="control-label">工作內容摘要*</label>
                        <div class="input-group col-md-6">
                            <textarea class="form-control" name="work_note" rows="3" placeholder="請輸入工作內容摘要" style="resize:none;width:100%"></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="" class="control-label">其他備註</label>
                        <div class="input-group col-md-6">
                            <textarea class="form-control" name="work_other_note" rows="3" placeholder="請輸入備註說明" style="resize:none;width:100%"></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="" class="control-label">人數*</label>
                        <div class="input-group col-md-6">
                            <input class="form-control" type="number" name="need_num" placeholder="輸入人數">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6"></div>
                <hr/>
                <div class="col-sm-12 no-padding">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="" class="control-label">工作時間*</label>
                            <div class="input-group col-sm-6">
                                <select class="form-control working_time_type" name="working_time_type">
                                    <optgroup label="執行時間">
                                        <option value="1" selected>執行時間(設定起迄時間)</option>
                                        <option value="2">工作時數(設定時數)</option>
                                    </optgroup>
                                </select>
                            </div>
                            <div class="input-group col-sm-6 working_1" style="top:10px;">
                                <input type="text" class="form-control" name="working_start_time" placeholder="HH:MM" style="border-right:none">
                                <span class="input-group-addon button" style="background-color:#fff;border-left:none!important;"><img src="<?=base_url('img/proj_new/clock.svg')?>" style="height:16px"></span>
                                <input type="text" class="form-control" name="working_end_time" placeholder="HH:MM" style="border-right:none">
                                <span class="input-group-addon button" style="background-color:#fff;border-left:none!important;"><img src="<?=base_url('img/proj_new/clock.svg')?>" style="height:16px"></span>
                            </div>
                            <div class="input-group col-sm-6 working_2" style="padding-top:10px;display:none">
                                <input type="text" class="form-control" name="working_hours" placeholder="請輸入時數" style="border-right:none">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="" class="control-label">休息分類*</label>
                            <div class="input-group col-sm-6">
                                <select class="form-control break_type" name="break_type" onchange="break_type_check()">
                                    <optgroup label="請選擇">
                                        <?php foreach ($break_type as $bt): ?>
                                        <option value="<?=$bt -> id?>" <?= isset($item) && $item -> break_type == $bt -> id ? 'selected' : '' ?>>
                                            <?=$bt -> break_type ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="" class="control-label">上下點時間*</label>
                        <div class="input-group col-sm-6" style="">
                            <input type="text" class="form-control" name="clock_on_time" placeholder="HH:MM" style="border-right:none">
                            <span class="input-group-addon button" style="background-color:#fff;border-left:none!important;"><img src="<?=base_url('img/proj_new/clock.svg')?>" style="height:16px"></span>
                            <input type="text" class="form-control" name="clock_off_time" placeholder="HH:MM" style="border-right:none">
                            <span class="input-group-addon button" style="background-color:#fff;border-left:none!important;"><img src="<?=base_url('img/proj_new/clock.svg')?>" style="height:16px"></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                      <label for="" class="control-label">休息時間*</label>
                      <div class="input-group col-sm-6" style="">
                        <input class="form-control" name="break_start_time" style="width:100%;" value="<?=isset($item) ? $item -> break_start_time : '' ?>">
                      </div>
                  </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="" class="control-label">上下點工作摘要</label>
                        <div class="input-group col-sm-6">
                            <input class="form-control" type="text" value="<?=isset($item) ? $item -> work_summary : '' ?>" name="work_summary" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="" class="control-label">供膳*</label>
                        <div class="input-group col-sm-6">
                            <select class="form-control" name="feeding">
                                <optgroup label="請選擇">
                                    <option selected disabled style="display: none;color:grey">請選擇</option>
                                    <?php foreach ($feeding as $fd): ?>
                                    <option value="<?=$fd -> id?>" <?= isset($item) && $item -> feeding == $fd -> id ? 'selected' : '' ?>>
                                        <?=$fd -> feeding?>
                                    </option>
                                    <?php endforeach; ?>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="" class="control-label">計薪時數</label>
                        <div class="input-group col-md-6">
                            <input class="form-control" type="text" name="pay_time" placeholder="輸入時數">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="" class="control-label">服裝說明</label>
                        <div class="input-group col-md-6">
                            <textarea class="form-control" rows="3" name="cloth_note" placeholder="請輸入服裝說明" style="resize:none;width:100%"></textarea>
                        </div>
                    </div>
                </div>
                <hr class="clearfix"/>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="" class="control-label">薪資金額*</label>
                        <div class="input-group col-md-6">
                            <input class="form-control pay_input" type="number" name="pay" inputmode="numeric" pattern="[0-9]*" placeholder="輸入金額">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="" class="control-label">給付條件</label>
                        <div>
                            <span>完成每班活動執行應給付的薪資</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="" class="control-label">附加說明</label>
                        <div class="input-group col-md-6">
                            <input class="form-control" type="text" name="pay_note" placeholder="輸入附加說明">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="col-sm-12" style="padding-bottom: 10px;">
                    <div>
                        <div class="card-body">
                            <div class="product-list">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>展資分類</th>
                                            <th>展資項目</th>
                                            <th>金額</th>
                                            <th>給付條件</th>
                                            <th>附加說明</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                          <tr class="pd_1 pdpd">
                                            <td style="border-right:none;">
                                                <select class="form-control p_1 info_cate" name="info_cate">
                                                    <?php foreach ($info_cate as $ic): ?>
                                                    <option value="<?=$ic -> id?>" <?= isset($pdpl) && $pdpl -> info_cate == $ic -> id ? 'selected' : '' ?>>
                                                        <?=$ic -> info_cate?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                            <td style="border-right:none;">
                                                <select class="form-control p_2 info_list" name="info_list">
                                                    <?php foreach ($info_list as $il): ?>
                                                    <option value="<?=$il -> id?>" <?= isset($pdpl) && $pdpl -> info_list == $il -> id ? 'selected' : '' ?>>
                                                        <?=$il -> info_list?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                            <td style="border-right:none;">
                                                <div class="input-group col-md-12">
                                                    <input type="text" name="info_pay" class="form-control info_pay" placeholder="請輸入金額">
                                                </div>
                                            </td>
                                            <td class="p_3">
																											本人現場參與集體培訓</td>
                                            <td style="border-right:none;">
                                                <div class="input-group col-md-12">
                                                    <input type="text" class="form-control info_pay_note" name="info_pay_note" placeholder="請輸入附加說明">
                                                </div>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger del_p" style="background-color:#F95E53">移除</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="search">
                            <!-- <input  type="text" class="form-control"  /> -->
                            <button type="button" class="btn btn-outline-warning add_p" name="button">增加展資商品</button>
                        </div>
                    </div>
                    <div class="card-footer">
                        <hr/>
                    </div>
                    <div class="col-sm-12 no-padding">
                        <button type="button" class="c_btn btn btn-default">取消</button>
                        <button type="button" class="c_btn btn btn-default save_temp_Btn" style="background-color:#45BA71;border-color:#308F57;color:white">儲存</button>
                    </div>
                </div>
            </section>

        </div>
        <div id="tab_b"></div>
        <hr/>
        <section class="col-md-12 col-xs-12 col-sm-12" style="padding: 17px 17px;border:1px solid #ccc">
            <div class="col-sm-12" style="font-size:120%;position:relative;margin-bottom:10px;">
                <div style="float:left">
                    <span>適用場次</span>
                </div>
                <div style="float:right">
                    <button type="button" class="btn btn-outline-warning" id="choose_ws" name="button">選擇適用場次</button>
                </div>
            </div>
            <hr/>
            <div class="col-sm-12" id="all_data">
                <div class="col-sm-2" style="padding:0px;margin-top:43px" id="w_data">

                </div>
                <div class="col-sm-10" style="overflow:scroll;padding-right:0px" >
                    <table class="table table-b" style="min-width:100%">
                      <thead id="t_data">

                      </thead>

                        <tbody id="s_data">
                            <!-- <tr>
                                <td>2018/06/15</td>
                                <td>2018/06/16</td>
                                <td>2018/06/17</td>
                                <td>2018/06/22</td>
                                <td>2018/06/23</td>
                                <td>2018/06/24</td>
                                <td>2018/06/25</td>
                                <td>2018/06/26</td>
                            </tr>
                            <tr>
                                <td class="tb-choose"></td>
                                <td class="tb-choose"></td>
                                <td class="tb-choose"></td>
                                <td></td>
                                <td></td>
                                <td class="tb-choose"></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td class="tb-choose"></td>
                                <td></td>
                                <td class="tb-choose"></td>
                                <td class="tb-choose"></td>
                                <td></td>
                                <td class="tb-choose"></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td class="tb-choose"></td>
                                <td class="tb-choose"></td>
                                <td></td>
                                <td class="tb-choose"></td>
                                <td class="tb-choose"></td>
                                <td></td>
                            </tr> -->
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <div class="col-md-12 col-xs-12 col-sm-12 no-padding" style="margin-top:10px">
            <button type="button" style="float:right;border-radius:5px;background-color:#45BA71;border-color:#308F57;font-size:14px;padding:10px" class="btn btn-success" onclick="doStep2()">儲存班次設定</button>
        </div>
    </form>

    <!-- step3 -->
    <form role="form" id="step-3" style="display:none;padding:0px 13px">
      <div class="col-xs-12" style="">

        <div class="form-group inline">
            <label for="" class="input-group control-label" style="float:left;padding:6px 12px">大區</label>
            <div class="input-group" style="width:150px">
                <select class="form-control" id="region" onchange="region_change()">
                    <option value="all" reg="all">全部</option>
                    <?php foreach ($region as $r): ?>
                    <option value="<?=$r -> region?>" reg="<?=$r -> id?>">
                        <?=$r -> region?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-group inline">
            <label for="" class="input-group control-label" style="float:left;padding:6px 12px">縣市</label>
            <div class="input-group" style="width:150px">
                <select class="form-control" id="market_city">
                    <option value="all">全部</option>
                    <?php foreach ($market_city as $m_city): ?>
                    <option value="<?=$m_city -> city?>">
                        <?=$m_city -> city?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
            <div class="form-group inline">
                <label for="" class="input-group control-label" style="float:left;padding:6px 12px;height:32px">通路分類</label>
                <div class="input-group" style="width:150px">
                    <select class="form-control" id="market_cate">
                        <option value="all">全部</option>
                        <?php foreach ($market_cate as $mc): ?>
                        <option value="<?=$mc -> name?>">
                            <?=$mc -> name?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group inline">
                <label for="" class="input-group control-label" style="float:left;padding:6px 12px">通路名稱</label>
                <div class="input-group" style="width:150px">
                    <select class="form-control" id="market_type">
                        <option value="all">全部</option>
                        <?php foreach ($market_type as $mt): ?>
                        <option value="<?=$mt -> name?>">
                            <?=$mt -> name?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

      </div>
      <div class="col-xs-12" style="">
        <div class="form-group inline" style="min-width:450px;float:left">
          <div class="form-group inline  no-padding">
              <label for="" class="input-group control-label" style="float:left;line-height:17px;padding:0px 10px">日期區間</label>
          </div>
          <div class="form-group inline no-padding" style="min-width:143px">
              <div class="input-group date">
                <input class="form-control inline date-input dt_picker" id="search_start_time" placeholder="YYYY-MM-DD"/>
                <img src="<?=base_url('img/proj_new/cala.svg')?>" style="height:16px;position:absolute;right:20px;top:9px;z-index:3">
              </div>
          </div>
          <div class="form-group inline" style="line-height:32px">
              <div class="input-group">
                  <span>~</span>
              </div>
          </div>
          <div class="form-group inline no-padding" style="min-width:143px">
              <div class="input-group">
                <input class="form-control inline date-input dt_picker" id="search_end_time" placeholder="YYYY-MM-DD" />
                <img src="<?=base_url('img/proj_new/cala.svg')?>" style="height:16px;position:absolute;right:20px;top:9px;z-index:3">
              </div>
          </div>
        </div>

        <div class="form-group inline" style="line-height:32px">
            <div class="input-group">
                <button type="button" id="searchBtn" style="background-color:#FF9030;padding:0px 10px;color:white">篩選</button>
            </div>
        </div>

      </div>

      <section class="col-md-12 col-xs-12 col-sm-12" style="padding: 17px 0px;border:1px solid #ccc">
        <div class="col-sm-12" id="all_data3">
          <div class="col-md-2 col-xs-2 col-sm-2 col-lg-2" style="padding:10px 0px;">
            <span style="font-size:14pt;color:#003355">店點分級及業務</span>
          </div>
          <div class="col-md-10 col-xs-10 col-sm-10 col-lg-10" style="padding:10px 0px;">
            <span style="font-size:14pt;color:#003355">設定KPI目標</span>

            <span class="d_text KPI_alert" style="display:none">*本專案有銷售獎金規劃</span>
          </div>
            <div class="col-sm-2" style="padding:0px;margin-top:42px" id="w_data3">

                <!-- <div class="col-sm-12 s_d">
                    <span>北區 量販通路</span>
                    <br>
                    <span>家樂福</span>
                    <span style="font-size:120%"> 南港店</span>
                </div>
                <div class="col-sm-12 s_d">
                    <span>北區 量販通路</span>
                    <br>
                    <span>家樂福</span>
                    <span style="font-size:120%"> 桂林店</span>
                </div>
                <div class="col-sm-12 s_d">
                    <span>中區 量販通路</span>
                    <br>
                    <span>家樂福</span>
                    <span style="font-size:120%"> 沙鹿店</span>
                </div> -->
            </div>
            <div class="col-sm-10" style="overflow:scroll;padding-right:0px" >

                <table class="table table-b" style="min-width:100%">
                  <thead id="t_data3">

                  </thead>

                    <tbody id="s_data3">
                        <!-- <tr>
                            <td>2018/06/15</td>
                            <td>2018/06/16</td>
                            <td>2018/06/17</td>
                            <td>2018/06/22</td>
                            <td>2018/06/23</td>
                            <td>2018/06/24</td>
                            <td>2018/06/25</td>
                            <td>2018/06/26</td>
                        </tr>
                        <tr>
                            <td class="tb-choose"></td>
                            <td class="tb-choose"></td>
                            <td class="tb-choose"></td>
                            <td></td>
                            <td></td>
                            <td class="tb-choose"></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="tb-choose"></td>
                            <td></td>
                            <td class="tb-choose"></td>
                            <td class="tb-choose"></td>
                            <td></td>
                            <td class="tb-choose"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="tb-choose"></td>
                            <td class="tb-choose"></td>
                            <td></td>
                            <td class="tb-choose"></td>
                            <td class="tb-choose"></td>
                            <td></td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
        </div>
      </section>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding:20px 10px">

        <button type="button" class="btn kpi_btn kpi_complete" id="save_and_back">儲存並離開</button>
        <button type="button" class="btn kpi_btn kpi_save" id="save_kpi_btn">儲存</button>
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
