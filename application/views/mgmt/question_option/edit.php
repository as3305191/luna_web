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
					<label class="col-md-3 control-label">問卷種類</label>
					<div class="col-md-6" id="patnet_status" >
						<input type="hidden" required class="form-control" id="s_question_style" value="<?= isset($item) ? $item -> question_style_id : 0 ?>"  />
						<select id="question_style" class="form-control">
										
						</select>
					</div>
				</div>
			</fieldset>

			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">註記</label>
					<div class="col-md-6">
						<input type="text" required class="form-control" name="note"  id="note" value="<?= isset($item) ? $item -> note : '' ?>"  />
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


	function do_save() {
	var url = baseUrl + 'mgmt/menu/insert'; // the script where you handle the form input.
	$.ajax({
		type : "POST",
		url : url,
		data : {
			id: $('#item_id').val(),
			menu_style_id:$('#menu_style_id').val(),
			menu_name: $('#menu_name').val(),
			img: img.join(","),
			open_date: $('#open_date').val(),
			note: $('#note').val(),
			dep_array: $('#dep_array').val()
		},
		success : function(data) {
			if(data.error_msg) {
				layer.msg(data.error_msg);
			} else {
				currentApp.mDtTable.ajax.reload(null, false);
				currentApp.backTo();
			}
		}
	});
};

function load_style() {
		$.ajax({
			url: '<?= base_url() ?>' + 'mgmt/question_option/find_question_style',
		
			type: 'POST',
			dataType: 'json',
			success: function(d) {
				if(d) {
					var s_question_style=$('#s_question_style').val();
					// console.log(d);
					$question_style = $('#question_style').empty();
					var option = '<option value="0">無</option>';
					$question_style.append(option);
					if(s_question_style>0 ){ 
						$.each(d.question_style, function(){
							if(this.id==s_question_style){
								$('<option/>', {
									'value': this.id,
									'text': this.question_style_name
								}).attr("selected", true).appendTo($question_style);	
							} else{
								$('<option/>', {
									'value': this.id,
									'text': this.question_style_name
								}).appendTo($question_style);
							}
						});
					} else{
						$.each(d.question_style, function(){
							$('<option/>', {
								'value': this.id,
								'text': this.question_style_name
							}).appendTo($question_style);
						});
					}
					
				}
			},
			failure:function(){
				alert('faialure');
			}
		});
	}
	load_style();
	$('#question_style').on('change', function(){
		$('#s_question_style').val($('#question_style').val()) ;
	});
</script>
