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
							<!-- <div class="widget-toolbar pull-left">
								<label>組別：</label>
							</div>
							<div class="widget-toolbar pull-left">
								<select name="" id="s_station_id" class="">
									<option value="-1">無</option>
									<?php foreach($station_list as $each): ?>
										<option value="<?= $each -> id?>" ><?=  $each -> name ?></option>
									<?php endforeach ?>
								</select>

							</div> -->
							<!-- <div class="widget-toolbar pull-left">
								<label>人員：</label>
							</div>
							<div class="widget-toolbar pull-left">
								<select name="" id="s_user_id" class="">
									<option value="-1">無</option>

								</select>

							</div> -->

							<!-- <div class="widget-toolbar pull-left">
								<div class="btn-group">
									<a href="<?= base_url("mgmt/receipt/flow_print") ?>" class="btn dropdown-toggle btn-xs btn-warning" target="_blank">
										<i class="fa fa-print"></i>前往列印頁面
									</a>
								</div>
							</div> -->
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
		loadScript(baseUrl + "js/app/receipt/list.js", function(){
			currentApp = new ReceiptAppClass(new BaseAppClass({}));
			currentApp.reloadFlow();
		});
	});
</script>
