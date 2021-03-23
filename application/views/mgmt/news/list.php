<style>
thead tr th {
	position:sticky;
	top:0;
	background-color:#FFFFFF !important;
	text-align:center;
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
					<div class="jarviswidget jarviswidget-color-darken">
						<header>
							<!-- <div class="widget-toolbar pull-left">
								<div class="btn-group">
									<button  onclick="currentApp.doEdit(0)" class="btn dropdown-toggle btn-xs btn-default" data-toggle="dropdown">
										<i class="fa fa-plus"></i>新增
									</button>
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
								<table id="dt_list" class="table table-striped table-bordered table-hover" width="100%">
									<thead>
										<tr>
											<!-- <th class="min75"></th> -->
											<th class="min150">標題</th>
											<th class="min250">類型</th>
											<th>建立時間</th>
										</tr>
										<tr class="search_box">
											<th><input class="form-control input-xs" type="text" /></th>
											<th><input class="form-control input-xs" type="text" /></th>
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

<?php $this -> load -> view('general/delete_modal'); ?>
<?php //$this -> load -> view('general/copy_modal'); ?>
<script type="text/javascript">
	// var baseUrl = '<?= base_url(); ?>';
	// loadScript(baseUrl + "js/app/products/list.js", function(){
	// 	productsApp.init();
	// });

	loadScript(baseUrl + "js/class/BaseAppClass.js", function(){
		loadScript(baseUrl + "js/app/news/list.js", function(){
			currentApp = new newsAppClass(new BaseAppClass({}));
		});
	});
</script>
