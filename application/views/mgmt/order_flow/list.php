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
							<!-- <div class="widget-toolbar pull-left">
								<label>範圍：<input id="s_multiple" type="checkbox" class="" value="" /></label>
							</div> -->
							<!-- <div class="widget-toolbar pull-left">
								<input id="s_dt" placeholder="請輸入日期" type="text" class="dt_picker" value="<?= date('Y-m-d') ?>" /> -->
							<!-- </div> -->
							<!-- <div class="widget-toolbar pull-left" >
								<input id="dt" placeholder="請輸入日期" type="text" class="dt_picker" value="<?= date('Y-m-d') ?>" />
							</div> -->
							<!-- <div class="widget-toolbar pull-left">
								<label>組別：</label>
							</div> -->
							<!-- <div class="widget-toolbar pull-left">
								<select name="" id="a_b" class="">
									<option value="0">以前</option>
									<option value="1">以後</option>


								</select>

							</div> -->
							<div class="widget-toolbar pull-left">
								<label>範圍查詢 <input id="s_multiple" type="checkbox" class="" value="" /></label>
							</div>
							<div class="widget-toolbar pull-left">
								<input id="s_dt" placeholder="請輸入日期" type="text" class="dt_picker" value="<?= date('Y-m-d') ?>" />
							</div>
							<div class="widget-toolbar pull-left" >
								~ <input id="e_dt"  placeholder="請輸入日期" type="text" class="dt_picker" value="<?= date('Y-m-d') ?>" />
							</div>
							<!-- <div class="widget-toolbar pull-left">
								<label>人員：</label>
							</div>
							<div class="widget-toolbar pull-left">
								<select name="" id="s_user_id" class="">
									<option value="-1">無</option>

								</select>

							</div> -->

							<div class="widget-toolbar pull-left">
								<div class="btn-group">
									<a href="<?= base_url("mgmt/order_flow/flow_print") ?>" class="btn dropdown-toggle btn-xs btn-warning" target="_blank">
										<i class="fa fa-print"></i>前往列印頁面
									</a>
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
								<div id="m_result"></div>
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
		loadScript(baseUrl + "js/app/order_flow/list.js", function(){
			currentApp = new OrderFlowAppClass(new BaseAppClass({}));
			currentApp.reloadFlow();
		});
	});

</script>
