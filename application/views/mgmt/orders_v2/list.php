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
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->

							</div>
							<!-- end widget edit box -->

							<!-- widget content -->
							<div class="widget-body no-padding">
								<div class="widget-toolbar pull-left">
									<label>組別：</label>
								</div>
								<div class="widget-toolbar pull-left">
									<select name="" id="station_id" class="" >
										<?php foreach($station_list as $each): ?>
											<option  value="<?= $each -> id?>" ><?=  $each -> name ?></option>
										<?php endforeach ?>
									</select>
									<input id="is_stock_1" name="market_location_file" type="hidden" value="">
								</div>
									<table id="dt_list" class="table table-striped table-bordered table-hover" width="100%">
									<thead>
										<tr>
											<th class="min150">建立時間</th>
											<th class="min150">工單編號</th>
											<th class="min150">狀態</th>
											<th class="min150">開始時間</th>
											<th class="min150">完工時間</th>
										</tr>
										<tr class="search_box">
									    <th></th>
									    <th><input class="form-control input-xs min100" type="text" /></th>
									    <th>
												<select id="s_status" class="form-control input-xs">
													<option value="-2">無</option>
													<option value="-1">取消</option>
													<option value="0">未完工</option>
													<option value="1">已完工</option>
												</select>
											</th>
									    <th>
												<input class="form-control input-xs min100 dt_picker" type="text" />
											</th>
									    <th></th>
								    </tr>
									</thead>
									<tbody>
									</tbody>
								</table>

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

<!-- Product Serach Modal -->
<div class="modal fade" id="productSearchModal" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
			</div>
			<div class="modal-body" id="station-edit-modal-body">
				<form id="product-seach-form" class="">
					<input id="order_id_1" class="market_location_file" name="order_id_1" type="hidden" value="">
					<input id="product_id_1" class="market_location_file" name="product_id_1" type="hidden" value="">
					<input id="station_id_1" class="market_location_file" name="station_id_1" type="hidden" value="">
					<div class="form-group">
						<span class=" control-label" style="color:red;font-size:20px">除了進口原料外，煩請務必輸入barcode以利後續操作，謝謝!!</span>
					</div>
					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">搜尋barcode</label>
							<div class="col-md-9">
								<div class="input-group">
									<input type="text" class="form-control" id="barcode"  value="" placeholder="請輸入開始搜尋" />
			      			<span class="input-group-btn">
			      				<button type="button" onclick="barcode_search()" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i></button>
			      			</span>
			      		</div>
							</div>
						</div>
					</fieldset>
					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">搜尋料品名稱/編號</label>
							<div class="col-md-9">
								<div class="input-group">
									<input type="text" class="form-control" id="s-type-product-name"  value="" placeholder="請輸入開始搜尋" />
			      			<span class="input-group-btn">
			      				<button type="submit" onclick="" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i></button>
			      			</span>
			      		</div>
							</div>
						</div>
					</fieldset>
					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">搜尋結果</label>
							<div class="col-md-9">
								<table class="table table-hover">
									<thead>
										<tr>
											<td>料號</td>
											<td>品名</td>
										</tr>
									</thead>
									<tbody id="product_list_serach_body">

									</tbody>
								</table>
							</div>
						</div>
					</fieldset>

					<hr/>

					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">料號</label>
							<div class="col-md-9">
								<input type="text" class="form-control" id="product_lot_number" name="lot_number"  value="" readonly />
							</div>
						</div>
					</fieldset>

					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">品名</label>
							<div class="col-md-9">
								<input type="text" class="form-control" id="product_name" name="name" value="" readonly />
							</div>
						</div>
					</fieldset>

					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">櫃號</label>
							<div class="col-md-9">
								<input type="text" class="form-control" id="product_container_sn" name="container_sn"  value=""  />
							</div>
						</div>
					</fieldset>



					<div id="body_1">
						<fieldset>
							<div class="form-group">
								<label class="col-md-3 control-label">儲位*</label>
								<div class="col-md-9">
									<select id="product_sloc_1" class="from-control col-md-6 required" name="sloc_1">
										<?php foreach($sloc_list as $each): ?>
											<option value="<?= $each -> sloc ?>"><?= $each -> sloc ?>-<?= $each -> desc ?></option>
										<?php endforeach ?>
									</select>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<div class="form-group">
								<label class="col-md-3 control-label">總重量*</label>
								<div class="col-md-9">
									<input type="text" class="form-control required" id="all_weight" name="all_weight" value=""  />
								</div>
							</div>
						</fieldset>
					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">總件數*</label>
							<div class="col-md-9">
								<input type="text" class="form-control required" id="all_pieces" name="all_pieces" value=""  />
							</div>
						</div>
					</fieldset>
					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">追溯批號*</label>
							<div class="col-md-9">
								<input type="text" class="form-control required" id="trace_batch_number" name="trace_batch_number" value=""  />
							</div>
						</div>
					</fieldset>
					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">廠號*</label>
							<div class="col-md-9">
								<input type="text" class="form-control required" id="factory_number" name="factory_number" value=""  />
							</div>
						</div>
					</fieldset>
				</div>
				<div class="s_sum" id="body_2">

					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">barcode<span style="color:red">(進口原料不用輸入)</span></label>
							<div class="col-md-9">
								<input type="text" class="form-control" id="barcode_psn" name="barcode_psn" value=""  />
							</div>
						</div>
					</fieldset>
				</div>

				<div class="modal-footer" id="button_1">
					<button type="button" class="btn btn-danger btn-sm" onclick="saveProductItem1()">
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
</div><!-- /.modal -->

