<?php $this->load->view('layout/head'); ?>
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
</style>
<div class="col-xs-12" style="padding:20px">
    <div class="col-xs-12">
        <span style="font-size:12pt">個人及工作疲勞量表</span>
    </div>
    <hr/>
    個人疲勞評估<br>
    <input type="hidden" id="qid" value="<?= isset($qid) ? $qid : '' ?>" />
    1.	你常覺得疲勞嗎？ <br>
    <input type="radio" name="q3_1" value="100" id="q1_100"><label for="q1_100">總是(100)</label><br>
    <input type="radio" name="q3_1" value="75" id="q1_75"><label for="q1_75">常常(75)</label><br>
    <input type="radio" name="q3_1" value="50" id="q1_50"><label for="q1_50">有時候(50)</label><br>
    <input type="radio" name="q3_1" value="25" id="q1_25"><label for="q1_25">不常(25)</label><br>
    <input type="radio" name="q3_1" value="0" id="q1_0"><label for="q1_0">從未或幾乎從未(0)</label><br>
    2.	你常覺得身體上體力透支嗎？ <br>
    <input type="radio" name="q3_2" value="100" id="q2_100"><label for="q2_100">總是(100)</label><br>
    <input type="radio" name="q3_2" value="75" id="q2_75"><label for="q2_75">常常(75)</label><br>
    <input type="radio" name="q3_2" value="50" id="q2_50"><label for="q2_50">有時候(50)</label><br>
    <input type="radio" name="q3_2" value="25" id="q2_25"><label for="q2_25">不常(25)</label><br>
    <input type="radio" name="q3_2" value="0" id="q2_0"><label for="q2_0">從未或幾乎從未(0)</label><br>
    3.	你常覺得情緒上心力交瘁嗎？ <br>
    <input type="radio" name="q3_3" value="100" id="q3_100"><label for="q3_100">總是(100)</label><br>
    <input type="radio" name="q3_3" value="75" id="q3_75"><label for="q3_75">常常(75)</label><br>
    <input type="radio" name="q3_3" value="50" id="q3_50"><label for="q3_50">有時候(50)</label><br>
    <input type="radio" name="q3_3" value="25" id="q3_25"><label for="q3_25">不常(25)</label><br>
    <input type="radio" name="q3_3" value="0" id="q3_0"><label for="q3_0">從未或幾乎從未(0)</label><br>
    4.	你常會覺得，「我快要撐不下去了」嗎？ <br>
    <input type="radio" name="q3_4" value="100" id="q4_100"><label for="q4_100">總是(100)</label><br>
    <input type="radio" name="q3_4" value="75" id="q4_75"><label for="q4_75">常常(75)</label><br>
    <input type="radio" name="q3_4" value="50" id="q4_50"><label for="q4_50">有時候(50)</label><br>
    <input type="radio" name="q3_4" value="25" id="q4_25"><label for="q4_25">不常(25)</label><br>
    <input type="radio" name="q3_4" value="0" id="q4_0"><label for="q4_0">從未或幾乎從未(0)</label><br>
    5.	你常覺得精疲力竭嗎？ <br>
    <input type="radio" name="q3_5" value="100" id="q5_100"><label for="q5_100">總是(100)</label><br>
    <input type="radio" name="q3_5" value="75" id="q5_75"><label for="q5_75">常常(75)</label><br>
    <input type="radio" name="q3_5" value="50" id="q5_50"><label for="q5_50">有時候(50)</label><br>
    <input type="radio" name="q3_5" value="25" id="q5_25"><label for="q5_25">不常(25)</label><br>
    <input type="radio" name="q3_5" value="0" id="q5_0"><label for="q5_0">從未或幾乎從未(0)</label><br>
    6.	你常常覺得虛弱，好像快要生病了嗎？ <br>
    <input type="radio" name="q3_6" value="100" id="q6_100"><label for="q6_100">總是(100)</label><br>
    <input type="radio" name="q3_6" value="75" id="q6_75"><label for="q6_75">常常(75)</label><br>
    <input type="radio" name="q3_6" value="50" id="q6_50"><label for="q6_50">有時候(50)</label><br>
    <input type="radio" name="q3_6" value="25" id="q6_25"><label for="q6_25">不常(25)</label><br>
    <input type="radio" name="q3_6" value="0" id="q6_0"><label for="q6_0">從未或幾乎從未(0)</label><br>
    個人相關疲勞分數(各題加總後除以6):<div id="t1"></div>
    個人相關過勞分級(【輕微】50分以下/【中度】50-70分/【嚴重】70分以上):<div id="t1_s"></div>
    工作疲勞評估<br>
    1.	你的工作會令人情緒上心力交瘁嗎？<br>
    <input type="radio" name="q3_7" value="100" id="q7_100"><label for="q7_100">總是(100)</label><br>
    <input type="radio" name="q3_7" value="75" id="q7_75"><label for="q7_75">常常(75)</label><br>
    <input type="radio" name="q3_7" value="50" id="q7_50"><label for="q7_50">有時候(50)</label><br>
    <input type="radio" name="q3_7" value="25" id="q7_25"><label for="q7_25">不常(25)</label><br>
    <input type="radio" name="q3_7" value="0" id="q7_0"><label for="q7_0">從未或幾乎從未(0)</label><br>
    2.	你的工作會讓你覺得快要累垮了嗎？ <br>
    <input type="radio" name="q3_8" value="100" id="q8_100"><label for="q8_100">總是(100)</label><br>
    <input type="radio" name="q3_8" value="75" id="q8_100"><label for="q8_100">常常(75)</label><br>
    <input type="radio" name="q3_8" value="50" id="q8_50"><label for="q8_50">有時候(50)</label><br>
    <input type="radio" name="q3_8" value="25" id="q8_25"><label for="q8_25">不常(25)</label><br>
    <input type="radio" name="q3_8" value="0" id="q8_0"><label for="q8_0">從未或幾乎從未(0)</label><br>
    3.	你的工作會讓你覺得挫折嗎？ <br>
    <input type="radio" name="q3_9" value="100" id="q9_100"><label for="q9_100">總是(100)</label><br>
    <input type="radio" name="q3_9" value="75" id="q9_75"><label for="q9_75">常常(75)</label><br>
    <input type="radio" name="q3_9" value="50" id="q9_50"><label for="q9_50">有時候(50)</label><br>
    <input type="radio" name="q3_9" value="25" id="q9_25"><label for="q9_25">不常(25)</label><br>
    <input type="radio" name="q3_9" value="0" id="q9_0"><label for="q9_0">從未或幾乎從未(0)</label><br>
    4.	工作一整天之後，你覺得精疲力竭嗎？ <br>
    <input type="radio" name="q3_10" value="100" id="q10_100"><label for="q10_100">總是(100)</label><br>
    <input type="radio" name="q3_10" value="75" id="q10_75"><label for="q10_75">常常(75)</label><br>
    <input type="radio" name="q3_10" value="50" id="q10_50"><label for="q10_50">有時候(50)</label><br>
    <input type="radio" name="q3_10" value="25" id="q10_25"><label for="q10_25">不常(25)</label><br>
    <input type="radio" name="q3_10" value="0" id="q10_0"><label for="q10_0">從未或幾乎從未(0)</label><br>
    5.	上班之前只要想到又要工作一整天，你就覺得沒力嗎？ <br>
    <input type="radio" name="q3_11" value="100" id="q11_100"><label for="q11_100">總是(100)</label><br>
    <input type="radio" name="q3_11" value="75" id="q11_75"><label for="q11_75">常常(75)</label><br>
    <input type="radio" name="q3_11" value="50" id="q11_50"><label for="q11_50">有時候(50)</label><br>
    <input type="radio" name="q3_11" value="25" id="q11_25"><label for="q11_25">不常(25)</label><br>
    <input type="radio" name="q3_11" value="0" id="q11_0"><label for="q11_0">從未或幾乎從未(0)</label><br>
    6.	上班時你會覺得每一刻都很難熬嗎？ <br>
    <input type="radio" name="q3_12" value="100" id="q12_100"><label for="q12_100">總是(100)</label><br>
    <input type="radio" name="q3_12" value="75" id="q12_75"><label for="q12_75">常常(75)</label><br>
    <input type="radio" name="q3_12" value="50" id="q12_50"><label for="q12_50">有時候(50)</label><br>
    <input type="radio" name="q3_12" value="25" id="q12_25"><label for="q12_25">不常(25)</label><br>
    <input type="radio" name="q3_12" value="0" id="q12_0"><label for="q12_0">從未或幾乎從未(0)</label><br>
    7.	不工作的時候，你有足夠的精力陪朋友或家人嗎？ <br>
    <input type="radio" name="q3_13" value="100" id="q13_100"><label for="q13_100">總是(100)</label><br>
    <input type="radio" name="q3_13" value="75" id="q13_75"><label for="q13_75">常常(75)</label><br>
    <input type="radio" name="q3_13" value="50" id="q13_50"><label for="q13_50">有時候(50)</label><br>
    <input type="radio" name="q3_13" value="25" id="q13_25"><label for="q13_25">不常(25)</label><br>
    <input type="radio" name="q3_13" value="0" id="q13_0"><label for="q13_0">從未或幾乎從未(0)</label><br>
    工作相關疲勞分數(各題加總後除以7):<div id="t2"></div>
    工作相關過勞分級(【輕微】45分以下/【中度】45-60分/【嚴重】60分以上):<div id="t2_s"></div>
    <div class="col-xs-12 no-padding" style="margin-top:20px">
        <div class="col-xs-6 no-padding">
            <button type="button" class="btn btn-secondary cancel" style="width:120px;height:40px;float:left">取消</button>
        </div>
        <div class="col-xs-6 no-padding">
            <button type="button" class="btn btn-success dosubmit" style="width:120px;height:40px;float:right">送出</button>
        </div>
    </div>
    <?php $this->load->view('layout/plugins'); ?>
