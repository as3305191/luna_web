<!-- Widget ID (each widget will need unique ID)-->
<div class="jarviswidget" id="wid-id-7" data-widget-colorbutton="false"	data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
	<header>

		<div class="widget-toolbar pull-left">
			<a href="javascript:void(0);" id="back_parent" onclick="currentApp.backTo()" class="btn btn-default ">
				<i class="fa fa-arrow-circle-left"></i>返回
			</a>
		</div>
		<div class="widget-toolbar pull-left">
			<a href="javascript:void(0);" id="back_parent" onclick="currentApp.doSubmit()" class="btn btn-default btn-danger">
				<i class="fa fa-save"></i>存檔
			</a>
		</div>



		<!-- <?php if (isset($item)): ?>
			<div class="widget-toolbar pull-left">
				<a href="javascript:void(0);" id="inventory_manage" onclick="currentApp.inv_manage()" class="btn btn-default">
					<i class="fa fa-balance-scale"></i>庫存管理
				</a>
			</div>
			<?$this -> session -> set_userdata('inv_product_id',$item -> id)?>
		<?php endif; ?>
 -->


		<ul class="nav nav-tabs pull-right in" id="myTab">
			<li class="active">
				<a data-toggle="tab" href="#s1"><i class="fa fa-list-alt"></i> <span class="hidden-mobile hidden-tablet">基本資料</span></a>
			</li>

			<li>
				<a data-toggle="tab" href="#s2"><i class="fa fa-image"></i> <span class="hidden-mobile hidden-tablet">圖片</span></a>
			</li>

			<li>
				<a data-toggle="tab" href="#s3"><i class="fa fa-file-text-o"></i> <span class="hidden-mobile hidden-tablet">商品介紹</span></a>
			</li>

			<li>
				<a data-toggle="tab" href="#s6"><i class="fa fa-file-text-o"></i> <span class="hidden-mobile hidden-tablet">作品介紹</span></a>
			</li>

			<li>
				<a data-toggle="tab" href="#s7"><i class="fa fa-file-text-o"></i> <span class="hidden-mobile hidden-tablet">購物說明</span></a>
			</li>

			<li>
				<a data-toggle="tab" href="#s5"><i class="fa fa-file-text-o"></i> <span class="hidden-mobile hidden-tablet">商品規格</span></a>
			</li>



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

				<div id="myTabContent" class="tab-content">
					<div class="tab-pane fade active in padding-10 no-padding-bottom" id="s1">
						<form id="app-edit-form" method="post" class="form-horizontal">
							<input type="hidden" id="product_id" name="id" value="<?= isset($item) ? $item->id : '0' ?>" />

							<style>

							</style>

								<fieldset>
									<fieldset>
										<div class="form-group">
											<label class="col-md-3 control-label">商品序號</label>
											<div class="col-md-6">
												<input type="text" class="form-control" required name="serial" value="<?= isset($item) ? $item -> serial : '' ?>" />
											</div>
										</div>
									</fieldset>

									<fieldset>
										<div class="form-group">
											<label class="col-md-3 control-label">商品名稱</label>
											<div class="col-md-6">
												<input type="text" class="form-control" required name="product_name" value="<?= isset($item) ? $item -> product_name : '' ?>" />
											</div>
										</div>
									</fieldset>

									<fieldset>
										<div class="form-group">
											<label class="col-md-3 control-label">商品重量</label>
											<div class="col-md-6">
												<input type="text" class="form-control" name="weight" required value="<?= isset($item) && !empty($item -> weight) ? $item -> weight : '0 g' ?>" />
											</div>
										</div>
									</fieldset>

									<fieldset>
										<div class="form-group">
											<label class="col-md-3 control-label">商品簡述</label>
											<div class="col-md-6">
												<input type="text" class="form-control" name="pdesc" required value="<?= isset($item) ? $item -> pdesc : '' ?>" />
											</div>
										</div>
									</fieldset>

									<fieldset>
										<div class="form-group">
											<label class="col-md-3 control-label">商品分類</label>
											<div class="col-md-6">
												<select id="main_cate" name="product_cate[]" class="form-control" multiple>
													<?php foreach($main_cates as $each): ?>
														<option value="<?= $each -> id ?>" <?= isset($mul_cates) && in_array($each->id,$mul_cates)  ? 'selected="selected"' : '' ?>>
															<?= $each -> cate_name ?>
														</option>
													<?php endforeach ?>
												</select>
											</div>
										</div>
									</fieldset>

									<fieldset>
										<div class="form-group">
											<label class="col-md-3 control-label">上架時間</label>
											<div class="col-md-6">
												<input type="text" required class="form-control dt_picker" name="start_time" value="<?= isset($item) ? $item -> start_time : '' ?>" />
											</div>
										</div>
									</fieldset>

									<fieldset>
										<div class="form-group">
											<label class="col-md-3 control-label">下架時間</label>
											<div class="col-md-6">
												<input type="text" class="form-control dt_picker" name="end_time" value="<?= isset($item) ? $item -> end_time : '' ?>" />
											</div>
										</div>
									</fieldset>

									<fieldset>
										<div class="form-group">
											<label class="col-md-3 control-label">定價</label>
											<div class="col-md-6">
												<input type="text" required class="form-control" name="pricing" value="<?= isset($item) ? $item -> price : '' ?>" />
											</div>
										</div>
									</fieldset>
									<fieldset>
										<div class="form-group">
											<label class="col-md-3 control-label">售價</label>
											<div class="col-md-6">
												<input type="text" required class="form-control" name="price" value="<?= isset($item) ? $item -> price : '' ?>" />
											</div>
										</div>
									</fieldset>

									<fieldset>
										<div class="form-group">
											<label class="col-md-3 control-label">排序</label>
											<div class="col-md-6">
												<input type="number" required class="form-control" name="pos" value="<?= isset($item) ? $item -> pos: '' ?>" />
												<span style="color:red">如果相同就以創建時間為排序</span>
											</div>
										</div>
									</fieldset>



										<fieldset>
											<div class="form-group">
												<label class="col-md-3 control-label">明星商品</label>
												<div class="col-md-6">
													<select class="form-control" name="is_star">
														<option value="1" <?=isset($item) && $item -> is_star == 1 ? 'selected' : ''?>>是</option>
														<option value="0" <?=isset($item) && $item -> is_star == 0 ? 'selected' : ''?>>否</option>
													</select>
												</div>
											</div>
										</fieldset>

								</fieldset>

							<!-- 專案商品 -->

						</form>
					</div>
					<!-- end of s1 -->
					<!-- start of s2 -->
					<div class="tab-pane fade in padding-10 no-padding-bottom" id="s2">
						<div class="row">
							<div class="col-md-12">
								<input id="file-input" name="file" type="file"accept=".jpg, .jpeg .png"  class="file-loading form-control">
							</div>
						</div>
					</div>
					<!-- end of s2 -->
					<!-- start of s3 -->
					<div class="tab-pane fade in padding-10 no-padding-bottom" id="s3">
						<form id="app-edit-form-s3" method="post" class="form-horizontal">
						<fieldset>
							<div class="form-group">
								<div class="col-md-12">
									<textarea id="desc" name="desc"><?= isset($item) ? $item -> desc : '' ?></textarea>
								</div>
							</div>
						</fieldset>
						</form>
					</div>
					<!-- end of s3 -->
					<!-- start of s4 -->
					<div class="tab-pane fade in padding-10 no-padding-bottom" id="s4">
						<form id="app-edit-form-s4" method="post" class="form-horizontal">
							<fieldset>
							<div class="form-group">
								<div class="col-md-2">
									<input id="off_start_time" type="text" required name="off_start_time" class="form-control dt_picker" placeholder="請輸入優惠開始時間" />
								</div>
								<div class="col-md-2">
									<input id="off_end_time" type="text" required name="off_end_time" class="form-control dt_picker" placeholder="請輸入優惠結束時間" />
								</div>
								<div class="col-md-2">
									<input id="off_price" type="number" class="form-control" name="off_price" placeholder="請輸入優惠價格" />
								</div>
								<div class="col-md-2">
									<button type="button" class="btn btn-sm btn-primary" onclick="addOff()"><i class="fa fa-plus-circle fa-lg"></i></button>
								</div>
							</div>
						</fieldset>
						</form>

						<fieldset>
							<div class="form-group">
								<div class="col-md-12">
									<table id="spec_list" class="table table-striped table-bordered table-hover" width="100%">
										<thead>
											<tr>
												<th class="min50"></th>
												<th class="min150">優惠開始時間</th>
												<th class="min150">優惠結束時間</th>
												<th >優惠價格</th>
											</tr>
										</thead>
										<tbody id="off_body">
										</tbody>
									</table>
								</div>
							</div>
						</fieldset>
						</form>


					</div>
					<!-- end of s4 -->

					<!-- start of s5 -->
					<div class="tab-pane fade in padding-10 no-padding-bottom" id="s5">
						<form id="app-edit-form-s5" method="post" class="form-horizontal">
							<fieldset>
								<div class="form-group">

									<div class="col-md-2">
										<input id="spec_name" type="text" class="form-control" name="spec_name" placeholder="請輸入規格名稱" />
									</div>
									<div class="col-md-2">
										<button type="button" class="btn btn-sm btn-primary" onclick="addSpec()"><i class="fa fa-plus-circle fa-lg"></i></button>
									</div>
								</div>
							</fieldset>
						</form>

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
						<fieldset>
							<div class="form-group">
								<div class="col-md-12">
									<div id="product_spec_list">

									</div>
								</div>
							</div>
						</fieldset>
						</form>


					</div>
					<!-- end of s5 -->


					<!-- start of s6 -->
					<div class="tab-pane fade in padding-10 no-padding-bottom" id="s6">
						<form id="app-edit-form-s6" method="post" class="form-horizontal">
						<fieldset>
							<div class="form-group">
								<div class="col-md-12">
									<textarea id="fdesc" name="fdesc"><?= isset($item) ? $item -> fdesc : '' ?></textarea>
								</div>
							</div>
						</fieldset>
						</form>
					</div>
					<!-- end of s6 -->

					<!-- start of s7 -->
					<div class="tab-pane fade in padding-10 no-padding-bottom" id="s7">
						<form id="app-edit-form-s7" method="post" class="form-horizontal">
						<fieldset>
							<div class="form-group">
								<div class="col-md-12">
									<textarea id="bdesc" name="bdesc"><?= isset($item) ? $item -> bdesc : '' ?></textarea>
								</div>
							</div>
						</fieldset>
						</form>
					</div>
					<!-- end of s7 -->
		</div>
		<!-- end widget content -->

	</div>
	<!-- end widget div -->

