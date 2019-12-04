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

				<!-- <fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">廠牌</label>
						<div class="col-md-6">
							<input type="text" class="form-control"  name="brand" value="<?= isset($item) ? $item -> brand : '' ?>"  />
						</div>
					</div>
				</fieldset>
				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">廠號</label>
						<div class="col-md-6">
							<input type="text" class="form-control"  name="brand_no" value="<?= isset($item) ? $item -> brand_no : '' ?>"  />
						</div>
					</div>
				</fieldset> -->
				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">料號</label>
						<div class="col-md-6">
							<input type="text" required class="form-control"  name="lot_number" value="<?= isset($item) ? $item -> lot_number : '' ?>"  />
						</div>
					</div>
				</fieldset>

				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">品名</label>
						<div class="col-md-6">
							<input type="text" required class="form-control"  name="name" value="<?= isset($item) ? $item -> name : '' ?>"  />
						</div>
					</div>
				</fieldset>

				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">磅秤料號</label>
						<div class="col-md-6">
							<input type="text" class="form-control"  name="weight_sn" value="<?= isset($item) ? $item -> weight_sn : '' ?>"  />
						</div>
					</div>
				</fieldset>
				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">噸工資代碼（本勞）</label>
						<div class="col-md-6">
							<input type="text" class="form-control"  name="salary_code" value="<?= isset($item) ? $item -> salary_code : '' ?>"  />
						</div>
					</div>
				</fieldset>
				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">噸工資代碼（外勞）</label>
						<div class="col-md-6">
							<input type="text" class="form-control"  name="salary_code_foreign" value="<?= isset($item) ? $item -> salary_code_foreign : '' ?>"  />
						</div>
					</div>
				</fieldset>
				<hr/>
				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">本勞點數</label>
						<div class="col-md-6">
							<input type="number" <?= !empty($edit_power) ? '' : "readonly" ?> step="0.01" class="form-control"  name="reward" value="<?= isset($item) ? $item -> reward : '' ?>"  />
						</div>
					</div>
				</fieldset>

				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">外勞點數</label>
						<div class="col-md-6">
							<input type="number" step="0.01" <?= !empty($edit_power) ? '' : "readonly" ?> class="form-control"  name="reward_foreign" value="<?= isset($item) ? $item -> reward_foreign : '' ?>"  />
						</div>
					</div>
				</fieldset>
				<hr/>
				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">分切成本</label>
						<div class="col-md-6">
							<input type="number" step="0.01" <?= !empty($edit_power) ? '' : "readonly" ?> class="form-control"  name="cut_cost" value="<?= isset($item) ? $item -> cut_cost : '' ?>"  />
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
