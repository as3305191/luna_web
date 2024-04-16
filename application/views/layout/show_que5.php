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
  tbody tr td {
    top:0;
    padding:0px 0px 15px 5px;

  }
  thead tr th {
    padding:0px 0px 15px 5px;
    position:sticky;
    background-color:#f3f3f3 !important;
    top:0;
  }
  .disabledinput {
    opacity: 0.4;
    filter: alpha(opacity=40);
    /* display: block; */
  }

</style>
<div class="col-xs-12" style="padding:20px">

    <hr/>
    <input type="hidden" id="qid" value="<?= isset($qid) ? $qid : '' ?>" />
    <input type="hidden" id="role_id" value="<?= isset($role_id) ? $role_id : '' ?>" />

    <table class="col-xs-12">
							<thead>
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
							</thead>
              <tbody>
                <?php for ($i=0;$i<count($question_list);$i++) : ?>
                <tr>
                  <td class="min300"><?= $question_list[$i] ?></td>
                  <td class="min80">
                    <input type="radio" id="q<?= $i+1 ?>_o1_1" name="q<?= $i+1 ?>_o1" value="是" class="btnY1" onclick="change_yn(<?= $i+1 ?>)"/>
                  </td>
                  <td class="min80">
                    <input type="radio" id="q<?= $i+1 ?>_o1_2" name="q<?= $i+1 ?>_o1" value="否" class="btnN1" onclick="change_yn(<?= $i+1 ?>)"/>
                  </td>
                    <td class="R1 min150">
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
                      <label for="q<?= $i+1 ?>_o1_20">有：</label><input id="q<?= $i+1 ?>_o1_21" name="q<?= $i+1 ?>_o8">
                    </td>
                </tr>

               <?php endfor ?>
              </tbody>

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

  function change_yn(q_num){
    if($('input:radio[name="q'+q_num+'_o1"]:checked').val()=='否'){
      for(var $j=3;$j<=21;$j++){
          $('#q'+q_num+'_o1_'+$j).addClass("disabledinput").attr('disabled',true).attr('checked',false);
          $('#q'+q_num+'_o1_21').val('');
      }
    }else{
      for(var $j=3;$j<=21;$j++){
          $('#q'+q_num+'_o1_'+$j).attr('disabled',false).removeClass("disabledinput");
      }
    }
  }
  var $num='';
  var question_list_count= <?= $question_list_count?>;
  var now_script = '';
  var each_dom_script='';
  var ajax_dom='';
  var ajax_script='';
  for(var i=0;i<question_list_count;i++){
    for(var j=0;j<7;j++){
      $num=''
      now_script = '';
      each_dom_script='';

      $i_1 = i+1;
      $j_1 = j+1;
      $num=i*7+j+1;
      each_dom_script='$(\'input:radio[name="q'+$i_1+'_o'+$j_1+'"]\').on(\'change\', function(){'+
         'q'+$num+ '= $(\'input:radio[name="q'+$i_1+'_o'+$j_1+'"]:checked\').val();'+
      '});';
      ajax_dom+= 'q'+$num+':q'+$num+','
      if(j==6){
        $j_2 = j+2;
        each_dom_script+='var q'+$i_1+'o=\'無\';'+'$(\'input[name="q'+$i_1+'_o'+$j_2+'"]\').on(\'change\', function(){'+
          'q'+$i_1+'o= $(\'input[name="q'+$i_1+'_o'+$j_2+'"]\').val();'+
        '});';
        ajax_dom+= 'q'+$i_1+'o:q'+$i_1+'o,'
      }
      
      now_script='<script type="text/javascript"> var q'+$num+'=null;'+each_dom_script+' <\/script>';
     
      document.write(now_script);
      if(j==6&&i==question_list_count-1){
        // console.log(ajax_dom);
        ajax_script='<script type="text/javascript">$(\'.dosubmit\').click(function() {'+
            'if (q1==null||){'+
                 ' alert("請填寫完全部題目！");'+ 
            ' } else{'+
                  ' $.ajax({'+ 
                    ' url: \'<?= base_url('mgmt/question_for_user/save_q5') ?>\','+ 
                    ' type: \'POST\','+ 
                    ' data: {'+ 
                      ' qid:$(\'#qid\').val(),'+ 
                      ajax_dom+
                    '},'+ 
                  ' dataType: \'json\','+ 
                  ' success: function(d) {'+ 
                    'if(d) {'+ 
                      '  console.log(d);'+ 
                      '}'+ 
                      'if(d.success){'+ 
                        '  var index = parent.layer.getFrameIndex(window.name);'+ 
                        ' parent.layer.close(index);'+ 
                        ' parent.location.reload();'+ 
                        ' }'+ 
                        'if(d.error){'+ 
                          ' layer.msg(d.error);'+ 
                          '}'+ 
                          ' },'+ 
                          ' failure:function(){'+ 
                            '  layer.msg(\'faialure\');'+ 
                            '}'+ 
                            ' });  '+ 
                            '}'+ 
                            '})<\/script>';
        document.write(ajax_script);
      }
    }
  }


 
  $('.trash_btn').click(function() {
    $(this).closest('.itemp').remove();
  })

  function t1(){
    var text = '';
    
    if(parseInt(total1)<=50){
      text = '<?= $this->_lang['q2_ss'] ?>';
    }
    if(parseInt(total1)<69 && parseInt(total1)>50){
      text = '<?= $this->_lang['q2_mm'] ?>';
    }
    if(parseInt(total1)>=70){
      text = '<?= $this->_lang['q2_sbs'] ?>';
    }
    if (q1!==null&&q2!==null&&q3!==null&&q4!==null&&q5!==null&&q6!==null){
      $('#t1').text(total1);
      $('#t1_s').text(text);
      q1o = total1;
      q2o = text;
    }
  }
  function t2(){
    var text1 = '';
    
    if(parseInt(total2)<=45){
      text = '<?= $this->_lang['q2_ss'] ?>';
    }
    if(45<parseInt(total2) && parseInt(total2)<60){
      text = '<?= $this->_lang['q2_mm'] ?>';
    }
    if(parseInt(total2)>=60){
      text = '<?= $this->_lang['q2_sbs'] ?>';
    }
    if (q7!==null&&q8!==null&&q9!==null&&q10!==null&&q11!==null&&q12!==null&&q13!==null){
      $('#t2').text(total2);
      $('#t2_s').text(text1);
      q3o = total2;
      q4o = text1;
    }
  }
</script>
