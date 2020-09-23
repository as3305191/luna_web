<style>
.file-drag-handle {
	display: none;
}
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
			<a href="javascript:void(0);" id="" onclick="do_save();" class="btn btn-default btn-danger">
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
				<!-- <input type="hidden" name="role_id"  value="1" /> -->
				<div class="form-group" style="padding:0px 26px">
        <div class="clearfix"></div>
    </div>
    <hr/>
		<div >
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">專利名稱</label>
					<div class="col-md-6">
						<input type="text" required class="form-control" name="patnet_name"  id="patnet_name" value="<?= isset($item) ? $item -> patent_name : '' ?>"  />
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">專利家族代碼</label>
					<div class="col-md-6">
						<input type="text"  class="form-control" name="patent_family"  id="patent_family" value="<?= isset($item) ? $item -> patent_family : '' ?>"  />
					</div>
					<div class="col-md-2">
						<button type="button" class="btn btn-sm btn-primary" onclick="check_family()">檢查</button>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">專利國家</label>
					<div class="col-md-6">
						<select name="patnet_country" id="patnet_country" class="form-control" >
							<option value="-1">無</option>
							<?php foreach($country as $each): ?>
								<option value="<?= $each -> id?>" ><?=  $each -> country_name ?></option>
							<?php endforeach ?>
						</select>
					</div>
					<div class="col-md-2">
						<button type="button" class="btn btn-sm btn-primary" id="add_country"><i class="fa fa-plus-circle fa-lg"></i></button>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">關鍵字</label>
					<div class="col-md-6">
						<input type="text"  class="form-control" name="patent_key"  id="patent_key" value="<?= isset($item) ? $item -> patent_key : '' ?>"  />
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">專利類別</label>
					<div class="col-md-6">
						<select name="patnet_category" id="patnet_category" class="form-control" >
							<option  value="1" >發明</option>
							<option  value="2" >新型</option>
							<option  value="3" >設計</option>
						</select>	
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">申請號</label>
					<div class="col-md-6">
						<input type="text" required class="form-control" name="application_num"  id="application_num" value="<?= isset($item) ? $item -> application_num : '' ?>"  />
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">公開號</label>
					<div class="col-md-6">
						<input id="public-num-input" name="file" type="file" accept=".pdf" multiple class="file-loading form-control">
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">專利號</label>
					<div class="col-md-6">
						<input id="patnet-num-input" name="file" type="file" accept=".pdf" multiple class="file-loading form-control">
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">申請日</label>
					<div class="col-md-6">
						<input type="text" required class="form-control dt_picker" name="application_date"  id="application_date" value="<?= isset($item) ? $item -> application_date : '' ?>"  />
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">公開日</label>
					<div class="col-md-6">
						<input type="text"  class="form-control dt_picker" name="public_date"  id="public_date" value="<?= isset($item) ? $item -> public_date : '' ?>"  />
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">公告日</label>
					<div class="col-md-6">
						<input type="text"  class="form-control dt_picker" name="announcement_date"  id="announcement_date" value="<?= isset($item) ? $item -> announcement_date : '' ?>"  />
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">專利權期間</label>
					<div class="col-md-2 widget-toolbar pull-left">
						<input id="s_dt" placeholder="開始日期" type="text" class="dt_picker" value="<?= isset($item) ? $item -> patent_start_dt : '' ?>" />
					</div>
					
					<div class="col-md-2 widget-toolbar pull-left">
						~<input id="e_dt" placeholder="結束日期" type="text" class="dt_picker" value="<?= isset($item) ? $item -> patent_end_dt : '' ?>" />
					</div>
					<div class="col-md-2 widget-toolbar pull-left">
						共
						<input type="text" id="year"/>
						年						
					</div>
					
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">專利權止日</label>
					<div class="col-md-6">
						<input type="text" class="dt_picker form-control" name="patent_finish_date"  id="patent_finish_date" value="<?= isset($item) ? $item -> patent_finish_date : '' ?>"  />
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">專利狀態</label>
					<div class="col-md-6">
						<select name="patnet_status" id="patnet_status" class="form-control" >
							<option  value="1" >有效</option>
							<option  value="2" >無效</option>
						</select>	
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">專利摘要</label>
					<div class="col-md-6">
						<textarea type="text" require class="form-control" rows="10" id="patent_note" name="patent_note" style="resize:none;width:100%"><?= isset($item) ? $item -> patent_note : '' ?></textarea>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">專利範圍</label>
					<div class="col-md-6">
						<textarea type="text" require class="form-control" rows="10" id="patent_range" name="patent_range" style="resize:none;width:100%"><?= isset($item) ? $item -> patent_range : '' ?></textarea>
					</div>
				</div>
			</fieldset>		
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">專利代表圖</label>
					<div class="col-md-6">
						<input id="img-input" name="file" type="file" accept="image/*" multiple class="file-loading form-control">
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">專利分析相關文件</label>
					<div class="col-md-6">
						<input id="file-input" name="file" type="file" accept=".pdf" multiple class="file-loading form-control">
					</div>
				</div>
			</fieldset>	
			

						<style>
							#product_spec_list {
							
								margin-top: 10px;
								margin-bottom: 10px;
							}

							#product_spec_list div {
								margin-top: 5px!important;
								margin-bottom: 5px!important;
							}

							#product_spec_list > div.row {
								background-color: #EEEEEE;
								font-size: 16px;
								font-weight: bolder;
							}

						</style>

		</div>

			</form>

		</div>
		<!-- end widget content -->

	</div>
	<!-- end widget div -->

