<style>
.file-drag-handle {
	display: none;
}
.btn_1 {
    background-color: #FFD22F !important;
    color: #F57316 !important;
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
			<a href="javascript:void(0);" id="" onclick="do_save()" class="btn btn-default btn-danger">
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
				<input type="hidden" name="role_id"  value="1" />
				<div class="form-group" style="padding:0px 26px">
	    
        <div class="clearfix"></div>
    </div>
    <hr/>
		<div id="basic_information">
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">專利名稱</label>
					<div class="col-md-6">
						<input type="text" required class="form-control" name="patnet"  id="patnet_name" value="<?= isset($item) ? $item -> patnet_name : '' ?>"  />
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">專利的圖片</label>
					<div class="col-md-6">
						<input id="img-input" name="file" type="file" accept="image/*" multiple class="file-loading form-control">
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">專利的檔案</label>
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
var img='';
var pdf_array=[];

$("#img-input").fileinput({
					language: "zh-TW",
        <?php if(!empty($item -> images) && count($item -> images) > 0): ?>
        	initialPreview: [
        		<?php foreach($item -> images as $img): ?>
        			'<?=  base_url('mgmt/images/get/' . $img -> id) ?>',
        		<?php endforeach ?>
        	],
        	initialPreviewConfig: [
        	<?php foreach($item -> images as $img): ?>
    		{
	        		'caption' : '<?= $img -> image_name ?>',
	        		'size' : <?= $img -> image_size ?>,
	        		'width' : '120px',
	        		'url' : '<?= base_url('mgmt/images/delete/' . $img -> id)  ?>',
	        		'key' : <?= $img -> id ?>
	        },
    		<?php endforeach ?>

        	],
        <?php else: ?>
        	initialPreview: [],
        	initialPreviewConfig: [],
        <?php endif ?>
        initialPreviewAsData: true,
        overwriteInitial: false,
        maxFileCount: 1,
        uploadUrl: 'mgmt/images/upload_img_or_pdf/img',
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
        <?php if(!empty($item -> images) && count($item -> images) > 0): ?>
        	initialPreview: [
        		<?php foreach($item -> images as $img): ?>
        			'<?=  base_url('mgmt/images/get_file/' . $img -> id) ?>',
        		<?php endforeach ?>
        	],
        	initialPreviewConfig: [
        	<?php foreach($item -> images as $img): ?>
    		{
	        		'caption' : '<?= $img -> image_name ?>',
	        		'size' : <?= $img -> image_size ?>,
	        		'width' : '120px',
	        		'url' : '<?= base_url('mgmt/images/delete/' . $img -> id)  ?>',
	        		'key' : <?= $img -> id ?>
	        },
    		<?php endforeach ?>

        	],
        <?php else: ?>
        	initialPreview: [],
        	initialPreviewConfig: [],
        <?php endif ?>
        initialPreviewAsData: true,
        overwriteInitial: false,
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
		pdf_array.splice($.inArray(data,img_array),1);

	}).on('fileuploaderror', function(event, data, previewId, index) {
		alert('upload error');
	}).on('filedeleted', function(event,data,key) {
	

	});

	function do_save() {
			var url = baseUrl + 'mgmt/patent/insert'; // the script where you handle the form input.
			$.ajax({
				type : "POST",
				url : url,
				data : {
					id: $('#item_id').val(),
					patnet_name: $('#patnet_name').val(),
					img: img,
					pdf_array: pdf_array.join(","),
				},
				success : function(data) {
					if(data.error_msg) {
						layer.msg(data.error_msg);
					} else {
						// currentApp.mDtTable.ajax.reload(null, false);
						currentApp.doEdit(0);
					}
				}
			});
		};

</script>
