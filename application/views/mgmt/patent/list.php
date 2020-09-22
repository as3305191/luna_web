<div class="tab-content">
	<div class="tab-pane active" id="list_page">

		<!-- widget grid -->
		<section id="widget-grid" class="">

			<!-- row -->
			<div class="row">

				<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

					<!-- Widget ID (each widget will need unique ID)-->
					<div class="">


						<!-- widget div-->
						<div>
						    <div class="col-md-12 col-xs-12 col-sm-12" style="padding:10px 20px 10px 12px;">
						        <div class="col-md-12 col-xs-12 col-sm-12 no-padding" style="margin-bottom: 10px;">
						            <span style="font-size: 16pt; color:#0d0d56">督導日報管理列表</span>
												<?php if ($dp -> export_manager_daily_report == 1): ?>
													<button id="manager_daily_report_export" class="btn" style="float:right;background-color:#FF9030;color:white;">匯出督導日報資料</button>
												<?php endif; ?>

						        </div>
						    </div>
						    <!-- $$$$$$$$$$$$$$$$$ -->
								<div class="col-md-12 col-xs-12 col-sm-12">
									<div class="inline" style="padding:0px 12px 0px 0px ;">專案名稱</div>
									<div class="inline">
										<input id="project_filter" type="text" class="form-control" value="" placeholder="請輸入名稱"/>
									</div>

									<!-- <div class="inline">日期區間</div>
									<div class="inline" style="position:relative">
										<input class="form-control inline date-input dt_picker" id="start_time_filter" placeholder="YYYY-MM-DD" name="start_time_filter"/>
										<img src="<?=base_url('img/proj_new/cala.svg')?>" style="height:16px;position:absolute;right:20px;top:9px;z-index:3">
									</div>
									<div class="inline">~</div>
									<div class="inline" style="position:relative">
										<input class="form-control inline date-input dt_picker" id="end_time_filter" placeholder="YYYY-MM-DD" name="end_time_filter"/>
										<img src="<?=base_url('img/proj_new/cala.svg')?>" style="height:16px;position:absolute;right:20px;top:9px;z-index:3">
									</div> -->

									<div class="inline" style="padding:0px 12px;">完成狀態</div>
									<div class="inline">
										<select class="form-control" required name="check_status" id="is_finish_filter">
											<option value="all">全部</option>
											<option value="0">未完成</option>
											<option value="1">已完成</option>
										</select>
									</div>

									<div class="inline" style="line-height:32px;vertical-align:middle">
											<div class="input-group">
													<button type="button" class="btn btn-primary" id="searchlist2Btn">Go!</button>
											</div>
									</div>
								</div>
						    <hr class="clearfix"/>
								<section class="col-md-12 col-xs-12 col-sm-12" style="padding: 17px 17px;border:1px solid #ccc">
										<table id="dt_list" class="table display datatable">
												<thead>
													<tr>
															<th class="no-sort">專案名稱</th>
															<th class="no-sort">日報模板</th>
															<th class="no-sort">完成狀態</th>
															<th class="no-sort">專案完成</th>
															<th class="no-sort"></th>
															<th class="no-sort"></th>


													</tr>
														<tr class="searchbox">
																<th class="no-sort"></th>
																<th class="no-sort"></th>
																<th class="no-sort"></th>
																<th class="min100 no-sort">應</th>
																<th class="min100 no-sort">已</th>
																<th class="min100 no-sort">未</th>

														</tr>
												</thead>
												<tbody>
												</tbody>
												<tfoot>
													<tr class="searchbox">
															<th class="no-sort"></th>
															<th class="no-sort"></th>
															<th class="no-sort"><span style="float:right">合計</span></th>
															<th class="no-sort" id="all_count"><?=$all_count?></th>
															<th class="no-sort" id="finish_count"><?=$finish_count?></th>
															<th class="no-sort" id="unfinish_count"><?=$unfinish_count?></th>
													</tr>
												</tfoot>
										</table>
								</section>
						    <!-- <div class="col-sm-12">
						        <button type="button" class="btn btn-warning" onclick="javascript:void(0)">新增任務</button>
						    </div> -->
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
		loadScript(baseUrl + "js/app/manager_daily_report/list.js?<?=time()?>", function(){
			currentAppm = new MdrAppClass(new BaseAppClass({}));
			// currentApp.doEdit($('#login_user_id').val());
		});
	});
</script>

<script type="text/javascript">
	// date-picker
	$(".dt_picker").datetimepicker({
		format : 'YYYY-MM-DD'
	});

	$(".dt_picker_t").datetimepicker({
		format : 'HH:mm'
	});

</script>
<script>
	$('td').click(function(){
    id = $('#dt_list tr').index($(this).closest('tr'));

      var loading = $('<h1 class="ajax-loading-animation"><i class="fa fa-cog fa-spin"></i> Loading...</h1>')
        .appendTo($('#edit-modal-body').empty());
    $("#btn-submit-edit").prop( "disabled", true);
    $('.tab-pane').removeClass('active'); $('#edit_page').addClass('active');
    $('#edit-modal-body').load(baseUrl + 'mgmt/arrange_time_search/show_detail/' + id, function(){
      $("#btn-submit-edit").prop( "disabled", false);
      loading.remove();
    });
  })

	$('#searchlist2Btn').click(function() {
		currentAppm.tableReload();
		$.ajax({
			url: '<?= base_url() ?>' + 'mgmt/manager_daily_report/recount_all',
			type: 'POST',
			data: {
				project_filter : $('#project_filter').val(),
				is_finish_filter : $('#is_finish_filter').val()
			},
			dataType: 'json',
			success: function(d) {
				$('#all_count').text(d.all_count);
				$('#finish_count').text(d.finish_count);
				$('#unfinish_count').text(d.unfinish_count);
				$('a[data-dt-idx="1"]').click();
			},
			failure:function(){
				alert('faialure');
			}
		});
	})

	$('#manager_daily_report_export').click(function(){
		var id = '';
		layer.open({
			type:2,
			title:'',
			closeBtn:0,
			area:['1000px','500px'],
			shadeClose:true,
			content:'<?=base_url('mgmt/manager_daily_report/manager_daily_report_export/')?>'
		})
	})

</script>
