<style>
.file-drag-handle {
	display: none;
}
.btn_1 {
    background-color: #FFD22F !important;
    color: #F57316 !important;
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
		<div class="table_1" id="basic_information" style="">
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
		</div>
		<div class="table_1" id="weight_history" style="display:none">
			<table id="weight_history_list" class="table table-striped table-bordered table-hover" width="100%">
				<thead>
					<tr>
						<th class="min100">體重</th>
						<th class="min100">體脂率</th>
						<th class="min100">脂肪</th>
						<th class="min100">內臟脂肪率</th>
						<th class="min100">蛋白率</th>
						<th class="min100">水分率</th>
						<th class="min100">肌肉率</th>
						<th class="min100">骨骼肌率</th>
						<th class="min100">骨重率</th>
						<th class="min100">皮下脂肪率</th>
						<th class="min100">肥胖等級</th>
						<th class="min100">BMR</th>
						<th class="min100">健康指數</th>
						<th class="min100">身體年齡</th>
						<th class="min100">身體類型</th>
						<th class="min100">日期</th>

					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>

		<div class="table_1" id="health_report" style="display:none">

			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">體重</label>
					<div class="col-md-6">
						<input type="text"  class="form-control" value="<?= isset($health_report) ? $health_report -> weight : '' ?>" readonly />
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">體脂率</label>
					<div class="col-md-6">
						<input type="text" class="form-control" value="<?= isset($health_report) ? $health_report -> body_fat : '' ?>"  readonly/>
					</div>
				</div>
			</fieldset>

			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">脂肪</label>
					<div class="col-md-6">
						<input type="text" class="form-control" value="<?= isset($health_report) ? $health_report -> body_fat_rate : '' ?>" readonly/>
					</div>
				</div>
			</fieldset>

			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">內臟脂肪率</label>
					<div class="col-md-6">
						<input type="text" class="form-control"  value="<?= isset($health_report) ? $health_report -> visceral_fat_rate : '' ?>"readonly />
					</div>
				</div>
			</fieldset>

			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">蛋白率</label>
					<div class="col-md-6">
						<input type="text" class="form-control" value="<?= isset($health_report) ? $health_report -> protein_rate : '' ?>" readonly/>
					</div>
				</div>
			</fieldset>

			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">水分率</label>
					<div class="col-md-6">
						<input type="text" class="form-control" value="<?= isset($health_report) ? $health_report -> moisture_rate : '' ?>" readonly/>

					</div>
				</div>
			</fieldset>

			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">肌肉率</label>
					<div class="col-md-6">
						<input type="text" class="form-control" value="<?= isset($health_report) ? $health_report -> muscle_rate : '' ?>" readonly/>
					</div>
				</div>
			</fieldset>

			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">骨骼肌率</label>
					<div class="col-md-6">
						<input type="text" class="form-control" value="<?= isset($health_report) ? $health_report -> skeletal_muscle_rate : '' ?>" readonly/>
					</div>
				</div>
			</fieldset>

			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">骨重率</label>
					<div class="col-md-6">
						<input type="text" class="form-control" value="<?= isset($health_report) ? $health_report -> bone_mass_rate : '' ?>" readonly/>
					</div>
				</div>
			</fieldset>

			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">皮下脂肪率</label>
					<div class="col-md-6">
						<input type="text" class="form-control" value="<?= isset($health_report) ? $health_report -> subcutaneous_fat_rate : '' ?>" readonly/>

					</div>
				</div>
			</fieldset>

			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">肥胖等級</label>
					<div class="col-md-6">
						<input type="text" class="form-control" value="<?= isset($health_report) ? $health_report -> fat_info : '' ?>" readonly/>

					</div>
				</div>
			</fieldset>

			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">BMR</label>
					<div class="col-md-6">
						<input type="text" class="form-control" value="<?= isset($health_report) ? $health_report -> bmr : '' ?>" readonly/>
					</div>
				</div>
			</fieldset>

			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">健康指數</label>
					<div class="col-md-6">
						<input type="text" class="form-control" value="<?= isset($health_report) ? $health_report -> health_index : '' ?>" readonly/>
					</div>
				</div>
			</fieldset>

			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">身體年齡</label>
					<div class="col-md-6">
						<input type="text" class="form-control" value="<?= isset($health_report) ? $health_report -> physical_age : '' ?>" readonly/>
					</div>
				</div>
			</fieldset>

			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">身體類型</label>
					<div class="col-md-6">
						<input type="text" class="form-control" value="<?= isset($health_report) ? $health_report -> body_type : '' ?>" readonly/>
					</div>
				</div>
			</fieldset>
		</div>

		<div class="table_1" id="ketone_record" style="display:none">
			<table id="ketone_record_list" class="table table-striped table-bordered table-hover" width="100%">
				<thead>
					<tr>
						<th class="min100">尿酮數值</th>
						<th class="min100">日期</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>



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

// $('#app-edit-form').bootstrapValidator({
// 	feedbackIcons : {
// 		valid : 'glyphicon glyphicon-ok',
// 		invalid : 'glyphicon glyphicon-remove',
// 		validating : 'glyphicon glyphicon-refresh'
// 	},
// 	fields: {
// 		account: {
// 					validators: {
// 						remote: {
// 							message: '已經存在',
// 							url: baseUrl + 'mgmt/users/check_account/' + ($('#item_id').val().length > 0 ? $('#item_id').val() : '0')
// 						}
// 					}
// 			 }
// 		}
//
// })
// .bootstrapValidator('validate');

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
