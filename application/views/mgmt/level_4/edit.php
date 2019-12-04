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
		<div class="widget-body">

			<form id="app-edit-form" method="post" class="form-horizontal">
				<input type="hidden" name="id" id="item_id" value="<?= isset($id) ? $id : '' ?>" />

				<?php foreach ($item as $each): ?>
					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">不一樣的事</label>
							<div class="col-md-6">
								<input type="text"  class="form-control"  style="border-width: 0;" value="<?= isset($each) ? $each -> content : '' ?>" />
							</div>
						</div>
					</fieldset>
					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">更新時間</label>
							<div class="col-md-6">
								<input type="text"  class="form-control" style="border-width: 0;" value="<?= isset($each) ? $each -> create_time : '' ?>" />
							</div>
						</div>
					</fieldset>
					<hr/>
				<?php endforeach; ?>
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
</style>
<script>



</script>
