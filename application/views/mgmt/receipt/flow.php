<style>
.file-drag-handle {
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

		<!-- <div class="widget-toolbar pull-left">
			<a href="javascript:void(0);" id="" onclick="currentApp.doSubmit()" class="btn btn-default btn-danger">
				<i class="fa fa-save"></i>存檔
			</a>
		</div> -->
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
		<div class="widget-body table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th class="min100">工站</th>
						<th class="" style="max-wdith: 400px; width: 400px;">即時商品流向</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($order_station_list as $each): ?>
						<tr>
							<td><?= $each -> name ?></td>
							<td>
								<div class="">
								<?php foreach($each -> or_product_list as $each_product): ?>
									<input id="tra_ba"  type="hidden" value="<?="20".substr($each_product->psn, 7, 6).substr($each_product->psn, -2)?>">

									  <div class="row show-grid">
									    <div class="col-md-6">
									      <?= $each_product -> product_name ?>
												<div class="pull-right">
													<?php if ($each_product->station_id ==1 || $each_product->station_id ==8 || $each_product->station_id ==105 || $each_product->station_id ==106 || $each_product->station_id ==110): ?>
														<?php if ($each_product->storage==1 ): ?>
														<div id="rceipt" style="float:left;">
															<span style="color:red;float:right;cursor:pointer;" onclick="mantissa('<?=$each_product->order_id?>','<?=$each_product->product_id?>','<?=$each_product->psn?>','<?=$each_product->station_id?>','<?=$each_product->actual_weight?>','<?=$each_product->note?>','<?=$each_product->thaw_date?>'
																,'<?=$each_product->thaw_id?>','<?=$each_product->container_sn?>','<?=$each_product->fty?>','<?=$each_product->batch?>','<?=$each_product->sloc?>','<?=$each_product->storage?>','<?=$each_product->id?>','<?=$each_product->from_station_id?>')">額外收料</span>
														</div>
														<?php endif; ?>
													<?php endif; ?>
													工單： <?= $each_product -> sn ?>
													<!-- <?= $each_product -> create_time ?> -->

												</div>
									    </div>
									    <div class="col-md-3">
									      <?= $each_product -> total_number ?>
									    </div>
									    <div class="col-md-3">
									      <?= number_format($each_product -> total_weight, 2) ?>
												<?php if ($each_product->station_id ==1 || $each_product->station_id ==8 || $each_product->station_id ==105 || $each_product->station_id ==106 || $each_product->station_id ==110): ?>
													<?php if ($each_product->storage==1 ): ?>
														<?php foreach($each_product->man_weight as $each_man_weight): ?>
															<div class="pull-right">
																已收料：<?= $each_man_weight ->man_weight ?>
										    			</div>
														<?php endforeach ?>
											<?php endif; ?>
										<?php endif; ?>
									    </div>

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

function Vaildation() {
		$('.required').on('keydown keyup keypress change focus blur',function(){
			if($(this).val() == ''){
				$(this).css({backgroundColor: '#ffcccc'});
			}else{
				$(this).css({backgroundColor: '#fff'});

			}
		}).change();
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
				location.reload();

			}

		},

		failure:function(){
			alert('faialure');
		}
	});
}
</script>
