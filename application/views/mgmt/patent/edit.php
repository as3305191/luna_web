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
		<?php if($login_user->role_id==52 ||$login_user->role_id==26): ?>
		<div class="widget-toolbar pull-left">
			<a href="javascript:void(0);" id="" onclick="do_save();" class="btn btn-default btn-danger">
				<i class="fa fa-save"></i>存檔
			</a>
		</div>
		<?php endif?>
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
				<input type="hidden" id="role_id" value="<?= isset($login_user->role_id) ? $login_user->role_id : '' ?>" />
				<div class="form-group" style="padding:0px 26px">
        <div class="clearfix"></div>
    </div>
    <hr/>
		<div >
		<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">專利類型</label>
					<div class="col-md-6" id="patnet_status" >
						
					</div>
					<input type="hidden" required class="form-control" id="in_patnet_status" value="<?= isset($item) ? $item -> patnet_status : '0' ?>"/>

				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">專利名稱</label>
					<div class="col-md-6">
						<input type="text" required class="form-control" name="patnet_name"  id="patnet_name" value="<?= isset($item) ? $item -> patent_name : '' ?>"  <?= $login_user->role_id==52 || $login_user->role_id==26? '': 'readonly' ?>/>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">專利名稱(英)</label>
					<div class="col-md-6">
						<input type="text" class="form-control" name="patent_name_eng"  id="patent_name_eng" value="<?= isset($item) ? $item -> patent_name_eng : '' ?>"  <?= $login_user->role_id==52 || $login_user->role_id==26? '': 'readonly' ?>/>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">專利家族代碼</label>
					<div class="col-md-6">
						<input type="text"  class="form-control" name="patent_family"  id="patent_family" value="<?= isset($item) ? $item -> patent_family : '' ?>"  <?= $login_user->role_id==52 || $login_user->role_id==26? '': 'readonly' ?>/>
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
					<input type="hidden"  id="p_country" required value="<?= isset($item) ? $item -> patent_country : '' ?>"  <?= $login_user->role_id==52 || $login_user->role_id==26? '': 'readonly' ?>/>

						<select name="patnet_country" id="patent_country" class="form-control" <?= $login_user->role_id==52 || $login_user->role_id==26? '': 'disabled' ?>>
						
						</select>
					</div>
					<div class="col-md-2">
						<button type="button" class="btn btn-sm btn-primary" id="add_country"><i class="fa fa-plus-circle fa-lg"></i></button>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">發明人</label>
					<div class="col-md-6">
						<textarea type="text" require class="form-control" rows="3" id="inventor" name="inventor" style="resize:none;width:100%" <?= $login_user->role_id==52 || $login_user->role_id==26? '': 'readonly' ?>><?= isset($item) ? $item -> inventor : '' ?></textarea>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">申請人</label>
					<div class="col-md-6">
						<textarea type="text" require class="form-control" rows="3" id="applicant" name="applicant" style="resize:none;width:100%" <?= $login_user->role_id==52 || $login_user->role_id==26? '': 'readonly' ?>><?= isset($item) ? $item -> applicant : '' ?></textarea>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">關鍵字</label>
					<div class="col-md-6">
						<input type="text"  class="form-control" name="patent_key"  id="patent_key" value="<?= isset($item) ? $item -> patent_key : '' ?>"  <?= $login_user->role_id==52 || $login_user->role_id==26? '': 'readonly' ?>/>
					</div>
				</div>
			</fieldset>

			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">專利狀態</label>
					<div class="col-md-6">
						<select name="patnet_category" required id="patnet_category" class="form-control" <?= $login_user->role_id==52 || $login_user->role_id==26? '': 'disabled' ?>>
							<option  value="1"  <?= isset($item) && $item -> patnet_category == 1 ? 'selected' : '' ?>>發明</option>
							<option  value="2"  <?= isset($item) && $item -> patnet_category == 2 ? 'selected' : '' ?>>新型</option>
							<option  value="3"  <?= isset($item) && $item -> patnet_category == 3 ? 'selected' : '' ?>>設計</option>
						</select>	
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">申請號</label>
					<div class="col-md-6">
						<input type="text" required class="form-control" name="application_number" id="application_number"  value="<?= isset($item) ? $item -> application_num : '' ?>" <?= $login_user->role_id==52 || $login_user->role_id==26? '': 'readonly' ?>/>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">公開號</label>
					<div class="col-md-6">
						<input type="text"  class="form-control" name="public_num" id="public_num"  value="<?= isset($item) ? $item -> public_num : '' ?>" <?= $login_user->role_id==52 || $login_user->role_id==26? '': 'readonly' ?>/>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">專利號</label>
					<div class="col-md-6">
						<input type="text"  class="form-control" name="patnet_num" id="patnet_num"  value="<?= isset($item) ? $item -> patnet_num : '' ?>" <?= $login_user->role_id==52 || $login_user->role_id==26? '': 'readonly' ?>/>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">公開號檔案</label>
					<div class="col-md-6">
						<input id="public-num-input" name="file[]" type="file" accept=".pdf" multiple class="file-loading form-control" <?= $login_user->role_id==52 || $login_user->role_id==26? '': 'readonly' ?>>
						<input id="public_num_file"  type="hidden"  value="<?= isset($item) ? $item -> public_num_file : '' ?>" <?= $login_user->role_id==52 || $login_user->role_id==26? '': 'readonly' ?>>

					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">公告號</label>
					<div class="col-md-6">
						<input type="text"  class="form-control dt_picker" name="announcement_num"  id="announcement_num" value="<?= isset($item) ? $item -> announcement_num : '' ?>"  <?= $login_user->role_id==52 || $login_user->role_id==26? '': 'readonly' ?>/>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">專利號檔案</label>
					<div class="col-md-6">
						<input id="patnet-num-input" name="file[]" type="file" accept=".pdf" multiple class="file-loading form-control" <?= $login_user->role_id==52 || $login_user->role_id==26? '': 'readonly' ?>>
						<input id="patnet_num_file" type="hidden"  value="<?= isset($item) ? $item -> patnet_num_file : '' ?>" <?= $login_user->role_id==52 || $login_user->role_id==26? '': 'readonly' ?>>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">申請日</label>
					<div class="col-md-6">
						<input type="text" required class="form-control dt_picker" name="application_date"  id="application_date" value="<?= isset($item) ? $item -> application_date : '' ?>"  <?= $login_user->role_id==52 || $login_user->role_id==26? '': 'readonly' ?>/>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">公開日</label>
					<div class="col-md-6">
						<input type="text"  class="form-control dt_picker" name="public_date"  id="public_date" value="<?= isset($item) ? $item -> public_date : '' ?>"  <?= $login_user->role_id==52 || $login_user->role_id==26? '': 'readonly' ?>/>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">公告日</label>
					<div class="col-md-6">
						<input type="text"  class="form-control dt_picker" name="announcement_date"  id="announcement_date" value="<?= isset($item) ? $item -> announcement_date : '' ?>"  <?= $login_user->role_id==52 || $login_user->role_id==26? '': 'readonly' ?>/>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">專利權期間</label>
					<div class="col-md-2 widget-toolbar pull-left">
						<input id="s_dt" placeholder="開始日期" type="text" class="dt_picker" value="<?= isset($item) ? $item -> patent_start_dt : '' ?>" <?= $login_user->role_id==52 || $login_user->role_id==26? '': 'readonly' ?>/>
					</div>
					
					<div class="col-md-2 widget-toolbar pull-left">
						~<input id="e_dt" placeholder="結束日期" type="text" class="dt_picker" value="<?= isset($item) ? $item -> patent_end_dt : '' ?>" <?= $login_user->role_id==52 || $login_user->role_id==26? '': 'readonly' ?>/>
					</div>
					<div class="col-md-2 widget-toolbar pull-left">
						共
						<input type="text" id="year" value="<?= isset($item) ? $item -> year : '' ?>" <?= $login_user->role_id==52 || $login_user->role_id==26? '': 'readonly' ?>/>
						年						
					</div>
					
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">專利權止日</label>
					<div class="col-md-6">
						<input type="text" class="dt_picker form-control" name="patent_finish_date"  id="patent_finish_date" value="<?= isset($item) ? $item -> patent_finish_date : '' ?>"  <?= $login_user->role_id==52 || $login_user->role_id==26? '': 'readonly' ?>/>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">專利狀態</label>
					<div class="col-md-6">
						<select name="patnet_status" id="patnet_status" class="form-control" >
							<option  value="1" <?= isset($item) && $item -> patnet_status == 1 ? 'selected' : '' ?>>有效</option>
							<option  value="2" <?= isset($item) && $item -> patnet_status == 2 ? 'selected' : '' ?>>無效</option>
						</select>	
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">專利摘要</label>
					<div class="col-md-6">
						<textarea type="text" require class="form-control" rows="10" id="patent_note" name="patent_note" style="resize:none;width:100%" <?= $login_user->role_id==52 || $login_user->role_id==26? '': 'readonly' ?>><?= isset($item) ? $item -> patent_note : '' ?></textarea>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">專利備註</label>
					<div class="col-md-6">
						<textarea type="text" require class="form-control" rows="10" id="patnet_note_for_users" name="patnet_note_for_users" style="resize:none;width:100%" <?= $login_user->role_id==52 || $login_user->role_id==26? '': 'readonly' ?>><?= isset($item) ? $item -> patnet_note_for_users : '' ?></textarea>
					</div>
				</div>
			</fieldset>	
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">專利範圍</label>
					<div class="col-md-6">
						<textarea type="text" require class="form-control" rows="10" id="patent_range" name="patent_range" style="resize:none;width:100%" <?= $login_user->role_id==52 || $login_user->role_id==26? '': 'readonly' ?>><?= isset($item) ? $item -> patent_range : '' ?></textarea>
					</div>
				</div>
			</fieldset>		
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">專利代表圖</label>
					<div class="col-md-6">
						<input id="img-input" name="file" type="file" accept="image/*" multiple class="file-loading form-control" <?= $login_user->role_id==52 || $login_user->role_id==26? '': 'readonly' ?>>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">專利分析相關文件</label>
					<div class="col-md-6">
						<input id="file-input" name="file[]" type="file" accept=".pdf" multiple class="file-loading form-control" <?= $login_user->role_id==52 || $login_user->role_id==26? '': 'readonly' ?>>
						<input id="files_id" type="hidden"  value="<?= isset($item) ? $item -> files_id : '' ?>" <?= $login_user->role_id==52 || $login_user->role_id==26? '': 'readonly' ?>>
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
var current_app = [];
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


