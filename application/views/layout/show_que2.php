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
        <span style="font-size:12pt">肌肉骨骼症狀問卷調查表</span>
    </div>
    <hr/>
    個人疲勞評估<br>
    <input type="hidden" id="qid" value="<?= isset($qid) ? $qid : '' ?>" />
    1.  您在過去1年內，身體是否有長達2星期以上的痠痛、發麻、刺痛、肌肉疲勞、關節活動限制等不適症狀？ <br>
    （若否，結束此調查表；若是，請繼續填寫<br>
    <input type="radio" name="q2_1" value="是" id="q1_y"><label for="q1_y">是</label><br>
    <input type="radio" name="q2_1" value="否" id="q1_n"><label for="q1_n">否</label><br>
    <img width="560" src="<?= base_url('img/body_fat/logo/body_back_for_que2.png') ?>" >
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
  			url: '<?= base_url() ?>' + 'mgmt/question_for_user/save_q3',
  			type: 'POST',
  			data: {
  				qid:$('#qid').val(),
          q1 : document.querySelector("input[name='q3_1']:checked").value,
          q2 : document.querySelector("input[name='q3_2']:checked").value,
          q3 : document.querySelector("input[name='q3_3']:checked").value,
          q4 : document.querySelector("input[name='q3_4']:checked").value,
          q5 : document.querySelector("input[name='q3_5']:checked").value,
          q6 : document.querySelector("input[name='q3_6']:checked").value,
          q7 : document.querySelector("input[name='q3_7']:checked").value,
          q8 : document.querySelector("input[name='q3_8']:checked").value,
          q9 : document.querySelector("input[name='q3_9']:checked").value,
          q10 : document.querySelector("input[name='q3_10']:checked").value,
          q11 : document.querySelector("input[name='q3_11']:checked").value,
          q12 : document.querySelector("input[name='q3_12']:checked").value,
          q13 : document.querySelector("input[name='q3_13']:checked").value,
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
