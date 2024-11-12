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
				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">員工編號</label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="empindex" value="<?= isset($item) ? $item -> empindex : '' ?>" />
						</div>
					</div>
				</fieldset>
				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">部門</label>
						<div class="col-md-6">
							<select name="role_id" id="department_id" class="form-control" onchange="department_change();">
							<option value="0">請選擇</option>
								<?php foreach($department_list as $each): ?>
									<?php if(!empty( $div_list)): ?>
										<option value="<?= $each -> id?>" <?= isset($item) && $item -> new_department_id == $each -> id ? 'selected' : '' ?> ><?=  $each -> name ?></option>
									<?php else: ?>
										<option value="<?= $each -> id?>" <?= isset($item) && $item -> role_id == $each -> id ? 'selected' : '' ?> ><?=  $each -> name ?></option>
									<?php endif ?>
								<?php endforeach ?>
							</select>
						</div>
					</div>
				</fieldset>
				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">課</label>
						<div class="col-md-6">
							<?php if(!empty($item)): ?>
								<select name="div_id" id="div_id" class="form-control">
									<?php if(!empty( $div_list)): ?>
										<?php foreach($div_list as $each): ?>
											<option value="<?= $each -> id?>" <?= isset($item) && $item -> div_id == $each -> id ? 'selected' : '' ?> ><?=  $each -> name ?></option>
										<?php endforeach ?>
									<?php else: ?>
										<option disabled="disabled" >部門沒有課</option>
									<?php endif ?>
								</select>
							<?php else: ?>
								<select name="div_id" id="div_id" class="form-control" >
									<option disabled="disabled">請先選擇部門</option>
								</select>
							<?php endif ?>
						</div>
					</div>
				</fieldset>
				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">隸屬部門</label>
						<div class="col-md-9 pull-left" id="patent_status">
							
							<?php foreach ($department_list_1 as $each) : ?>
								<?php if(!empty($item -> in_departments)): ?>
									<label class="u-check g-pl-0">
										<input class="g-hidden-xs-up g-pos-abs g-top-0 g-left-0" name="in_department[]" type="checkbox" value="<?= $each->id ?>"
											<?php foreach ($item -> in_departments as $each_department) : ?>
												<?= isset($each_department) && $each_department == $each->id ? 'checked': '' ?> 
											<?php endforeach ?>
										>
										<span class="btn btn-md btn-block u-btn-outline-lightgray g-color-white--checked g-bg-primary--checked rounded-0"><?= $each->name ?></span>
									</label>
								<?php else: ?>
									<label class="u-check g-pl-0">
										<input class="g-hidden-xs-up g-pos-abs g-top-0 g-left-0" name="in_department[]" type="checkbox" value="<?= $each->id ?>" <?= isset($each_department) && $each_department == $each->id ? 'checked': '' ?> >
										<span class="btn btn-md btn-block u-btn-outline-lightgray g-color-white--checked g-bg-primary--checked rounded-0"><?= $each->name ?></span>
									</label>
								<?php endif ?>
							<?php endforeach ?>
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

	function department_change(){
    var $department = $('#department_id').val();
    $.ajax({
			url: '<?= base_url() ?>' + 'mgmt/users/find_div_by_department',
			type: 'POST',
			data: {
				department: $department
			},
			dataType: 'json',
			success: function(d) {
				if(d) {
					// console.log(d);
					$div = $('#div_id').empty();
					$("#div_id").prepend("<option value='0'>沒有課</option>");
					$.each(d.div_list, function(){
						$('<option/>', {
							'value': this.id,
							'text': this.name
						}).appendTo($div);
					});

				}
			},
			failure:function(){
				alert('faialure');
			}
		});
  }


</script>
