<style>
.file-drag-handle {
	display: none;
}

.nono {
	display: none;
}
.table td {
	padding: 20px!important;
}

.table .row>.col, .table .row>[class^=col-] {
    padding-top: .75rem;
    padding-bottom: .75rem;
    background-color: rgba(86,61,124,.15);
    border: 1px solid rgba(86,61,124,.2);
}

.table .row > :nth-child(3n), .table .row > :nth-child(3n-1){
  background-color: #dcdcdc;
}
.table .row > :nth-child(3n-2){
  background-color: #aaaaaa;
}

</style>
<!-- Widget ID (each widget will need unique ID)-->
<div class="jarviswidget" id="wid-id-7" data-widget-colorbutton="false"	data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
	<header>
		<div class="widget-toolbar pull-left">
			<a href="javascript:void(0);" id="back_parent" onclick="currentApp.backTo()" class="btn btn-default ">
				<i class="fa fa-arrow-circle-left"></i>返回
			</a>
			<?php if ($is_stock->id==1): ?>
				<a href="javascript:void(0);" onclick="doSearchType2Product()" class="btn btn-default ">
					領料
				</a>
			<?php else: ?>
			<?php endif; ?>
		</div>
	</header>
	<!-- widget div-->
	<div id="page">
		<!-- widget edit box -->
		<div class="jarviswidget-editbox">
			<!-- This area used as dropdown edit box -->
			<input class="form-control" type="text">
		</div>
		<!-- end widget edit box -->
		<!-- widget content -->
		<fieldset class="form-group no-padding">
			<div class="form-group no-padding">
				<div class="col-md-12 no-padding">
					<label class="col-md-2 control-label">原料列表</label>
					<table class="table table-hover">
						<thead>
							<tr>
								<td class="min100">料號</td>
								<td class="min150">品名</td>
								<td class="min100">櫃號</td>
								<td class="min100">批號</td>
								<td class="min100">需求重量(KG)</td>
								<td class="min100">實際重量(KG))</td>
								<td class="min150">解凍方式/日期</td>
							</tr>
						</thead>
						<tbody id="">
							<?php foreach($type_0_list as $each): ?>
								<tr>
									<td><?= $each -> lot_number ?></td>
									<td><?= $each -> name ?></td>
									<td><?= $each -> container_sn ?></td>
									<td><?= $each -> trace_batch ?></td>
									<td><?= $each -> weight ?></td>
									<td><?= $each -> actual_weight ?></td>
									<td><?= $each -> thaw_name ?>/<?= $each -> thaw_date ?></td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				</div>
			</div>
		</fieldset>
		<div class="widget-body table-responsive">
			<input id="order_id"  name="" type="hidden" value="<?= !empty($sop->file_id) ?$sop->file_id: ''?>">
			<input id="market_sop"  name="" type="hidden" value="<?= !empty($sop->file_id) ?$sop->file_id: ''?>">
			<input id="st_id1" name="" type="hidden" value="">
			<table class="table table-striped">
				<thead>
					<tr>
						<th class="min100">工站</th>
						<th class="" style="max-wdith: 25%; width: 30%;">發料統計</th>
						<th class="" style="max-wdith: 25%; width: 30%;">收料統計</th>
						<th class="" style="max-wdith: 40%; width: 30%">即時商品流向</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($order_station_list as $each): ?>
						<tr>
							<td><?= $each -> name ?></td>
							<td>
								<div class="">
								<?php foreach($each -> osr_product_list_0 as $each_product): ?>
									  <div class="row show-grid">
									    <div class="col-md-6">
									      <?= $each_product -> product_name ?>
									    </div>
									    <div class="col-md-3">
									      <?= $each_product -> total_number ?>
									    </div>
									    <div class="col-md-3">
									      <?= number_format($each_product -> total_weight, 2)  ?>
									    </div>
									  </div>
								<?php endforeach ?>
								</div>
							</td>
							<td>
								<div class="">
								<?php foreach($each -> osr_product_list as $each_product): ?>
									  <div class="row show-grid">
									    <div class="col-md-5">
									      <?= $each_product -> product_name ?>
									    </div>
									    <div class="col-md-3">
									      <?= $each_product -> total_number ?>
									    </div>
									    <div class="col-md-4">
									      <?= number_format($each_product -> total_weight, 2)  ?>
									    </div>
									  </div>
								<?php endforeach ?>
								</div>
							</td>
							<td>
								<div class="">
								<?php foreach($each -> or_product_list as $each_product): ?>
									  <div class="row show-grid ">
									    <div class="col-md-6" >
												<input id="tra_ba"  type="hidden" value="<?="20".substr($each_product->psn, 7, 6).substr($each_product->psn, -2)?>">
									      <?= $each_product -> product_name ?>
												<?php if ($is_stock->is_stock==1 && $is_stock->id!==$each_product->station_id): ?>
													<?php if ($each_product->station_id ==1 || $each_product->station_id ==8 || $each_product->station_id ==105 || $each_product->station_id ==106 || $each_product->station_id ==110): ?>
													<?php else: ?>
														<div id="rceipt" style="float:right;">
															<span style="color:red;float:right;cursor:pointer;" onclick="show_rceipt(<?=$each_product->order_id?>,<?=$each_product->product_id?>,'<?=$each_product->psn?>',<?=$is_stock->is_stock?>,<?=$each_product->station_id?>)">收料</span>
														</div>
													<?php endif; ?>
													<?php else: ?>
												<?php endif; ?>
												<?php if ($each_product->station_id ==1 || $each_product->station_id ==8 || $each_product->station_id ==105 || $each_product->station_id ==106 || $each_product->station_id ==110): ?>
													<?php if ($each_product->storage==1 ): ?>
													<div id="rceipt" style="float:right;">
														<span style="color:red;float:right;cursor:pointer;" onclick="mantissa('<?=$each_product->order_id?>','<?=$each_product->product_id?>','<?=$each_product->psn?>','<?=$is_stock->is_stock?>','<?=$each_product->station_id?>','<?=$each_product->actual_weight?>','<?=$each_product->note?>','<?=$each_product->thaw_date?>'
															,'<?=$each_product->thaw_id?>','<?=$each_product->container_sn?>','<?=$each_product->fty?>','<?=$each_product->batch?>','<?=$each_product->sloc?>','<?=$each_product->storage?>','<?=$each_product->id?>','<?=$each_product->from_station_id?>')">額外收料</span>
													</div>
													<?php endif; ?>
												<?php else: ?>
												<?php endif; ?>
											</div>
									    <div class="col-md-2">
									      <?= $each_product -> total_number ?>
									    </div>
									    <div class="col-md-2">
									      <?= number_format($each_product -> total_weight, 2) ?>
									    </div>
											<?php if ($is_stock->id==1 && $item->status==0 && $each_product->from_station_id==0 && $each_product->storage==0): ?>
												<div class="col-md-2" >
													<a style="margin-right:5px;"id="delete_o" onclick="show_delete(<?=$each_product->id?>)"><i class="fa fa-trash fa-lg"></i></a>
													<?php if (empty($each_product -> psn)): ?>
														<span style="color:red;float:right;cursor:pointer;" onclick="new_psn(<?=$each_product->id?>)">編輯</span>
													<?php endif; ?>
												</div>
											<?php else: ?>
											<?php endif; ?>
									  </div>
								<?php endforeach ?>
								</div>
							</td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
		<!-- end widget content -->
	</div>
	<!-- end widget div -->
