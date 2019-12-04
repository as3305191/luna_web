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
								<div class="btn-group">
									<button onclick="currentApp.doEdit(0)" class="btn dropdown-toggle btn-xs btn-success" data-toggle="dropdown">
										<i class="fa fa-plus"></i>新增
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

								<table id="dt_list" class="table table-striped table-bordered table-hover" width="100%">
									<thead>
										<tr>
											<th class="min100"></th>
											<th class="min150">建立時間</th>
											<th class="min150">工單編號</th>
											<th class="min150">狀態</th>
											<th class="min150">開始時間</th>
											<th class="min150">完工時間</th>
										</tr>
										<tr class="search_box">
									    <th></th>
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
					<!-- <fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">搜尋工站名稱</label>
							<div class="col-md-9">
								<div class="input-group">
									<input type="text" class="form-control" id="s-station-name" placeholder="請輸入開始搜尋" />
			      			<span class="input-group-btn">
			      				<button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i></button>
			      			</span>
			      		</div>
							</div>
						</div>
					</fieldset> -->
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
							<label class="col-md-3 control-label">批號</label>
							<div class="col-md-9">
								<input type="text" class="form-control" id="product_batch" name="trace_batch" value=""  />
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

					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">儲位</label>
							<div class="col-md-9">
								<input type="text" class="form-control" id="product_sloc" name="sloc"  value=""  />
							</div>
						</div>
					</fieldset>

					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">需求重量</label>
							<div class="col-md-9">
								<input type="text" class="form-control" id="product_weight" name="weight" value=""  />
							</div>
						</div>
					</fieldset>
					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">實際重量</label>
							<div class="col-md-9">
								<input type="text" class="form-control" id="product_actual_weight" name="actual_weight" value=""  />
							</div>
						</div>
					</fieldset>
					<hr/>
					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">解凍方式</label>
							<div class="col-md-9">
								<select id="product_thaw_id" class="from-control col-md-6" name="thaw_id">
									<option value="0">-</option>
									<?php foreach($thaw_list as $each): ?>
										<option value="<?= $each -> id ?>"><?= $each -> name ?></option>
									<?php endforeach ?>
								</select>
							</div>
						</div>
					</fieldset>
					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">解凍日期</label>
							<div class="col-md-9">
								<input type="text" class="form-control dt_picker" id="product_thaw_date" name="thaw_date"  value="" placeholder="解凍日期"  />
							</div>
						</div>
					</fieldset>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-sm" onclick="saveProductItem()">
					<i class="fa fa-save"></i> 存擋
				</button>
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
					<i class="fa fa-close"></i> 關閉
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php $this -> load -> view('general/delete_modal'); ?>

<script type="text/javascript">
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
	var mCols = [null, {
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
	defaultContent += $('<a href="javascript:void(0)" style="margin-left: 5px;" class="btn btn-primary btn-xs">').text("流向").prop("outerHTML");;
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
		loadScript(baseUrl + "js/app/orders/list.js", function(){
			currentApp = new OrdersAppClass(new BaseAppClass({}));

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

	//----
</script>
