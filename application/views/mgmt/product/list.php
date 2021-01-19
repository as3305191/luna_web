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

							<div class="widget-toolbar pull-left">
								<div class="btn-group">
								 	<span>上傳磅秤料號</span>
								</div>
							</div>

							<div class="widget-toolbar pull-left">
								<div class="btn-group">
									<input id="file-input" name="file" type="file" class="form-control">
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
											<th class="min25"></th>
											<th class="min150">料號</th>
											<th class="min200">品名</th>
											<th class="min100">磅秤料號</th>
											<th class="min100">噸工資代碼</th>
											<th class="min100">本/外勞點數</th>
											<th class="">建立時間</th>
										</tr>
										<tr class="search_box">
											<th></th>
											<th><input class="form-control input-xs min100" type="text" /></th>
											<th><input class="form-control input-xs min100" type="text" /></th>
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
	var mCols = [null, {
		data : 'lot_number'
	}, {
		data : 'name'
	}, {
		data : 'weight_sn'
	}, {
		data : 'salary_code',
		render: function(d,t,r) {
			return d + " / " + r.salary_code_foreign;
		}
	}, {
		data : 'reward',
		render: function(d,t,r) {
			return d + " / " + r.reward_foreign;
		}
	}, {
		data : 'create_time'
	}];

	var mOrderIdx = 6;

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
		"targets" : [1,2,3,4,5],
		"orderable" : false
	}];

	loadScript(baseUrl + "js/class/BaseAppClass.js", function(){
		loadScript(baseUrl + "js/app/product/list.js", function(){
			currentApp = new ProductAppClass(new BaseAppClass({}));

			$('#file-input').fileupload({
				url: currentApp.basePath + 'upload_excel',
				dataType: 'json',
				fileuploadstart:function() {
					layer.load(2);
				},
				done: function (e, data) {
					layer.closeAll();

					if(data.result.error_msg) {
						layer.msg(data.result.error_msg);
					} else {
						layer.msg("上傳完畢");
					}
				},
				progressall: function (e, data) {
						var progress = parseInt(data.loaded / data.total * 100, 10);
						$('#file-input-progress').show();
						$('#file-input-progress .progress-bar').show().css(
								'width',
								progress + '%'
						);
				}
			}).prop('disabled', !$.support.fileInput)
					.parent().addClass($.support.fileInput ? undefined : 'disabled');
		});
	});
</script>