var pdf_array=false,public_num_input=false,patnet_num_input=false;
var img='<?= isset($item->image_id)?$item->image_id['0']:''?>';

if($('#item_id').val()>0){
	pdf_array=[];
	public_num_input=[];
	patnet_num_input=[];
	if($('#files_id').val().length>0){
		pdf_array.push($('#files_id').val());
		// pdf_array.splice($.inArray(0,pdf_array),1);

	}

	if($('#public_num_file').val().length>0){
		public_num_input.push($('#public_num_file').val());
		// public_num_input.splice($.inArray(0,public_num_input),1);

	}
	
	if($('#patnet_num_file').val().length>0){
		patnet_num_input.push($('#patnet_num_file').val());
		// patnet_num_input.splice($.inArray(0,patnet_num_input),1);

	}
} else{
	pdf_array=[];
	public_num_input=[];
	patnet_num_input=[];
}


// console.log(img);
// console.log(pdf_array);
// console.log(public_num_input);
// console.log(patnet_num_input);

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
				<?php if($login_user->role_id==52 ||$login_user->role_id==26): ?>
				{
						'caption' : '<?= $img -> image_name ?>',
						'size' : <?= $img -> image_size ?>,
						'width' : '120px',
						'url' : '<?= base_url('mgmt/images/delete/' . $img->id )  ?>',
						'downloadUrl': '<?=base_url('mgmt/images/get/' . $img->id)?>',
						'key' : <?= $img->id?>
				},
				<?php else: ?>
				{
						'caption' : '<?= $img -> image_name ?>',
						'size' : <?= $img -> image_size ?>,
						'width' : '120px',
						'downloadUrl': '<?=base_url('mgmt/images/get/' . $img->id)?>',
						'key' : <?= $img->id?>
				},
				<?php endif ?>

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
			<?php if($login_user->role_id==52 ||$login_user->role_id==26): ?>
				{
	        		'caption' : '<?= $files -> file_name ?>',
	        		'size' : <?= $files -> file_size ?>,
					'width' : '120px',
					'type': 'pdf',
					'downloadUrl': '<?=base_url('mgmt/images/get_pdf/' . $files->id)?>',
	        		'url' : '<?= base_url('mgmt/images/delete_file/' . $files->id)  ?>',
	        		'key' : <?= $files->id?>
				},
				<?php else: ?>
					{
						'caption' : '<?= $files -> file_name ?>',
						'size' : <?= $files -> file_size ?>,
						'width' : '120px',
						'type': 'pdf',
						'downloadUrl': '<?=base_url('mgmt/images/get_pdf/' . $files->id)?>',
						'key' : <?= $files->id?>
					},
				<?php endif ?>
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
    	
			
			<?php if($login_user->role_id==52 ||$login_user->role_id==26): ?>
				{
	        		'caption' : '<?= $files -> file_name ?>',
	        		'size' : <?= $files -> file_size ?>,
					'width' : '120px',
					'type': 'pdf',
					'downloadUrl': '<?=base_url('mgmt/images/get_pdf/' . $files->id)?>',
	        		'url' : '<?= base_url('mgmt/images/delete_file/' . $files->id )  ?>',
	        		'key' : <?= $files->id?>
			},
				<?php else: ?>
					{
	        		'caption' : '<?= $files -> file_name ?>',
	        		'size' : <?= $files -> file_size ?>,
					'width' : '120px',
					'type': 'pdf',
					'downloadUrl': '<?=base_url('mgmt/images/get_pdf/' . $files->id)?>',
	        		'key' : <?= $files->id?>
			},
				<?php endif ?>

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

			
			<?php if($login_user->role_id==52 ||$login_user->role_id==26): ?>
				{
	        		'caption' : '<?= $files -> file_name ?>',
	        		'size' : <?= $files -> file_size ?>,
					'width' : '120px',
					'type': 'pdf',
					'downloadUrl': '<?=base_url('mgmt/images/get_pdf/' . $files->id)?>',
	        		'url' : '<?= base_url('mgmt/images/delete_file/' . $files->id )  ?>',
	        		'key' : '<?= $files->id  ?>'
			},
				<?php else: ?>
					{
	        		'caption' : '<?= $files -> file_name ?>',
	        		'size' : <?= $files -> file_size ?>,
					'width' : '120px',
					'type': 'pdf',
					'downloadUrl': '<?=base_url('mgmt/images/get_pdf/' . $files->id)?>',
	        		'key' : '<?= $files->id  ?>'
			},
				<?php endif ?>

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

