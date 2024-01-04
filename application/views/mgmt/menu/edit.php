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
					<label class="col-md-3 control-label">店名</label>
					<div class="col-md-6" id="patnet_status" >
						<input type="text" required class="form-control" name="menu_name"  id="menu_name" value="<?= isset($item) ? $item -> menu_name : '' ?>"  />
						<div style="color:#a90329;" id="same_name">
						</div>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">分類</label>
					<div class="col-md-6">
						<input type="hidden" required class="form-control" name="s_menu_style_id"  id="s_menu_style_id" value="<?= isset($item) ? $item -> menu_style_id : 0 ?>"  />
						<select id="menu_style_id" class="form-control">
											<!-- option from javascript -->
						</select>
					</div>
				</div>
			</fieldset>

			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">開放日期</label>
					<div class="col-md-6">
						<input class="form-control input-xs min100 dt_picker"  id="open_date" type="text"  value="<?= isset($item) ? $item -> open_date : 0 ?>" />
					</div>
				</div>
			</fieldset>

			<fieldset >
				<div class="form-group" >
					<label class="col-md-3 control-label">開放部門</label>
					<input type="hidden" id="dep_array" value="<?= isset($dep_array) ? $dep_array : '' ?>" />
					<div class="col-md-6">

						<select id="user_dep_array" name="user_dep[]" class="form-control" multiple>
						
						</select>
						
					</div>

				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">備註</label>
					<div class="col-md-6">
						<input type="text" required class="form-control" name="note"  id="note" value="<?= isset($item) ? $item -> note : '' ?>"  />
					</div>
				</div>
			</fieldset>
			

			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">圖片</label>
					<div class="col-md-6">
						<input id="img-input" name="file[]" type="file" accept="image/*" multiple class="file-loading form-control" >
						<input id="img_id" type="hidden"  value="<?= isset($item) ? $item -> img_id : '' ?>" >
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
	var img=false
	if($('#item_id').val()>0){
		img=[];
		if($('#img_id').val().length>0){
			img.push($('#img_id').val());
		}
	} else{
		img=[];
	}

	$(".dt_picker").datetimepicker({
		format : 'YYYY.MM.DD'
	}).on('dp.change',function(event){

	});
	var dep_array =[];

	if(typeof $('#dep_array').val() !=='undefined'){
		dep_array.push($('#dep_array').val());

	}


	function find_dep() {	
		
		$.ajax({
			url: '<?= base_url() ?>' + 'mgmt/menu/find_dep',
			type: 'POST',
			data: {},
			dataType: 'json',
			success: function(d) {
				if(d) {
					// console.log(d);
					$user_dep_array = $('#user_dep_array').empty();
					option ='';
					if(user_dep_array.length>0){
						$new_user_dep_array = user_dep_array[0].split(",");

					} else{
						$new_user_dep_array = [];

					}

					$.each(d.dep[0], function(){
						if($new_user_dep_array.indexOf(this.id)>=0){
							option +='<option value="'+this.id+'"  selected="selected">'+this.name+'</option>';
						} else{
							option +='<option value="'+this.id+'">'+this.key+'</option>';
						}

					});
					$user_dep_array.append(option).select2();
					// select2()
				}	
			},
			failure:function(){
				alert('faialure');
			}
		});

	}
	find_dep();
	$('#user_dep_array').on('change', function(){
		$('#dep_array').val('');
		$('#dep_array').val($('#user_dep_array').val());
	});


$("#img-input").fileinput({
					language: "zh-TW",
			
		<?php if(!empty($item -> image) && count($item -> image) > 0): ?>

        	initialPreview: [
        		<?php foreach($item -> image as $img): ?>
        			'<?=  base_url('mgmt/images/get/' . $img->id) ?>',
        		<?php endforeach ?>
			],
        	initialPreviewConfig: [
			<?php foreach($item -> image as $img): ?>
				{
						'caption' : '<?= $img -> image_name ?>',
						'size' : <?= $img -> image_size ?>,
						'width' : '120px',
						'url' : '<?= base_url('mgmt/images/delete/' . $img->id )  ?>',
						'downloadUrl': '<?=base_url('mgmt/images/get/' . $img->id)?>',
						'key' : <?= $img->id?>
				},
				
    		<?php endforeach ?>
        	],
        <?php else: ?>
        	initialPreview: [],
        	initialPreviewConfig: [],
        <?php endif ?>
        initialPreviewAsData: true,
		overwriteInitial: false,
		purifyHtml:true ,
		maxFileCount: 1,
		
        uploadUrl: 'mgmt/images/upload/img',
        uploadExtraData: {
        }
    }).on('fileuploaded', function(event, data, previewId, index) {
		// upload image
		var id = data.response.id;
		img.push(id);	
		console.log(img);
	}).on('fileselect', function(event, numFiles, label) {
    	$("#img-input").fileinput('upload');
	}).on('filedeleted', function(event,data,key) {
		img.splice($.inArray(data,img),1);
	}).on('fileuploaderror', function(event, data, previewId, index) {
		alert('upload error');
	}).on('filedeleted', function(event,data,key) {
	});


	$('#menu_name').on('keyup', function(){
		var url = baseUrl + 'mgmt/menu/menu_name_check'; // the script where you handle the form input.
		$.ajax({
			type : "POST",
			url : url,
			data : {
				menu_name: $('#menu_name').val(),
			},
			success : function(data) {
				if(data.count_same_menu_name>0){
					$('#same_name').text('已有相似店家： '+data.same_name_list);
				} else{
					$('#same_name').text('');
				}
				
			}
		});
	});
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
			dep_array: dep_array.join(",")
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
			url: '<?= base_url() ?>' + 'mgmt/menu/find_menu_style',
		
			type: 'POST',
			dataType: 'json',
			success: function(d) {
				if(d) {
					var menu_style_id=$('#s_menu_style_id').val();
					// console.log(d);
					$img_style = $('#menu_style_id').empty();
					var option = '<option value="0">無</option>';
					$img_style.append(option);
					if(menu_style_id>0 ){ 
						$.each(d.menu_style, function(){
							if(this.id==menu_style_id){
								$('<option/>', {
									'value': this.id,
									'text': this.menu_style
								}).attr("selected", true).appendTo($img_style);	
							} else{
								$('<option/>', {
									'value': this.id,
									'text': this.menu_style
								}).appendTo($img_style);
							}
						});
					} else{
						$.each(d.menu_style, function(){
							$('<option/>', {
								'value': this.id,
								'text': this.menu_style
							}).appendTo($img_style);
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
	$('#menu_style_id').on('change', function(){
		$('#s_menu_style_id').val($('#menu_style_id').val()) ;
	});
</script>
