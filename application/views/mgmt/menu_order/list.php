<div class="col-md-12 col-xs-12 col-sm-12" id="top_title" style="padding:10px 0px;background-color:#DCDCDC;position:relative;z-index:3">
    <div class="col-md-12 col-xs-12 col-sm-12" style="font-size: 12pt; color:#0d0d56">
      <?php if (empty($item ->id)): ?>
        <div onclick="currentApp.backTo()" style="color:#2E95BC;cursor:pointer;display:inline-block">職務樣板設定</div>
      <?php else: ?>
        <div onclick="currentApp.backTo()" id="back_parent" style="color:#2E95BC;cursor:pointer;display:inline-block">職務樣板設定</div>
      <?php endif; ?>
        <div style="display:inline-block">
            <span>></span>
            <span><?= isset($item) ? $item -> temp_title : '新增職務模板'  ?></span>
        </div>
    </div>
</div>
<header>
  <!-- <div class="col-sm-12">
    <div class="col-sm-6" style="padding: 17px 0px">
      <div class="pull-left">
        <div class="form-group">
          <a href="javascript:void(0);" id="back_parent" onclick="currentApp.doSubmit()" class="btn btn-default ">
            完成編輯並返回
          </a>
        </div>

      </div>
    </div>
  </div> -->

</header>
    <ul class="nav nav-tabs" role="tablist">
        <?php $i = 1?>
        <?php if (!empty($project_duties_temp)): ?>
          <?php foreach ($project_duties_temp as $pdt): ?>
          <li class="nav-item">
              <!-- <a class="nav-link" href="#s<?=$pdt->temp_pos?>" data-toggle="tab" role="tab" aria-controls="" aria-expanded="true" temp_id="<?=$pdt->id?>"><?=$pdt -> temp_title?></a> -->
          </li>
          <?php $i++;?>
          <?php endforeach; ?>
        <?php endif; ?>

        <!-- <li class="nav-item">
          <?php if (isset($check_is_pwsd) && $check_is_pwsd != 1): ?>
            <button type="button" id="plus-tab" class="nav-link" style="cursor:pointer;border:0;background-color:rgba(0,0,0,0)" aria-controls="" aria-expanded="true">新增職務樣板</button>
          <?php endif; ?>

        </li> -->
          <div class="col-sm-6">
              <div class="form-group">
                <label for="" class="control-label">職務樣板名稱:</label>
                  <div class="input-group col-md-6">
                    <input type="text" class="form-control" id="temp_title_name"  value="<?= isset($project_duties_temp) ? $project_duties_temp[0] -> temp_title : '職務樣板' ?>"   />
                  </div>
              </div>
          </div>
          <input type="hidden" class="form-control" id="for_each_id"  value="<?= isset($id) ? $id : 0 ?>"/>
    </ul>
    <?php if (empty($project_duties_temp)): ?>
      <div class="col-sm-12">
        <div class="col-sm-12 no-padding" style="margin-top:10px">
          <button type="button" class="btn btn-outline-warning add_person is_pwsd" name="button">增加人員資訊</button>
        </div>
      </div>
    <?php endif; ?>

    <div id="myTabContent" class="tab-content">
        <section class="tab-pane padding-10 no-padding-bottom" id="s_template" style="padding: 17px 0px">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="" class="control-label">職務分類*</label>
                    <div class="input-group col-md-6">
                        <select name="duties" required class="form-control change-name">
                            <option selected style="">請選擇</option>
                            <?php foreach ($job_title as $jt): ?>
                            <option value="<?=$jt -> id?>">
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
                        <textarea class="form-control" name="invite_note" rows="3" required placeholder="請輸入條件" style="resize:none;width:100%"></textarea>
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
                                    <option value="<?=$bt -> id?>" <?= isset($pd) && $pd -> break_type == $bt -> id ? 'selected' : '' ?>>
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
                      <input class="form-control" name="break_start_time" style="width:100%;" value="<?=isset($pd) ? $pd -> work_summary : '' ?>">
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="" class="control-label">上下點工作摘要</label>
                    <div class="input-group col-sm-6">
                      <input class="form-control" type="text" value="<?=isset($pd) ? $pd -> work_summary : '' ?>" name="work_summary" />
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
                                <option value="<?=$fd -> id?>" <?= isset($pd) && $pd -> feeding == $fd -> id ? 'selected' : '' ?>>
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
            <hr/>
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
                                    <tr>
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
                    <button type="button" class="c_btn btn btn-default save_temp_Btn"  style="background-color:#45BA71;border-color:#308F57;color:white">儲存</button>
                </div>
            </div>
        </section>
        <?php $j = 1 ?>
        <?php if (!empty($project_duties_temp)): ?>
          <?php foreach ($project_duties_temp as $dt): ?>
          <section class="tab-pane data padding-10 no-padding-bottom active" id="s<?=$dt -> temp_pos?>" style="padding: 17px 17px;border:1px solid #ccc">
              <div class="input-group col-sm-12">
                  <?php $k = 1?>
                  <?php foreach ($project_duties as $pd): ?>
                  <?php if ($pd -> job_duties_id == $dt -> id): ?>
                      <div class="panel panel-default col-md-12 col-xs-12 col-sm-12 no-padding" style="margin:10px 0px" temp_p_id="<?=$pd -> id?>">
                          <div class="panel-heading">
                              <h4 class="panel-title">
                                <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$k?>"><?=$pd -> title?></a>
                                  <span class="glyphicon glyphicon-trash trash" boss="collapse<?=$k?>" style="float:right;cursor:pointer;padding-right:30px;padding-top:2px"></span>
                              </h4>
                          </div>
                          <div id="collapse<?=$k?>" class="panel-collapse collapse">
                              <section class="new_ap" id="ap1" style="padding: 17px 0px;">
                                  <div class="col-sm-6">
                                      <div class="form-group">
                                          <label for="" class="control-label">職務分類*</label>
                                          <div class="input-group col-md-6">
                                              <select name="duties" required="" class="form-control change-name" boss="collapse<?=$k?>">
                                                  <option selected="" disabled="" style="display:none">請選擇</option>
                                                  <?php foreach ($job_title as $jt): ?>
                                                    <option value="<?=$jt -> id?>" <?= isset($pd) && $pd -> duties == $jt -> id ? 'selected' : '' ?>>
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
                                          <label for="" class="control-label">招募人員條件（性別／年齡／長相／身高／體重）*</label>
                                          <div class="input-group col-md-6">
                                              <textarea class="form-control" name="invite_note" rows="3" placeholder="請輸入備註說明" style="resize:none;width:100%" value="<?=$pd -> invite_note?>"><?=$pd -> invite_note?></textarea>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-sm-6">
                                      <div class="form-group">
                                          <label for="" class="control-label">工作內容摘要*</label>
                                          <div class="input-group col-md-6">
                                              <textarea class="form-control" name="work_note" rows="3" placeholder="請輸入工作內容摘要" style="resize:none;width:100%" value="<?=$pd -> work_note?>"><?=$pd -> work_note?></textarea>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-sm-6">
                                      <div class="form-group">
                                          <label for="" class="control-label">其他備註</label>
                                          <div class="input-group col-md-6">
                                              <textarea class="form-control" name="work_other_note" rows="3" placeholder="請輸入備註說明" style="resize:none;width:100%" value="<?=$pd -> work_other_note?>"><?=$pd -> work_other_note?></textarea>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-sm-6">
                                      <div class="form-group">
                                          <label for="" class="control-label">人數*</label>
                                          <div class="input-group col-md-6">
                                              <input class="form-control" type="number"  name="need_num" placeholder="輸入人數" value="<?=$pd -> need_num?>">
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-sm-6"></div>
                                  <hr>
                                  <div class="col-sm-12 no-padding">
                                      <div class="col-sm-6">
                                          <div class="form-group">
                                              <label for="" class="control-label">工作時間*</label>
                                              <div class="input-group col-sm-6">
                                                  <select class="form-control working_time_type" name="working_time_type">
                                                      <optgroup label="執行時間">
                                                          <option value="1" <?=$pd -> working_time_type == 1 ? 'selected' : ''?>>執行時間(設定起迄時間)</option>
                                                          <option value="2" <?=$pd -> working_time_type == 2 ? 'selected' : ''?>>工作時數(設定時數)</option>
                                                      </optgroup>
                                                  </select>
                                              </div>
                                              <?php if ($pd -> working_time_type == 1): ?>
                                                  <div class="input-group col-sm-6 working_1" style="padding-top:10px">
                                                      <input type="text" class="form-control dt_picker_t_1" name="working_start_time" placeholder="HH:MM" style="border-right:none" value="<?=$pd -> working_start_time?>">
                                                      <span class="input-group-addon button" style="background-color:#fff;border-left:none!important;"><img src="<?=base_url('img/proj_new/clock.svg')?>" style="height:16px"></span>
                                                      <input type="text" class="form-control dt_picker_t_1" name="working_end_time" placeholder="HH:MM" style="border-right:none" value="<?=$pd -> working_end_time?>">
                                                      <span class="input-group-addon button" style="background-color:#fff;border-left:none!important;"><img src="<?=base_url('img/proj_new/clock.svg')?>" style="height:16px"></span>
                                                  </div>
                                                  <div class="input-group col-sm-6 working_2" style="padding-top:10px;display:none">
                                                      <input type="text" class="form-control" name="working_hours" placeholder="請輸入時數" style="border-right:none">
                                                  </div>
                                              <?php else: ?>
                                                  <div class="input-group col-sm-6 working_1 " style="padding-top:10px;display:none">
                                                      <input type="text" class="form-control dt_picker_t_1" name="working_start_time" placeholder="HH:MM" style="border-right:none">
                                                      <span class="input-group-addon button" style="background-color:#fff;border-left:none!important;"><img src="<?=base_url('img/proj_new/clock.svg')?>" style="height:16px"></span>
                                                      <input type="text" class="form-control dt_picker_t_1" name="working_end_time" placeholder="HH:MM" style="border-right:none">
                                                      <span class="input-group-addon button" style="background-color:#fff;border-left:none!important;"><img src="<?=base_url('img/proj_new/clock.svg')?>" style="height:16px"></span>
                                                  </div>
                                                  <div class="input-group col-sm-6 working_2" style="padding-top:10px;">
                                                      <input type="text" class="form-control" name="working_hours" placeholder="請輸入時數" style="border-right:none" value="<?=$pd -> working_hours?>">
                                                  </div>
                                              <?php endif; ?>
                                          </div>
                                      </div>
                                      <div class="col-sm-6">
                                          <div class="form-group">
                                              <label for="" class="control-label">休息分類*</label>
                                              <div class="input-group col-sm-6">
                                                  <select class="form-control break_type" name="break_type" onchange="break_type_check()">
                                                      <optgroup label="請選擇">
                                                          <?php foreach ($break_type as $bt): ?>
                                                          <option value="<?=$bt -> id?>" <?= isset($pd) && $pd -> break_type == $bt -> id ? 'selected' : '' ?>>
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
                                          <div class="input-group col-sm-6" style="padding-top:10px">
                                              <input type="text" class="form-control dt_picker_t_1" name="clock_on_time" placeholder="HH:MM" style="border-right:none" value="<?=$pd -> clock_on_time?>">
                                              <span class="input-group-addon button" style="background-color:#fff;border-left:none!important;"><img src="<?=base_url('img/proj_new/clock.svg')?>" style="height:16px"></span>
                                              <input type="text" class="form-control dt_picker_t_1" name="clock_off_time" placeholder="HH:MM" style="border-right:none" value="<?=$pd -> clock_off_time?>">
                                              <span class="input-group-addon button" style="background-color:#fff;border-left:none!important;"><img src="<?=base_url('img/proj_new/clock.svg')?>" style="height:16px"></span>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="" class="control-label">休息時間*</label>
                                        <div class="input-group col-sm-6" style="">
                                          <input class="form-control" name="break_start_time" style="width:100%" value="<?=$pd -> break_start_time?>">
                                        </div>
                                    </div>
                                  </div>

                                  <div class="col-sm-6">
                                      <div class="form-group">
                                          <label for="" class="control-label">上下點工作摘要</label>
                                          <div class="input-group col-sm-6">
                                              <input class="form-control" type="text" value="<?=isset($pd) ? $pd -> work_summary : '' ?>" name="work_summary" />
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
                                                      <option value="<?=$fd -> id?>" <?= isset($pd) && $pd -> feeding == $fd -> id ? 'selected' : '' ?>>
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
                                              <input class="form-control" type="text" name="pay_time" placeholder="輸入時數" value="<?=$pd -> pay_time?>">
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-sm-6">
                                      <div class="form-group">
                                          <label for="" class="control-label">服裝說明</label>
                                          <div class="input-group col-md-6">
                                              <textarea class="form-control" rows="3" name="cloth_note" placeholder="請輸入服裝說明" style="resize:none;width:100%" value="<?=$pd -> cloth_note?>"><?=$pd -> cloth_note?></textarea>
                                          </div>
                                      </div>
                                  </div>
                                  <hr class="clearfix">
                                  <div class="col-sm-6">
                                      <div class="form-group">
                                          <label for="" class="control-label">薪資金額*</label>
                                          <div class="input-group col-md-6">
                                              <input class="form-control pay_input" type="number" name="pay" placeholder="輸入金額" value="<?=$pd -> pay?>">
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
                                              <input class="form-control" type="text" name="pay_note" placeholder="輸入附加說明" value="<?=$pd -> pay_note?>">
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
                                                          <?php foreach ($pd -> pdpl as $each): ?>
                                                          <tr>
                                                              <td style="border-right:none;">
                                                                  <select class="form-control p_1 info_cate" name="info_cate">
                                                                      <?php foreach ($info_cate as $ic): ?>
                                                                      <option value="<?=$ic -> id?>" <?= $each -> duties_info_cate == $ic -> id ? 'selected' : '' ?>>
                                                                          <?=$ic -> info_cate?>
                                                                      </option>
                                                                      <?php endforeach; ?>
                                                                  </select>
                                                              </td>
                                                              <td style="border-right:none;">
                                                                  <select class="form-control p_2 info_list" name="info_list">
                                                                      <?php foreach ($info_list as $il): ?>
                                                                      <option value="<?=$il -> id?>" <?= $each -> duties_info_list == $il -> id ? 'selected' : '' ?>>
                                                                          <?=$il -> info_list?>
                                                                      </option>
                                                                      <?php endforeach; ?>
                                                                  </select>
                                                              </td>
                                                              <td style="border-right:none;">
                                                                  <div class="input-group col-md-12">
                                                                      <input type="text" name="info_pay" class="form-control info_pay" placeholder="請輸入金額" value="<?=$each -> duties_pay?>">
                                                                  </div>
                                                              </td>
                                                              <td class="p_3">
                                                                      本人現場參與集體培訓</td>
                                                              <td style="border-right:none;">
                                                                  <div class="input-group col-md-12">
                                                                      <input type="text" class="form-control info_pay_note" name="info_pay_note" placeholder="請輸入附加說明" value="<?=$each -> duties_pay_note?>">
                                                                  </div>
                                                              </td>
                                                              <td>
                                                                  <button type="button" class="btn btn-danger del_p" style="background-color:#F95E53">移除</button>
                                                              </td>
                                                          </tr>
                                                          <?php endforeach; ?>
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
                                          <hr>
                                      </div>
                                      <div class="col-sm-12 no-padding">
                                          <!-- <button type="button" class="c_btn btn btn-default">取消</button> -->
                                          <button type="button" class="c_btn btn btn-default save_temp_Btn"  style="background-color:#45BA71;border-color:#308F57;color:white">儲存</button>
                                      </div>
                                  </div>
                              </section>
                          </div>
                      </div>
                  <?php endif; ?>
                  <?php $k++?>
                  <?php endforeach; ?>
                  <div class="col-sm-12 no-padding" style="margin-top:10px">
                    <button type="button" class="btn btn-outline-warning add_person" name="button">增加人員資訊</button>
                  </div>
              </div>
          </section>
          <?php $j++;?>
          <?php endforeach; ?>
        <?php endif; ?>
        <div class="col-md-12 col-xs-12 col-sm-12 no-padding" style="margin-top:10px">
            <button onclick="currentApp.doSubmit()"  style="float:right;border-radius:5px;background-color:#45BA71;border-color:#308F57;font-size:14px;padding:10px" class="btn btn-success">
                <?= isset($item) ? '確定修改' : '確定新增'  ?>
            </button>
        </div>
    </div>


<?php $this -> load -> view('general/delete_modal'); ?>
<script type="text/javascript">
	

	loadScript(baseUrl + "js/class/BaseAppClass.js", function(){
		loadScript(baseUrl + "js/app/menu_order/list.js", function(){
			currentApp = new menuorderAppClass(new BaseAppClass({}));
			
		});
	});

	
</script>
