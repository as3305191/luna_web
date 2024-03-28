<style>

.btn_1 {
	background-color: #FFD22F !important;
	color: #F57316 !important;
}
.is_ok {
	background-color:lightgreen;
}
.not_ok {
	background-color:red;
}
.fileinput-upload{
	display:none !important;
}
.fileinput-remove{
	display:none !important;
}
.fail_fieldset{
	display:none !important;
}
.family_span:hover{
    color:#FFD22F;
}
.remove_pa:hover{
    color:#9AFF02;
}

</style>
<!-- Widget ID (each widget will need unique ID)-->
<div class="jarviswidget" id="wid-id-7" data-widget-colorbutton="false"	data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
	<header>
		<div class="widget-toolbar pull-left">
			<a href="javascript:void(0);" id="back_parent" onclick="currentApp.backTo()" class="btn btn-default">
				<i class="fa fa-arrow-circle-left"></i>返回
			</a>
			<a href="javascript:void(0);" onclick="currentApp.each_detail.export_item()" class="btn btn-default">
				<i class="fa fa-save"></i>下載檔案
			</a>
		</div>
		
		<!-- <div class="widget-toolbar pull-left">
			<a href="javascript:void(0);"  onclick="do_save();" class="btn btn-default btn-danger">
				<i class="fa fa-save"></i>存檔
			</a>
		</div> -->
		
	</header>
	<!-- widget div-->
	<div>
		<!-- widget edit box -->
		<div class="jarviswidget-editbox">
			<!-- This area used as dropdown edit box -->
			<input class="form-control" type="text">
		</div>
		<!-- end widget edit box -->
		<!-- widget content -->
		<div class="widget-body">
			<form id="app-export-form" method="post" class="form-horizontal">
			<input type="hidden" name="id" id="export_item_id" value="<?= isset($item) ? $item -> id : '' ?>" />
			
			
					<div class="col-md-12 col-xs-12 col-sm-12 " style="padding:0px 0px 6px 0px;">
						<span style="font-size: 16pt;color:#0d0d56">未填寫人員：</span>
					</div>
					<div class="col-md-12 col-xs-12 col-sm-12 " id="not_finish_p" style="padding:0px 0px 6px 0px;">
						
					</div>
				
					<div>
						<div class="col-md-12 col-xs-12 col-sm-12 " style="padding:0px 0px 6px 0px;">
							<span style="font-size: 16pt;color:#0d0d56">已填寫資料：</span>
						</div>
							<div class="widget-toolbar pull-left">
								<input id="s_name" placeholder="搜尋人名" type="text" class="" >
							</div>
						
						<table id="dt_list_each_detail" class="table table-striped table-bordered table-hover" width="100%">
							<thead>
								<tr>
									<th class="min100"></th>
									<th class="min150">姓名</th>
									<th class="min150">建立時間</th>
									<th class="min150">匯出</th>
								</tr>
							
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>	
			</div>
		
			</form>

		</div>
		<!-- end widget content -->

	</div>
	<!-- end widget div -->

</div>
<!-- end widget -->
<!-- <script src="http://www.appelsiini.net/download/jquery.jeditable.mini.js"></script> -->
<script>
currentApp.each_detail = new QuestioneachdetailAppClass(new BaseAppClass({}));

function load_not_finish() {
		var html ='';
		$.ajax({
			url: '<?= base_url() ?>' + 'mgmt/question_option/get_data_not_finish',
		
			type: 'POST',
			dataType: 'json',
			data : {
				item_id: $('#export_item_id').val(),
			},
			success: function(d) {
				if(d) {
					$question_style = $('#not_finish_p').empty();
					$.each(d.items, function(){
						html+='<span>'+this.dep_name+'-'+this.user_name+'</span> ';
					});
					$question_style.append(html);
					// console.log(html);
					
				}
			},
			failure:function(){
				alert('faialure');
			}
		});
	}
	load_not_finish();
</script>
