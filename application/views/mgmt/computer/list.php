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
											<th class=""></th>
											<th class="min100">電腦名稱</th>
											<th class="min100">建立時間</th>
										</tr>
										<tr class="search_box">
											<th></th>
											<th><input class="form-control input-xs min100" type="text" /></th>
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
<div class="modal fade" id="fixModal" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
			</div>
			<div class="modal-body" id="">
				<form id="" class="">
					<input id="fix_record_id"  type="hidden" value="">
					<input id="fix_type"  type="hidden" value="">
					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">維修日期</label>
							<div class="col-md-9">
								<div class="col-md-9">
									<input type="text" class="form-control" id="fix_date" value=""  />
								</div>
							</div>
						</div>
					</fieldset>
					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">完修日期</label>
							<div class="col-md-9">
								<div class="col-md-9">
									<input type="text" class="form-control" id="done_fix_date" value=""  />
								</div>
							</div>
						</div>
					</fieldset>
					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">維修方法</label>
							<div class="col-md-9">
								<div class="col-md-9">
									<input type="text" class="form-control" id="fix_way" value=""  />
								</div>
							</div>
						</div>
					</fieldset>
					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">故障原因</label>
							<div class="col-md-9">
								<div class="col-md-9">
									<input type="text" class="form-control" id="fix_result" value=""  />
								</div>
							</div>
						</div>
					</fieldset>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-sm" onclick="save_fix()">
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
<?php $this -> load -> view('general/delete_modal'); ?>
<script type="text/javascript">
	var mCols = [null,{
		data : 'computer_name'
	},{
		data : 'create_time'
	}];

	var mOrderIdx = 2;

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
		loadScript(baseUrl + "js/app/computer/list.js", function(){
			currentApp = new ComputerAppClass(new BaseAppClass({}));
		});
	});

	function save_fix(){
        $.ajax({
            url: '<?= base_url() ?>' + 'mgmt/fix_list/fix_record_insert',
            type: 'POST',
            data: {
				fix_date: $('#fix_record_id').val(),
                fix_date: $('#fix_type').val(),
                fix_date: $('#fix_date').val(),
                done_fix_date: $('#done_fix_date').val(),
				fix_way: $('#fix_way').val(),
                fix_result: $('#fix_result').val(),

            },
            dataType: 'json',
            success: function(d) {
                if(d) {
                    var $now_change_list = $('<div class="col-sm-12" style="border-width:3px;border-style:double;border-color:#ccc;padding:5px;"><div class="12ol-sm-ㄉ"><span change_id="'+d.last_id+'">舊有軟硬體:  '+$('#old_sh option:selected').text()+'   換成: '+$('#new_sh option:selected').text()+'  更換原因:  '+change_reason+'  處置情形:  '+change_way+'  維修者:  '+$('#change_user option:selected').text()+'</span></div></div></hr>').appendTo($('#now_fix'));
                    now_fix_record.push(d.last_id);
                }
            },
            failure:function(){
                alert('faialure');
            }
        });
	}

</script>