<div class="modal fade" id="barcodeModal" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
			</div>
			<div class="modal-body" id="">
				<form id="" class="">
					<input id="or1"  type="hidden" value="">
					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">barcode</label>
							<div class="col-md-9">
								<input type="text" class="form-control required" id="psn_b" value=""  />
							</div>
						</div>
					</fieldset>
					<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-sm" onclick="savepsn()">
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

<div class="modal fade" id="rceiptModal" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
			</div>
			<div class="modal-body" id="">
				<form id="" class="">
					<input id="order_id_11"  type="hidden" value="">
					<input id="product_id_11" type="hidden" value="">
					<input id="psn_11"  type="hidden" value="">
					<input id="is_stock_11"  type="hidden" value="">
					<input id="station_id_11"  type="hidden" value="">
					<input id="trace_batch_11"  type="hidden" value="">

					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">總重量*</label>
							<div class="col-md-9">
								<input type="text" class="form-control required" id="a_weight" value=""  />
							</div>
						</div>
					</fieldset>
					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">總數量*</label>
							<div class="col-md-9">
								<input type="text" class="form-control required" id="a_pieces" value=""  />
							</div>
						</div>
					</fieldset>
					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">儲位*</label>
							<div class="col-md-9">
								<select id="product_sloc_1" class="from-control col-md-6 required" name="sloc_1">
									<?php foreach($sloc_list as $each): ?>
										<option value="<?= $each -> sloc ?>"><?= $each -> sloc ?>-<?= $each -> desc ?></option>
									<?php endforeach ?>
								</select>
							</div>
						</div>
					</fieldset>

				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-sm" onclick="save_rceipt()">
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
							<label class="col-md-3 control-label">重量</label>
							<div class="col-md-9">
								<div class="col-md-9">
									<input type="text" class="form-control required" id="mantissa_weight" value=""  />
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

<div class="modal small fade" id="delete_m" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<input id="or"  type="hidden" value="">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					×
				</button>
				<h3 id="deleteModalLabel">刪除確認</h3>
			</div>
			<div class="modal-body" id="deleteModalBody">
				<div class="alert alert-warning fade in">
					<i class="fa fa-warning modal-icon"></i>
					<strong>Warning</strong> 確定要刪除嗎? <br>
					無法復原
				</div>

			</div>
			<div class="modal-footer">
				<button class="btn btn-default" data-dismiss="modal" aria-hidden="true">
					取消
				</button>
				<button class="btn btn-danger" data-dismiss="modal" id="" onclick="do_delete()">
					刪除
				</button>
			</div>
		</div>
	</div>
</div>

<?php $this -> load -> view('general/delete_modal'); ?>


<script type="text/javascript">
$(document).ready(function(){
	var st_id = $('#station_id').val();
	$('#station_id_1').val(st_id);
})
	var $thawList = JSON.parse('<?= json_encode($thaw_list) ?>');
	function getThawName(id) {
		var name = "";
		$.each($thawList, function(){
			if(this.id == id) {
				name = this.name;
			}
		});
		return name;
	}
	var mCols = [{
		data : 'create_time'
	}, {
		data : 'sn',
		render: function(d,t,r){
			var html = "";
			html += d;
			if(r.status == 0 && r.thaw_expire && r.thaw_expire > 0) {
				html += $('<font color="red">').text(" - 解凍逾期" + r.thaw_expire  +"天").prop("outerHTML");
			}
			return html;
		}
	}, {
		data : 'status_name',
		render: function(d,t,r) {
			var html = '';
			switch(r.status) {
				case "-1":
					html += $('<font color="red">').text(d).prop("outerHTML");
				case "1":
					html += $('<font color="green">').text(d).prop("outerHTML");
				default:
					html += $('<font color="blue">').text(d).prop("outerHTML");
			}
			if(r.order_expire && r.order_expire > 0) {
				if(r.order_expire < 3) {
					html += $('<font color="green">').text(" - " + r.order_expire).prop("outerHTML");
				} else {
					html += $('<font color="red">').text(" - " + r.order_expire).prop("outerHTML");
				}
			}
			return html;
		}
	}, {
		data : 'start_time'
	}, {
		data : 'finish_time',
		render:function(d,t,r) {
			if(d && d.length >= 10) {
				return d.substring(0,10)
			}
			return d;
		}
	}];

	var mOrderIdx = 1;

	var defaultContent = '<a href="#deleteModal" role="button" data-toggle="modal" style="margin-right: 5px;"><i class="fa fa-trash fa-lg"></i></a>';
	var mColDefs = [{
		targets : 0,
		data : null,
		defaultContent : defaultContent,
		searchable : false,
		orderable : false,
		width : "5%",
		className : ''
	}, {
		"targets" : [1,2,3,4],
		"orderable" : false
	}];

	loadScript(baseUrl + "js/class/BaseAppClass.js", function(){
		loadScript(baseUrl + "js/app/orders_v2/list.js?<?= time() ?>", function(){
			currentApp = new Ordersv2AppClass(new BaseAppClass({}));

			$('#station-add-form').submit(function(e){
				stationChange();
				e.preventDefault();
			});

			$('#product-seach-form').submit(function(e){
				productChange();
				e.preventDefault();
			});

			// date time picker
			$(".dt_picker").datetimepicker({
				format : 'YYYY-MM-DD'
			}).on('dp.change',function(event){
				this.value = event.date.format("YYYY-MM-DD");
				$(this).trigger("change");
			});
		});
	});



</script>
