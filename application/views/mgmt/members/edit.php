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
						<label class="col-md-3 control-label">醫院</label>
						<div class="col-md-6">
							<select name="hospital_id" id="f_hospital" class="form-control" onchange="hospital()">
								<?php
									foreach ($hospital_list as $each) {
										$selected = ((isset($item) && isset($item -> hospital_id) && $item -> hospital_id == $each -> id) ? 'selected' : '');
										echo "<option value='{$each -> id}' $selected>{$each -> hospital_name}</option>";
									}
								?>
							</select>
						</div>
					</div>
				</fieldset>

				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">醫生</label>
						<div class="col-md-6">
							<select name="user_doctor_id" id="f_doctor" class="form-control" >
								<option value="-1">無</option>
								<?php foreach($doctor as $each): ?>
								<option value="<?= $each -> id?>" <?= isset($item) && $item -> user_doctor_id == $each -> id ? 'selected' : '' ?> ><?=  $each -> user_name ?></option>
							<?php endforeach ?>
							</select>
						</div>
					</div>
				</fieldset>
				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">個管師</label>
						<div class="col-md-6">
							<select name="user_manager_id" id="f_manager" class="form-control">
								<option value="-1">無</option>
								<?php foreach($manager as $each): ?>
								<option value="<?= $each -> id?>" <?= isset($item) && $item -> user_manager_id == $each -> id ? 'selected' : '' ?> ><?=  $each -> user_name ?></option>
							<?php endforeach ?>
							</select>
						</div>
					</div>
				</fieldset>
				<?php if (!empty($item -> id)): ?>
					<hr>
					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">連續登日次數</label>
							<!-- <button id="update_here" type="button"  style="margin:7px;border-radius:5px;border:1.5px solid #ccc;background-color:#FFFFFF;color:#A5A4A4;width:70px;height:40px">更新狀態</button> -->
							<button type="button"  style="margin:7px;border-radius:5px;border:1.5px solid #ccc;background-color:#FFFFFF;color:#A5A4A4;width:200px;height:50px" onclick="update_here()">更新狀態</button>

							<div class="col-md-6">
								<span>目前：<?=  $item -> login_count ?></span>
								<select  id="login_count" class="form-control">
									<option value="0">0</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
								</select>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">種子類型</label>
							<div class="col-md-6">
								<span>目前：<?=  $item -> seed ?></span>
								<select  id="seed" class="form-control">
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
								</select>
							</div>
						</div>
					</fieldset>
					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">目前關卡</label>
							<div class="col-md-6">
								<span>目前：<?=  $item -> level_status ?></span>
								<select  id="level_status" class="form-control">
									<option value="0">未進入關卡</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
								</select>
							</div>
						</div>
					</fieldset>

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
	          console.log(d);
	          $doctor_id= $('#f_doctor').empty();
						$manager_id= $('#f_manager').empty();

	          var html = '<option value="-1">無</option>';
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