</div>
<!-- end widget -->
<script src="http://www.appelsiini.net/download/jquery.jeditable.mini.js"></script>

<style>
	.kv-file-zoom {
		display: none;
	}	
</style>

<script>
$(document).ready(function() {
	if($('#item_id').val()==0){
		var url = baseUrl + 'mgmt/patent/new_patent_family'; // the script where you handle the form input.
		$.ajax({
			type : "POST",
			url : url,
			// data : {},
			success : function(d) {
				$('#patent_family').val(d.family_num);
			}
		});
	}
});

$('#app-edit-form').bootstrapValidator({
		feedbackIcons : {
			valid : 'glyphicon glyphicon-ok',
			invalid : 'glyphicon glyphicon-remove',
			validating : 'glyphicon glyphicon-refresh'
		},
		fields: {
			account: {
            validators: {
              remote: {
              	message: '已經存在',
              	url: baseUrl + 'mgmt/users/check_account/' + ($('#item_id').val().length > 0 ? $('#item_id').val() : '0')
              }
            }
         }
      }

	}).bootstrapValidator('validate');

$(".dt_picker").datetimepicker({
    format : 'YYYY-MM-DD'
}).on('dp.change',function(event){

});

var img='';
var pdf_array=[];
var public_num_input=[];
var patnet_num_input=[];
// console.log(img);
// console.log(pdf_array);

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
		img='';
		var id = data.response.id;
		img=id ;
		// console.log(img_array);
		// $('#image_id').val(id);
	   $("#img-input").fileinput('reset');
	}).on('fileselect', function(event, numFiles, label) {
    	$("#img-input").fileinput('upload');
	}).on('filedeleted', function(event,data,key) {
		img='';
		// console.log(img_array);
	}).on('fileuploaderror', function(event, data, previewId, index) {
		alert('upload error');
	}).on('filedeleted', function(event,data,key) {

	});

	$("#file-input").fileinput({
		language: "zh-TW",
		initialPreviewAsData: true,
		overwriteInitial: false,
		purifyHtml:true ,
		 
        <?php if(!empty($item -> files) && count($item -> files) > 0): ?>
        	initialPreview: [
        		<?php foreach($item -> files as $files): ?>
        			'<?=  base_url('mgmt/images/get_pdf/' . $files->id) ?>',
        		<?php endforeach ?>
        	],
        	initialPreviewConfig: [
        	<?php foreach($item -> files as $files): ?>
    		{
	        		'caption' : '<?= $files -> file_name ?>',
	        		'size' : <?= $files -> file_size ?>,
					'width' : '120px',
					'type': 'pdf',
					'downloadUrl': '<?=base_url('mgmt/images/get_pdf/' . $files->id)?>',
	        		'url' : '<?= base_url('mgmt/images/delete_file/' . $files->id)  ?>',
	        		'key' : <?= $files->id?>
	        },
    		<?php endforeach ?>

        	],
        <?php else: ?>
        	initialPreview: [],
        	initialPreviewConfig: [],
		<?php endif ?>
	
        maxFileCount: 1,
        uploadUrl: 'mgmt/images/upload_img_or_pdf/file',
        uploadExtraData: {
        }
    }).on('fileuploaded', function(event, data, previewId, index) {
    	// upload image
	   var id = data.response.id;
	   pdf_array.push(id);
	   console.log(pdf_array);
	//    $("#file-input").fileinput('reset');
	}).on('fileselect', function(event, numFiles, label) {
    	$("#file-input").fileinput('upload');
	}).on('filedeleted', function(event,data,key) {
		pdf_array.splice($.inArray(data,pdf_array),1);

	}).on('fileuploaderror', function(event, data, previewId, index) {
		alert('upload error');
	}).on('filedeleted', function(event,data,key) {
	

	});

	$("#public-num-input").fileinput({
		language: "zh-TW",
        <?php if(!empty($item -> public_number) && count($item -> public_number) > 0): ?>
        	initialPreview: [
        		<?php foreach($item -> public_number as $files): ?>
        			'<?=  base_url('mgmt/images/get_pdf/' . $files->id) ?>',
        		<?php endforeach ?>
        	],
        	initialPreviewConfig: [
				<?php foreach($item -> public_number as $files): ?>
    		{
	        		'caption' : '<?= $files -> file_name ?>',
	        		'size' : <?= $files -> file_size ?>,
					'width' : '120px',
					'type': 'pdf',
					'downloadUrl': '<?=base_url('mgmt/images/get_pdf/' . $files->id)?>',
	        		'url' : '<?= base_url('mgmt/images/delete_file/' . $files->id )  ?>',
	        		'key' : <?= $files->id?>
	        },
    		<?php endforeach ?>

        	],
        <?php else: ?>
        	initialPreview: [],
        	initialPreviewConfig: [],
		<?php endif ?>
		overwriteInitial: false,
    	initialPreviewAsData: true,
        maxFileCount: 1,
        uploadUrl: 'mgmt/images/upload_img_or_pdf/file',
        uploadExtraData: {
        }
    }).on('fileuploaded', function(event, data, previewId, index) {
    	// upload image
	   var id = data.response.id;
	   public_num_input.push(id);
	   console.log(public_num_input);
	//    $("#file-input").fileinput('reset');
	}).on('fileselect', function(event, numFiles, label) {
    	$("#public-num-input").fileinput('upload');
	}).on('filedeleted', function(event,data,key) {
		public_num_input.splice($.inArray(data,public_num_input),1);

	}).on('fileuploaderror', function(event, data, previewId, index) {
		alert('upload error');
	}).on('filedeleted', function(event,data,key) {
	

	});

	$("#patnet-num-input").fileinput({
					language: "zh-TW",
        <?php if(!empty($item -> patnet_number) && count($item -> patnet_number) > 0): ?>
        	initialPreview: [
        		<?php foreach($item -> patnet_number as $files): ?>
        			'<?=  base_url('mgmt/images/get_pdf/' . $files->id) ?>',
        		<?php endforeach ?>
        	],
        	initialPreviewConfig: [
				<?php foreach($item -> patnet_number as $files): ?>
    		{
	        		'caption' : '<?= $files -> file_name ?>',
	        		'size' : <?= $files -> file_size ?>,
					'width' : '120px',
					'type': 'pdf',
					'downloadUrl': '<?=base_url('mgmt/images/get_pdf/' . $files->id)?>',
	        		'url' : '<?= base_url('mgmt/images/delete_file/' . $files->id )  ?>',
	        		'key' : '<?= $files->id  ?>'
	        },
    		<?php endforeach ?>

        	],
        <?php else: ?>
        	initialPreview: [],
        	initialPreviewConfig: [],
		<?php endif ?>
        overwriteInitial: false,
    	initialPreviewAsData: true,
        maxFileCount: 1,
        uploadUrl: 'mgmt/images/upload_img_or_pdf/file',
        uploadExtraData: {
        }
    }).on('fileuploaded', function(event, data, previewId, index) {
    	// upload image
	   var id = data.response.id;
	   patnet_num_input.push(id);
	   console.log(patnet_num_input);
	//    $("#file-input").fileinput('reset');
	}).on('fileselect', function(event, numFiles, label) {
    	$("#patnet-num-input").fileinput('upload');
	}).on('filedeleted', function(event,data,key) {
		patnet_num_input.splice($.inArray(data,patnet_num_input),1);

	}).on('fileuploaderror', function(event, data, previewId, index) {
		alert('upload error');
	}).on('filedeleted', function(event,data,key) {
	

	});

