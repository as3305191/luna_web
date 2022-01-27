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
        <span style="font-size:12pt">新增標題名稱</span>
    </div>
    <hr/>
    <input type="text" class="form-control" placeholder="新增標題名稱" name="name" id="name" />

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

  $('.cancel').click(function() {
    var index = parent.layer.getFrameIndex(window.name); 
    parent.layer.close(index);
  })

  $('.dosubmit').click(function() {
  		$.ajax({
  			url: '<?= base_url() ?>' + 'mgmt/swot_bfl/add_title',
  			type: 'POST',
  			data: {
          swot_title : $('#name').val()
  			},
  			dataType: 'json',
  			success: function(d) {
  				if(d) {
  					console.log(d);
  				}
          if(d.success){
            var index = parent.layer.getFrameIndex(window.name); 
            parent.layer.close(index);
            parent.load_list_title();            
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
