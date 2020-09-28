<style>
	.main {
		background-color: #F0F0F0;
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
		<div class="widget-toolbar pull-left">
			<a href="javascript:void(0);" id="back_parent" onclick="currentApp.doSubmit()" class="btn btn-default btn-danger">
				<i class="fa fa-save"></i>存擋
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
				<input type="hidden" name="id" value="<?= isset($item) ? $item -> id : '' ?>" />
				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">角色名稱</label>
						<div class="col-md-6">
							<input type="text" required class="form-control" name="name" value="<?= isset($item) ? $item -> name : '' ?>" />
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

<!-- PAGE RELATED PLUGIN(S) -->
<script>
$('#app-edit-form').bootstrapValidator({
	feedbackIcons : {
		valid : 'glyphicon glyphicon-ok',
		invalid : 'glyphicon glyphicon-remove',
		validating : 'glyphicon glyphicon-refresh'
	}
});

$('#chk-all').on('click', function(){
	$('#power-table .menu-chk').prop('checked', $(this).is(':checked'));
});

$('.menu-chk').on('click', function(){
	var me = $(this);
	if(me.data('mm')) {
		// sub
		$('#mm_' + me.data('mm')).prop('checked', true);
	} else {
		// main
		if(!me.is(':checked')) {
			// remove all sub
			console.log('main');
			$('#power-table .menu-chk[data-mm=' + me.data('id') + ']').prop('checked', false);
		}
	}

	isAllChecked();
});

function isAllChecked() {
	console.log('isAllChecked');
	$('#chk-all').prop('checked', $('.menu-chk:checked').length == $('.menu-chk').length);
}

isAllChecked();
</script>
