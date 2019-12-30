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
						<label class="col-md-3 control-label">標籤等級</label>
						<div class="col-md-6">
							<select name="level" class="form-control">
								<option value="2" <?= isset($item) && $item -> level == 2 ? 'selected' : '' ?>>第2等級</option>
								<option value="3" <?= isset($item) && $item -> level == 3 ? 'selected' : '' ?>>最低等級</option>
							</select>
						</div>
					</div>
				</fieldset>

				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">早餐</label>
						<div class="col-md-6">
							<textarea class="form-control" name="breakfast" rows="8" placeholder="請輸入早餐" style="resize:none;width:100%"><?= isset($item) ? $item -> breakfast : '' ?></textarea>
						</div>
					</div>
				</fieldset>
				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">午餐</label>
						<div class="col-md-6">
							<textarea class="form-control" name="lunch" rows="8"  placeholder="請輸入午餐" style="resize:none;width:100%"><?= isset($item) ? $item -> lunch : '' ?></textarea>
						</div>
					</div>
				</fieldset>

				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">晚餐</label>
						<div class="col-md-6">
							<textarea class="form-control" name="dinner" rows="8" placeholder="請輸入晚餐" style="resize:none;width:100%"><?= isset($item) ? $item -> dinner : '' ?></textarea>
						</div>
					</div>
				</fieldset>

				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">備註</label>
						<div class="col-md-6">
							<textarea class="form-control" name="note" rows="8" placeholder="請輸入備註" style="resize:none;width:100%"><?= isset($item) ? $item -> note : '' ?></textarea>
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
