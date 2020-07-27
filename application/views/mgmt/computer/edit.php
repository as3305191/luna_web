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
		<div class="widget-toolbar pull-right">
			<div class="btn-group">
				<button onclick="currentApp.doExportAll()" class="btn dropdown-toggle btn-xs btn-warning" data-toggle="dropdown">
					<i class="fa fa-save"></i>匯出
				</button>
			</div>
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
				<input type="hidden" id="role_id" value="<?= isset($login_user) ? $login_user -> role_id : '' ?>"  />
				<fieldset>
					<div class="col-md-6 form-group">
						<button type="button" class="1 btn_roles btn_1" style="margin:7px;border-radius:5px;border:1.5px solid #ccc;background-color:#FFFFFF;color:#A5A4A4;width:200px;height:50px" onclick="showmefieldset('1')">電腦基本資料資料</button>
						<button type="button" class="2 btn_roles" style="margin:7px;border-radius:5px;border:1.5px solid #ccc;background-color:#FFFFFF;color:#A5A4A4;width:200px;height:50px" onclick="showmefieldset('2')">維修紀錄</button>
					</div>
				</fieldset>
				<hr/>
			<div class="fieldset1" id="1" style="">
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">電腦名稱</label>
					<div class="col-md-6">
						<input type="text" required class="form-control" name="computer_name"  id="computer_name" value="<?= isset($item) ? $item -> computer_name : '' ?>"  />
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">電腦序號</label>
					<div class="col-md-6">
						<input type="text" required class="form-control" name="computer_num" id="computer_num" value="<?= isset($item) ? $item -> computer_num : '' ?>"  />
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">財產編號</label>
					<div class="col-md-6">
						<input type="text" class="form-control"  id="computer_property_num" value="<?= isset($item) ? $item -> computer_property_num : '' ?>"  />
					</div>
				</div>
			</fieldset>	
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">預設使用者</label>
					<div class="col-md-6">
						<input type="text" class="form-control"  id="admin_user" value="<?= isset($item) ? $item -> admin_user_id : '' ?>"  />
					</div>
				</div>
			</fieldset>	
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">硬體</label>
					<div class="col-md-6">
						<select class="form-group" id="c_h_name" style="width:100%"> 
						<option selected disabled style="display:none">請選擇</option>
							<?php foreach($computer_hard_list as $each): ?>
								<option value="<?= $each -> id?>" ><?=  $each -> computer_hard_name ?> (可使用次數剩餘：<?=  $each -> usage_count ?>)</option>
							<?php endforeach ?>
						</select> 
					</div>
					<div class="col-md-2">
						<button type="button" class="btn btn-sm btn-primary" onclick="select_h()"><i class="fa fa-plus-circle fa-lg"></i></button>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">軟體</label>
					<div class="col-md-6">
						<select class="form-group" id="c_s_name" style="width:100%"> 
						<option selected disabled style="display:none">請選擇</option>
							<?php foreach($computer_soft_list as $each): ?>
								<option value="<?= $each -> id?>" ><?=  $each -> computer_soft_name ?> (可使用次數剩餘：<?=  $each -> usage_count ?>)</option>
							<?php endforeach ?>
						</select> 
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
		<div class="fieldset1" id="2" style="display:none">
			<div>
				<label class="col-md-3" style="font-weight:bold;font-size:large;">已完成維修紀錄:</label>
				<table id="fix_list" class="table table-striped table-bordered table-hover" width="100%">
					<thead>
						<tr>
							<th class="min100">報修日期</th>
							<th class="min100">維修日期</th>
							<th class="min100">完修日期</th>
							<th class="min100">維修方式</th>
							<th class="min100">維修方法</th>
							<th class="min100">故障原因</th>
							<th class="min100">處置情形</th>
							<th class="min100">維修人員</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>

			</hr>
			
			<div>
				<label class="col-md-3" style="font-weight:bold;font-size:large;">維修中:</label>
				<table id="fix_listing" class="table table-striped table-bordered table-hover" width="100%">
					<thead>
						<tr>
							<th class="min100">報修日期</th>
							<th class="min100">維修日期</th>
							<th class="min100">完修日期</th>
							<th class="min100">維修方式</th>
							<th class="min100">維修方法</th>
							<th class="min100">故障原因</th>
							<th class="min100">處置情形</th>
							<th class="min100">維修人員</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>

		</div>
			</form>

		</div>
		<!-- end widget content -->

	</div>
	<!-- end widget div -->

</div>
<!-- end widget -->
<script src="http://www.appelsiini.net/download/jquery.jeditable.mini.js"></script>

<style>
	.kv-file-zoom {
		display: none;
	}
</style>

<script>
$(document).ready(function() {
	$('#c_h_name').select2();
	$('#c_s_name').select2();
});



function showmefieldset(id) {
	//   document.getElementById(id).show();
	$('.fieldset1').hide();
	$('#'+id).show();
	$('.btn_roles').removeClass('btn_1');
	$('.'+id).addClass('btn_1');
}

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

var computer_hard_id_array = [];//存取硬體新的所有料
var computer_soft_id_array = [];//存取軟體新的所有料
var soft_id_array = [];//只存取軟體新的id
var hard_id_array = [];//只存取硬體新的id
var computer_old_h = [];//存取舊有硬體id
var computer_old_s = [];//存取舊有軟體id

