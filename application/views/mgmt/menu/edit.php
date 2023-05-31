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

	
		<div class="widget-toolbar pull-right">
			<div class="btn-group">
				<button onclick="currentApp.doExportAll(<?=isset($item->id) && $item->id>0? $item -> id : ''?>)" class="btn dropdown-toggle btn-xs btn-warning" data-toggle="dropdown">
					<i class="fa fa-save"></i>匯出
				</button>
			</div>
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
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">分類</label>
					<div class="col-md-6">
						<input type="text" required class="form-control" name="patnet_name"  id="patnet_name" value="<?= isset($item) ? $item -> patent_name : '' ?>"  <?= $login_user->role_id==9 || $login_user->role_id==11 || $login_user->role_id==28? '': 'readonly' ?>/>
					</div>
				</div>
			</fieldset>
		
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">圖片</label>
					<div class="col-md-6">
						<input id="img-input" name="file[]" type="file" accept="image/*" multiple class="file-loading form-control" <?= $login_user->role_id==9 || $login_user->role_id==11 || $login_user->role_id==28? '': 'readonly' ?>>
						<input id="img_id" type="hidden"  value="<?= isset($item) ? $item -> img_id : '' ?>" <?= $login_user->role_id==9 || $login_user->role_id==11 || $login_user->role_id==28? '': 'readonly' ?>>
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
				<?php if($login_user->role_id==9 || $login_user->role_id==11 || $login_user->role_id==28): ?>
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
		var id = data.response.id;
		img.push(id);		
	}).on('fileselect', function(event, numFiles, label) {
    	$("#img-input").fileinput('upload');
	}).on('filedeleted', function(event,data,key) {
		img.splice($.inArray(data,img),1);
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
			<?php if($login_user->role_id==9 || $login_user->role_id==11 || $login_user->role_id==28): ?>
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
	//    console.log(pdf_array);
	//    $("#file-input").fileinput('reset');
	}).on('fileselect', function(event, numFiles, label) {
    	$("#file-input").fileinput('upload');
	}).on('filedeleted', function(event,data,key) {
		pdf_array.splice($.inArray(data,pdf_array),1);
	}).on('fileuploaderror', function(event, data, previewId, index) {
		alert('upload error');
	});

	

</script>
