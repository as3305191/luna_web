<style>
.s_sum {
	display: none;
}
</style>
<div class="tab-content">
	<div class="tab-pane active" id="list_page">

		<!-- widget grid -->
		<section id="widget-grid" class="">

			<!-- row -->
			<div class="row">

				<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget">
						<header>
							<div class="widget-toolbar pull-left">

							</div>

						</header>

						<!-- widget div-->
						<div>

							<!-- widget edit box -->
							<div class="widget-body table-responsive">
								<input id="order_id"  name="" type="hidden" value="<?= !empty($sop->file_id) ?$sop->file_id: ''?>">
								<input id="market_sop"  name="" type="hidden" value="<?= !empty($sop->file_id) ?$sop->file_id: ''?>">
								<input id="st_id1" name="" type="hidden" value="">
								<table class="table table-striped">
									<thead>
										<tr>
											<th class="" style="max-wdith: 30%; width: 30%;">商品名稱</th>
											<th class="" style="max-wdith: 30%; width: 30%;">商品料號</th>
											<th class="" style="max-wdith: 30%; width: 30%">重量</th>
										</tr>
									</thead>
									<?php foreach ($items as $each): ?>
									<tbody>
											<input id="tra_ba"  type="hidden" value="<?="20".substr($each->psn, 7, 6).substr($each->psn, -2)?>">
											<th class="" ><?=$each-> product_name?></th>
											<th class="" ><?=$each-> lot_number?></th>
											<th class="" >
												<?=$each-> total_weight?>
												<div class="widget-toolbar pull-right">
													<a href="javascript:void(0);"  onclick="storage('<?=$each->order_id?>','<?=$each->product_id?>','<?=$each->psn?>','<?=$each->station_id?>','<?=$each->actual_weight?>','<?=$each->note?>','<?=$each->thaw_date?>'
														,'<?=$each->thaw_id?>','<?=$each->container_sn?>','<?=$each->fty?>','<?=$each->batch?>','<?=$each->sloc?>','<?=$each->storage?>','<?=$each->id?>','<?=$each->from_station_id?>','<?=$each->record_id?>')" class="btn btn-default btn-danger">
														入庫
													</a>
												</div>
											</th>
									</tbody>
								<?php endforeach; ?>

								</table>
							</div>
							<!-- end widget edit box -->

							<!-- widget content -->
							<div class="widget-body no-padding">

								<div class="widget-toolbar pull-left">

									<input id="is_stock_1" name="market_location_file" type="hidden" value="">
								</div>


							</div>
							<!-- end widget content -->

						</div>
						<!-- end widget div -->

					</div>
					<!-- end widget -->

				</article>
				<!-- WIDGET END -->

			</div>

			<!-- end row -->

		</section>
		<!-- end widget grid -->
	</div>

	<div class="tab-pane animated fadeIn" id="edit_page">
		<section class="">
			<!-- row -->
			<div class="row">
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="edit-modal-body">

				</article>
			</div>
		</section>
	</div>
</div>

<!-- Station Serach Modal -->
<div class="modal fade" id="stationEditModal" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">

			</div>
			<div class="modal-body" id="station-edit-modal-body">
				<form id="station-add-form">
					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">搜尋結果</label>
							<div class="col-md-9">
								<table class="table table-hover">
									<thead>
										<tr>
											<td>單位名稱</td>
										</tr>
									</thead>
									<tbody id="station_list_serach_body">

									</tbody>
								</table>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
					<i class="fa fa-close"></i> 確定
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="mantissaModal" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
			</div>
			<div class="modal-body" id="">
				<form id="" class="">
					<input id="order_id_m"  type="hidden" value="">
					<input id="from_station_id_m"  type="hidden" value="">
					<input id="station_id_m"  type="hidden" value="">
					<input id="storage_m"  type="hidden" value="">
					<input id="product_id_m" type="hidden" value="">
					<input id="psn_m"  type="hidden" value="">
					<input id="batch_m"  type="hidden" value="">
					<input id="trace_batch_m"  type="hidden" value="">
					<input id="fty_m"  type="hidden" value="">
					<input id="container_sn_m"  type="hidden" value="">
					<input id="sloc_m"  type="hidden" value="">
					<input id="thaw_id_m"  type="hidden" value="">
					<input id="thaw_date_m"  type="hidden" value="">
					<input id="note_m"  type="hidden" value="">
					<input id="actual_weight"  type="hidden" value="">
					<input id="record_id"  type="hidden" value="">
					<input id="creat_id_m"  type="hidden" value="<?=$login_user_id?>">

					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">總重量</label>
							<div class="col-md-9">
								<div class="col-md-9">
									<input type="text" class="form-control required" id="mantissa_weight" value=""  />
								</div>
							</div>
						</div>
					</fieldset>
					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">總件數</label>
							<div class="col-md-9">
								<div class="col-md-9">
									<input type="text" class="form-control required" id="mantissa_number" value=""  />
								</div>
							</div>
						</div>
					</fieldset>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-sm" onclick="save_mantissa()">
						<i class="fa fa-save"></i> 存擋
					</button>
					<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
						<i class="fa fa-close"></i> 關閉
					</button>
				</div>
				</form>
			</div>

		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<script type="text/javascript">
function storage(order_id,product_id,psn,
	station_id,actual_weight,note,thaw_date,thaw_id,container_sn,fty,batch,sloc,storage,id,from_station_id,record_id) {
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
	$('#record_id').val(record_id);
}


function save_mantissa() {
	// var url = '<?= base_url() ?>' + 'api/order/transfer_station';
	var url = '<?= base_url() ?>' + 'mgmt/mantissa/mantissa';
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
			record_id: $('#record_id').val(),
			number: $('#mantissa_number').val(),
		},
		dataType: 'json',
		success: function(d) {
			Vaildation();
			if(d.success=="true"){
				$('#mantissaModal').modal('hide');
				window.location.reload();
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
</script>
