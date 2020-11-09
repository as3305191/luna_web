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
				<div class="form-group" style="padding:0px 26px">
					<div class="col-md-12 col-xs-12 col-sm-12 no-padding" style="">
						<button type="button" class="new_information btn_roles btn_1" style="margin:7px;border-radius:5px;border:1.5px solid #ccc;background-color:#FFFFFF;color:#A5A4A4;width:200px;height:50px" onclick="showmetable('new_information')">景點資料管理</button>
						<button type="button" class="image_list btn_roles" style="margin:7px;border-radius:5px;border:1.5px solid #ccc;background-color:#FFFFFF;color:#A5A4A4;width:200px;height:50px" onclick="showmetable('image_list')">圖片列表/上傳</button>
					</div>
					<div class="clearfix"></div>
				</div>
				<hr />
				<div class="table_1" id="new_information">
					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">名稱</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="place_mark_name" value="<?= isset($item) ? $item->place_mark_name : '' ?>" />
							</div>
						</div>
					</fieldset>


					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">類型</label>

							<div class="col-md-6">
								<?php foreach ($pma_list as $each) : ?>
									<div class="col-md-4">
										<label class="">
											<input class="" name="s_attr[]" type="checkbox" value="<?= $each->attribute_name ?>" <?php foreach ($attribute_new as $each_attribute) : ?> <?= ((isset($each_attribute) && $each_attribute == $each->attribute_name) ? 'checked' : '') ?> <?php endforeach ?>>
											<?= $each->attribute_name ?>
										</label>
									</div>
								<?php endforeach ?>
							</div>

						</div>
					</fieldset>

					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">經度</label>
							<div class="col-md-6">
								<input type="text" class="form-control" id="lng" name="lng" value="<?= isset($item) ? $item->lng : '' ?>" />
							</div>
						</div>
					</fieldset>

					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">緯度</label>
							<div class="col-md-6">
								<input type="text" class="form-control" id="lat" name="lat" value="<?= isset($item) ? $item->lat : '' ?>" />
							</div>
						</div>
					</fieldset>

					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label"></label>
							<div class="col-md-6">
								<button type="button" class="btn btn-primary" onclick="doGetCityAndArea()">經緯度取得城市/區域</button>
							</div>
						</div>
					</fieldset>
					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">城市</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="city" value="<?= isset($item) ? $item->city : '' ?>" />
							</div>
						</div>
					</fieldset>
					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">區域</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="district" value="<?= isset($item) ? $item->district : '' ?>" />
							</div>
						</div>
					</fieldset>
					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">地址</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="full_address" value="<?= isset($item) ? $item->full_address : '' ?>" />
							</div>
						</div>
					</fieldset>
					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">官網</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="web_url" value="<?= isset($item) ? $item->web_url : '' ?>" />
							</div>
						</div>
					</fieldset>
					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">粉絲專頁</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="facebook_url" value="<?= isset($item) ? $item->facebook_url : '' ?>" />
							</div>
						</div>
					</fieldset>
					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">描述</label>
							<div class="col-md-6">
								<textarea type="text" class="form-control" rows="10" id="m_content" name="description" style="resize:none;width:100%"><?= isset($item) ? $item->description : '' ?></textarea>
							</div>
						</div>
					</fieldset>
				</div>

				<div class="table_1" id="image_list" style="display:none">
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
				</div>
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