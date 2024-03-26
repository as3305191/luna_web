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
  .d_hide{
    display:none;
  }
</style>
<div class="col-xs-12" style="padding:20px">
    <div class="col-xs-12">
        <span style="font-size:12pt">肌肉骨骼症狀問卷調查表</span>
    </div>
    <hr/>
    個人疲勞評估<br>
    <input type="hidden" id="qid" value="<?= isset($qid) ? $qid : '' ?>" />
    一.  您在過去1年內，身體是否有長達2星期以上的痠痛、發麻、刺痛、肌肉疲勞、關節活動限制等不適症狀？ <br>
    (若否，結束此調查表；若是，請繼續填寫) <br>
    <input type="radio" name="q2_1" value="是" id="q1_y"><label for="q1_y">是</label><br>
    <input type="radio" name="q2_1" value="否" id="q1_n"><label for="q1_n">否</label><br>
    <div class="d_hide" id="d_hide">
      二.請於下圖勾選各部位痠痛或不適症狀之嚴重度:嚴重度說明:0無症狀;1輕微可忽略;2顯著但不影響工作;3影響工作但不需休假;
      4影響工作且需休假少於四天;5影響工作且需休假四天以上。<br>
      <div class="form-group">
        <div class="col-xs-6" >
          <img width="300" src="<?= base_url('img/body_fat/logo/body_back_for_que2.png') ?>" >
        </div >
        <div class="col-xs-3" >
          1. <br>
          <input type="radio" name="q2_2" value="0" id="q2_1"><label for="q2_1">0</label>
          <input type="radio" name="q2_2" value="1" id="q2_2"><label for="q2_2">1</label>
          <input type="radio" name="q2_2" value="2" id="q2_3"><label for="q2_3">2</label>
          <input type="radio" name="q2_2" value="3" id="q2_4"><label for="q2_4">3</label>
          <input type="radio" name="q2_2" value="4" id="q2_5"><label for="q2_5">4</label>
          <input type="radio" name="q2_2" value="5" id="q2_6"><label for="q2_6">5</label><br>
          2. <br>
          <input type="radio" name="q2_3" value="0" id="q3_1"><label for="q3_1">0</label>
          <input type="radio" name="q2_3" value="1" id="q3_2"><label for="q3_2">1</label>
          <input type="radio" name="q2_3" value="2" id="q3_3"><label for="q3_3">2</label>
          <input type="radio" name="q2_3" value="3" id="q3_4"><label for="q3_4">3</label>
          <input type="radio" name="q2_3" value="4" id="q3_5"><label for="q3_5">4</label>
          <input type="radio" name="q2_3" value="5" id="q3_6"><label for="q3_6">5</label><br>
          3. <br>
          <input type="radio" name="q2_4" value="0" id="q4_1"><label for="q4_1">0</label>
          <input type="radio" name="q2_4" value="1" id="q4_2"><label for="q4_2">1</label>
          <input type="radio" name="q2_4" value="2" id="q4_3"><label for="q4_3">2</label>
          <input type="radio" name="q2_4" value="3" id="q4_4"><label for="q4_4">3</label>
          <input type="radio" name="q2_4" value="4" id="q4_5"><label for="q4_5">4</label>
          <input type="radio" name="q2_4" value="5" id="q4_6"><label for="q4_6">5</label><br>
          4. <br>
          <input type="radio" name="q2_5" value="0" id="q5_1"><label for="q5_1">0</label>
          <input type="radio" name="q2_5" value="1" id="q5_2"><label for="q5_2">1</label>
          <input type="radio" name="q2_5" value="2" id="q5_3"><label for="q5_3">2</label>
          <input type="radio" name="q2_5" value="3" id="q5_4"><label for="q5_4">3</label>
          <input type="radio" name="q2_5" value="4" id="q5_5"><label for="q5_5">4</label>
          <input type="radio" name="q2_5" value="5" id="q5_6"><label for="q5_6">5</label><br>
          5. <br>
          <input type="radio" name="q2_6" value="0" id="q6_1"><label for="q6_1">0</label>
          <input type="radio" name="q2_6" value="1" id="q6_2"><label for="q6_2">1</label>
          <input type="radio" name="q2_6" value="2" id="q6_3"><label for="q6_3">2</label>
          <input type="radio" name="q2_6" value="3" id="q6_4"><label for="q6_4">3</label>
          <input type="radio" name="q2_6" value="4" id="q6_5"><label for="q6_5">4</label>
          <input type="radio" name="q2_6" value="5" id="q6_6"><label for="q6_6">5</label><br>
          6. <br>
          <input type="radio" name="q2_7" value="0" id="q7_1"><label for="q7_1">0</label>
          <input type="radio" name="q2_7" value="1" id="q7_2"><label for="q7_2">1</label>
          <input type="radio" name="q2_7" value="2" id="q7_3"><label for="q7_3">2</label>
          <input type="radio" name="q2_7" value="3" id="q7_4"><label for="q7_4">3</label>
          <input type="radio" name="q2_7" value="4" id="q7_5"><label for="q7_5">4</label>
          <input type="radio" name="q2_7" value="5" id="q7_6"><label for="q7_6">5</label><br>
          7. <br>
          <input type="radio" name="q2_8" value="0" id="q8_1"><label for="q8_1">0</label>
          <input type="radio" name="q2_8" value="1" id="q8_2"><label for="q8_2">1</label>
          <input type="radio" name="q2_8" value="2" id="q8_3"><label for="q8_3">2</label>
          <input type="radio" name="q2_8" value="3" id="q8_4"><label for="q8_4">3</label>
          <input type="radio" name="q2_8" value="4" id="q8_5"><label for="q8_5">4</label>
          <input type="radio" name="q2_8" value="5" id="q8_6"><label for="q8_6">5</label><br>
          8. <br>
          <input type="radio" name="q2_9" value="0" id="q9_1"><label for="q9_1">0</label>
          <input type="radio" name="q2_9" value="1" id="q9_2"><label for="q9_2">1</label>
          <input type="radio" name="q2_9" value="2" id="q9_3"><label for="q9_3">2</label>
          <input type="radio" name="q2_9" value="3" id="q9_4"><label for="q9_4">3</label>
          <input type="radio" name="q2_9" value="4" id="q9_5"><label for="q9_5">4</label>
          <input type="radio" name="q2_9" value="5" id="q9_6"><label for="q9_6">5</label><br>
        </div >
        <div class="col-xs-3" >
          9. <br>
          <input type="radio" name="q2_10" value="0" id="q10_1"><label for="q10_1">0</label>
          <input type="radio" name="q2_10" value="1" id="q10_2"><label for="q10_2">1</label>
          <input type="radio" name="q2_10" value="2" id="q10_3"><label for="q10_3">2</label>
          <input type="radio" name="q2_10" value="3" id="q10_4"><label for="q10_4">3</label>
          <input type="radio" name="q2_10" value="4" id="q10_5"><label for="q10_5">4</label>
          <input type="radio" name="q2_10" value="5" id="q10_6"><label for="q10_6">5</label><br>
          10. <br>
          <input type="radio" name="q2_11" value="0" id="q11_1"><label for="q11_1">0</label>
          <input type="radio" name="q2_11" value="1" id="q11_2"><label for="q11_2">1</label>
          <input type="radio" name="q2_11" value="2" id="q11_3"><label for="q11_3">2</label>
          <input type="radio" name="q2_11" value="3" id="q11_4"><label for="q11_4">3</label>
          <input type="radio" name="q2_11" value="4" id="q11_5"><label for="q11_5">4</label>
          <input type="radio" name="q2_11" value="5" id="q11_6"><label for="q11_6">5</label><br>
          11. <br>
          <input type="radio" name="q2_12" value="0" id="q12_1"><label for="q12_1">0</label>
          <input type="radio" name="q2_12" value="1" id="q12_2"><label for="q12_2">1</label>
          <input type="radio" name="q2_12" value="2" id="q12_3"><label for="q12_3">2</label>
          <input type="radio" name="q2_12" value="3" id="q12_4"><label for="q12_4">3</label>
          <input type="radio" name="q2_12" value="4" id="q12_5"><label for="q12_5">4</label>
          <input type="radio" name="q2_12" value="5" id="q12_6"><label for="q12_6">5</label><br>
          12. <br>
          <input type="radio" name="q2_13" value="0" id="q13_1"><label for="q13_1">0</label>
          <input type="radio" name="q2_13" value="1" id="q13_2"><label for="q13_2">1</label>
          <input type="radio" name="q2_13" value="2" id="q13_3"><label for="q13_3">2</label>
          <input type="radio" name="q2_13" value="3" id="q13_4"><label for="q13_4">3</label>
          <input type="radio" name="q2_13" value="4" id="q13_5"><label for="q13_5">4</label>
          <input type="radio" name="q2_13" value="5" id="q13_6"><label for="q13_6">5</label><br>
          13. <br>
          <input type="radio" name="q2_14" value="0" id="q14_1"><label for="q14_1">0</label>
          <input type="radio" name="q2_14" value="1" id="q14_2"><label for="q14_2">1</label>
          <input type="radio" name="q2_14" value="2" id="q14_3"><label for="q14_3">2</label>
          <input type="radio" name="q2_14" value="3" id="q14_4"><label for="q14_4">3</label>
          <input type="radio" name="q2_14" value="4" id="q14_5"><label for="q14_5">4</label>
          <input type="radio" name="q2_14" value="5" id="q14_6"><label for="q14_6">5</label><br>
          14. <br>
          <input type="radio" name="q2_15" value="0" id="q15_1"><label for="q15_1">0</label>
          <input type="radio" name="q2_15" value="1" id="q15_2"><label for="q15_2">1</label>
          <input type="radio" name="q2_15" value="2" id="q15_3"><label for="q15_3">2</label>
          <input type="radio" name="q2_15" value="3" id="q15_4"><label for="q15_4">3</label>
          <input type="radio" name="q2_15" value="4" id="q15_5"><label for="q15_5">4</label>
          <input type="radio" name="q2_15" value="5" id="q15_6"><label for="q15_6">5</label><br>
          15. <br>
          <input type="radio" name="q2_16" value="0" id="q16_1"><label for="q16_1">0</label>
          <input type="radio" name="q2_16" value="1" id="q16_2"><label for="q16_2">1</label>
          <input type="radio" name="q2_16" value="2" id="q16_3"><label for="q16_3">2</label>
          <input type="radio" name="q2_16" value="3" id="q16_4"><label for="q16_4">3</label>
          <input type="radio" name="q2_16" value="4" id="q16_5"><label for="q16_5">4</label>
          <input type="radio" name="q2_16" value="5" id="q16_6"><label for="q16_6">5</label><br>
        </div >
      </div>
      
      <div class="form-group">
      <div class="col-xs-12" >
          三.上圖最痠痛或不適之部位，症狀持續長達多久時間？<br>
          <input type="radio" name="q2_17" value="2星期" id="q17_1"><label for="q17_1">2星期</label><br>
          <input type="radio" name="q2_17" value="1個月" id="q17_2"><label for="q17_2">1個月</label><br>
          <input type="radio" name="q2_17" value="3個月" id="q17_3"><label for="q17_3">3個月</label><br>
          <input type="radio" name="q2_17" value="6個月" id="q17_4"><label for="q17_4">6個月</label><br>
          <input type="radio" name="q2_17" value="1年" id="q17_5"><label for="q17_5">1年</label><br>
          <input type="radio" name="q2_17" value="2年以上" id="q17_6"><label for="q17_6">2年以上</label><br>
          四.上圖痠痛或不適症狀，是否經常於工作後才出現或加劇？<br>
          <input type="radio" name="q2_18" value="是" id="q18_y"><label for="q18_y">是</label><br>
          <input type="radio" name="q2_18" value="否" id="q18_n"><label for="q18_n">否</label><br>
          症狀與工作相關說明：<br>
          <textarea class="form-control" name="q1o"></textarea>
          五.近3個月您是否有因上述不適症狀而請假就醫? <br>
          <input type="radio" name="q2_19" value="是" id="q19_y"><label for="q19_y">是</label>
          請假<input name="q2o">天<br>
          <input type="radio" name="q2_19" value="否" id="q19_n"><label for="q19_n">否</label><br>
          六.您是否曾被醫師確診肌肉骨骼或神經系統相關疾病（需藥物、復健或手術治療）？<br>
          <input type="radio" name="q2_20" value="是" id="q20_y"><label for="q20_y">是</label>
          診斷名稱：
          <input name="q3o"><br>
          <input type="radio" name="q2_21" value="否" id="q21_n"><label for="q21_n">否</label><br>
        
          七.其他症狀、病史說明：(例如糖尿病、高血壓等等)<br>
          <textarea class="form-control" name="q4o"></textarea>
        </div>
      </div>
    </div>
    
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
	// date-picker

  $( document ).ready(function() {
    $('#name').focus();
  })

  $('.cancel').click(function() {
    var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
    parent.layer.close(index);
  })

  $("input[name='q2_1']").on('change', function(){
    if( document.querySelector("input[name='q2_1']:checked").value=='是'){
      $('#d_hide').removeClass('d_hide');
    } else{
      $('#d_hide').addClass('d_hide');
    }
  });
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
  var  q14 = null;
  var  q15 = null;
  var  q16 = null;
  var  q17 = null;
  var  q18 = null;
  var  q19 = null;
  var  q20 = null;
  var  q21 = null;
  var  q1o = '無';
  var  q2o = '無';
  var  q3o = '無';
  var  q4o = '無';
  var is_ok=false;
  $('input:radio[name="q2_1"]').on('change', function(){
    q1 = $('input:radio[name="q2_1"]:checked').val();
   
  });
  $('input:radio[name="q2_2"]').on('change', function(){
    q2 = $('input:radio[name="q2_2"]:checked').val();
   
  });
  $('input:radio[name="q2_3"]').on('change', function(){
    q3 = $('input:radio[name="q2_3"]:checked').val();
   
  });
  $('input:radio[name="q2_4"]').on('change', function(){
    q4 = $('input:radio[name="q2_4"]:checked').val();
   
  });
  $('input:radio[name="q2_5"]').on('change', function(){
    q5 = $('input:radio[name="q2_5"]:checked').val();
   
  });
  $('input:radio[name="q2_6"]').on('change', function(){
    q6 = $('input:radio[name="q2_6"]:checked').val();
   
  });
  $('input:radio[name="q2_7"]').on('change', function(){
    q7 = $('input:radio[name="q2_7"]:checked').val();
   
  });
  $('input:radio[name="q2_8"]').on('change', function(){
    q8 = $('input:radio[name="q2_8"]:checked').val();
   
  });
  $('input:radio[name="q2_9"]').on('change', function(){
    q9 = $('input:radio[name="q2_9"]:checked').val();
   
  });
  $('input:radio[name="q2_10"]').on('change', function(){
    q10 = $('input:radio[name="q2_10"]:checked').val();
   
  });
  $('input:radio[name="q2_11"]').on('change', function(){
    q11 = $('input:radio[name="q2_11"]:checked').val();
   
  });
  $('input:radio[name="q2_12"]').on('change', function(){
    q12 = $('input:radio[name="q2_12"]:checked').val();
   
  });
  $('input:radio[name="q2_13"]').on('change', function(){
    q13 = $('input:radio[name="q2_13"]:checked').val();
   
  });
  $('input:radio[name="q2_14"]').on('change', function(){
    q14 = $('input:radio[name="q2_14"]:checked').val();
   
  });
  $('input:radio[name="q2_15"]').on('change', function(){
    q15 = $('input:radio[name="q2_15"]:checked').val();
   
  });
  $('input:radio[name="q2_16"]').on('change', function(){
    q16 = $('input:radio[name="q2_16"]:checked').val();
   
  });
  $('input:radio[name="q2_17"]').on('change', function(){
    q17 = $('input:radio[name="q2_17"]:checked').val();
   
  });
  $('input:radio[name="q2_18"]').on('change', function(){
    q18 = $('input:radio[name="q2_18"]:checked').val();
   
  });
  $('input:radio[name="q2_19"]').on('change', function(){
    q19 = $('input:radio[name="q2_19"]:checked').val();
   
  });
  $('input:radio[name="q2_20"]').on('change', function(){
    q20 = $('input:radio[name="q2_20"]:checked').val();
   
  });

  $('input:radio[name="q2_21"]').on('change', function(){
    q21 = $('input:radio[name="q2_21"]:checked').val();
   
  });


  $('[name="q1o"]').on('change', function(){
    q1o = $('[name="q1o"]').val();
    // console.log(q1o);
   
  });
  $('[name="q2o"]').on('change', function(){
    q2o = $('[name="q2o"]').val();
    // console.log(q2o);

  });
  $('[name="q3o"]').on('change', function(){
    q3o = $('[name="q3o"]').val();
    // console.log(q3o);

  });
  $('[name="q4o"]').on('change', function(){
    q4o = $('[name="q4o"]').val();
    // console.log(q4o);

  });
console.log(q1);
  $('.dosubmit').click(function() {
   
    if (q1=='是'){
      if (q1!==null&&q2!==null&&q3!==null&&q4!==null&&q5!==null&&q6!==null&&
         q7!==null&&q8!==null&&q9!==null&&q10!==null&&q11!==null&&q12!==null&&q13!==null&&
         q14!==null&&q15!==null&&q16!==null&&q17!==null&&q18!==null&&q19!==null&&q13!==null&&
         q21!==null){
          is_ok=true;
         }
    } else{
      if (q1=='否'){
        is_ok=true;
      } else{
        alert('請填寫第一題！');
      }
      
    }
    if(is_ok){
      $.ajax({
  			url: '<?= base_url() ?>' + 'mgmt/question_for_user/save_q2',
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
          q14 : q14,
          q15 : q15,
          q16 : q16,
          q17 : q17,
          q18 : q18,
          q19 : q19,
          q20 : q20,
          q21 : q21,
          q1o : q1o,
          q2o : q2o,
          q3o : q3o,
          q4o : q4o
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
</script>
