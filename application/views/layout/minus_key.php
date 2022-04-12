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
        <span style="font-size:12pt">刪除關鍵字</span>
    </div>
    <hr/>
    <select id="key" class="form-control" multiple>
      <?php foreach($key as $each): ?>
        <option value="<?= $each -> id ?>" >
          <?= $each -> key ?>
        </option>
      <?php endforeach ?>
    </select>
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
	$('#key').select2();

  $('.cancel').click(function() {
    var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
    parent.layer.close(index);
  })

  $('.dosubmit').click(function() { 
  		$.ajax({
  			url: '<?= base_url() ?>' + 'mgmt/patent/del_key',
  			type: 'POST',
  			data: {
          key : $('#key').val()
  			},
  			dataType: 'json',
  			success: function(d) {
  				if(d) {
  					console.log(d);
  				}
          if(d.success){
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            parent.layer.close(index);
            parent.find_key();            
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

  function load_key() {
		
    $.ajax({
        url: '<?= base_url() ?>' + 'mgmt/patent/find_key',
        type: 'POST',
        data: {},
        dataType: 'json',
        success: function(d) {
          if(d) {
            // console.log(d);
            $patent_key = $('#key').empty();
            $.each(d.key, function(){
              $('<option/>', {
                  'value': this.id,
                  'text': this.key
                }).appendTo($patent_key);
            });
          }
          
        },
        failure:function(){
          alert('faialure');
        }
      });
  
  }
  load_key();
  
  $('.trash_btn').click(function() {
    $(this).closest('.itemp').remove();
  })


</script>
