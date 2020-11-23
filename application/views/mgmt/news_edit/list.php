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
											<th class="min150">標題</th>
											<th class="min250">類型</th>
											<th class="min150">建立時間</th>
										</tr>
										<tr class="search_box">
											<th></th>
											<th></th>
											<th>
												<div class="min100">
													<select id="s_news_style" class="form-control">
														<!-- option from javascript -->
													</select>
												</div>
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
<?php $this -> load -> view('general/delete_modal'); ?>

<script type="text/javascript">
	loadScript(baseUrl + "js/class/BaseAppClass.js", function(){
		loadScript(baseUrl + "js/app/news_edit/list.js", function(){
			currentApp = new NewsEditAppClass(new BaseAppClass({}));
		});
	});

	function load_s_news_style() {
	$.ajax({
			url: '<?= base_url() ?>' + 'mgmt/news_edit/find_news_style',
			type: 'POST',
			data: {},
			dataType: 'json',
			success: function(d) {
				if(d) {
					// console.log(d);
					$s_news_style = $('#s_news_style').empty();
					var option = '<option value="0">全部</option>';
          			$s_news_style.append(option);
					$.each(d.news_style, function(){
						$('<option/>', {
							'value': this.id,
							'text': this.news_style
						}).appendTo($s_news_style);
					});
				}
			},
			failure:function(){
				alert('faialure');
			}
		});

}
load_s_news_style();
</script>
