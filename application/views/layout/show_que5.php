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
    display: none;
  }

</style>
<div class="col-xs-12" style="padding:20px">

    <hr/>
    <input type="hidden" id="qid" value="<?= isset($qid) ? $qid : '' ?>" />
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
                  <td class="min30">
                    <input type="radio" id="q<?= $i+1 ?>_o1_1" name="q<?= $i+1 ?>_o1" value="是" class="btnY1" onclick="change_yn(<?= $i+1 ?>)"/>
                  </td>
                  <td class="min100">
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
          $('#q'+q_num+'_o1_'+$j).addClass("disabledinput");
      }
    }else{
      for(var $j=3;$j<=21;$j++){
          $('#q'+q_num+'_o1_'+$j).removeClass("disabledinput");
      }
    }
  }

  var  q1 = null;
  var  q2 = null;
  var  q3 = null;
  var  q4 = null;
  var  q5 = null;
  var  q6 = null;
  var  q7 = null;
  var  q8 = null;
  var  q9 = null;
  var  q10 = null;
  var  q11 = null;
  var  q12 = null;
  var  q13 = null;
  var  total1 = 0;
  var  total2 = 0;
  var  q1o = '無';
  var  q2o = '無';
  var  q3o = '無';
  var  q4o = '無';
  $('').on('change', function(){
    q1 = $('input:radio[name="q3_1"]:checked').val();
    sum_p1 = parseInt(q1)+parseInt(q2)+parseInt(q3)+parseInt(q4)+parseInt(q5)+parseInt(q6);
    var rem = sum_p1 % 6;
    total1 = (sum_p1 - rem) / 6;

    // console.log(total1);
    t1();
  });
  $('input:radio[name="q3_2"]').on('change', function(){
    q2 = $('input:radio[name="q3_2"]:checked').val();
    sum_p1 = parseInt(q1)+parseInt(q2)+parseInt(q3)+parseInt(q4)+parseInt(q5)+parseInt(q6);
    var rem = sum_p1 % 6;
    total1 = (sum_p1 - rem) / 6;    // console.log(total1);
    t1();
  });
  $('input:radio[name="q3_3"]').on('change', function(){
    q3 = $('input:radio[name="q3_3"]:checked').val();
    sum_p1 = parseInt(q1)+parseInt(q2)+parseInt(q3)+parseInt(q4)+parseInt(q5)+parseInt(q6);
    var rem = sum_p1 % 6;
    total1 = (sum_p1 - rem) / 6;    // console.log(total1);
    t1();
  });
  $('input:radio[name="q3_4"]').on('change', function(){
    q4 = $('input:radio[name="q3_4"]:checked').val();
    sum_p1 = parseInt(q1)+parseInt(q2)+parseInt(q3)+parseInt(q4)+parseInt(q5)+parseInt(q6);
    var rem = sum_p1 % 6;
    total1 = (sum_p1 - rem) / 6;    // console.log(total1);
    t1();
  });
  $('input:radio[name="q3_5"]').on('change', function(){
    q5 = $('input:radio[name="q3_5"]:checked').val();
    sum_p1 = parseInt(q1)+parseInt(q2)+parseInt(q3)+parseInt(q4)+parseInt(q5)+parseInt(q6);
    var rem = sum_p1 % 6;
    total1 = (sum_p1 - rem) / 6;    // console.log(total1);
    t1();
  });
  $('input:radio[name="q3_6"]').on('change', function(){
    q6 = $('input:radio[name="q3_6"]:checked').val();
    sum_p1 = parseInt(q1)+parseInt(q2)+parseInt(q3)+parseInt(q4)+parseInt(q5)+parseInt(q6);
    var rem = sum_p1 % 6;
    total1 = (sum_p1 - rem) / 6;    // console.log(total1);
    t1();
  });

  $('input:radio[name="q3_7"]').on('change', function(){
    q7 = $('input:radio[name="q3_7"]:checked').val();
    sum_p2 = parseInt(q7)+parseInt(q8)+parseInt(q9)+parseInt(q10)+parseInt(q11)+parseInt(q12)+parseInt(q13);
    var rem2 = sum_p2 % 6;
    total2 = (sum_p2 - rem2) / 6;
    // console.log(total1);
    t2();
  });
  $('input:radio[name="q3_8"]').on('change', function(){
    q8 = $('input:radio[name="q3_8"]:checked').val();
    sum_p2 = parseInt(q7)+parseInt(q8)+parseInt(q9)+parseInt(q10)+parseInt(q11)+parseInt(q12)+parseInt(q13);
    var rem2 = sum_p2 % 6;
    total2 = (sum_p2 - rem2) / 6;    // console.log(total1);
    t2();
  });
  $('input:radio[name="q3_9"]').on('change', function(){
    q9 = $('input:radio[name="q3_9"]:checked').val();
    sum_p2 = parseInt(q7)+parseInt(q8)+parseInt(q9)+parseInt(q10)+parseInt(q11)+parseInt(q12)+parseInt(q13);
    var rem2 = sum_p2 % 6;
    total2 = (sum_p2 - rem2) / 6;    // console.log(total1);
    t2();
  });
  $('input:radio[name="q3_10"]').on('change', function(){
    q10 = $('input:radio[name="q3_10"]:checked').val();
    sum_p2 = parseInt(q7)+parseInt(q8)+parseInt(q9)+parseInt(q10)+parseInt(q11)+parseInt(q12)+parseInt(q13);
    var rem2 = sum_p2 % 6;
    total2 = (sum_p2 - rem2) / 6;    // console.log(total1);
    t2();
  });
  $('input:radio[name="q3_11"]').on('change', function(){
    q11 = $('input:radio[name="q3_11"]:checked').val();
    sum_p2 = parseInt(q7)+parseInt(q8)+parseInt(q9)+parseInt(q10)+parseInt(q11)+parseInt(q12)+parseInt(q13);
    var rem2 = sum_p2 % 6;
    total2 = (sum_p2 - rem2) / 6;    // console.log(total1);
    t2();
  });
  $('input:radio[name="q3_12"]').on('change', function(){
    q12 = $('input:radio[name="q3_12"]:checked').val();
    sum_p2 = parseInt(q7)+parseInt(q8)+parseInt(q9)+parseInt(q10)+parseInt(q11)+parseInt(q12)+parseInt(q13);
    var rem2 = sum_p2 % 6;
    total2 = (sum_p2 - rem2) / 6;    // console.log(total1);
    t2();
  });
  $('input:radio[name="q3_13"]').on('change', function(){
    q13 = $('input:radio[name="q3_13"]:checked').val();
    sum_p2 = parseInt(q7)+parseInt(q8)+parseInt(q9)+parseInt(q10)+parseInt(q11)+parseInt(q12)+parseInt(q13);
    var rem2 = sum_p2 % 6;
    total2 = (sum_p2 - rem2) / 6;    // console.log(total1);
    t2();
  });


  $('.dosubmit').click(function() {
    if (q1==null||q2==null||q3==null||q4==null||q5==null||q6==null||
         q7==null||q8==null||q9==null||q10==null||q11==null||q12==null||q13==null){
          alert("請填寫完全部題目！");   
    } else{
      
        $.ajax({
          url: '<?= base_url() ?>' + 'mgmt/question_for_user/save_q5',
          type: 'POST',
          data: {
            qid:$('#qid').val(),
            q1 : q1,
            q2 : q2,
            q3 : q3,
            q4 : q4,
            q5 : q5,
            q6 : q6,
            q7 : q7,
            q8 : q8,
            q9 : q9,
            q10 : q10,
            q11 : q11,
            q12 : q12,
            q13 : q13,
            q1o : q1o,
            q2o : q2o,
            q3o : q3o,
            q4o : q4o,
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
  }
  		
  })
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
