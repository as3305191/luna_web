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
					<label class="col-md-3 control-label">硬體名稱</label>
					<div class="col-md-6">
						<input type="text" required class="form-control"  name="computer_hard_name" value="<?= isset($item) ? $item -> computer_hard_name : '' ?>"  />
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
				<label class="col-md-3 control-label">序號</label>

					<div class="col-md-2">
						<input id="spec_name" type="text" class="form-control" name="spec_name" placeholder="序號" />
					</div>
					<div class="col-md-2">
						<button type="button" class="btn btn-sm btn-primary" onclick="addSpec()"><i class="fa fa-plus-circle fa-lg"></i></button>
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
						<fieldset>
							<div class="form-group">
								<div class="col-md-12">
									<div id="product_spec_list">

									</div>
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

	var specStore = [];
	function addSpec() {
		var $specName = $('#spec_name');
		var specName = $specName.val();
		if(specName.length == 0) {
			alert('請輸序號名稱');
			return;
		}
		$.ajax({
			url: baseUrl + 'mgmt/computer_hard/add_number',
			type: 'POST',
			data: {
				spec_name: specName,
				product_id: $('#product_id').val()
			},
			dataType: 'json',
			success: function(d) {
				if(d.spec) {
					$specName.val(''); // reset
					specStore.push({
						id: d.spec.id,
						product_id: d.spec.product_id,
						spec_name: d.spec.spec_name,
						pos: d.spec.pos,
						details: []
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
		var $specList = $('#product_spec_list').empty();
		$.each(specStore, function(){
			var me = this;
			if(me.status && me.status == 1) {
				return;
			}

			var $a_div = $('<div class="row"></div>').appendTo($specList);
			var $b_div = $('<div class="row"></div>').appendTo($specList);
			var $dBoxDiv = $('<div></div>');
			$b_div.after($dBoxDiv);

			var editable = $('<input type="text" class="form-control input-xs" />')
			.val(me.spec_name)
			.on('change', function(){
				me.spec_name = $(this).val();
			});
			$a_div.append($('<div class="col-sm-3"></div>').append(editable));

			var oDiv = $('<div class="col-sm-3"></div>').appendTo($b_div);
			var mName = $('<input type="text" class="form-control input-xs" placeholder="請輸入序號" value="">')
				.appendTo(oDiv);

		
			// 複選
			oDiv = $('<div class="col-sm-2"></div>').appendTo($a_div);
			var mulCheck = $('<input type="checkbox" />').on('change', function(){
				if($(this).is(":checked")) {
					me.is_multiple = 1;
				} else {
					me.is_multiple = 0;
				}
			});

			if(me.is_multiple && me.is_multiple == 1) {
				mulCheck.prop('checked', true);
			}


			$('<label></label>')
				.append(mulCheck)
				.append('複選')
				.appendTo(oDiv);

			// 必填
			var isRequiredCheck = $('<input type="checkbox" />').on('change', function(){
				if($(this).is(":checked")) {
					me.is_required = 1;
				} else {
					me.is_required = 0;
				}
			});

			if(me.is_required && me.is_required == 1) {
				isRequiredCheck.prop('checked', true);
			}

			$('<label></label>')
				.append(isRequiredCheck)
				.append('必填')
				.appendTo(oDiv);

			// 順序
			oDiv = $('<div class="col-sm-2"></div>').appendTo($a_div);

			$('<label style="float:left;"></label>')
				.append('順序')
				.appendTo(oDiv);

			$('<input type="number" class="form-control input-xs" style="width:50px; float:left;" />')
			.val(me.pos)
			.on('change', function(){
				me.pos = $(this).val();
			})
			.appendTo(oDiv);

			// ---
			oDiv = $('<div class="col-sm-1"></div>').appendTo($b_div);
			$('<button type="button" class="btn btn-xs btn-primary"><i class="fa fa-plus-circle fa-lg"></i></button>')
				.on('click', function(){
					var err = [];
					if(mName.val().length == 0) {
						err.push('請輸入名稱');
					}
					if(mPrice.val().length == 0) {
						err.push('請輸入價格');
					}
					if(mPos.val().length == 0) {
						err.push('請輸入順序');
					}

					if(err.length > 0) {
						alert(err.join(','));
						return;
					}
					me.details.push({
						id:0,
						spec_id: me.spec_id,
						detail_name: mName.val(),
						price_diff: mPrice.val(),
						pos: mPos.val()
					});

					redrawSpec();
				})
				.appendTo(oDiv);

				oDiv = $('<div class="col-sm-2"></div>').appendTo($a_div);
				oDiv = $('<div class="col-sm-1"></div>').appendTo($a_div);
				$('<button type="button" class="btn btn-xs btn-warning"><i class="fa fa-minus-circle fa-lg"></i></button>')
					.on('click', function(){
						if(me.id == 0) {
							specStore.splice( $.inArray(me, specStore), 1 );
						} else {
							me.status = 1; // mark as remove
						}

						redrawSpec();
					})
					.appendTo(oDiv);

				// details
				$.each(me.details, function(){
					var aDetail = this;
					if(aDetail.status && aDetail.status == 1) {
						return;
					}
					$dDiv = $('<div class="row"></div>').appendTo($dBoxDiv);

					editable = $('<input type="text" class="form-control input-xs" style="width:100px;" />')
					.val(aDetail.detail_name)
					.on('change', function(){
						aDetail.detail_name = $(this).val();
					});

					$('<div class="col-sm-3"></div>').append(editable).appendTo($dDiv);

					editable = $('<input type="number" class="form-control input-xs" style="width:100px;" />')
					.val(aDetail.price_diff)
					.attr('readonly', true)
					.on('change', function(){
						aDetail.price_diff = $(this).val();
					});

					$('<div class="col-sm-3"></div>').append(editable).appendTo($dDiv);

					// pos
					editable = $('<input type="number" class="form-control input-xs" style="width:100px;" />')
					.val(aDetail.pos)
					.on('change', function(){
						aDetail.pos = $(this).val();
					});

					$('<div class="col-sm-3"></div>').append(editable).appendTo($dDiv);

					editable = $('<button type="button" class="btn btn-xs btn-error"><i class="fa fa-minus-circle fa-lg"></i></button>')
						.on('click', function(){
							if(aDetail.id == 0) {
								me.details.splice( $.inArray(aDetail, me.details), 1 );
							} else {
								aDetail.status = 1; // mark as remove
							}

							redrawSpec();
						});
						$('<div class="col-sm-3"></div>').append(editable).appendTo($dDiv);
				});
		});
	}

</script>
