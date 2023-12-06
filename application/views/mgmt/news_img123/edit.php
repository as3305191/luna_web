<!-- Widget ID (each widget will need unique ID)-->
<div class="jarviswidget" id="wid-id-7" data-widget-colorbutton="false"	data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
	<header>
		<!-- <div class="widget-toolbar pull-left">
			<a href="javascript:void(0);" id="back_parent" onclick="currentApp.backTo()" class="btn btn-default ">
				<i class="fa fa-arrow-circle-left"></i>返回
			</a>
		</div> -->
		<div class="widget-toolbar pull-left">
			<a href="javascript:void(0);" id="back_parent" onclick="currentApp.doSubmit()" class="btn btn-default btn-danger">
				<i class="fa fa-save"></i>存檔
			</a>
		</div>

		<ul class="nav nav-tabs pull-right in" id="myTab">
			<!-- <li class="active">
				<a data-toggle="tab" href="#s1"><i class="fa fa-list-alt"></i> <span class="hidden-mobile hidden-tablet">基本資料</span></a>
			</li>

			<li>
				<a data-toggle="tab" href="#s2"><i class="fa fa-image"></i> <span class="hidden-mobile hidden-tablet">圖片</span></a>
			</li> -->

			<!-- <li class="active">
				<a data-toggle="tab" href="#s3"><i class="fa fa-file-text-o"></i> <span class="hidden-mobile hidden-tablet">內容描述</span></a>
			</li> -->

		</ul>
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

				<!-- <div id="myTabContent" class="tab-content"> -->

					<!-- start of s3 -->
					<!-- <div class="tab-pane fade active in padding-10 no-padding-bottom" id="s3"> -->
						<form id="app-edit-form-s3" method="post" class="form-horizontal">
							<input type="hidden" name="id" value="<?= $id ?>" />

							<?php if(!empty($item)): ?>
								<?php foreach ($item as $each): ?>
										<?php if ($each -> rule_type == 1): ?>
											<h2>編輯 服務條款</h2>
										<?php elseif($each -> rule_type == 2): ?>
											<h2>編輯 使用條款</h2>
										<?php endif; ?>

										<fieldset>
											<div class="form-group">
												<div class="col-md-12">
													<?php if ($each -> rule_type == 1): ?>
														<textarea id="desc_tos" name="desc_tos"><?= $each -> desc ?></textarea>
													<?php elseif($each -> rule_type == 2): ?>
														<textarea id="desc_ur" name="desc_ur"><?= $each -> desc ?></textarea>
													<?php endif; ?>

												</div>
											</div>
										</fieldset>
									<?php endforeach; ?>		
							<?php endif; ?>
								

						</form>
					<!-- </div> -->


					<!-- end of s3 -->


		<!-- </div> -->
		<!-- end widget content -->

	</div>
	<!-- end widget body -->

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

</style>
<script src="<?= base_url('js/plugin/ckeditor/ckeditor.js') ?>"></script>
<script src="<?= base_url('js/plugin/ckeditor/adapters/jquery.js') ?>"></script>
<script>
	$('#spec_1_title').on('change keyup', function(){
		$('#spec_1_head').text($(this).val().length > 0 ? $(this).val() : $(this).data('dVal'));
	});
	$('#spec_2_title').on('change keyup', function(){
		$('#spec_2_head').text($(this).val().length > 0 ? $(this).val() : $(this).data('dVal'));
	});

	$('#spec_1_title').data('dVal', $('#spec_1_head').text()).trigger('change');
	$('#spec_2_title').data('dVal', $('#spec_2_head').text()).trigger('change');

	// spec


	// ckeditor
	var config = {
		plugins:'basicstyles,sourcearea,image,button,colorbutton,colordialog,contextmenu,toolbar,font,format,wysiwygarea,justify,menubutton,link,list',
		extraPlugins : 'filebrowser,autogrow',
		filebrowserBrowseUrl: baseUrl + 'mgmt/images/browser',
		startupFocus: true,
		autoGrow_onStartup: true,
		autoGrow_minHeight: 400,
		//autoGrow_maxHeight: 800,
		removePlugins: 'resize'
	};

	// CKEditors
	$('#desc_tos').ckeditor(config).editor.on('dialogShow',function(event){
		currentApp.imgDialog = event.data;
	});

	$('#desc_ur').ckeditor(config).editor.on('dialogShow',function(event){
		currentApp.imgDialog = event.data;
	});

	function callbackImgUrl($imageUrl){
		currentApp.imgDialog.setValueOf( 'info', 'txtUrl', $imageUrl );
	}

	$('#myTab a').click(function (e) {
		  e.preventDefault()
		  $(this).tab('show');
		  if($(this).attr('href') == '#s3') {
		  		// setTimeout(function(){
				// 	CKEDITOR.instances.desc.execCommand('autogrow');
		  		// }, 500);
				  CKEDITOR.instances.desc.execCommand('autogrow');
		  }
	})

	currentApp.clearImgs();
	$("#file-input").fileinput({
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
        maxFileCount: 8,
        uploadUrl: 'mgmt/images/upload/about_articles_img',
        uploadExtraData: {
        }
    }).on('fileuploaded', function(event, data, previewId, index) {
    	// upload image
	   var id = data.response.id;
	   $("#file-input").fileinput('reset');
	}).on('fileselect', function(event, numFiles, label) {
    	$("#file-input").fileinput('upload');
	}).on('filedeleted', function(event, key) {

	}).on('fileuploaderror', function(event, data, previewId, index) {
		alert('upload error');
	}).on('filedeleted', function(event, key) {
		$('#image_id').val(0);
	});

    $(".dt_picker").datetimepicker({
		format : 'YYYY-MM-DD HH:mm:ss'
	}).on('changeDate', function (e) {
        $(this).datepicker('hide');
        //$('#user-form').bootstrapValidator('updateStatus', 'dt', 'VALID');
  	});

  	$('#cate_main').on('change', function(){
  		var _id = $(this).find('option:selected').val();
  		loadSubCate(_id);
  	});

  	function loadSubCate(id) {
  		$.ajax({
  			url: baseUrl + 'mgmt/products/cate_sub/' + id,
  			success: function(data) {
  				$('#cate_sub')
  							.find('option')
						    .remove()
						    .end()
						    .val(0);
				$('#cate_sub')
						    .append($('<option></option>').attr('value', 0).text('---'));

  				if(data && data.list.length > 0) {
  					$.each(data.list, function(){
  						$('#cate_sub')
						    .append($('<option></option>').attr('value', this.id).text(this.cate_name));
  					});
  				}

			},
			failure: function() {
			}
  		});
  	}

  // 	$('#app-edit-form').bootstrapValidator({
	// 	feedbackIcons : {
	// 		valid : 'glyphicon glyphicon-ok',
	// 		invalid : 'glyphicon glyphicon-remove',
	// 		validating : 'glyphicon glyphicon-refresh'
	// 	}
	// });




</script>
