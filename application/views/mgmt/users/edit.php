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

				<!-- <fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">單位</label>
						<div class="col-md-6">
							<select name="station_id" id="user_station_id" class="form-control" >
								<?php foreach($station_list as $each): ?>
									<option value="<?= $each -> id?>" <?= isset($item) && $item -> station_id == $each -> id ? 'selected' : '' ?> ><?=  $each -> name ?></option>
								<?php endforeach ?>
							</select>
						</div>
					</div>
				</fieldset> -->
				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">權限角色</label>
						<div class="col-md-6">
							<select name="role_id" id="user_role_id" class="form-control">
								<?php foreach($role_list as $each): ?>
									<option value="<?= $each -> id?>" <?= isset($item) && $item -> role_id == $each -> id ? 'selected' : '' ?> ><?=  $each -> role_name ?></option>
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
	$('#app-edit-form').bootstrapValidator({
		feedbackIcons : {
			valid : 'glyphicon glyphicon-ok',
			invalid : 'glyphicon glyphicon-remove',
			validating : 'glyphicon glyphicon-refresh'
		},
		fields: {
			account: {
            validators: {
              remote: {
              	message: '已經存在',
              	url: baseUrl + 'mgmt/users/check_account/' + ($('#item_id').val().length > 0 ? $('#item_id').val() : '0')
              }
            }
         }
      }

	})
	.bootstrapValidator('validate');
	$(".dt_picker").datetimepicker({
		format : 'YYYY-MM-DD'
	}).on('dp.change',function(event){

	});
</script>