if($('#item_id').val()>0){
	var url = baseUrl + 'mgmt/patent/find_each_category_val'; // the script where you handle the form input.
	$.ajax({
		type : "POST",
		url : url,
		data : {
			item_id:$('#item_id').val(),
		},
		success : function(d) {
			if(d){
				current_app.push(d);
				console.log(current_app);
			}
		}
	});
} 

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
					$patnet_country = $('#patent_country').empty();
					$.each(d.country, function(){
						if(this.id==$('#p_country').val()){
							$('<option/>', {
								'value': this.id,
								'text': this.country_name
							}).attr("selected", true).appendTo($patnet_country);
						}else{
							$('<option/>', {
								'value': this.id,
								'text': this.country_name
							}).appendTo($patnet_country);
						}
										
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
	if(!$('#app-edit-form').data('bootstrapValidator').validate().isValid()) return;
	var url = baseUrl + 'mgmt/patent/insert'; // the script where you handle the form input.
	$.ajax({
		type : "POST",
		url : url,
		data : {
			id: $('#item_id').val(),
			patent_family:$('#patent_family').val(),
			patent_name_eng: $('#patent_name_eng').val(),
			patnet_name: $('#patnet_name').val(),
			pdf_array: pdf_array.join(","),
			img: img,
			application_number:$('#application_number').val(),
			announcement_num:$('#announcement_num').val(),
			patent_country:$('#patent_country').val(),
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
			patnet_status: $('#in_patnet_status').val(),
			patent_note: $('#patent_note').val(),
			patent_range: $('#patent_range').val(),
			patnet_note_for_users: $('#patnet_note_for_users').val(),
			year: $('#year').val(),
			public_num: $('#public_num').val(),
			patnet_num: $('#patnet_num').val(),	
			applicant: $('#applicant').val(),	
			inventor: $('#inventor').val(),
			patnet_type: $('#patnet_type').val()	
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

	$(".dt_picker").datetimepicker({
		format : 'YYYY-MM-DD'
	}).on('dp.change',function(event){
		var s_dt = $('#s_dt').val();
		var e_dt = $('#e_dt').val();
		if(e_dt.indexOf(" ") >= 0 || e_dt== null){
			$('#year').val('0').removeClass('not_ok');
		}else if(s_dt.indexOf(" ") >= 0 || s_dt== null){
			$('#year').val('0').removeClass('not_ok');
		} else{
			// console.log('123');
			date1 = e_dt.split('-');
			date2 = s_dt.split('-');
			if((Date.parse(e_dt)).valueOf()>= (Date.parse(s_dt)).valueOf()){
				var the_day_before_e_dt=new Date(e_dt);
				the_day_before_e_dt=the_day_before_e_dt.setDate(the_day_before_e_dt.getDate()+1);
				the_day_before_e_dt=new Date(the_day_before_e_dt);
				the_day_before_e_dt=the_day_before_e_dt.setFullYear(the_day_before_e_dt.getFullYear()-1);
				the_day_before_e_dt=new Date(the_day_before_e_dt);
				var the_day_before_date1 = the_day_before_e_dt.toLocaleDateString().replace(/\//g,"-");
				var s_dt_new =new Date(s_dt);
				s_dt_new = s_dt_new.toLocaleDateString().replace(/\//g,"-");

				if((Date.parse(s_dt_new)).valueOf()<=(Date.parse(the_day_before_date1)).valueOf()){
					var m = Math.abs(parseInt(date1[0]) * 12 + parseInt(date1[1])- (parseInt(date2[0]) * 12 + parseInt(date2[1])));
					var year=Math.floor(m/12); 
					$('#year').val(year).removeClass('not_ok');
				} else{
					$('#year').val('0').removeClass('not_ok');
				}
				
			} else{
				$('#year').val('結束日期不可小於開始日期').addClass('not_ok');
			}
		}
	});

	var total_edit_category=0;
	function load_edit_category() {
		$.ajax({
				url: '<?= base_url() ?>' + 'mgmt/patent/find_all_category',
				type: 'POST',
				data: {},
				dataType: 'json',
				success: function(d) {
					if(d) {
						// console.log(d);
						$category = $('#patnet_status').empty();
						var i=0;
						var html='';
						total_edit_category = d.max;
						for(i;i<=d.max;i++){
							if($('#role_id').val()=='52'||$('#role_id').val()=='26'){
								html+='<div class="widget-toolbar pull-left">'+
									'<select id="patnet_status_'+i+'" class="p_patnet_status form-control" data-val="'+i+'" >'+
									'</select>'+
								'</div>';
								} else{
									html+='<div class="widget-toolbar pull-left">'+
									'<select id="patnet_status_'+i+'" class="p_patnet_status form-control" data-val="'+i+'" disabled>'+
									'</select>'+
								'</div>';
								}
							
						}
						$(html).appendTo($category);
						var category_option = '<option value="all">全部</option>';
						var $category_0 = $('#patnet_status_0').empty();
						$category_0.append(category_option);
						$.each(d.category, function(){
							
							if(this.level==0){
								if($('#role_id').val()=='52'||$('#role_id').val()=='26'){
									
									if(current_app[0]['patnet_status_0'] &&current_app[0]['patnet_status_0']==this.id){
											$('<option />', {
												'value': this.id,
												'text': this.name,
											}).attr("selected", true).appendTo($category_0);										
									} else{
										$('<option />', {
											'value': this.id,
											'text': this.name,
										}).appendTo($category_0);
									}
								} else{
									if(current_app[0]['patnet_status_0'] && current_app[0]['patnet_status_0']==this.id){
											$('<option />', {
												'value': this.id,
												'text': this.name,
											}).attr("selected", true).appendTo($category_0);
									} else{
										$('<option />', {
											'value': this.id,
											'text': this.name,
										}).appendTo($category_0);
									}
									
									$('#patnet_status_0').attr("disabled",true);
								}
								
								$('.p_patnet_status').on('change', function(){
							var me = $(this);
							var _dataVal = me.data("val");
							var select_Val = me.val();
							var before_dataVal = _dataVal-1;
							if(select_Val=='all'){
								if(_dataVal>0){
									$('#in_patnet_status').val($('#patnet_status_'+before_dataVal).val());
								}else{
									$('#in_patnet_status').val("0");

								}
							} else{
								$('#in_patnet_status').val(select_Val);
							}
								var next_c =_dataVal+1;
								console.log(next_c);
								$.ajax({
									url:  baseUrl + 'mgmt/patent/find_next_category',
									type: 'POST',
									data: {
										next_level:next_c,
										this_val:select_Val,
									},
									dataType: 'json',
									success: function(d) {
										var category_option = '<option value="all">全部</option>';
										var $category = $('#patnet_status_'+next_c).empty();
										$category.append(category_option);
										if(d.category){
											$.each(d.category, function(){
												if($('#role_id').val()=='52'||$('#role_id').val()=='26'){

													if(current_app[0]['patnet_status_'+next_c] && current_app[0]['patnet_status_'+next_c]==this.id){
															$('<option />', {
																'value': this.id,
																'text': this.name,
															}).attr("selected", true).appendTo($category);										
													} else{
														$('<option />', {
															'value': this.id,
															'text': this.name,
														}).appendTo($category);
													}

													
												} else{
													if(current_app[0]['patnet_status_'+next_c] && current_app[0]['patnet_status_'+next_c]==this.id){
															$('<option />', {
																'value': this.id,
																'text': this.name,
															}).attr("selected", true).appendTo($category);									
													} else{
														$('<option />', {
															'value': this.id,
															'text': this.name,
														}).appendTo($category);
													}
													
													$('#patnet_status_'+next_c).attr("disabled",true);
												}
												
											});
											
										}
									},
									failure:function(){
									}
								});

						});
								
							}
						});

						$('.p_patnet_status').on('change', function(){
							var me = $(this);
							var _dataVal = me.data("val");
							var select_Val = me.val();
							var before_dataVal = _dataVal-1;
							if(select_Val=='all'){
								if(_dataVal>0){
									$('#in_patnet_status').val($('#patnet_status_'+before_dataVal).val());
								}else{
									$('#in_patnet_status').val("0");

								}
							} else{
								$('#in_patnet_status').val(select_Val);
							}
								var next_c =_dataVal+1;
								console.log(next_c);
								$.ajax({
									url:  baseUrl + 'mgmt/patent/find_next_category',
									type: 'POST',
									data: {
										next_level:next_c,
										this_val:select_Val,
									},
									dataType: 'json',
									success: function(d) {
										var category_option = '<option value="all">全部</option>';
										var $category = $('#patnet_status_'+next_c).empty();
										$category.append(category_option);
										if(d.category){
											$.each(d.category, function(){
												if($('#role_id').val()=='52'||$('#role_id').val()=='26'){

													if(current_app[0]['patnet_status_'+next_c] && current_app[0]['patnet_status_'+next_c]==this.id){
															$('<option />', {
																'value': this.id,
																'text': this.name,
															}).attr("selected", true).appendTo($category);										
													} else{
														$('<option />', {
															'value': this.id,
															'text': this.name,
														}).appendTo($category);
													}

													
												} else{
													if(current_app[0]['patnet_status_'+next_c] && current_app[0]['patnet_status_'+next_c]==this.id){
															$('<option />', {
																'value': this.id,
																'text': this.name,
															}).attr("selected", true).appendTo($category);									
													} else{
														$('<option />', {
															'value': this.id,
															'text': this.name,
														}).appendTo($category);
													}
													
													$('#patnet_status_'+next_c).attr("disabled",true);
												}
												
											});
											
										}
									},
									failure:function(){
									}
								});

						});
						
						
					}
				},
				failure:function(){
					alert('faialure');
				}
		});

	}	
	load_edit_category();



</script>
