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
		<div>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">開放日期</label>
					<div class="col-md-6">
						<input class="form-control input-xs min100 dt_picker"  id="open_date" type="text"  value="<?= isset($item) ? $item -> open_date : '' ?>" />
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">參賽人1</label>
					<div class="col-md-6">
						<input type="text" required class="form-control" id="m_1" value="<?= isset($item) ? $item -> note : '' ?>"  />
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">參賽人2</label>
					<div class="col-md-6">
						<input type="text" required class="form-control" id="m_2" value="<?= isset($item) ? $item -> note : '' ?>"  />
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">參賽人3</label>
					<div class="col-md-6">
						<input type="text" required class="form-control" id="m_3" value="<?= isset($item) ? $item -> note : '' ?>"  />
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">參賽人4</label>
					<div class="col-md-6">
						<input type="text" required class="form-control" id="m_4" value="<?= isset($item) ? $item -> note : '' ?>"  />
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">參賽人5</label>
					<div class="col-md-6">
						<input type="text" required class="form-control" id="m_5" value="<?= isset($item) ? $item -> note : '' ?>"  />
					</div>
				</div>
			</fieldset>
			
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

$(".dt_picker").datetimepicker({
	format : 'YYYY.MM.DD'
}).on('dp.change',function(event){

});

function do_save(id) {
	$.ajax({
		url: '<?= base_url() ?>' + 'mgmt/sing_status/switch_sing',
		type: 'POST',
		data: {
			id: $('#item_id').val(),
			open_date: $('#open_date').val(),
			m_1: $('#m_1').val(),
			m_2: $('#m_2').val(),
			m_3: $('#m_3').val(),
			m_4: $('#m_4').val(),
			m_5: $('#m_5').val(),

		},
		dataType: 'json',
		success: function(d) {
			currentApp.tableReload();
		},
		failure:function(){
			alert('faialure');
		}
	});
}
</script>
