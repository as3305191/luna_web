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
						<label class="col-md-2 control-label">工單編號</label>
						<div class="col-md-10">
							<input type="text" class="form-control" name="sn"  value="<?= isset($item) ? $item -> sn : '' ?>" <?= isset($item) ? 'readonly' : '' ?> placeholder="若留空系統會自動產生" />
						</div>
					</div>
				</fieldset>
				<fieldset>
					<div class="form-group">
						<label class="col-md-2 control-label">工單編號SAP</label>
						<div class="col-md-10">
							<input type="text" class="form-control" name="sn_sap"  value="<?= isset($item) ? $item -> sn_sap : '' ?>"  readonly />
						</div>
					</div>
				</fieldset>
				<fieldset>
					<div class="form-group">
						<label class="col-md-2 control-label">工單執行日期</label>
						<div class="col-md-10">
							<input type="text" class="form-control dt_picker"  name="start_time"  value="<?= isset($item) ? $item -> start_time : '' ?>"  />
						</div>
					</div>
				</fieldset>
				<fieldset>
					<div class="form-group">
						<label class="col-md-2 control-label">完工日期</label>
						<div class="col-md-10">
							<input type="text" class="form-control dt_picker"  name="finish_time"  value="<?= isset($item) ? $item -> finish_time : '' ?>"  />
						</div>
					</div>
				</fieldset>

				<hr/>
				<fieldset>
					<div class="form-group">
						<label class="col-md-2 control-label">工站列表</label>

						<div class="col-md-10">
							<button class="btn btn-warning btn-xs" onclick="doSearchStation()">
								<i class="fa fa-plus"></i>新增
							</button>
							<table class="table">
								<thead>
									<tr>
										<td class="min100">工站名稱</td>
										<td></td>
									</tr>
								</thead>
								<tbody id="station_list_body">

								</tbody>
							</table>
						</div>
					</div>
				</fieldset>
				<hr/>

				<fieldset>
					<div class="form-group">
						<label class="col-md-2 control-label">原料列表</label>
						<div class="col-md-10">
							<button class="btn btn-warning btn-xs" onclick="doSearchType0Product()">
								<i class="fa fa-plus"></i>新增
							</button>

							<table class="table table-hover">
								<thead>
									<tr>
										<td class="min100">料號</td>
										<td class="min100">品名</td>
										<td class="min100">櫃號</td>
										<td class="min100">批號</td>
										<td class="min100">需求重量(KG)</td>
										<td class="min100">實際重量(KG))</td>
										<td class="min150">解凍方式/日期</td>
										<td></td>
									</tr>
								</thead>
								<tbody id="type_0_product_list_body">

								</tbody>
							</table>
						</div>
					</div>
				</fieldset>
				<hr/>

				<fieldset>
					<div class="form-group">
						<label class="col-md-2 control-label">成品列表</label>
						<div class="col-md-10">
							<button class="btn btn-warning btn-xs" onclick="doSearchType2Product()">
								<i class="fa fa-plus"></i>新增
							</button>

							<table class="table table-hover">
								<thead>
									<tr>
										<td class="min100">料號</td>
										<td class="min100">品名</td>
										<td class="min100">櫃號</td>
										<td class="min100">批號</td>
										<td class="min100">需求重量</td>
										<td class="min100">實際重量</td>
										<td></td>
									</tr>
								</thead>
								<tbody id="type_2_product_list_body">

								</tbody>
							</table>
						</div>
					</div>
				</fieldset>
				<hr/>

				<fieldset>
					<div class="form-group">
						<label class="col-md-2 control-label">狀態</label>
						<div class="col-md-10">
							<select name="status" class="form-control">
								<option value="0" <?= isset($item) && $item -> status == 0 ? 'selected' : '' ?>>未完工</option>
								<option value="1" <?= isset($item) && $item -> status == 1 ? 'selected' : '' ?>>已完工</option>
								<option value="-1" <?= isset($item) && $item -> status == -1 ? 'selected' : '' ?>>取消</option>
							</select>
						</div>
					</div>
				</fieldset>
				<fieldset>
					<div class="form-group">
						<label class="col-md-2 control-label">備註</label>
						<div class="col-md-10">
							<textarea class="form-control"  name="note"><?= isset($item) ? $item -> note : '' ?></textarea>
						</div>
					</div>
				</fieldset>

				<fieldset>
					<div class="form-group">
						<label class="col-md-2 control-label">上傳時間</label>
						<div class="col-md-10">
							<input type="text" class="form-control"  name="op_datetime" readonly value="<?= isset($item) ? $item -> op_datetime : '' ?>"  />
						</div>
					</div>
				</fieldset>

				<fieldset>
					<div class="form-group">
						<label class="col-md-2 control-label">更新時間</label>
						<div class="col-md-10">
							<input type="text" class="form-control" readonly value="<?= isset($item) ? $item -> update_time : '' ?>"  />
						</div>
					</div>
				</fieldset>
				<fieldset>
					<div class="form-group">
						<label class="col-md-2 control-label">最後更新人員</label>
						<div class="col-md-10">
							<input type="text" class="form-control" readonly value="<?= isset($item) ? $item -> update_user_name : '' ?>"  />
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

	// station list
	var stationListStore = [];
	function reloadStationList() {
		var url = baseUrl + currentApp.basePath + 'station_list'; // the script where you handle the form input.
		$.ajax({
			type : "POST",
			url : url,
			data : {
				order_id: $('#item_id').val()
			},
			success : function(data) {
				stationListStore = data.list;
				redrawStationList();
			}
		});
	}

	function redrawStationList() {
		var $body = $('#station_list_body').empty();
		var cnt = 0;
		$.each(stationListStore, function(){
			var me = this;
			me._idx = cnt++;

			if(!me.is_del) {
				var $tr = $('<tr />');
				$td = $("<td></td>").text(me.name).appendTo($tr);
				$td = $("<td></td>").append($('<button class="btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>').click(function(){
					if(me.id > 0) {
						me.is_del = 1; // mark del
					} else { // remove it
						stationListStore.splice(me._idx, 1);
					}
					redrawStationList();
				})).appendTo($tr);
				$body.append($tr);
			}

		})
	}
	reloadStationList();

	function doSearchStation() {
		stationChange();
		$('#stationEditModal').modal('show');
		$('#s-station-name').val('').trigger("change");
	}

	function stationChange(){
		var url = baseUrl + currentApp.basePath + 'station_search'; // the script where you handle the form input.
		if($.stationXhr) {
			$.stationXhr.abort();
		}
		$.stationXhr = $.ajax({
			type : "POST",
			url : url,
			data : {
				q: $('#s-station-name').val()
			},
			success : function(data) {
				var $body = $('#station_list_serach_body').empty();
				$.each(data.list, function(){
					var me = this;
					var $tr = $('<tr class="pointer"></tr>').appendTo($body);


					var $lb = $("<label></label>");
					var $input = $("<input type='checkbox' />");

					$tr.on("click", function(){
						$input.trigger("click");
					});

					// hide exists
					$.each(stationListStore, function(){
						var station = this;
						if(!station.is_del && station.station_id == me.station_id) {
							$input.prop("disabled", true);
							$lb.addClass("disabled");
						}
					})

					$input.click(function(){
						var _isChecked = $input.is(":checked");
						var _canInsert = true;
						$.each(stationListStore, function(){
							var station = this;
							if(!station.is_del && station.station_id == me.station_id) {
								_canInsert = false;
							}
						})

						if(_canInsert) {
							// $('#stationEditModal').modal('hide');
							if(_isChecked) {
								stationListStore.push(me);
								redrawStationList();
							}
						} else {
							// layui.layer.msg("重複新增");
							if(!_isChecked) {
								console.log('remove')
								// remove checked
								var cnt = 0;
								$.each(stationListStore, function(){
									var aStation = this;
									aStation._idx = cnt++;
									if(aStation.station_id == me.station_id) {
										if(!aStation.is_del) {
											if(aStation.id > 0) {
												aStation.is_del = 1; // mark del
											} else { // remove it
												stationListStore.splice(aStation._idx, 1);
											}
											redrawStationList();
										}
									}
								})
							}
						}
					});

					$lb.append(me.name);
					$('<td>').append($input).append($lb).appendTo($tr);
				})
			}
		});
	}

	stationChange();

	// $('#s-station-name').on("change keyup", function(){
	// 	stationChange();
	// });


	function productChange(){
		var url = baseUrl + currentApp.basePath + 'product_search'; // the script where you handle the form input.
		if($.porductXhr) {
			$.porductXhr.abort();
		}
		$.porductXhr = $.ajax({
			type : "POST",
			url : url,
			data : {
				q: $('#s-type-product-name').val()
			},
			success : function(data) {
				var $body = $('#product_list_serach_body').empty();
				$.each(data.list, function(){
					var me = this;
					var $tr = $('<tr class="pointer">').click(function(){
						$('#s-type-product-name').val('');
						productChange();

						$._product_obj.lot_number = me.lot_number;
						$._product_obj.name = me.name;
						$._product_obj.product_id = me.product_id;
						renderProductForm();

 					}).appendTo($body);
					$('<td>').html(me.lot_number).appendTo($tr);
					$('<td>').html(me.name).appendTo($tr);
				})
			}
		});
	}



	//
	var type0ProductStore = [];
	var type2ProductStore = [];
	function reloadProductList(type) {
		var url = baseUrl + currentApp.basePath + 'product_list'; // the script where you handle the form input.
		$.ajax({
			type : "POST",
			url : url,
			data : {
				order_id: $('#item_id').val(),
				type: type
			},
			success : function(data) {
				if(type == 0) {
					type0ProductStore = data.list;
					redrawType0ProductList();
				}
				if(type == 2) {
					type2ProductStore = data.list;
					redrawType2ProductList();
				}
			}
		});
	}

	function redrawType0ProductList() {
		var $body = $('#type_0_product_list_body').empty();

		var cnt = 0;
		$.each(type0ProductStore, function(){
			var me = this;
			me._idx = cnt++;
			if(me.is_del && me.is_del == 1) {
				return;
			}

			var $tr = $('<tr class="pointer" />');
			$td = $("<td></td>").text(me.lot_number).appendTo($tr);
			$td = $("<td></td>").text(me.name).appendTo($tr);
			$td = $("<td></td>").text(me.container_sn).appendTo($tr);
			$td = $("<td></td>").text(me.trace_batch).appendTo($tr);
			$td = $("<td></td>").text(me.weight).appendTo($tr);
			$td = $("<td></td>").text(me.actual_weight).appendTo($tr);

			var exTxt = me.thaw_id > 0 ? getThawName(me.thaw_id) + "/" + me.thaw_date : '';
			if(me.thaw_expire && me.thaw_expire > 0) {
				exTxt += $('<font color="red">').html(" - 逾期" + me.thaw_expire  +"天").prop("outerHTML");
			}
			$td = $("<td></td>").html(exTxt).appendTo($tr);
			$td = $("<td></td>").appendTo($tr);
			$('<button class="btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>').click(function(){
				if(confirm("確定刪除?")) {
					if(me.id > 0) {
						me.is_del = 1; // mark del
					} else { // remove it
						type0ProductStore.splice(me._idx, 1);
					}
					redrawType0ProductList();
				}
			}).appendTo($td);

			$tr.find("td:not(:last-child)").click(function(){
				$._product_type = 0;
				$._product_obj = me;
				showProductModal();
			});

			$body.append($tr);
		})
	}

	reloadProductList(0); // 讀取原料

	function redrawType2ProductList() {
		var $body = $('#type_2_product_list_body').empty();

		var cnt = 0;

		$.each(type2ProductStore, function(){
			var me = this;
			me._idx = cnt++;
			if(me.is_del && me.is_del == 1) {
				return;
			}

			var $tr = $('<tr class="pointer" />');
			$td = $("<td></td>").text(me.lot_number).appendTo($tr);
			$td = $("<td></td>").text(me.name).appendTo($tr);
			$td = $("<td></td>").text(me.container_sn).appendTo($tr);
			$td = $("<td></td>").text(me.trace_batch).appendTo($tr);
			$td = $("<td></td>").text(me.weight).appendTo($tr);
			$td = $("<td></td>").text(me.actual_weight).appendTo($tr);
			$td = $("<td></td>").appendTo($tr);

			$('<button class="btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>').click(function(){
				if(confirm("確定刪除?")) {
					if(me.id > 0) {
						me.is_del = 1; // mark del
					} else { // remove it
						type2ProductStore.splice(me._idx, 1);
					}
					redrawType2ProductList();
				}
			}).appendTo($td);

			$tr.find("td:not(:last-child)").click(function(){
				$._product_type = 2;
				$._product_obj = me;
				showProductModal();
			});
			$body.append($tr);
		})
	}

	reloadProductList(2); // 讀取成品

	function renderProductForm() {
		$('#product_lot_number').val($._product_obj.lot_number);
		$('#product_name').val($._product_obj.name);
		$('#product_weight').val($._product_obj.weight);
		$('#product_actual_weight').val($._product_obj.actual_weight);
		$('#product_container_sn').val($._product_obj.container_sn);
		$('#product_batch').val($._product_obj.trace_batch);
		$('#product_sloc').val($._product_obj.sloc);
		$('#product_thaw_id').val($._product_obj.thaw_id);
		$('#product_thaw_date').val($._product_obj.thaw_date);
	}

	function doSearchType0Product() {
		$._product_type = 0;
		$._product_obj = {
			"id": 0,
			"is_add": 1,
			'product_id' : 0,
			'lot_number' : '',
			'name' : '',
			'weight' : '',
			'actual_weight' : '',
			'container_sn' : '',
			'trace_batch' : '',
			'sloc' : '',
			'thaw_id' : '0',
			'thaw_date' : '',
		};
		showProductModal();
	}

	function doSearchType2Product() {
		$._product_type = 2;
		$._product_obj = {
			"id": 0,
			"is_add": 1,
			'product_id' : 0,
			'lot_number' : '',
			'name' : '',
			'weight' : '',
			'actual_weight' : '',
			'container_sn' : '',
			'trace_batch' : '',
			'sloc' : '',
			'thaw_id' : '0',
			'thaw_date' : '',
		};
		showProductModal();
	}

	function showProductModal() {
		$('#productSearchModal').modal('show');
		renderProductForm();
		$('#s-type-product-name').val('');
		productChange();
	}

	function saveProductItem() {
		var store;
		// create
		if($._product_type == 0) {
			store = type0ProductStore;
		}
		if($._product_type == 2) {
			store = type2ProductStore;
		}

		$._product_obj.weight = $("#product_weight").val();
		$._product_obj.actual_weight = $("#product_actual_weight").val();
		$._product_obj.trace_batch = $("#product_batch").val();
		$._product_obj.sloc = $("#product_sloc").val();
		$._product_obj.container_sn = $("#product_container_sn").val();
		$._product_obj.thaw_id = $("#product_thaw_id").val();
		$._product_obj.thaw_date = $("#product_thaw_date").val();

		if($._product_obj.id == 0 && $._product_obj.is_add && $._product_obj.is_add == 1) {
			var _canInsert = true;
			$.each(store, function(){
				var me = this;
				console.log(me.lot_number);
				console.log($._product_obj.lot_number);
				console.log(me.trace_batch);
				console.log($._product_obj.trace_batch);
				console.log(me.container_sn);
				console.log($._product_obj.container_sn);
				if(me.lot_number == $._product_obj.lot_number
						&& me.trace_batch == $._product_obj.trace_batch
						&& me.container_sn == $._product_obj.container_sn) {
					_canInsert = false;
				}
			})
			if(!_canInsert) {
				layui.layer.msg("重複新增");
				return;
			}

			$._product_obj.is_add = 0; // unset is_add
			store.push($._product_obj);
		}



		$('#productSearchModal').modal('hide');

		if($._product_type == 0) {
			redrawType0ProductList();
		}
		if($._product_type == 2) {
			redrawType2ProductList();
		}
	}

</script>
