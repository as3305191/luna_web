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
    個人疲勞評估
    <input type="" id="qid" value="<?= isset($qid) ? $qid : '' ?>" />
    1.	你常覺得疲勞嗎？ <br>
    <input type="checkbox" name="q1" value="100">總是(100)<br>
    <input type="checkbox" name="q1" value="75">常常(75)<br>
    <input type="checkbox" name="q1" value="50">有時候(50)<br>
    <input type="checkbox" name="q1" value="25">不常(25)<br>
    <input type="checkbox" name="q1" value="0">從未或幾乎從未(0)<br>
    2.	你常覺得身體上體力透支嗎？ <br>
    <input type="checkbox" name="q2" value="100">總是(100)<br>
    <input type="checkbox" name="q2" value="75">常常(75)<br>
    <input type="checkbox" name="q2" value="50">有時候(50)<br>
    <input type="checkbox" name="q2" value="25">不常(25)<br>
    <input type="checkbox" name="q2" value="0">從未或幾乎從未(0)<br>
    3.	你常覺得情緒上心力交瘁嗎？ <br>
    <input type="checkbox" name="q3" value="100">總是(100)<br>
    <input type="checkbox" name="q3" value="75">常常(75)<br>
    <input type="checkbox" name="q3" value="50">有時候(50)<br>
    <input type="checkbox" name="q3" value="25">不常(25)<br>
    <input type="checkbox" name="q3" value="0">從未或幾乎從未(0)<br>
    4.	你常會覺得，「我快要撐不下去了」嗎？ <br>
    <input type="checkbox" name="q4" value="100">總是(100)<br>
    <input type="checkbox" name="q4" value="75">常常(75)<br>
    <input type="checkbox" name="q4" value="50">有時候(50)<br>
    <input type="checkbox" name="q4" value="25">不常(25)<br>
    <input type="checkbox" name="q4" value="0">從未或幾乎從未(0)<br>
    5.	你常覺得精疲力竭嗎？ <br>
    <input type="checkbox" name="q5" value="100">總是(100)<br>
    <input type="checkbox" name="q5" value="75">常常(75)<br>
    <input type="checkbox" name="q5" value="50">有時候(50)<br>
    <input type="checkbox" name="q5" value="25">不常(25)<br>
    <input type="checkbox" name="q5" value="0">從未或幾乎從未(0)<br>
    6.	你常常覺得虛弱，好像快要生病了嗎？ <br>
    <input type="checkbox" name="q6" value="100">總是(100)<br>
    <input type="checkbox" name="q6" value="75">常常(75)<br>
    <input type="checkbox" name="q6" value="50">有時候(50)<br>
    <input type="checkbox" name="q6" value="25">不常(25)<br>
    <input type="checkbox" name="q6" value="0">從未或幾乎從未(0)<br>
    工作疲勞評估
    1.	你的工作會令人情緒上心力交瘁嗎？<br>
    <input type="checkbox" name="q7" value="100">總是(100)<br>
    <input type="checkbox" name="q7" value="75">常常(75)<br>
    <input type="checkbox" name="q7" value="50">有時候(50)<br>
    <input type="checkbox" name="q7" value="25">不常(25)<br>
    <input type="checkbox" name="q7" value="0">從未或幾乎從未(0)<br>
    2.	你的工作會讓你覺得快要累垮了嗎？ <br>
    <input type="checkbox" name="q8" value="100">總是(100)<br>
    <input type="checkbox" name="q8" value="75">常常(75)<br>
    <input type="checkbox" name="q8" value="50">有時候(50)<br>
    <input type="checkbox" name="q8" value="25">不常(25)<br>
    <input type="checkbox" name="q8" value="0">從未或幾乎從未(0)<br>
    3.	你的工作會讓你覺得挫折嗎？ <br>
    <input type="checkbox" name="q9" value="100">總是(100)<br>
    <input type="checkbox" name="q9" value="75">常常(75)<br>
    <input type="checkbox" name="q9" value="50">有時候(50)<br>
    <input type="checkbox" name="q9" value="25">不常(25)<br>
    <input type="checkbox" name="q9" value="0">從未或幾乎從未(0)<br>
    4.	工作一整天之後，你覺得精疲力竭嗎？ <br>
    <input type="checkbox" name="q10" value="100">總是(100)<br>
    <input type="checkbox" name="q10" value="75">常常(75)<br>
    <input type="checkbox" name="q10" value="50">有時候(50)<br>
    <input type="checkbox" name="q10" value="25">不常(25)<br>
    <input type="checkbox" name="q10" value="0">從未或幾乎從未(0)<br>
    5.	上班之前只要想到又要工作一整天，你就覺得沒力嗎？ <br>
    <input type="checkbox" name="q11" value="100">總是(100)<br>
    <input type="checkbox" name="q11" value="75">常常(75)<br>
    <input type="checkbox" name="q11" value="50">有時候(50)<br>
    <input type="checkbox" name="q11" value="25">不常(25)<br>
    <input type="checkbox" name="q11" value="0">從未或幾乎從未(0)<br>
    6.	上班時你會覺得每一刻都很難熬嗎？ <br>
    <input type="checkbox" name="q12" value="100">總是(100)<br>
    <input type="checkbox" name="q12" value="75">常常(75)<br>
    <input type="checkbox" name="q12" value="50">有時候(50)<br>
    <input type="checkbox" name="q12" value="25">不常(25)<br>
    <input type="checkbox" name="q12" value="0">從未或幾乎從未(0)<br>
    7.	不工作的時候，你有足夠的精力陪朋友或家人嗎？ <br>
    <input type="checkbox" name="q13" value="100">總是(100)<br>
    <input type="checkbox" name="q13" value="75">常常(75)<br>
    <input type="checkbox" name="q13" value="50">有時候(50)<br>
    <input type="checkbox" name="q13" value="25">不常(25)<br>
    <input type="checkbox" name="q13" value="0">從未或幾乎從未(0)<br>
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
  $('.dosubmit').click(function() {
  		$.ajax({
  			url: '<?= base_url() ?>' + 'mgmt/roles/add_under',
  			type: 'POST',
  			data: {
  				qid:$('#qid').val(),
          q1 : $('.q1').val(),
          q2 : $('.q2').val(),
          q3 : $('.q3').val(),
          q4 : $('.q4').val(),
          q5 : $('.q5').val(),
          q6 : $('.q6').val(),
          q7 : $('.q7').val(),
          q8 : $('.q8').val(),
          q9 : $('.q9').val(),
          q10 : $('.q10').val(),
          q11 : $('.q11').val(),
          q12 : $('.q12').val(),
          q13 : $('.q13').val(),
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
