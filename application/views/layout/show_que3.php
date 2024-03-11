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
        <span style="font-size:12pt">問卷3</span>
    </div>
    <hr/>
    <input type="" id="qid" value="<?= isset($qid) ? $qid : '' ?>" />
    Q4：味覺不會騙人，你討厭吃什麼？複選題 <br>
    <input type="checkbox" name="Hate" value="Taiwanese">台式<br>
    <input type="checkbox" name="Hate" value="Italian">義式<br>
    <input type="checkbox" name="Hate" value="Japanese">日式<br>
    <input type="checkbox" name="Hate" value="American">美式<br>
    
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
