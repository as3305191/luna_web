<style>
.file-drag-handle {
	display: none;
}
</style>
<!-- Widget ID (each widget will need unique ID)-->
<div class="jarviswidget" id="wid-id-7" data-widget-colorbutton="false"	data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
	<header>
		<div class="widget-toolbar pull-left">
			<a href="javascript:void(0);" id="back_parent" onclick="currentApp.backTo()" class="btn btn-default ">
				<i class="fa fa-arrow-circle-left"></i>返回
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
		<div class="" >
			<div class="widget-toolbar pull-left">
				<input id="dtt" placeholder="請輸入日期" type="text" class="dt_picker " value="<?= date('Y-m-d') ?>" autocomplete="off"  />
			</div>
				<table id="question_list" class="table table-striped table-bordered table-hover" width="100%">
					<thead>
						<tr>
							<th class="min100">題目</th>
							<th class="min100">答案</th>
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
<style>
	.kv-file-zoom {
		display: none;
	}
</style>
<script>


	currentApp.questionList = new QuestionAppClass(new BaseAppClass({}));


</script>