function check_family(){
	var url = baseUrl + 'mgmt/patent/check_family'; 
	$.ajax({
		type : "POST",
		url : url,
		data : {
			patent_family: $('#patent_family').val(),
		},
		success : function(d) {
			if(d.valid=='TRUE'){//沒有重複
				$('#patent_family').removeClass('not_ok');
				$('#patent_family').addClass('is_ok');
			} else{//有重複
				$('#patent_family').removeClass('is_ok');
				$('#patent_family').addClass('not_ok');
			}
		}
	});
}

$('#add_country').click(function() {
	layer.open({
		type:2,
		title:'',
		closeBtn:0,
		area:['400px','200px'],
		shadeClose:true,
		content:'<?=base_url('mgmt/patent/new_country')?>'
    })
})

function load_country() {
	$.ajax({
			url: '<?= base_url() ?>' + 'mgmt/patent/find_country',
			type: 'POST',
			data: {},
			dataType: 'json',
			success: function(d) {
				if(d) {
					// console.log(d);
					$patnet_country = $('#patnet_country').empty();
					$.each(d.country, function(){
						$('<option/>', {
							'value': this.id,
							'text': this.country_name
						}).appendTo($patnet_country);
					});
				}
			},
			failure:function(){
				alert('faialure');
			}
		});

}
load_country();

function do_save() {
	var url = baseUrl + 'mgmt/patent/insert'; // the script where you handle the form input.
	$.ajax({
		type : "POST",
		url : url,
		data : {
			id: $('#item_id').val(),
			patent_family:$('#patent_family').val(),
			patnet_name: $('#patnet_name').val(),
			pdf_array: pdf_array.join(","),
			img: img,
			patnet_country:$('#patnet_country').val(),
			patent_key: $('#patent_key').val(),
			patnet_category: $('#patnet_category').val(),
			public_num_input:  public_num_input.join(","),
			patnet_num_input:  patnet_num_input.join(","),
			application_date: $('#application_date').val(),
			public_date: $('#public_date').val(),
			announcement_date: $('#announcement_date').val(),
			s_dt: $('#s_dt').val(),
			e_dt: $('#e_dt').val(),
			patent_finish_date: $('#patent_finish_date').val(),
			patnet_status: $('#patnet_status').val(),
			patent_note: $('#patent_note').val(),
			patent_range: $('#patent_range').val(),

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

</script>