<script type="text/javascript">
 
  
  $( document ).ready(function() {
    $('#name').focus();
  })

  $('.cancel').click(function() {
    var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
    parent.layer.close(index);
  })

  var  q1 = '';
  var  q2 = '';
  var  q3 = '';
  var  q4 = '';
  var  q5 = '';
  var  q6 = '';
  var  q7 = '';
  var  q8 = '';
  var  q9 = '';
  var  q10 = '';
  var  q11 = '';
  var  q12 = '';
  var  q13 = '';
  var  total1 = 0;
  var  total2 = 0;
  $('input:radio[name="q3_1"]').on('change', function(){
    q1 = $('input:radio[name="q3_1"]:checked').val();
    total1 =(parseInt(q1)+parseInt(q2)+parseInt(q3)+parseInt(q4)+parseInt(q5)+parseInt(q6))/6;
    // console.log(total1);
    t1();
  });
  $('input:radio[name="q3_2"]').on('change', function(){
    q2 = $('input:radio[name="q3_2"]:checked').val();
    total1 =(parseInt(q1)+parseInt(q2)+parseInt(q3)+parseInt(q4)+parseInt(q5)+parseInt(q6))/6;
    // console.log(total1);
    t1();
  });
  $('input:radio[name="q3_3"]').on('change', function(){
    q3 = $('input:radio[name="q3_3"]:checked').val();
    total1 =(parseInt(q1)+parseInt(q2)+parseInt(q3)+parseInt(q4)+parseInt(q5)+parseInt(q6))/6;
    // console.log(total1);
    t1();
  });
  $('input:radio[name="q3_4"]').on('change', function(){
    q4 = $('input:radio[name="q3_4"]:checked').val();
    total1 =(parseInt(q1)+parseInt(q2)+parseInt(q3)+parseInt(q4)+parseInt(q5)+parseInt(q6))/6;
    // console.log(total1);
    t1();
  });
  $('input:radio[name="q3_5"]').on('change', function(){
    q5 = $('input:radio[name="q3_5"]:checked').val();
    total1 =(parseInt(q1)+parseInt(q2)+parseInt(q3)+parseInt(q4)+parseInt(q5)+parseInt(q6))/6;
    // console.log(total1);
    t1();
  });
  $('input:radio[name="q3_6"]').on('change', function(){
    q6 = $('input:radio[name="q3_6"]:checked').val();
    total1 =(parseInt(q1)+parseInt(q2)+parseInt(q3)+parseInt(q4)+parseInt(q5)+parseInt(q6))/6;
    // console.log(total1);
    t1();
  });

  $('input:radio[name="q3_7"]').on('change', function(){
    q7 = $('input:radio[name="q3_7"]:checked').val();
    total2 =(parseInt(q7)+parseInt(q8)+parseInt(q9)+parseInt(q10)+parseInt(q11)+parseInt(q12)+parseInt(q13))/7;
    // console.log(total1);
    t2();
  });
  $('input:radio[name="q3_8"]').on('change', function(){
    q8 = $('input:radio[name="q3_8"]:checked').val();
    total2 =(parseInt(q7)+parseInt(q8)+parseInt(q9)+parseInt(q10)+parseInt(q11)+parseInt(q12)+parseInt(q13))/7;
    // console.log(total1);
    t2();
  });
  $('input:radio[name="q3_9"]').on('change', function(){
    q9 = $('input:radio[name="q3_9"]:checked').val();
    total2 =(parseInt(q7)+parseInt(q8)+parseInt(q9)+parseInt(q10)+parseInt(q11)+parseInt(q12)+parseInt(q13))/7;
    // console.log(total1);
    t2();
  });
  $('input:radio[name="q3_10"]').on('change', function(){
    q10 = $('input:radio[name="q3_10"]:checked').val();
    total2 =(parseInt(q7)+parseInt(q8)+parseInt(q9)+parseInt(q10)+parseInt(q11)+parseInt(q12)+parseInt(q13))/7;
    // console.log(total1);
    t2();
  });
  $('input:radio[name="q3_11"]').on('change', function(){
    q11 = $('input:radio[name="q3_11"]:checked').val();
    total2 =(parseInt(q7)+parseInt(q8)+parseInt(q9)+parseInt(q10)+parseInt(q11)+parseInt(q12)+parseInt(q13))/7;
    // console.log(total1);
    t2();
  });
  $('input:radio[name="q3_12"]').on('change', function(){
    q12 = $('input:radio[name="q3_12"]:checked').val();
    total2 =(parseInt(q7)+parseInt(q8)+parseInt(q9)+parseInt(q10)+parseInt(q11)+parseInt(q12)+parseInt(q13))/7;
    // console.log(total1);
    t2();
  });
  $('input:radio[name="q3_13"]').on('change', function(){
    q13 = $('input:radio[name="q3_13"]:checked').val();
    total2 =(parseInt(q7)+parseInt(q8)+parseInt(q9)+parseInt(q10)+parseInt(q11)+parseInt(q12)+parseInt(q13))/7;
    // console.log(total1);
    t2();
  });


  $('.dosubmit').click(function() {
    if (q1==null||q2==null||q3==null||q4==null||q5==null||q6==null||
         q7==null||q8==null||q9==null||q10==null||q11==null||q12==null||q13==null){
          alert("請填寫完全部題目！");   
    } else{
      
        $.ajax({
          url: '<?= base_url() ?>' + 'mgmt/question_for_user/save_q3',
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
      text = '輕微';
    }
    if(parseInt(total1)<69 && parseInt(total1)>50){
      text = '中度';
    }
    if(parseInt(total1)>=70){
      text = '嚴重';
    }
    if (q1==null||q2==null||q3==null||q4==null||q5==null||q6==null){
      $('#t1').text(total1);
      $('#t1_s').text(text);
    }
  }
  function t2(){
    var text1 = '';
    
    if(parseInt(total2)<=45){
      text1 = '輕微';
    }
    if(45<parseInt(total2) && parseInt(total2)<60){
      text1 = '中度';
    }
    if(parseInt(total2)>=60){
      text1 = '嚴重';
    }
    if (q7==null||q8==null||q9==null||q10==null||q11==null||q12==null||q13==null){
      $('#t2').text(total2);
      $('#t2_s').text(text1);
    }
  }
</script>
