<style>
	#dt_list_wrapper {
		border-top: 1px solid #CCCCCC;
	}
	#dt_list_type_0_wrapper {
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
							<div class="widget-toolbar pull-left">
								<label>範圍查詢 <input id="s_multiple" type="checkbox" class="" value="" /></label>
							</div>
							<div class="widget-toolbar pull-left">
								<input id="s_dt" placeholder="請輸入日期" type="text" class="dt_picker" value="<?= date('Y-m-d') ?>" />
							</div>
							<div class="widget-toolbar pull-left" disabled>
								~ <input id="e_dt" disabled placeholder="請輸入日期" type="text" class="dt_picker" value="<?= date('Y-m-d') ?>" />
							</div>

							<div class="widget-toolbar pull-left">
								<label>組別：</label>
							</div>
							<div class="widget-toolbar pull-left">
								<select name="" id="s_station_id" class="">
									<option value="-1">無</option>
									<?php foreach($station_list as $each): ?>
										<option value="<?= $each -> id?>" ><?=  $each -> name ?></option>
									<?php endforeach ?>
								</select>

							</div>
							<div class="widget-toolbar pull-left">
								<label>排除解凍組 <input id="s_bypass_101" type="checkbox" class="" value="1" checked /></label>
							</div>
							<!-- <div class="widget-toolbar pull-left">
								<label>櫃號</label>
							</div>
							<div class="widget-toolbar pull-left">
								<input id="s_container_sn" ondragover="" type="text" class="form-control" />
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
											<td class="min100">原料</td>
											<td><span id="sum_orders_type_0" class="t_red"></span></td>
											<td class="min100">總重量(KG)</td>
											<td><span id="sum_weight_type_0" class="t_red"></span></td>
										</tr>
									</table>
								</div>
								<table id="dt_list_type_0" class="table table-striped table-bordered table-hover" width="100%">
									<thead>
										<tr>
											<th class="min100">站別</th>
											<th class="min100">料號</th>
											<th class="min150">品名</th>
											<th class="min50">件數</th>
											<th class="">重量(KG)</th>
										</tr>

									</thead>
									<tbody>
									</tbody>
								</table>
								<hr/>
								<div>
									<table class="table table-striped table-bordered table-hover">
										<tr>
											<td class="min100">成品/半成品</td>
											<td><span id="sum_orders" class="t_red"></span></td>
											<td class="min100">總重量(KG)</td>
											<td><span id="sum_weight" class="t_red"></span></td>
											<td class="min100">產成比</td>
											<td><span id="sum_weight_ratio" class="t_red"></span></td>
										</tr>
									</table>
								</div>
								<table id="dt_list" class="table table-striped table-bordered table-hover" width="100%">
									<thead>
										<tr>
											<th class="min100">站別</th>
											<th class="min100">料號</th>
											<th class="min150">品名</th>
											<th class="min50">件數</th>
											<th class="">重量(KG)</th>
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
<style>
#dt_list_wrapper .table-responsive {
	width: 100%;
}
#dt_list_type_0_wrapper .table-responsive {
	width: 100%;
}
</style>
<script type="text/javascript">
	loadScript(baseUrl + "js/class/BaseAppClass.js", function(){
		loadScript(baseUrl + "js/app/yield_rate_station/list.js?<?= time() ?>", function(){
			currentApp = new YieldRateStationAppClass(new BaseAppClass({}));
			currentApp.type1 = new YieldRateStationAppType1Class(new BaseAppClass({}));
		});
	});
</script>
