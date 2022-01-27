<style>
/* .file-drag-handle {
	display: none;
} */
.none {
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
		<div class="widget-body">
			<form id="img-upload-form" method="post" style="display: none;" enctype="multipart/form-data">
				<input type="file" name="file" id="file" />
			</form>

			<form id="app-edit-form" method="post" class="form-horizontal">
				<input type="hidden" name="swot_title_id" id="swot_title_id" value="<?= isset($swot_title_id) ? $swot_title_id: '' ?>" />
				<div>
				<table id="swot_style_table" class="table table-striped table-bordered table-hover" width="100%">
					<thead>
						<tr>
							<th class="min100"></th>
							<th class="min500">文件種類</th>
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
	currentApp.swot_style = new swotstyleAppClass(new BaseAppClass({}));
	
</script>
