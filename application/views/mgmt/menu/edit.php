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
						<label class="col-md-3 control-label">編號</label>
						<div class="col-md-6">
							<input type="text"  class="form-control"  name="menu_code" value="<?= isset($item) ? $item -> menu_code : '' ?>" <?= isset($item) ? 'readonly' : '' ?> />
						</div>
					</div>
				</fieldset>
				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">菜單名稱</label>
						<div class="col-md-6">
							<input type="text" class="form-control"  name="menu_name" value="<?= isset($item) ? $item -> menu_name : '' ?>"  />
						</div>
					</div>
				</fieldset>
				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">菜色類別</label>
						<div class="col-md-6">
							<input type="text" class="form-control"  name="cuisine_type" value="<?= isset($item) ? $item -> cuisine_type : '' ?>"  />
						</div>
					</div>
				</fieldset>
				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label"></label>
						<div class="col-md-6">
							<input type="text" class="form-control"  name="meal_name" value="<?= isset($item) ? $item -> meal_name : '' ?>"  />
						</div>
					</div>
				</fieldset>
				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">日期</label>
						<div class="col-md-6">
							<input type="text" class="form-control"  name="date" value="<?= isset($item) ? $item -> date : '' ?>"  />
						</div>
					</div>
				</fieldset>
				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">全穀根莖類</label>
						<div class="col-md-6">
							<input type="text" class="form-control"  name="grain_rhizomes" value="<?= isset($item) ? $item -> grain_rhizomes : '' ?>"  />
						</div>
					</div>
				</fieldset>
				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">豆魚肉蛋類</label>
						<div class="col-md-6">
							<input type="text" class="form-control"  name="fish_eggs" value="<?= isset($item) ? $item -> fish_eggs : '' ?>"  />
						</div>
					</div>
				</fieldset>
				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">油脂與堅果種子類</label>
						<div class="col-md-6">
							<input type="text" class="form-control"  name="oils_nuts" value="<?= isset($item) ? $item -> oils_nuts : '' ?>"  />
						</div>
					</div>
				</fieldset>
				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">蔬菜</label>
						<div class="col-md-6">
							<input type="text" class="form-control"  name="vegetables" value="<?= isset($item) ? $item -> vegetables : '' ?>"  />
						</div>
					</div>
				</fieldset>
				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">水果</label>
						<div class="col-md-6">
							<input type="text" class="form-control"  name="fruit" value="<?= isset($item) ? $item -> fruit : '' ?>"  />
						</div>
					</div>
				</fieldset>
				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">乳製品</label>
						<div class="col-md-6">
							<input type="text" class="form-control"  name="dairy_products" value="<?= isset($item) ? $item -> dairy_products : '' ?>"  />
						</div>
					</div>
				</fieldset>
				<?php if ($login_user->corp_id==0): ?>
					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">公司</label>
							<div class="col-md-6">
								<select name="corp_id" id="corp_id" class="form-control">
									<option value="-1">無</option>
									<?php foreach($corp_list as $each): ?>
										<option value="<?= $each -> id?>" ><?=  $each -> corp_name ?></option>
									<?php endforeach ?>
								</select>
							</div>
						</div>
					</fieldset>
				<?php else: ?>
					<input type="hidden" class="form-control"  name="crop_id" value="<?= isset($login_user) ? $login_user->corp_id : '' ?>"  />

				<?php endif; ?>

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
