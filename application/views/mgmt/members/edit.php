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
						<label class="col-md-3 control-label">email</label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="email" value="<?= isset($item) ? $item -> email : '' ?>" />
						</div>
					</div>
				</fieldset>

				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">生日</label>
						<div class="col-md-6">
							<input type="text" class="form-control dt_picker" name="birth" value="<?= isset($item) ? $item -> birth : '' ?>" />
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
						<label class="col-md-3 control-label">性別</label>
						<div class="col-md-6">
							<select name="gender" class="form-control">
								<option value="0" <?= isset($item) && $item -> gender == 0 ? 'selected' : '' ?>>女生</option>
								<option value="1" <?= isset($item) && $item -> gender == 1 ? 'selected' : '' ?>>男生</option>
							</select>
						</div>
					</div>
				</fieldset>

				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">年齡</label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="age" value="<?= isset($item) ? $item -> age : '' ?>" />
						</div>
					</div>
				</fieldset>

				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">身高</label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="height" value="<?= isset($item) ? $item -> height : '' ?>" />
						</div>
					</div>
				</fieldset>

				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">身份</label>
						<div class="col-md-6">
							<select name="type" id="" class="form-control" >
								<option value="0" <?= isset($item) && $item -> type == 0 ? 'selected' : '' ?>>一般會員</option>
							<option value="1" <?= isset($item) && $item -> type == 1 ? 'selected' : '' ?>>教練</option>
							</select>
						</div>
					</div>
				</fieldset>

				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">所屬教練</label>
						<div class="col-md-6">
							<select name="coach_id" id="" class="form-control" >
								<option value="0">無</option>
								<?php foreach($coach as $each): ?>
								<option value="<?= $each -> id?>" <?= isset($item) && $item -> coach_id == $each -> id ? 'selected' : '' ?> ><?=  $each -> user_name ?></option>
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
$(".dt_picker").datetimepicker({
		format : 'YYYY-MM-DD'
	}).on('dp.change',function(event){

	});

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

			function update_here() {
					$.ajax({
						url: '<?= base_url() ?>' + 'mgmt/members/update_here',
						type: 'POST',
						data: {
							id: $('#item_id').val(),
							login_count: $('#login_count').val(),
							seed: $('#seed').val(),
							level_status: $('#level_status').val()
						},
						dataType: 'json',
						success: function(d) {
							// alert('更新狀態成功');
							currentApp.doEdit($('#item_id').val());
						},
						failure:function(){
							alert('faialure');
						}
					});
			}
</script>
