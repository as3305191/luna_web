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
		<!-- <div class="widget-toolbar pull-left">
			<a href="javascript:void(0);" id="" onclick="do_save();" class="btn btn-default btn-danger">
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
			<form id="img-upload-form" method="post" style="display: none;" enctype="multipart/form-data">
				<input type="file" name="file" id="file" />
			</form>
			<form id="app-edit-form" method="post" class="form-horizontal">
				<input type="hidden" name="id" id="item_id" value="<?= isset($item) ? $item -> id : '' ?>" />
				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">公告類別</label>
						<div class="col-md-6" style="padding:8px 0px 0px 20px">
							<?= isset($item) ? $item -> news_style : '' ?>	
						</div>
					</div>
				</fieldset>
				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">標題</label>
						<div class="col-md-6" style="padding:8px 0px 0px 20px">
							<?= isset($item) ? $item -> title : '' ?>
						</div>
					</div>
				</fieldset>
				<fieldset id='content_panel'>
					<div class="form-group">
						<label class="col-md-3 control-label">內容</label>
						<div class="col-md-6" style="padding:8px 0px 0px 20px">
							<?= isset($item) ? $item -> content : '' ?>
						</div>
					</div>
				</fieldset>
			</form>
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
	.cke_skin_v2 input.cke_dialog_ui_input_text, .cke_skin_v2 input.cke_dialog_ui_input_password {
	    background-color: white;
	    border: none;
	    padding: 0;
	    width: 100%;
	    height: 14px;
	    /* new lines */
	    position: relative;
	    z-index: 9999;
	}
	div.cke_dialog_body {
		border: 1px solid #BCBCBC;
	}
</style>

