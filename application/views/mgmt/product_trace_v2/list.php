<style>
	#dt_list_wrapper {
		border-top: 1px solid #CCCCCC;
	}
	input[disabled] {
	  background-color: #DDD;
		color: #EEE;
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
							<!-- <div class="widget-toolbar pull-left">
								<label>原料/成品</label>
							</div> -->
							<!-- <div class="widget-toolbar pull-left">
								<select name="" id="s_storage" class="">
									<option value="-1">無</option>
									<option value="0">原料</option>
									<option value="2">成品</option>

								</select>
							</div> -->

							<div class="widget-toolbar pull-left">
								<label>原料櫃號</label>
							</div>
							<div class="widget-toolbar pull-left">
								<input id="s_container_sn" ondragover="" autocomplete="off" type="text" class="form-control" />
							</div>
							<div class="widget-toolbar pull-left">
								<label>工單編號</label>
							</div>
							<div class="widget-toolbar pull-left">
								<input id="s_sn" type="text" class="form-control" autocomplete="off" />
							</div>
							<div class="widget-toolbar pull-left">
								<label>料號</label>
							</div>
							<div class="widget-toolbar pull-left">
								<input id="s_lot_number" ondragover="" type="text" class="form-control" autocomplete="off"/>
							</div>
		
							<div class="widget-toolbar pull-left">
								<label>品名</label>
							</div>
							<div class="widget-toolbar pull-left">
								<input id="s_product_name1"  type="text" class="form-control" style="background:#FFFFFF" value="" readonly/>
								<input id="s_product_name"  type="button" style="width:171px;position:relative;z-index:300;top:-30px;background-color: transparent; border: 0" class="form-control" autocomplete="off"/>
							</div>
							<div class="widget-toolbar pull-left">
								<label>批號</label>
							</div>
							<div class="widget-toolbar pull-left">
								<input id="s_trace_batch" type="text" class="form-control"autocomplete="off" />
							</div>
		<!-- <div class="widget-toolbar pull-left">
								<label>料號</label>
							</div>
							<div class="widget-toolbar pull-left">
								<input id="s_lot_number" ondragover=""type="text" class="form-control" />
							</div>

							<div class="widget-toolbar pull-left">
								<label>品名</label>
							</div>
							<div class="widget-toolbar pull-left">
								<input id="s_product_name" type="text" class="form-control" />
							</div>

							<div class="widget-toolbar pull-left">
								<label>批號</label>
							</div>
							<div class="widget-toolbar pull-left">
								<input id="s_trace_batch" type="text" class="form-control" />
							</div> -->
							<div class="widget-toolbar pull-left">
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

							</div>
							<!-- end widget edit box -->

							<!-- widget content -->
							<div class="widget-body no-padding">
								<div>
									<table class="table table-striped table-bordered table-hover">
										<tr>
											<td class="min100">項目數量</td>
											<td><span id="sum_orders" class="t_red"></span></td>
											<td class="min100">原料總重量(KG)</td>
											<td><span id="sum_weight_2" class="t_red"></span></td>
											<td class="min100">成品總重量(KG)</td>
											<td><span id="sum_weight_0" class="t_red"></span></td>
											<td class="min100">產成率</td>
											<td><span id="sum_weight_3" class="t_red"></span></td>
										</tr>
									</table>
								</div>
								<br/>
								<table id="dt_list" class="table table-striped table-bordered table-hover" width="100%">
									<thead>
										<tr>
											<th class="min100">時間</th>
											<th class="min100">原料/成品</th>
											<th class="min100">櫃號</th>
											<th class="min100">工單編號</th>
											<th class="min100">料號</th>
											<th class="min150">品名</th>
											<th class="min150">條碼</th>
											<th class="min150">批號</th>
											<th class="min100">工單產成</th>
											<th class="min100">成品料號</th>
											<th class="min100">成品品名</th>
											<th class="min100">成品批號</th>
											<th class="min100">工單原料KG)</th>
											<th class="min100">工單產出(KG)</th>

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
	<div class="modal fade" id="SearchModal" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
				</div>
				<div class="modal-body" id="station-edit-modal-body">
					<form id="product-seach-form" class="">

						<fieldset>
							<div class="form-group">
								<label class="col-md-6 control-label">搜尋品名</label>
								<div class="col-md-9">
									<div class="input-group">
										<input type="text" class="form-control" id="s-type-product-name"  value="" placeholder="請輸入開始搜尋" />
										<span class="input-group-btn">
											<button type="submit" onclick="" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i>搜尋</button>
										</span>
									</div>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<div class="form-group">
								<div class="col-md-9">
									<label class=" control-label">搜尋結果</label>
								</div>

								<div class="col-md-9">
									<table class="table table-hover">
										<thead>
											<tr>
												<td>品名</td>
											</tr>
										</thead>
										<tbody id="product_list_serach_body">

										</tbody>
									</table>
								</div>
							</div>
						</fieldset>


						<!-- <fieldset>
							<div class="form-group">
								<label class="col-md-3 control-label">品名</label>
								<div class="col-md-9">
									<input type="text" class="form-control" id="product_name" name="name" value="" readonly />
								</div>
							</div>
						</fieldset> -->

					</form>
				</div>

			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
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
<style>
#dt_list_wrapper .table-responsive {
	width: 100%;
	padding-bottom: 21px;
}
</style>
<script type="text/javascript">
loadScript(baseUrl + "js/class/BaseAppClass.js", function(){
	loadScript(baseUrl + "js/app/product_trace_v2/list.js?<?= time() ?>", function(){
		currentApp = new ProductTracev2AppClass(new BaseAppClass({}));
	});
});
$("#s_product_name").click(function(){
	$('#SearchModal').modal('show');
})
$('#product-seach-form').submit(function(e){
	productChange();
	e.preventDefault();
});
function productChange(){
	var url = baseUrl + 'mgmt/orders_v2/product_search'; // the script where you handle the form input.
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
					$('#s_product_name1').val(me.name);
					currentApp.tableReload();
					hideSearchModal();
				}).appendTo($body);
				$('<td>').html(me.name).appendTo($tr);
			})
		}
	});
}

function hideSearchModal() {
	$('#SearchModal').modal('hide');

}
</script>
