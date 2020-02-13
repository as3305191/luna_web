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
				<div class="form-group" style="padding:0px 26px">
	        <div class="col-md-12 col-xs-12 col-sm-12 no-padding" style="">
		        <button type="button" class="basic_information btn_roles btn_1" style="margin:7px;border-radius:5px;border:1.5px solid #ccc;background-color:#FFFFFF;color:#A5A4A4;width:200px;height:50px" onclick="showmetable('basic_information')">基本資料</button>
		        <button type="button" class="lottery btn_roles" style="margin:7px;border-radius:5px;border:1.5px solid #ccc;background-color:#FFFFFF;color:#A5A4A4;width:200px;height:50px" onclick="showmetable('lottery')">摸彩卷</button>
		        <button type="button" class="items btn_roles" style="margin:7px;border-radius:5px;border:1.5px solid #ccc;background-color:#FFFFFF;color:#A5A4A4;width:200px;height:50px" onclick="showmetable('items')">道具</button>

	        </div>
        <div class="clearfix"></div>
    </div>
    <hr/>
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

	function showmetable(id) {
		//   document.getElementById(id).show();
		$('.table_1').hide();
		$('#'+id).show();
		$('.btn_roles').removeClass('btn_1');
		$('.'+id).addClass('btn_1');
	}

	// currentApp.weighthistoryList = new WeightHistoryClass(new BaseAppClass({}));
	// currentApp.giftList = new FishtableGiftAppClass(new BaseAppClass({}));
	// currentApp.rechargeList = new RechargerecordAppClass(new BaseAppClass({}));
	// currentApp.storeList = new StoreAppClass(new BaseAppClass({}));
	// currentApp.buyList = new BuyAppClass(new BaseAppClass({}));
	// currentApp.friendsList = new FriendsAppClass(new BaseAppClass({}));
	// currentApp.talkList = new TalkAppClass(new BaseAppClass({}));
	// currentApp.caughtfishList = new CaughtfishAppClass(new BaseAppClass({}));
	// currentApp.levelrecordfishList = new LevelrecordAppClass(new BaseAppClass({}));
	// currentApp.loginList = new LoginAppClass(new BaseAppClass({}));
</script>