</div>
<!-- end widget -->


<script>


	currentApp.tableReload();
	var proStore = <?= json_encode($pro_list) ?>;
	if($('input[name="id"]').val()=="0"){
		proStore = [];
	}

	function redrawPro() {
		var $sBody = $('#pro_body').empty();
		$.each(proStore, function(){
			var obj = this;
			if(obj.is_delete == 1) {
				// don't display deleted
				return;
			}

			var $tr = $('<tr></tr>').appendTo($sBody);
			var $td = $('<td></td>').appendTo($tr);
			var $del = $('<a href="javascript:(0)"><i class="fa fa-trash"></i></a>').on('click', function(){
				if(obj.id > 0) {
					// mark to be deleted
					obj.is_delete = 1;
				} else {
					// just remove
					for(var i = proStore.length - 1; i >= 0; i--) {
					    if(proStore[i] === obj) {
					       proStore.splice(i, 1);
					    }
					}
				}

				redrawPro();
			}).appendTo($td);

			$('<img />').attr('src',baseUrl + 'api/images/get/' + obj.image_id + '/thumb').css('width','50px')
				.appendTo($('<td></td>').appendTo($tr));

			$('<td>'+obj.serial+'</td>').appendTo($tr);
			$('<td>'+obj.product_name+'</td>').appendTo($tr);

			$('<input type="number">').val(obj.numbers).on('change keyup', function(){
				obj.numbers = $(this).val();
			}).appendTo($('<td></td>').appendTo($tr));
		});
	}

	function callPro(){
		$('#productModal').modal('show');
	}
	redrawPro();
