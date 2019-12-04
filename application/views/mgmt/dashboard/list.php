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
								<label>範圍查詢 <input id="s_multiple" type="checkbox" class="" value="" /></label>
							</div>
							<div class="widget-toolbar pull-left">
								<input id="s_dt" placeholder="請輸入日期" type="text" class="dt_picker" value="<?= date('Y-m-d') ?>" />
							</div>
							<div class="widget-toolbar pull-left" disabled>
								~ <input id="e_dt" disabled placeholder="請輸入日期" type="text" class="dt_picker" value="<?= date('Y-m-d') ?>" />
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
							<div class="widget-body " style="padding-right:30px;padding-top:2px">

								<fieldset>
									<div class="form-group">
										<label class="col-md-3 control-label">過去24小時使用人數</label>
										<div class="col-md-6">
											<input type="text"  class="form-control"  name="account" value="<?= isset($count_24hr) ? $count_24hr : '' ?>" readonly />
										</div>
									</div>
								</fieldset>
								<hr/>
								<fieldset>
									<div class="form-group">
										<label class="col-md-3 control-label">關卡一人數</label>
										<div class="col-md-6">
											<input type="text"  class="form-control"  name="account" value="<?= isset($count_level_1) ? $count_level_1  : '' ?>" readonly />
										</div>
									</div>
								</fieldset>
								<hr/>

								<fieldset>
									<div class="form-group">
										<label class="col-md-3 control-label">關卡二人數</label>
										<div class="col-md-6">
											<input type="text"  class="form-control"  name="account" value="<?= isset($count_level_2) ? $count_level_2 : '' ?>" readonly />
										</div>
									</div>
								</fieldset>
							<hr/>

								<fieldset>
									<div class="form-group">
										<label class="col-md-3 control-label">關卡三人數</label>
										<div class="col-md-6">
											<input type="text"  class="form-control"  name="account" value="<?= isset($count_level_3) ? $count_level_3 : '' ?>" readonly />
										</div>
									</div>
								</fieldset>
							<hr/>

								<fieldset>
									<div class="form-group">
										<label class="col-md-3 control-label">關卡四人數</label>
										<div class="col-md-6">
											<input type="text"  class="form-control"  name="account" value="<?= isset($count_level_4) ? $count_level_4 : '' ?>" readonly />
										</div>
									</div>
								</fieldset>
							<hr/>

								<!-- <fieldset>
									<div class="form-group">
										<label class="col-md-3 control-label">以結束人員</label>
										<div class="col-md-6">
											<input type="text"  class="form-control"  name="account" value="<?= isset($item) ? $item -> account : '' ?>" readonly />
										</div>
									</div>
								</fieldset> -->




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
</style>
<script type="text/javascript">
	loadScript(baseUrl + "js/class/BaseAppClass.js", function(){
		loadScript(baseUrl + "js/app/dashboard/list.js", function(){

		});
	});
</script>
