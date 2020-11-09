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
<div class="jarviswidget" id="wid-id-7" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
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

			<form id="app-edit-form" method="post" class="form-horizontal">
				<input type="hidden" name="id" id="item_id" value="<?= isset($item) ? $item->id : '' ?>" />
			
					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">上傳照片</label>
							<div class="col-md-6">
								<input id="image_id" name="image_id" type="hidden" value="<?= isset($item) ? $item->image_id : '' ?>">
								<img id="file-input-win-img" style="max-width:80%;position: relative;z-index: 100;<?= isset($item) && !empty($item->image_id) ? " " : 'display:none;' ?>" />
								<input id="img-input" name="file" type="file" accept=".jpg, .jpeg" class="form-control">
								<div id="file-input-progress-win-img" class="progress" style="display:none">
									<div class="progress-bar progress-bar-success"></div>
								</div>
							</div>
						</div>
					</fieldset>
					<hr>
					<table id="pic_list" class="table table-striped table-bordered table-hover" width="100%">
						<thead>
							<tr>
								<th class="min100">是否預設</th>
								<th class="min100">照片</th>
								<th>日期</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
			</form>

		</div>
		<!-- end widget content -->

	</div>
	<!-- end widget div -->

</div>
<!-- end widget -->

<script src="<?= base_url('js/plugin/ckeditor/ckeditor.js') ?>"></script>
<script src="<?= base_url('js/plugin/ckeditor/adapters/jquery.js') ?>"></script>

<script>
	var place_mark_id = $('#item_id');

	$('#app-edit-form').bootstrapValidator({
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
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

	$("#file-input").fileinput({
		<?php if (!empty($item->img)) : ?>
			initialPreview: [],
			initialPreviewConfig: [{
				'caption': '<?= $item->img->image_name ?>',
				'size': <?= $item->img->image_size ?>,
				'width': '120px',
				'url': '<?= base_url('mgmt/images/delete/' . $item->img->id)  ?>',
				'key': <?= $item->img->id ?>
			}],
		<?php else : ?>
			initialPreview: [],
			initialPreviewConfig: [],
		<?php endif ?>
		initialPreviewAsData: true,
		maxFileCount: 1,
		uploadUrl: 'mgmt/images/upload/user_img',
		uploadExtraData: {}
	}).on('fileselect', function(event, numFiles, label) {
		layer.load(2);
		$("#file-input").fileinput('upload');
	}).on('fileuploaded', function(event, data, previewId, index) {
		var id = data.response.id;
		$('#image_id').val(id);
	}).on('fileuploaderror', function(event, data, previewId, index) {
		alert('upload error');
	}).on('filedeleted', function(event, key) {
		$('#image_id').val(0);
	});

	$("#m_bulletin_type").val($("#bulletin_type").val());

	$('#img-input').fileupload({
			url: '<?= base_url('mgmt/images/upload/user_img') ?>',
			dataType: 'json',
			done: function(e, data) {
				// $('#file-input-win-img').prop('src', data.result.initialPreview[0]).show();
				$('#image_id').val(data.result.id).attr('uid', data.result.id);
				// $('#file-input-progress-win-img').hide();
			},
			progressall: function(e, data) {
				var progress = parseInt(data.loaded / data.total * 100, 10);
				$('#file-input-progress-win-img').show();
				$('#file-input-progress-win-img .progress-bar').show().css(
					'width',
					progress + '%'
				);
			},
			success: function(data) {
				layer.msg("圖片上傳成功")
				layer.closeAll();
				currentApp.image_List.tableReload();

			}
		}).prop('disabled', !$.support.fileInput)
		.parent().addClass($.support.fileInput ? undefined : 'disabled');

	function showmetable(id) {
		$('.table_1').hide();
		$('#' + id).show();
		$('.btn_roles').removeClass('btn_1');
		$('.' + id).addClass('btn_1');
	}

	currentApp.doSubmit = function() {
		if (!$('#app-edit-form').data('bootstrapValidator').validate().isValid()) return;

		$('#lang').val($('#sys_lang').val());
		var sAttr = $("input[name='s_attr[]']:checked").map(function() {
			return this.value
		}).get();

		var url = baseUrl + 'mgmt/place_mark/insert'; // the script where you handle the form input.
		$.ajax({
			type: "POST",
			url: url,
			data: {
				sAttr: sAttr.join('#'),
				id: $('#item_id').val(),
				place_mark_name: $('input[name="place_mark_name"]').val(),
				lng: $('input[name="lng"]').val(),
				lat: $('input[name="lat"]').val(),
				description: $('input[name="description"]').val(),
				full_address: $('input[name="full_address"]').val(),
				country: $('input[name="country"]').val(),
				city: $('input[name="city"]').val(),
				district: $('input[name="district"]').val(),
				web_url: $('input[name="web_url"]').val(),
				facebook_url: $('input[name="facebook_url"]').val(),

			},
			success: function(data) {
				// app.mDtTable.ajax.reload(null, false);
				// app.backTo();


			}
		});
	};

	currentApp.image_List = new ImageAppClass(new BaseAppClass({}));

	// ckeditor
	$(function() {
		// ckeditor
		var config = {
			plugins: 'basicstyles,sourcearea,button,colorbutton,colordialog,contextmenu,toolbar,font,format,wysiwygarea,justify,menubutton,link,list',
			extraPlugins: 'autogrow',
			autoGrow_onStartup: true,
			autoGrow_minHeight: 400,
			//autoGrow_maxHeight: 800,
			removePlugins: 'resize'
		}
		config.removeButtons = 'Save,NewPage,Preview,Print,Templates,Cut,Copy,Paste,PasteText,PasteFromWord,Find,SelectAll,Scayt,About';


		try {
			CKEDITOR.instances['m_content'].destroy(true);
		} catch (e) {

		}
		CKEDITOR.replace("m_content", config);
		CKEDITOR.instances['m_content'].on('change', function() {
			CKEDITOR.instances['m_content'].updateElement()
		});
	});

	function doGetCityAndArea() {
		var lng = $("#lng").val();
		var lat = $("#lat").val();

		$.ajax({
			type: "POST",
			url: '<?= base_url('api/parser/check_loc_test') ?>',
			data: {
				lng: lng,
				lat: lat
			},
			success: function(data) {
				if (data.county_name) {
					$('input[name="city"]').val(data.county_name);
					$('input[name="district"]').val(data.town_name);
				}
			}
		});
	}
</script>