</div>
<!-- end widget -->
<style>
</style>
<script>
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
		var id ='<?=$item->id?>'
		$('#productSearchModal').modal('show');
		$('#order_id_1').val(id);

		renderProductForm();

		$('#s-type-product-name').val('');
		productChange();
	}

	function show_delete(id) {
		$('#or').val(id);
		$('#delete_m').modal('show');

	}

	function new_psn(id) {
		$('#or1').val(id);
		$('#barcodeModal').modal('show');
	}

	function mantissa(order_id,product_id,psn,
		station_id,actual_weight,note,thaw_date,thaw_id,container_sn,fty,batch,sloc,storage,id,from_station_id) {
		var trace_batch = $('#tra_ba').val();
		$('#mantissaModal').modal('show');
		$('#order_id_m').val(order_id);
		$('#product_id_m').val(product_id);
		$('#psn_m').val(psn);
		$('#station_id_m').val(station_id);
		$('#trace_batch_m').val(trace_batch);
		$('#record_id').val(id);
	 	$('#from_station_id_m').val(from_station_id);
		$('#sloc_m').val(sloc);
		$('#storage_m').val(storage);
		$('#batch_m').val(batch);
		$('#fty').val(fty);
		$('#container_sn_m').val(container_sn);
		$('#thaw_id_m').val(thaw_id);
		$('#thaw_date_m').val(thaw_date);
		$('#note_m').val(note);
		$('#actual_weight').val(actual_weight);
	}

	function show_rceipt(order_id,product_id,psn,is_stock,station_id) {
		$('#rceiptModal').modal('show');
		$('#order_id_11').val(order_id);
		$('#product_id_11').val(product_id);
		$('#psn_11').val(psn);
		$('#is_stock_11').val(is_stock);
		$('#station_id_11').val(station_id);
		var trace_batch = $('#tra_ba').val();
		$('#trace_batch_11').val(trace_batch);
	}

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

	function barcode_search() {
		var url = '<?= base_url() ?>' + 'mgmt/orders_v2/barcode_search';
		$.ajax({
			url : url,
			type: 'POST',
			data: {
				psn: $('#barcode').val(),
			},
			dataType: 'json',
			success: function(d) {
				$('#body_2').addClass('s_sum');


				if(d.success=="true") {
					var me = d.list;
					$('#product_lot_number').val(me[0].lot_number);
				 	$('#product_name').val(me[0].name);
					$('#product_id_1').val(me[0].id);
					$('#order_id_1').val();
					$('#trace_batch_number').val(d.trace_batch_number);
				}
				if(d.error=="true") {
					alert('沒有此商品')
				}
			},
			failure:function(){
				alert('faialure');
			}
		});
	}

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
				$('#body_2').removeClass('s_sum');
				$.each(data.list, function(){
					var me = this;
					var $tr = $('<tr class="pointer">').click(function(){
						$('#s-type-product-name').val('');
						productChange();

						$._product_obj.lot_number = me.lot_number;
						$._product_obj.name = me.name;
						$._product_obj.product_id = me.product_id;
						$('#product_id_1').val(me.product_id);
						renderProductForm();
 					}).appendTo($body);
					$('<td>').html(me.lot_number).appendTo($tr);
					$('<td>').html(me.name).appendTo($tr);
				})
			}
		});
	}

	function saveProductItem1() {
		var url = '<?= base_url() ?>' + 'mgmt/orders_v2/barcode_insert';

		$.ajax({
			url : url,
			type: 'POST',
			data: {
				psn: $('#barcode').val(),
				order_id: $('#order_id_1').val(),
				product_id: $('#product_id_1').val(),
				station_id: $('#station_id_1').val(),
				product_lot_number: $('#product_lot_number').val(),
				product_name: $('#product_name').val(),
				container_sn: $('#product_container_sn').val(),
				product_sloc: $('#product_sloc_1').val(),
				all_weight: $('#all_weight').val(),
				all_pieces: $('#all_pieces').val(),
				trace_batch_number: $('#trace_batch_number').val(),
				factory_number: $('#factory_number').val(),
				barcode_psn: $('#barcode_psn').val()
			},
			dataType: 'json',
			success: function(d) {
				Vaildation();
				if(d.err_message=="true"){
					alert('工單未設定此原料，請先至工單管理設定');
				}
				if(d.success=="true") {
					currentApp.doEdit(currentApp.lastDoEditId);
				$('#productSearchModal').modal('hide');


				}
			},

			failure:function(){
				alert('faialure');
			}
		});
	}

	function savepsn() {
		var url = '<?= base_url() ?>' + 'api/order/update_barcode';

		$.ajax({
			url : url,
			type: 'POST',
			data: {
				psn: $('#psn_b').val(),
				id: $('#or1').val()
			},
			dataType: 'json',
			success: function(d) {
				Vaildation();
				if(d) {
					currentApp.doEdit(currentApp.lastDoEditId);
				$('#barcodeModal').modal('hide');
				}
			},

			failure:function(){
				alert('faialure');
			}
		});
	}

	function save_mantissa() {
		// var url = '<?= base_url() ?>' + 'api/order/transfer_station';
		var url = '<?= base_url() ?>' + 'mgmt/orders_v2/mantissa';
		$.ajax({
			url : url,
			type: 'POST',
			data: {
				order_id: $('#order_id_m').val(),
				product_id: $('#product_id_m').val(),
				weight: $('#mantissa_weight').val(),
				psn: $('#psn_m').val(),
				station_id: $('#station_id_m').val(),
				from_station_id: $('#from_station_id_m').val(),
				sloc: $('#sloc_m').val(),
				storage: $('#storage_m').val(),
				trace_batch: $('#trace_batch_m').val(),
				batch: $('#batch_m').val(),
				fty: $('#fty_m').val(),
				container_sn: $('#container_sn_m').val(),
				thaw_id: $('#thaw_id_m').val(),
				thaw_date: $('#thaw_date_m').val(),
				note: $('#note_m').val(),
				actual_weight: $('#actual_weight').val(),
				creat_id_m: $('#creat_id_m').val(),
				record_id: $('#record_id').val()
			},
			dataType: 'json',
			success: function(d) {
				Vaildation();
				if(d.success=="true"){
					$('#mantissaModal').modal('hide');
				}

			},

			failure:function(){
				alert('faialure');
			}
		});
	}

	function save_rceipt() {
		var url = '<?= base_url() ?>' + 'api/order/transfer_station';
		// var url = '<?= base_url() ?>' + 'mgmt/orders_v2/rceipt';
		$.ajax({
			url : url,
			type: 'POST',
			data: {
				order_id: $('#order_id_11').val(),
				product_id: $('#product_id_11').val(),
				weight: $('#a_weight').val(),
				number: $('#a_pieces').val(),
				psn: $('#psn_11').val(),
				is_stock: $('#is_stock_11').val(),
				to_station_id: $('#station_id_1').val(),
				from_station_id: $('#station_id_11').val(),
				sloc: $('#product_sloc_1').val(),
				trace_batch: $('#trace_batch_11').val()


			},
			dataType: 'json',
			success: function(d) {
				Vaildation();
				if(d){
					currentApp.doEdit(currentApp.lastDoEditId);
					$('#rceiptModal').modal('hide');
				}
				if(d.error_message=="超過庫存量"){
					alert('超過庫存量');
				}
			},

			failure:function(){
				alert('faialure');
			}
		});
	}

	function Vaildation() {
			$('.required').on('keydown keyup keypress change focus blur',function(){
				if($(this).val() == ''){
					$(this).css({backgroundColor: '#ffcccc'});
				}else{
					$(this).css({backgroundColor: '#fff'});

				}
			}).change();
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

	var mst = $('#station_id').val();
	$('#st_id1').val(mst);


	function do_delete() {
	var url = '<?= base_url() ?>' + 'mgmt/orders_v2/delete_or';
	$.ajax({
		url : url,
		type: 'POST',
		data: {
			id:$('#or').val()
		},
		dataType: 'json',
		success: function(d) {
			if(d.success=="true") {
				currentApp.doEdit(currentApp.lastDoEditId);
				$('#delete_m').modal('hide');

			}
		},
		failure:function(){
			alert('faialure');
		}

	});
	}

</script>
