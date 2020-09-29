<style>
	#dt_list_wrapper {
		border-top: 1px solid #CCCCCC;
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
					<div class="col-md-12 col-xs-12 col-sm-12" style="padding:10px 17px 10px 17px;">
						<div class="col-md-12 col-xs-12 col-sm-12 no-padding" >
							<span style="font-size: 16pt; color:#0d0d56">專利項目類別</span>
							<button class="btn" id="new_department" style="float:right;background-color:#FF9030;color:white;width:140px">新增專利主項目</button>
						</div>
					</div>
					<!-- Widget ID (each widget will need unique ID)-->
					<div class="" >
						<!-- widget div-->
						<div>
							<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->
							</div>
							<!-- end widget edit box -->
							<!-- widget content -->
							<div class="widget-body" >
								<section class="col-md-12 col-xs-12 col-sm-12" style="padding: 17px 17px;border:1px solid #ccc;background-color:#fff">
								<table id="dt_list" class="table table-striped table-bordered table-hover" width="100%">
									<thead>
										<tr>
											<th class="">項目名稱</th>
											<th class="">操作</th>
										</tr>
									</thead>
									<tbody id="t_data">

									</tbody>
								</table>
								</section>
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

	<div class="tab-pane" id="edit_page">
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
		loadScript(baseUrl + "js/app/patent_category/list.js", function(){
			currentApp = new PatentcategoryAppClass(new BaseAppClass({}));
		});
	});

	$('#t_data').empty();
	$('#t_data').html('<?=$t_data?>');

	function add_under($id) {
		layer.open({
			type:2,
			title:'',
			closeBtn:0,
			area:['400px','200px'],
			shadeClose:true,
			content:'<?=base_url('mgmt/patent_category/show_role_window/')?>'+$id
		})
	}

	function edit_page($id) {
		var loading = $('<h1 class="ajax-loading-animation"><i class="fa fa-cog fa-spin"></i> Loading...</h1>').appendTo($('#edit-modal-body').empty());
		$("#btn-submit-edit").prop( "disabled", true);

		$('.tab-pane').removeClass('active'); $('#edit_page').addClass('active');

		$('#edit-modal-body').load(baseUrl + 'mgmt/patent_category/edit_page/' + $id, function(){
					$("#btn-submit-edit").prop( "disabled", false);
					var url = baseUrl + 'mgmt/patent_category/re_index'; 
					$.ajax({
						type : "POST",
						url : url,
						data : {},
						success : function(data) {
							if(data) {
								$('#t_data').empty();
								$('#t_data').html(data.t_data);
							}
						}
					});
					
		});
	}

	$('#new_department').click(function() {
		layer.open({
		type:2,
		title:'',
		closeBtn:0,
		area:['400px','200px'],
		shadeClose:true,
		content:'<?=base_url('mgmt/patent_category/new_department')?>'
		})
	})

	function del_page($id) {
		$.ajax({
			url: '<?= base_url() ?>' + 'mgmt/patent_category/del_page',
			type: 'POST',
			data: {
				id:$id
			},
			dataType: 'json',
			success: function(d) {
				if(d.success){
					var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
					parent.layer.close(index);
					layer.msg('已刪除');
					parent.location.reload();
				}
				if(d.error_msg){
					layer.msg(d.error_msg);
				}
			},
			failure:function(){
				layer.msg('faialure');
			}
		});
	}
</script>
