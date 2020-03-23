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
									<input id="s_dt" placeholder="請輸入日期" type="text" class="dt_picker" value="<?= date('Y-m-d') ?>" />
								</div>
								<div class="widget-toolbar pull-left" disabled>
									~ <input id="e_dt" disabled placeholder="請輸入日期" type="text" class="dt_picker" value="<?= date('Y-m-d') ?>" />
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

								<table id="dt_list" class="table table-striped table-bordered table-hover" width="100%">
									<thead>
										<tr>
											<!-- <th></th> -->
											<th class="min100">會員</th>
											<th class="min100">酮體</th>

											<th class="min100">色值</th>
											<th class="min100">建立時間</th>
										</tr>
										<tr class="search_box">
											    <!-- <th></th> -->
											    <th><input class="form-control input-xs min100" type="text" /></th>
													<th><input class="form-control input-xs min100" type="text" /></th>
													<th></th>
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
<script type="text/javascript">
	var mCols = [{
		data : 'user_name'
	},{
		data : 'value'
	},{
		data : 'color'
	},{
		data : 'create_time'
		// render:function(d,t,r) {
		// 	if(d == 0) {
		// 		return '一般會員';
		// 	}
		// 	if(d == 1) {
		// 		return '教練';
		// 	}
		// 	if(d == 2) {
		// 		return '訪客';
		// 	}
		// 	return d;
		// }
	}];

	var mOrderIdx = 3;

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
		"targets" : [0,1,2],
		"orderable" : false
	}];

	loadScript(baseUrl + "js/class/BaseAppClass.js", function(){
		loadScript(baseUrl + "js/app/ketone/list.js", function(){
			currentApp = new KetoneClass(new BaseAppClass({}));
		});
	});


</script>
