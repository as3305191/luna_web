<?php $this->load->view('layout/head'); ?>
<?php require_once(APPPATH."views/lang/$lang.php"); ?>
<style>
  span{
    color:#003355;
  }
  label{
    color:#003355;
  }
  th span{
    color:white;
  }
  table tr td {
    /* border:3px #cccccc solid; */
    padding:0px 0px 15px 5px;
  }
  table tr th {
    /* border:3px #cccccc solid; */
    padding:0px 0px 15px 5px;

    text-align:center;
  }
</style>
<div class="col-xs-12" style="padding:20px">
    <div class="col-xs-12">
        <span style="font-size:12pt">不法侵害問卷</span>
    </div>
    <hr/>
    <input type="hidden" id="qid" value="<?= isset($qid) ? $qid : '' ?>" />
    <table>
							<tr>
                <th>潛在風險(外部/內部)</th>
                <th>是</th>
                <th>否</th>
                <th>風險類型</th>
                <th>可能性(發生機率)</th>
                <th>嚴重性(傷害程度)</th>
                <th>風險等級(可能性×嚴重性)</th>
                <th>現有控制措施</th>
                <th>降低風險措施</th>
							</tr>
							<!-- <tr>
								<td>外部不法侵害(註：勾否者該項無需評估)</td>
							</tr> -->

              <?php for ($i=0;$i<count($question_list);$i++) : ?>
              <tr>
								<td class="min300"><?= $question_list[$i] ?></td>
                <td class="min30">
									<input type="radio" id="q<?= $i+1 ?>_o1_1" name="q<?= $i+1 ?>_o1" value="是" class="btnY1"/>
								</td>
								<td class="min30">
									<input type="radio" id="q<?= $i+1 ?>_o1_2" name="q<?= $i+1 ?>_o1" value="否" class="btnN1"/>
								</td>
									<td  class="R1 min150">
										<input type="radio" id="q<?= $i+1 ?>_o1_3" name="q<?= $i+1 ?>_o2" value="肢體"/>
										<label for="q<?= $i+1 ?>_o1_3">肢體</label>
										<input type="radio" id="q<?= $i+1 ?>_o1_4" name="q<?= $i+1 ?>_o2" value="語言"/>
										<label for="q<?= $i+1 ?>_o1_4">語言</label><br>
										<input type="radio" id="q<?= $i+1 ?>_o1_5" name="q<?= $i+1 ?>_o2" value="心理"/>
										<label for="q<?= $i+1 ?>_o1_5">心理</label>
										<input type="radio" id="q<?= $i+1 ?>_o1_6" name="q<?= $i+1 ?>_o2" value="性騷擾"/>
										<label for="q<?= $i+1 ?>_o1_6">性騷擾</label>
									</td>
									<td  class="R1 min150">
										<input type="radio" id="q<?= $i+1 ?>_o1_7" name="q<?= $i+1 ?>_o3" value="可能3分"/>
										<label for="q<?= $i+1 ?>_o1_7">可能3分</label><br>
										<input type="radio" id="q<?= $i+1 ?>_o1_8" name="q<?= $i+1 ?>_o3" value="不太可能2分"/>
										<label for="q<?= $i+1 ?>_o1_8">不太可能2分</label><br>
										<input type="radio" id="q<?= $i+1 ?>_o1_9" name="q<?= $i+1 ?>_o3" value="極不可能1分"/>
										<label for="q<?= $i+1 ?>_o1_9">極不可能1分</label>
									</td>
									<td  class="R1 min130">
										<input type="radio" id="q<?= $i+1 ?>_o1_10" name="q<?= $i+1 ?>_o4" value="嚴重3分"/>
										<label for="q<?= $i+1 ?>_o1_10">嚴重3分</label><br>
										<input type="radio" id="q<?= $i+1 ?>_o1_11" name="q<?= $i+1 ?>_o4" value="中度2分"/>
										<label for="q<?= $i+1 ?>_o1_11">中度2分</label><br>
										<input type="radio" id="q<?= $i+1 ?>_o1_12" name="q<?= $i+1 ?>_o4" value="輕度1分"/>
										<label for="q<?= $i+1 ?>_o1_12">輕度1分</label>
									</td>
									<td  class="R1 min130">
										<input type="radio" id="q<?= $i+1 ?>_o1_13" name="q<?= $i+1 ?>_o5" value="高度6-9分"/>
										<label for="q<?= $i+1 ?>_o1_13">高度6-9分</label><br>
										<input type="radio" id="q<?= $i+1 ?>_o1_14" name="q<?= $i+1 ?>_o5" value="中度3-4分"/>
										<label for="q<?= $i+1 ?>_o1_14">中度3-4分</label><br>
										<input type="radio" id="q<?= $i+1 ?>_o1_15" name="q<?= $i+1 ?>_o5" value="輕度1-2分"/>
										<label for="q<?= $i+1 ?>_o1_15">輕度1-2分</label>
									</td>
									<td  class="R1 min130">
										<input type="radio" id="q<?= $i+1 ?>_o1_16" name="q<?= $i+1 ?>_o6" value="工程控制"/>
										<label for="q<?= $i+1 ?>_o1_16">工程控制</label><br>
										<input type="radio" id="q<?= $i+1 ?>_o1_17" name="q<?= $i+1 ?>_o6" value="個人防護"/>
										<label for="q<?= $i+1 ?>_o1_17">個人防護</label><br>
										<input type="radio" id="q<?= $i+1 ?>_o1_18" name="q<?= $i+1 ?>_o6" value="管理控制"/>
										<label for="q<?= $i+1 ?>_o1_18">管理控制</label>
									</td>
									<td class="R1 min300">
										<input type="radio" id="q<?= $i+1 ?>_o1_19" name="q<?= $i+1 ?>_o7" value="無"/>
										<label for="q<?= $i+1 ?>_o1_19">無</label><br>
										<input type="radio" id="q<?= $i+1 ?>_o1_20" name="q<?= $i+1 ?>_o7" value="有：敘述"/>
										<label for="q<?= $i+1 ?>_o1_20">有：</label><input name="q<?= $i+1 ?>_o8">
									</td>
							</tr>

			    	<?php endfor ?>

						</table>

           
            

            


    <div class="col-xs-12 no-padding" style="margin-top:20px">
        <div class="col-xs-6 no-padding">
            <button type="button" class="btn btn-secondary cancel" style="width:120px;height:40px;float:left">取消</button>
        </div>
        <div class="col-xs-6 no-padding">
            <button type="button" class="btn btn-success dosubmit" style="width:120px;height:40px;float:right">送出</button>
        </div>
    </div>
    </div>
    <?php $this->load->view('layout/plugins'); ?>
    <script type="text/javascript">
	// date-picker

  $( document ).ready(function() {
    $('#name').focus();
  })

  $('.cancel').click(function() {
    var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
    parent.layer.close(index);
  })
  $('.dosubmit').click(function() {
  		$.ajax({
  			url: '<?= base_url() ?>' + 'mgmt/roles/add_under',
  			type: 'POST',
  			data: {
  				qid:$('#qid').val(),
          new_name : $('#name').val()
  			},
  			dataType: 'json',
  			success: function(d) {
  				if(d) {
  					console.log(d);
  				}
          if(d.success){
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            parent.layer.close(index);
            parent.location.reload();
          }
          if(d.error){
            layer.msg(d.error);
          }
  			},
  			failure:function(){
  				layer.msg('faialure');
  			}
  		});
  })
  $('.trash_btn').click(function() {
    $(this).closest('.itemp').remove();
  })
</script>