</script>


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

	fieldset.product-border {
		border: 1px groove #ddd !important;
		padding: 0 1.4em 1.4em 1.4em !important;
		margin: 0 0 1.5em 0 !important;
		-webkit-box-shadow:  0px 0px 0px 0px #000;
		box-shadow:  0px 0px 0px 0px #000;
	}

	legend.product-border {
		font-size: 1.2em !important;
		font-weight: bold !important;
		text-align: left !important;
		width:auto;
		padding:0 10px;
		border-bottom:none;
	}

	.general-product .onoffswitch {
 		width: 70px;
	}

	.general-product .onoffswitch-switch {
 		right: 53px;
	}

</style>
<!-- PAGE RELATED PLUGIN(S) -->
<script src="<?= base_url('js/plugin/ckeditor/ckeditor.js') ?>"></script>
<script src="<?= base_url('js/plugin/ckeditor/adapters/jquery.js') ?>"></script>

<script>
	//call bootstrapValidator when change date
	$('#off_start_time').on('dp.change dp.show',function(){
		$('#app-edit-form-s4').bootstrapValidator('revalidateField', 'off_start_time');;
	});

	$('#off_end_time').on('dp.change dp.show',function(){
		$('#app-edit-form-s4').bootstrapValidator('revalidateField', 'off_end_time');;
	});

	var offStore = <?= json_encode($off_list) ?>;
	function redrawOff() {
		var $sBody = $('#off_body').empty();
		$.each(offStore, function(){
			var obj = this;
			if(obj.is_delete == 1) {
				// don't display deleted
				return;
			}

			var $tr = $('<tr></tr>').appendTo($sBody);
			var $td = $('<td></td>').appendTo($tr);
			var $del = $('<a href="javascript:(0)"><i class="fa fa-trash"></i></a>').on('click', function(){
				if(obj.id > 0) {
					obj.is_delete = 1;
				} else {
					for(var i = offStore.length - 1; i >= 0; i--) {
					    if(offStore[i] === obj) {
					       offStore.splice(i, 1);
					    }
					}
				}

				redrawOff();
			}).appendTo($td);

			$('<input type="text" class="dt_picker">').val(obj.off_start_time).on('dp.change keyup', function(){
				obj.off_start_time = $(this).val();
			}).appendTo($('<td></td>').appendTo($tr));


			$('<input type="text" class="dt_picker">').val(obj.off_end_time).on('dp.change keyup', function(){
				obj.off_end_time = $(this).val();
			}).appendTo($('<td></td>').appendTo($tr));

			$('<input type="number">').val(obj.off_price).on('change keyup', function(){
				obj.off_price = $(this).val();
			}).appendTo($('<td></td>').appendTo($tr));

			// $('<td>'+obj.off_start_time+'</td>').appendTo($tr);
			// $('<td>'+obj.off_end_time+'</td>').appendTo($tr);
			// $('<td>'+obj.off_price+'</td>').appendTo($tr);



		});
	}

	function addOff() {
		if(!$('#app-edit-form-s4').data('bootstrapValidator').validate().isValid()) {
			return;
		}
		var obj = {
			id: 0,
			off_start_time : $('#off_start_time').val(),
			off_end_time : $('#off_end_time').val(),
			off_price : $('#off_price').val(),
			is_delete: 0
		};
		offStore.push(obj);
		redrawOff();

		// reset form value and validator
		$('#off_start_time').val('');
		$('#off_end_time').val('');
		$('#off_price').val('');
		$('#app-edit-form-s4').data('bootstrapValidator').resetForm();
	}

	redrawOff();

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
	$('#desc').ckeditor(config).editor.on('dialogShow',function(event){
		currentApp.imgDialog = event.data;
	});

	$('#fdesc').ckeditor(config).editor.on('dialogShow',function(event){
		currentApp.imgDialog = event.data;
	});

	$('#bdesc').ckeditor(config).editor.on('dialogShow',function(event){
		currentApp.imgDialog = event.data;
	});

	function callbackImgUrl($imageUrl){
		currentApp.imgDialog.setValueOf( 'info', 'txtUrl', $imageUrl );
	}

	$('#myTab a').click(function (e) {
		  e.preventDefault()
		  $(this).tab('show');
		  if($(this).attr('href') == '#s3') {
		  		setTimeout(function(){
		  			CKEDITOR.instances.desc.execCommand('autogrow');
		  		}, 500);
		  }
	})

	$('#myTab a').click(function (e) {
		  e.preventDefault()
		  $(this).tab('show');
		  if($(this).attr('href') == '#s6') {
		  		setTimeout(function(){
		  			CKEDITOR.instances.desc.execCommand('autogrow');
		  		}, 500);
		  }
	})

	$('#myTab a').click(function (e) {
		  e.preventDefault()
		  $(this).tab('show');
		  if($(this).attr('href') == '#s7') {
		  		setTimeout(function(){
		  			CKEDITOR.instances.desc.execCommand('autogrow');
		  		}, 500);
		  }
	})

	currentApp.clearImgs();
	$("#file-input").fileinput({
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
        uploadUrl: 'mgmt/images/upload/product_img',
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

  	$('#app-edit-form').bootstrapValidator({
		feedbackIcons : {
			valid : 'glyphicon glyphicon-ok',
			invalid : 'glyphicon glyphicon-remove',
			validating : 'glyphicon glyphicon-refresh'
		}
	});

  	$('#app-edit-form-s4').bootstrapValidator({
		feedbackIcons : {
			valid : 'glyphicon glyphicon-ok',
			invalid : 'glyphicon glyphicon-remove',
			validating : 'glyphicon glyphicon-refresh'
		}
	});


	$('#cate_main').select2();


	//永久檔期
	$('#ever_time').change(function(){
		if($(this).prop('checked')){
			$('input[name="ever_time"]').val(1);
		}else{
			$('input[name="ever_time"]').val(0);
		}
	});

	$('#own_store').change(function(){
		if($(this).prop('checked')){
			$('input[name="own_store"]').val(1);
		}else{
			$('input[name="own_store"]').val(0);
		}
	});

	//禮卷
	$('#is_voucher').change(function(){
		if($(this).prop('checked')){
			$('input[name="is_voucher"]').val(1);
		}else{
			$('input[name="is_voucher"]').val(0);
		}
	});

	//置頂
	$('#pos').change(function(){
		if($(this).prop('checked')){
			$('input[name="pos"]').val(1);
		}else{
			$('input[name="pos"]').val(2);
		}
	});


	//兌換商品
	$('#is_product').change(function(){
		if($(this).prop('checked')){
			$('input[name="is_product"]').val(1);
		}else{
			$('input[name="is_product"]').val(0);
		}
	});

	$('#inventory').change(function(){
		if($(this).prop('checked')){
			$('input[name="inventory"]').val(1);
		}else{
			$('input[name="inventory"]').val(-1);
		}
	});

	//集點商品
	$('#is_package').change(function(){
		if($(this).prop('checked')){
			$('input[name="is_package"]').val(1);
		}else{
			$('input[name="is_package"]').val(0);
		}
	});

	// draw cate by select2
	$('#main_cate').select2();


	// spec
	var specStore = [];
	function addSpec() {
		var $specName = $('#spec_name');
		var specName = $specName.val();
		if(specName.length == 0) {
			alert('請輸入規格名稱');
			return;
		}

		$.ajax({
			url: baseUrl + 'mgmt/products/add_spec',
			type: 'POST',
			data: {
				spec_name: specName,
				product_id: $('#product_id').val()
			},
			dataType: 'json',
			success: function(d) {
				if(d.spec) {
					$specName.val(''); // reset
					specStore.push({
						id: d.spec.id,
						product_id: d.spec.product_id,
						spec_name: d.spec.spec_name,
						pos: d.spec.pos,
						details: []
					});
					redrawSpec();
				}
			},
			failure:function(){
				alert('faialure');
			}
		});
	}

	$.fn.editable.defaults.mode = 'inline';

	function redrawSpec() {
		var $specList = $('#product_spec_list').empty();
		$.each(specStore, function(){
			var me = this;
			if(me.status && me.status == 1) {
				return;
			}

			var $a_div = $('<div class="row"></div>').appendTo($specList);
			var $b_div = $('<div class="row"></div>').appendTo($specList);
			var $dBoxDiv = $('<div></div>');
			$b_div.after($dBoxDiv);

			var editable = $('<input type="text" class="form-control input-xs" />')
			.val(me.spec_name)
			.on('change', function(){
				me.spec_name = $(this).val();
			});
			$a_div.append($('<div class="col-sm-3"></div>').append(editable));

			var oDiv = $('<div class="col-sm-3"></div>').appendTo($b_div);
			var mName = $('<input type="text" class="form-control input-xs" placeholder="請輸入名稱" value="">')
				.appendTo(oDiv);

			var oDiv = $('<div class="col-sm-3"></div>').appendTo($b_div);
			var mPrice = $('<input type="number" class="form-control input-xs" placeholder="請輸入價格" value="">')
				.appendTo(oDiv);

			var oDiv = $('<div class="col-sm-3"></div>').appendTo($b_div);
			var mPos = $('<input type="number" class="form-control input-xs" placeholder="請輸入順序(依新增順序請輸入0)" value="">')
				.appendTo(oDiv);

			// 複選
			oDiv = $('<div class="col-sm-2"></div>').appendTo($a_div);
			var mulCheck = $('<input type="checkbox" />').on('change', function(){
				if($(this).is(":checked")) {
					me.is_multiple = 1;
				} else {
					me.is_multiple = 0;
				}
			});

			if(me.is_multiple && me.is_multiple == 1) {
				mulCheck.prop('checked', true);
			}


			$('<label></label>')
				.append(mulCheck)
				.append('複選')
				.appendTo(oDiv);

			// 必填
			var isRequiredCheck = $('<input type="checkbox" />').on('change', function(){
				if($(this).is(":checked")) {
					me.is_required = 1;
				} else {
					me.is_required = 0;
				}
			});

			if(me.is_required && me.is_required == 1) {
				isRequiredCheck.prop('checked', true);
			}

			$('<label></label>')
				.append(isRequiredCheck)
				.append('必填')
				.appendTo(oDiv);

			// 順序
			oDiv = $('<div class="col-sm-2"></div>').appendTo($a_div);

			$('<label style="float:left;"></label>')
				.append('順序')
				.appendTo(oDiv);

			$('<input type="number" class="form-control input-xs" style="width:50px; float:left;" />')
			.val(me.pos)
			.on('change', function(){
				me.pos = $(this).val();
			})
			.appendTo(oDiv);

			// ---
			oDiv = $('<div class="col-sm-1"></div>').appendTo($b_div);
			$('<button type="button" class="btn btn-xs btn-primary"><i class="fa fa-plus-circle fa-lg"></i></button>')
				.on('click', function(){
					var err = [];
					if(mName.val().length == 0) {
						err.push('請輸入名稱');
					}
					if(mPrice.val().length == 0) {
						err.push('請輸入價格');
					}
					if(mPos.val().length == 0) {
						err.push('請輸入順序');
					}

					if(err.length > 0) {
						alert(err.join(','));
						return;
					}
					me.details.push({
						id:0,
						spec_id: me.spec_id,
						detail_name: mName.val(),
						price_diff: mPrice.val(),
						pos: mPos.val()
					});

					redrawSpec();
				})
				.appendTo(oDiv);

				oDiv = $('<div class="col-sm-2"></div>').appendTo($a_div);
				oDiv = $('<div class="col-sm-1"></div>').appendTo($a_div);
				$('<button type="button" class="btn btn-xs btn-warning"><i class="fa fa-minus-circle fa-lg"></i></button>')
					.on('click', function(){
						if(me.id == 0) {
							specStore.splice( $.inArray(me, specStore), 1 );
						} else {
							me.status = 1; // mark as remove
						}

						redrawSpec();
					})
					.appendTo(oDiv);

				// details
				$.each(me.details, function(){
					var aDetail = this;
					if(aDetail.status && aDetail.status == 1) {
						return;
					}
					$dDiv = $('<div class="row"></div>').appendTo($dBoxDiv);

					editable = $('<input type="text" class="form-control input-xs" style="width:100px;" />')
					.val(aDetail.detail_name)
					.on('change', function(){
						aDetail.detail_name = $(this).val();
					});

					$('<div class="col-sm-3"></div>').append(editable).appendTo($dDiv);

					editable = $('<input type="number" class="form-control input-xs" style="width:100px;" />')
					.val(aDetail.price_diff)
					.attr('readonly', true)
					.on('change', function(){
						aDetail.price_diff = $(this).val();
					});

					$('<div class="col-sm-3"></div>').append(editable).appendTo($dDiv);

					// pos
					editable = $('<input type="number" class="form-control input-xs" style="width:100px;" />')
					.val(aDetail.pos)
					.on('change', function(){
						aDetail.pos = $(this).val();
					});

					$('<div class="col-sm-3"></div>').append(editable).appendTo($dDiv);

					editable = $('<button type="button" class="btn btn-xs btn-error"><i class="fa fa-minus-circle fa-lg"></i></button>')
						.on('click', function(){
							if(aDetail.id == 0) {
								me.details.splice( $.inArray(aDetail, me.details), 1 );
							} else {
								aDetail.status = 1; // mark as remove
							}

							redrawSpec();
						});
						$('<div class="col-sm-3"></div>').append(editable).appendTo($dDiv);
				});
		});
	}

	function reloadSpec() {
		$.ajax({
			url: baseUrl + 'mgmt/products/list_spec',
			type: 'POST',
			data: {
				product_id: $('#product_id').val()
			},
			dataType: 'json',
			success: function(d) {
				if(d.list) {
					specStore = d.list;
					redrawSpec();
				}
			},
			failure:function(){
				alert('faialure');
			}
		});
	}

	// reload spec
	reloadSpec();


	$(function(){
    $('#bind_branch').select2({
        placeholder: "請選擇要綁定的分店",
        tags:true,
        createTag:function (decorated, params) {
            return null;
        },
        width:'100%'
    });


	function formatState (state) {
	    if (!state.id) { return state.text; }
	    var $state = $(
	    '<span>' + state.text + '</span>'
	    );
	    return $state;
	};


});
</script>
