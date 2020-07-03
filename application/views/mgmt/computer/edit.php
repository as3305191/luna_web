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
			<a href="javascript:void(0);" id="" onclick="do_save()" class="btn btn-default btn-danger">
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
	        <!-- <div class="col-md-12 col-xs-12 col-sm-12 no-padding" style="">
		        <button type="button" class="basic_information btn_roles btn_1" style="margin:7px;border-radius:5px;border:1.5px solid #ccc;background-color:#FFFFFF;color:#A5A4A4;width:200px;height:50px" onclick="showmetable('basic_information')">基本資料</button>
		        <button type="button" class="weight_history btn_roles" style="margin:7px;border-radius:5px;border:1.5px solid #ccc;background-color:#FFFFFF;color:#A5A4A4;width:200px;height:50px" onclick="showmetable('weight_history')">上秤歷史紀錄</button>
		        <button type="button" class="health_report btn_roles" style="margin:7px;border-radius:5px;border:1.5px solid #ccc;background-color:#FFFFFF;color:#A5A4A4;width:200px;height:50px" onclick="showmetable('health_report')">健康報告</button>
						<button type="button" class="ketone_record btn_roles" style="margin:7px;border-radius:5px;border:1.5px solid #ccc;background-color:#FFFFFF;color:#A5A4A4;width:200px;height:50px" onclick="showmetable('ketone_record')">尿酮紀錄</button>

	        </div> -->
        <div class="clearfix"></div>
    </div>
    <hr/>
		<div id="basic_information" style="">
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">電腦名稱</label>
					<div class="col-md-6">
						<input type="text" required class="form-control"   name="computer_name" value="<?= isset($item) ? $item -> computer_name : '' ?>"  />
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">硬體序號</label>
					<div class="col-md-6">
						<input type="text" required class="form-control"  name="computer_num" value="<?= isset($item) ? $item -> computer_num : '' ?>"  />
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">財產編號</label>
					<div class="col-md-6">
						<input type="text" class="form-control"  name="computer_property_num" value="<?= isset($item) ? $item -> computer_property_num : '' ?>"  />
					</div>
				</div>
			</fieldset>	
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">預設使用者</label>
					<div class="col-md-6">
						<input type="text" class="form-control"  name="admin_user" value="<?= isset($item) ? $item -> admin_user : '' ?>"  />
					</div>
				</div>
			</fieldset>	
			<fieldset>
				<div class="form-group">
				<label class="col-md-3 control-label">硬體</label>

					<div class="col-md-2">
						<input id="computer_h" type="text" class="form-control" placeholder="點擊收尋" />
					</div>
					<div class="col-md-2">
						<button type="button" class="btn btn-sm btn-primary" onclick="select_h()"><i class="fa fa-plus-circle fa-lg"></i></button>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
				<label class="col-md-3 control-label">軟體</label>

					<div class="col-md-2">
						<input id="computer_s" type="text" class="form-control" placeholder="點擊收尋" />
					</div>
					<div class="col-md-2">
						<button type="button" class="btn btn-sm btn-primary" onclick="select_s()"><i class="fa fa-plus-circle fa-lg"></i></button>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">已用硬體</label>
					<div class="col-md-6" id="hard_list">
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">已用軟體</label>
					<div class="col-md-6" id="soft_list">
					</div>
				</div>
			</fieldset>
						<style>
							#product_spec_list {
							
								margin-top: 10px;
								margin-bottom: 10px;
							}

							#product_spec_list div {
								margin-top: 5px!important;
								margin-bottom: 5px!important;
							}

							#product_spec_list > div.row {
								background-color: #EEEEEE;
								font-size: 16px;
								font-weight: bolder;
							}

						</style>
				

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
$(".dt_picker_").datetimepicker({
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

}).bootstrapValidator('validate');

var computer_num_array = [];

function do_save() {
			var url = baseUrl + 'mgmt/computer_hard/insert'; // the script where you handle the form input.
			$.ajax({
				type : "POST",
				url : url,
				data : {
					id: $('#item_id').val(),
					computer_hard_name: $('#computer_hard_name').val(),
					computer_num_array: computer_num_array,
				},
				success : function(data) {
					if(data.error_msg) {
						layer.msg(data.error_msg);
					} else {
						app.mDtTable.ajax.reload(null, false);
					}
					// app.backTo();
				}
			});
		};

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


	function addSpec() {
		var $computer_num = $('#computer_num');
		var computer_num = $computer_num.val();
		if(computer_num.length == 0) {
			alert('請輸序號名稱');
			return;
		}
		$.ajax({
			url: baseUrl + 'mgmt/computer_hard/add_number',
			type: 'POST',
			data: {
				computer_num: computer_num,
			},
			dataType: 'json',
			success: function(d) {
				if(d) {
					$computer_num.val(''); // reset
					computer_num_array.push({
						id: d.last_id,
						computer_hard_num: d.last_computer_num,
					});
					redrawSpec();
				}
			},
			failure:function(){
				alert('faialure');
			}
		});
	}

	function redrawSpec() {
		// console.log(computer_num_array);
		var $computer_num_list = $('#computer_num_list').empty();
		$.each(computer_num_array, function(){
			var me = this;
			var $now_computer_num_array = $('<div><span computer_num_id="'+me.id+'">'+me.computer_hard_num+'</span><div>').appendTo($computer_num_list);
		});
	}

	function drawfirst() {
		var $computer_num_list = $('#computer_num_list').empty();
		$.ajax({
			url: baseUrl + 'mgmt/computer_hard/find_all_list_now',
			type: 'POST',
			data: {
				id: $('#item_id').val(),
			},
			dataType: 'json',
			success: function(d) {
				if(d) {
					$computer_num.val(''); // reset
					computer_num_array.push({
						id: d.last_id,
						computer_hard_num: d.last_computer_num,
					});
					redrawSpec();
				}
			},
			failure:function(){
				alert('faialure');
			}
		});
	
	}

	// drawfirst();
</script>
