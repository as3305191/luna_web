<style>
.file-drag-handle {
	display: none;
}
</style>
<!-- Widget ID (each widget will need unique ID)-->
<div class="jarviswidget" id="wid-id-7" data-widget-colorbutton="false"	data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
	<header>
		<div class="widget-toolbar pull-left">
			<a href="javascript:void(0);" id="back_parent" onclick="currentApp.backTo()" class="btn btn-default ">
				<i class="fa fa-arrow-circle-left"></i>返回
			</a>
		</div>
		<div class="widget-toolbar pull-left">
			<a href="javascript:void(0);" id="" onclick="currentApp.doSubmit()" class="btn btn-default btn-danger">
				<i class="fa fa-save"></i>存檔
			</a>
		</div>
	</header>
	<!-- widget div-->
	<div>
		<!-- widget edit box -->
		<div class="jarviswidget-editbox">
			<!-- This area used as dropdown edit box -->
			<input class="form-control" type="text">
		</div>
		<!-- end widget edit box -->
		<!-- widget content -->
		<div class="widget-body">
			<form id="app-edit-form" method="post" class="form-horizontal">
				<input type="hidden" name="id" id="item_id" value="<?= isset($item) ? $item -> id : '' ?>" />
				<input type="hidden" name="role_id"  value="1" />
				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">帳號</label>
						<div class="col-md-6">
							<input type="text" required class="form-control"  name="account" value="<?= isset($item) ? $item -> account : '' ?>" <?= isset($item) ? 'readonly' : '' ?> />
						</div>
					</div>
				</fieldset>
				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">名稱</label>
						<div class="col-md-6">
							<input type="text" class="form-control"  name="user_name" value="<?= isset($item) ? $item -> user_name : '' ?>"  />
						</div>
					</div>
				</fieldset>
				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">密碼</label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="password" value="<?= isset($item) ? $item -> password : '' ?>" />
						</div>
					</div>
				</fieldset>
				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">醫院</label>
						<div class="col-md-6">
							<select name="f_hospital" id="f_hospital" class="form-control" onchange="hospital()">
								<option value="-1">無</option>
								<?php foreach($hospital_list as $each): ?>
									<option value="<?= $each -> id?>" ><?=  $each -> hospital_name ?></option>
								<?php endforeach ?>
							</select>
						</div>
					</div>
				</fieldset>
				
				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">醫生</label>
						<div class="col-md-6">
							<select name="doctor_id" id="f_doctor" class="form-control" >
								<option value="-1">無</option>
								<?php foreach($doctor as $each): ?>
									<option value="<?= $each -> id?>" ><?=  $each -> user_name ?></option>
								<?php endforeach ?>
							</select>
						</div>
					</div>
				</fieldset>
				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">個管師</label>
						<div class="col-md-6">
							<select name="manager_id" id="f_manager" class="form-control">
								<option value="-1">無</option>
								<?php foreach($manager as $each): ?>
									<option value="<?= $each -> id?>" ><?=  $each -> user_name ?></option>
								<?php endforeach ?>
							</select>
						</div>
					</div>
				</fieldset>
			</form>
		</div>
		<!-- end widget content -->
	</div>
	<!-- end widget div -->
</div>
<!-- end widget -->
<style>
	.kv-file-zoom {
		display: none;
	}
</style>
<script>
function hospital(){
    $.ajax({
      url: '<?= base_url() ?>' + 'mgmt/members/find_doctor',
      type: 'POST',
      data: {
        hospital: $('#f_hospital').find(':selected').attr('value')
      },
      dataType: 'json',
      success: function(d) {
        if(d) {
			var html = '<option value="all">無</option>';

			console.log(d);
			$doctor_id= $('#f_doctor').empty();
			$manager_id= $('#f_manager').empty();
			$doctor_id.append(html);
			$manager_id.append(html);

			$.each(d.list, function(){
				$('<option/>', {
					'value': this.id,
					'text': this.user_name
				}).appendTo($doctor_id);
			});

			$.each(d.list_1, function(){
				$('<option/>', {
						'value': this.id,
						'text': this.user_name
				}).appendTo($manager_id);
			});
        }
      },
      failure:function(){
        alert('faialure');
      }
    });
  }

</script>
