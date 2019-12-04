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
								<label>人員：</label>
							</div>
							<div class="widget-toolbar pull-left">
								<select name="" id="s_user_id" class="">
									<option value="-1">無</option>

								</select>

							</div>

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
											<td class="min100">發料數量</td>
											<td><span id="sum_orders_type_0" class="t_red"></span></td>
											<td class="min100">總點數</td>
											<td><span id="sum_reward_type_0" class="t_red"></span></td>
											<td class="min100">總重(KG)</td>
											<td><span id="sum_weight_type_0" class="t_red"></span></td>
											<td class="min100">總料品點數</td>
											<td><span id="sum_reward_total_type_0" class="t_red"></span></td>
										</tr>
									</table>
								</div>
								<table id="dt_list_type_0" class="table table-striped table-bordered table-hover" width="100%">
									<thead>
										<tr>
											<th class="min100">日期</th>
											<th class="min100">組別</th>
											<th class="min100">人員帳號</th>
											<th class="min100">名稱</th>
											<th class="min100">料號</th>
											<th class="min100">品名</th>
											<th class="min100">總重(KG)</th>
											<th class="min100">料品點數</th>
											<th class="min150">總料品點數</th>
										</tr>

									</thead>
									<tbody>
									</tbody>
								</table>
								<hr/>
								<div>
									<table class="table table-striped table-bordered table-hover">
										<tr>
											<td class="min100">收料數量</td>
											<td><span id="sum_orders" class="t_red"></span></td>
											<td class="min100">總點數</td>
											<td><span id="sum_reward" class="t_red"></span></td>
											<td class="min100">總重(KG)</td>
											<td><span id="sum_weight" class="t_red"></span></td>
											<td class="min100">產成比</td>
											<td><span id="sum_weight_ratio" class="t_red"></span></td>
											<td class="min100">總料品點數</td>
											<td><span id="sum_reward_total" class="t_red"></span></td>
										</tr>
									</table>
								</div>
								<table id="dt_list" class="table table-striped table-bordered table-hover" width="100%">
									<thead>
										<tr>
											<th class="min100">日期</th>
											<th class="min100">組別</th>
											<th class="min100">人員帳號</th>
											<th class="min100">名稱</th>
											<th class="min100">料號</th>
											<th class="min100">品名</th>
											<th class="min100">總重(KG)</th>
											<th class="min100">料品點數</th>
											<th class="min150">總料品點數</th>
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
		loadScript(baseUrl + "js/app/yield_rate_user/list.js?<?= time() ?>", function(){
			currentApp = new YieldRateUserAppClass(new BaseAppClass({}));
			currentApp.type_0 = new YieldRateUserType0AppClass(new BaseAppClass({}));
		});
	});
</script>
