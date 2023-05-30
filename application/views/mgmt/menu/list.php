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
							<div class="widget-toolbar pull-left">
								<label class="col-md-3 control-label">圖片類別</label>
								<div class="col-md-6">
									<select id="img_style" class="form-control">
										<!-- option from javascript -->
									</select>
								</div>
								<div class="col-md-2">
									<button type="button" class="btn btn-sm btn-primary" id="add_img_style"><i class="fa fa-plus-circle fa-lg"></i></button>
								</div>
							</div>
							<div class="widget-toolbar pull-left">
								<label class="col-md-3 control-label">上傳照片</label>
								<div class="col-md-6">
									<input id="image_id" name="image_id" type="hidden" value="<?= isset($item) ? $item->image_id : '' ?>">
									<img id="file-input-win-img" style="max-width:80%;position: relative;z-index: 100;<?= isset($item) && !empty($item->image_id) ? " " : 'display:none;' ?>" />
									<input id="img-input" name="file" type="file" accept="image/*" class="form-control">
									<div id="file-input-progress-win-img" class="progress" style="display:none">
										<div class="progress-bar progress-bar-success"></div>
									</div>
								</div>
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
								<table id="pic_list" class="table table-striped table-bordered table-hover" width="100%">
									<thead>
										<tr>
											<th class="min100">是否預設</th>
											<th class="min100">分類</th>
											<th class="min100">照片</th>
											<th>日期</th>
										</tr>
										<tr class="search_box">
											<th></th>
											<th>
												<div class="col-md-6">
													<select id="s_img_style" class="form-control">
														<!-- option from javascript -->
														
													</select>
												</div>
											</th>
											<th></th>
											<th></th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>

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
<script src="<?= base_url() ?>js/plugin/jquery-file-upload/js/vendor/jquery.ui.widget.js"></script>
<script src="<?= base_url() ?>js/plugin/jquery-file-upload/js/jquery.iframe-transport.js"></script>
<script src="<?= base_url() ?>js/plugin/jquery-file-upload/js/jquery.fileupload.js"></script>

<script type="text/javascript">

	loadScript(baseUrl + "js/class/BaseAppClass.js", function(){
		loadScript(baseUrl + "js/app/menu/list.js", function(){
			currentApp = new MenuClass(new BaseAppClass({}));
			// currentApp.doEdit();
		});
	});

	$('#add_img_style').click(function() {
		layer.open({
			type:2,
			title:'',
			closeBtn:0,
			area:['400px','200px'],
			shadeClose:true,
			content:'<?=base_url('mgmt/menu/new_menu_style')?>'
		})
	})

	$("#m_bulletin_type").val($("#bulletin_type").val());

	$('#img-input').fileupload({
			
			url: '<?= base_url('mgmt/images/upload_news/news_img') ?>',
			dataType: 'json',
			done: function(e, data) {
				// $('#file-input-win-img').prop('src', data.result.initialPreview[0]).show();
				$('#image_id').val(data.result.id).attr('uid', data.result.id);
				// $('#file-input-progress-win-img').hide();
				$.ajax({
					url: '<?= base_url() ?>' + 'mgmt/news_img/update_img_style',
					type: 'POST',
					data: {
						last_id:data.result.id,
						img_style:$('#img_style').val()
					},
					dataType: 'json',
					success: function(d) {
						layer.msg("圖片上傳成功")
						layer.closeAll();
						currentApp.tableReload();
					},
					failure:function(){
						alert('faialure');
					}
				});
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
			}
		}).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');

	// currentApp.doSubmit = function() {
	// 	if (!$('#app-edit-form').data('bootstrapValidator').validate().isValid()) return;
	// 	$('#lang').val($('#sys_lang').val());
	// 	var sAttr = $("input[name='s_attr[]']:checked").map(function() {
	// 		return this.value
	// 	}).get();

	// 	var url = baseUrl + 'mgmt/place_mark/insert'; // the script where you handle the form input.
	// 	$.ajax({
	// 		type: "POST",
	// 		url: url,
	// 		data: {
	// 			sAttr: sAttr.join('#'),
	// 			id: $('#item_id').val(),
	// 			place_mark_name: $('input[name="place_mark_name"]').val(),
	// 			lng: $('input[name="lng"]').val(),
	// 			lat: $('input[name="lat"]').val(),
	// 			description: $('input[name="description"]').val(),
	// 			full_address: $('input[name="full_address"]').val(),
	// 			country: $('input[name="country"]').val(),
	// 			city: $('input[name="city"]').val(),
	// 			district: $('input[name="district"]').val(),
	// 			web_url: $('input[name="web_url"]').val(),
	// 			facebook_url: $('input[name="facebook_url"]').val(),

	// 		},
	// 		success: function(data) {
	// 			// app.mDtTable.ajax.reload(null, false);
	// 			// app.backTo();
	// 		}
	// 	});
	// };

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

	function load_menu_style() {
		$.ajax({
			url: '<?= base_url() ?>' + 'mgmt/menu/find_menu_style',
			type: 'POST',
			dataType: 'json',
			success: function(d) {
				if(d) {
					// console.log(d);
					$img_style = $('#img_style').empty();
					$.each(d.menu_style, function(){
						$('<option/>', {
							'value': this.id,
							'text': this.menu_style
						}).appendTo($img_style);
					});
					$s_img_style = $('#s_img_style').empty();

					var option = '<option value="0">全部</option>';
					$s_img_style.append(option);
					$.each(d.img_style, function(){
						$('<option/>', {
							'value': this.id,
							'text': this.img_style
						}).appendTo($s_img_style);
					});
				}
			},
			failure:function(){
				alert('faialure');
			}
		});
	}
load_menu_style();
</script>
