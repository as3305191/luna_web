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
		</div>
		
		<div class="widget-toolbar pull-left">
			<a href="javascript:void(0);"  onclick="do_save();" class="btn btn-default btn-danger">
				<i class="fa fa-save"></i>存檔
			</a>
		</div>
		
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
			<form id="app-edit-form" method="post" class="form-horizontal">
				<input type="hidden" name="id" id="item_id" value="<?= isset($item) ? $item -> id : '' ?>" />
			
				<div class="form-group" style="padding:0px 26px">
        <div class="clearfix"></div>
    </div>
    <hr/>
		<div >
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">問卷名稱</label>
					<div class="col-md-6" >
						<input type="text" required class="form-control" name="question_title_name"  id="question_title_name" value="<?= isset($item) ? $item -> question_title_name : '' ?>"  />
					</div>
				</div>
			</fieldset>
				<table id="dt_list_question" class="table table-striped table-bordered table-hover" width="100%">

					<thead>
						<tr>
							<th></th>
							<th>題目</th>
						</tr>
						<tr>
							<td class="min50" style="border-right:none;"></td>
							
							<td style="border-right:none;">
								<div class="input-group col-md-10">
									<input type="text" class="form-control" id="order_name" placeholder="題目">
								</div>
								<button type="button" class="btn btn-sm btn-primary" onclick="add_order()"><i class="fa fa-plus-circle fa-lg"></i></button>
							</td>							
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>		
		</form>

		</div>
		<!-- end widget content -->

	</div>
	<!-- end widget div -->

</div>
<!-- end widget -->
<script>
		currentApp.question = new questioneachAppClass(new BaseAppClass({}));

</script>
