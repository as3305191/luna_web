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
		<div class="widget-toolbar pull-left">
			<a href="javascript:void(0);" id="" onclick="currentApp.doSubmit()" class="btn btn-default btn-danger">
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
			<form id="img-upload-form" method="post" style="display: none;" enctype="multipart/form-data">
				<input type="file" name="file" id="file" />
			</form>

			<form id="app-edit-form" method="post" class="form-horizontal">
				<input type="hidden" name="id" id="item_id" value="<?= isset($item) ? $item -> id : '' ?>" />
				
				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">類別</label>
						<div class="col-md-6">
							<select name="category_id" id="category_id" class="form-control">
								<?php
									foreach ($category_list as $category) {
										$selected = ((isset($item) && isset($item -> category_id) && $item -> category_id == $category -> id) ? 'selected' : '');
										echo "<option value='{$category -> id}' $selected>{$category -> name}</option>";
									}
								?>
							</select>
						</div>
					</div>
				</fieldset>
			
				<fieldset id='content_panel'>
					<div class="form-group">
						<label class="col-md-3 control-label">內容</label>
						<div class="col-md-9">
							<textarea required class="form-control" id="m_content" name="content"><?= isset($item) ? $item -> content : '' ?></textarea>
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
	div.cke_dialog_body {
		border: 1px solid #BCBCBC;
	}
</style>
<!-- PAGE RELATED PLUGIN(S) -->
<script src="<?= base_url('js/plugin/ckeditor/ckeditor.js') ?>"></script>
<script src="<?= base_url('js/plugin/ckeditor/adapters/jquery.js') ?>"></script>
<script>
	var g_bootstrap_validator = null;
	function reCreateBootstrapValidator() {
		if (null != g_bootstrap_validator) {
			$("#app-edit-form").data('bootstrapValidator').destroy();
			$('#app-edit-form').data('bootstrapValidator', null);
		}

		g_bootstrap_validator = $('#app-edit-form').bootstrapValidator({
			feedbackIcons : {
				valid : 'glyphicon glyphicon-ok',
				invalid : 'glyphicon glyphicon-remove',
				validating : 'glyphicon glyphicon-refresh'
			},
			fields: {

			}
		}).bootstrapValidator('validate');
	}



	function changeDataSourceLabel() {
		var category_id = $('#app-edit-form #category_id option:selected').val();
		console.info('xxxx', category_id);
		if (category_id == 3) {
			$('#data_source_label').html('頭銜名稱');
		} else {
			$('#data_source_label').html('資料來源');
		}
	}

	function filePreview(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#preview_img').attr('src', e.target.result);
				$('#preview_img').css('height', '200px');
			}
			reader.readAsDataURL(input.files[0]);
		}
	}

	function upload_img() {
		$('#file').val('');
		$('#file').trigger('click');
	}


	$(function() {
		// ckeditor
		var config = {
				customConfig : '',
				toolbarCanCollapse : false,
				colorButton_enableMore : false,
				removePlugins : 'list,indent,enterkey,showblocks,stylescombo,styles',
				extraPlugins : 'imagemaps,autogrow,uploadimage',
				filebrowserUploadUrl:baseUrl + 'mgmt/images/upload_terms/dm_image',
				autoGrow_onStartup : true,
				height:400,

				allowedContent: true
			}
			config.removeButtons = 'Save,NewPage,Preview,Print,Templates,Cut,Copy,Paste,PasteText,PasteFromWord,Find,SelectAll,Scayt,About';


		try {
			CKEDITOR.instances['m_content'].destroy(true);
		} catch (e) {
		}
		CKEDITOR.replace("m_content", config);
		CKEDITOR.instances['m_content'].on('change', function() { CKEDITOR.instances['m_content'].updateElement() });
	});
</script>
