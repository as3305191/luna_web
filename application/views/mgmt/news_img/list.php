<div class="tab-content">
	<div class="tab-pane active" id="list_page">

		<!-- widget grid -->
		<section id="widget-grid" class="">

			<!-- row -->
			<div class="row">

				<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget">
						<header>
							<!-- <div class="widget-toolbar pull-left">
								<div class="btn-group">
									<button onclick="currentApp.doEdit(0)" class="btn dropdown-toggle btn-xs btn-success" data-toggle="dropdown">
										<i class="fa fa-plus"></i>新增
									</button>
								</div> -->
							</div>



						</header>

						<!-- widget div-->
						<div>

							<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->

							</div>
							<!-- end widget edit box -->
							<input type="hidden" class="form-control" id="user_id" name="user_id" value="<?= isset($login_user) ? $login_user->id : '' ?>"  />

							<!-- widget content -->
							<div class="widget-body no-padding">

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

				</article>
				<!-- WIDGET END -->

			</div>

			<!-- end row -->

		</section>
		<!-- end widget grid -->
	</div>

	<div class="tab-pane animated fadeIn" id="edit_page">
		<section class="">
			<!-- row -->
			<div class="row">
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="edit-modal-body">

				</article>
			</div>
		</section>
	</div>
</div>
<?php $this -> load -> view('general/delete_modal'); ?>
<script src="<?= base_url('js/plugin/ckeditor/ckeditor.js') ?>"></script>
<script src="<?= base_url('js/plugin/ckeditor/adapters/jquery.js') ?>"></script>
<script type="text/javascript">

	loadScript(baseUrl + "js/class/BaseAppClass.js", function(){
		loadScript(baseUrl + "js/app/news_img/list.js", function(){
			currentApp = new NewsimgClass(new BaseAppClass({}));
		});
	});

	
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