function do_save() {
			var url = baseUrl + 'mgmt/computer/insert'; // the script where you handle the form input.
			$.ajax({
				type : "POST",
				url : url,
				data : {
					id: $('#item_id').val(),
					computer_name: $('#computer_name').val(),
					computer_num: $('#computer_num').val(),
					computer_property_num: $('#computer_property_num').val(),
					admin_user: $('#admin_user').val(),
					hard_id_array: hard_id_array.join(","),
					soft_id_array: soft_id_array.join(","),
				},
				success : function(data) {
					if(data.error_msg) {
						layer.msg(data.error_msg);
					} else {
						currentApp.mDtTable.ajax.reload(null, false);
						currentApp.backTo();
					}
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


	function select_h() {
		var $c_h_id = $('#c_h_name');
		var c_h_id = $c_h_id.val();
		if(c_h_id<1){
			alert('請選擇要使用硬體');
			return
		}
		$.ajax({
			url: baseUrl + 'mgmt/computer/add_useful',
			type: 'POST',
			data: {
				c_h_id: c_h_id
			},
			dataType: 'json',
			success: function(d) {
				if(d) {
					computer_hard_id_array.push({
						id: d.last_hard_id,
						hard_name: d.hard_name,
						hard_num: d.hard_num,
					});
				
					hard_id_array.push(d.last_hard_id);

					redraw();
				}
			},
			failure:function(){
				alert('faialure');
			}
		});
	}

	function select_s() {
		var $c_s_id= $('#c_s_name');
		var c_s_id = $c_s_id.val();
		if(c_s_id<1){
			alert('請選擇要使用軟體');
			return
		}
		$.ajax({
			url: baseUrl + 'mgmt/computer/add_useful',
			type: 'POST',
			data: {
				c_s_id: c_s_id
			},
			dataType: 'json',
			success: function(d) {
				if(d) {
					computer_soft_id_array.push({
						id: d.last_soft_id,
						soft_name: d.soft_name,
						soft_num: d.soft_num,
					});
					soft_id_array.push(d.last_soft_id);
					redraw();
				}
			},
			failure:function(){
				alert('faialure');
			}
		});
	}

	function redraw() {
		// console.log(computer_num_array);
		var $hard_list = $('#hard_list').empty();
		var $soft_list = $('#soft_list').empty();

		$.each(computer_hard_id_array, function(){
			var me = this;
			var $now_hard_list = $('<div><span style="color:red;" computer_hard_id="'+me.id+'">'+me.hard_name+'</span><button onclick="do_del_h('+me.id+');"><i class="fa fa-trash fa-lg"></i></button><div>').appendTo($hard_list);
		});
		$.each(computer_soft_id_array, function(){
			var me = this;
			var $now_soft_list = $('<div><span style="color:red;" computer_soft_id="'+me.id+'">'+me.soft_name+'</span><button onclick="do_del_s('+me.id+');"><i class="fa fa-trash fa-lg"></i></button><div>').appendTo($soft_list);
		});
	}

	function drawfirst() {
		var $hard_list = $('#hard_list').empty();
		var $soft_list = $('#soft_list').empty();
		var $item_id = $('#item_id').val();
		if($item_id===''){
			return;
		}
		$.ajax({
			url: baseUrl + 'mgmt/computer/find_now_s_h_list',
			type: 'POST',
			data: {
				computer_id: $('#item_id').val(),
			},
			dataType: 'json',
			success: function(d) {
				if(d) {
					$.each(d.hard_list, function(){
						var me = this;
						computer_old_h.push(me.id);
						var $now_hard_list = $('<div><span computer_hard_id="'+me.id+'">'+me.hard_name+'</span><button onclick="do_del_h('+me.id+');"><i class="fa fa-trash fa-lg"></i></button><div>').appendTo($hard_list);
					});
					$.each(d.soft_list, function(){
						var me = this;
						computer_old_s.push(me.id);
						var $now_soft_list = $('<div><span computer_soft_id="'+me.id+'">'+me.soft_name+'</span><button onclick="do_del_s('+me.id+');"><i class="fa fa-trash fa-lg"></i></button><div>').appendTo($soft_list);
					});
				}
			},
			failure:function(){
				alert('faialure');
			}
		});
	
	}

	drawfirst();

	currentApp.fixrecord = new FixrecordAppClass(new BaseAppClass({}));
	currentApp.fixrecording = new FixrecordingAppClass(new BaseAppClass({}));



	function save_fix(){
        $.ajax({
            url: '<?= base_url() ?>' + 'mgmt/computer/update_fix_type',
            type: 'POST',
            data: {
				fix_record_id: $('#fix_record_id').val(),
                fix_type: $('#fix_type').val(),
                fix_date: $('#fix_date').val(),
                done_fix_date: $('#done_fix_date').val(),
				fix_way: $('#fix_way').val(),
                fix_reason: $('#fix_reason').val(),

            },
            dataType: 'json',
            success: function(d) {
                if(d.success) {
					currentApp.fixrecord.tableReload();
					currentApp.fixrecording.tableReload();
					$('#fixModal').modal('hide');
                }
            },
            failure:function(){
                alert('faialure');
            }
        });
	}

</script>
