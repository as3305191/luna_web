<style>

</style>
<!-- Widget ID (each widget will need unique ID)-->
<div class="jarviswidget" id="wid-id-7" data-widget-colorbutton="false"	data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
	<header>
		<div class="widget-toolbar pull-left">
			<a href="javascript:void(0);" id="back_parent" onclick="currentApp.back(<?= isset($item) ? $item -> id : '0' ?>)" class="btn btn-default">
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
				<input type="hidden" name="id" id="item_id" value="<?= isset($item) ? $item -> id : '0' ?>" />
				<input type="hidden" id="role_id" value="<?= isset($login_user->role_id) ? $login_user->role_id : '' ?>" />
				<input type="hidden" id="is_use" value="<?= isset($item) ? $item -> is_use : ''?>" />
				<div class="form-group" style="padding:0px 26px">
        <div class="clearfix"></div>
    </div>
    <hr/>
		<div id="edit_div">
			<?php if(empty($item -> id) || $item -> id==0): ?>
				<?php if(!empty($login_user_role_array)&& count($login_user_role_array)>1): ?>
					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">選擇部門</label>
							<div class="col-md-6">
								<select name="department" id="department" class="form-control" >
									<?php foreach ($department_list as $each) : ?>
										<?php foreach ($login_user_role_array as $each_role) : ?>
											<?php if($each->id==$each_role): ?>
												<option value="<?= $each -> id?>" <?= isset($item) && $item -> role_id == $each -> id ? 'selected' : '' ?>><?=  $each -> name ?></option>
											<?php endif?>
										<?php endforeach ?>	
									<?php endforeach ?>
								</select>
							</div>
						</div>
					</fieldset>
				<?php else: ?>
					<input type="hidden" id="department" value="<?= $login_user_role_array[0] ?>" />
				<?php endif?>
			<?php else: ?>
				<input type="hidden" id="department" value=" <?= isset($item) ? $item -> role_id : '' ?>" />
			<?php endif?>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">文件種類</label>
					<div class="col-md-6">
						<input type="hidden"  id="s_style" value="<?= isset($item) ? $item -> swot_style_id : '' ?>"/>
						<select name="swot_style" id="swot_style" class="form-control" >
							<!-- option from javascript -->
						</select>
					</div>
					<div class="col-md-2">
						<button type="button" class="btn btn-sm btn-primary" id="add_swot"><i class="fa fa-plus-circle fa-lg"></i></button>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">標題</label>
					<div class="col-md-6">
						<input type="text" required class="form-control" id="title" name="title" value="<?= isset($item) ? $item -> title : '' ?>" />
					</div>
				</div>
			</fieldset>
			<fieldset id='swot_s'>
				<div class="form-group">
					<label class="col-md-3 control-label">S:優勢</label>
					<div class="col-md-9">
						<textarea required class="form-control" id="m_swot_s" name="m_swot_s"><?= isset($item) ? $item -> m_swot_s : '' ?></textarea>
					</div>
				</div>
			</fieldset>
			<fieldset id='swot_w'>
				<div class="form-group">
					<label class="col-md-3 control-label">W:弱勢</label>
					<div class="col-md-9">
						<textarea required class="form-control" id="m_swot_w" name="m_swot_w"><?= isset($item) ? $item -> m_swot_w : '' ?></textarea>
					</div>
				</div>
			</fieldset>
			<fieldset id='swot_o'>
				<div class="form-group">
					<label class="col-md-3 control-label">O:機會</label>
					<div class="col-md-9">
						<textarea required class="form-control" id="m_swot_o" name="m_swot_o"><?= isset($item) ? $item -> m_swot_o : '' ?></textarea>
					</div>
				</div>
			</fieldset>
			<fieldset id='swot_t'>
				<div class="form-group">
					<label class="col-md-3 control-label">T:威脅</label>
					<div class="col-md-9">
						<textarea required class="form-control" id="m_swot_t" name="m_swot_t"><?= isset($item) ? $item -> m_swot_t : '' ?></textarea>
					</div>
				</div>
			</fieldset>
			<fieldset id='swot_s_o'>
				<div class="form-group">
					<label class="col-md-3 control-label">S+O</label>
					<div class="col-md-9">
						<textarea required class="form-control" id="m_swot_s_o" name="m_swot_s_o"><?= isset($item) ? $item -> m_swot_s_o : '' ?></textarea>
					</div>
				</div>
			</fieldset>
			<fieldset id='swot_w_o'>
				<div class="form-group">
					<label class="col-md-3 control-label">W+O</label>
					<div class="col-md-9">
						<textarea required class="form-control" id="m_swot_w_o" name="m_swot_w_o"><?= isset($item) ? $item -> m_swot_w_o : '' ?></textarea>
					</div>
				</div>
			</fieldset>
			<fieldset id='swot_s_t'>
				<div class="form-group">
					<label class="col-md-3 control-label">S+T</label>
					<div class="col-md-9">
						<textarea required class="form-control" id="m_swot_s_t" name="m_swot_s_t"><?= isset($item) ? $item -> m_swot_s_t : '' ?></textarea>
					</div>
				</div>
			</fieldset>
			<fieldset id='swot_w_t'>
				<div class="form-group">
					<label class="col-md-3 control-label">W+T</label>
					<div class="col-md-9">
						<textarea required class="form-control" id="m_swot_w_t" name="m_swot_w_t"><?= isset($item) ? $item -> m_swot_w_t : '' ?></textarea>
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
<script src="<?= base_url('js/plugin/ckeditor/ckeditor.js') ?>"></script>
<script src="<?= base_url('js/plugin/ckeditor/adapters/jquery.js') ?>"></script>
<script>
	$(function() {
		// ckeditor
		var config = {
				customConfig : '',
				toolbarCanCollapse : false,
				colorButton_enableMore : false,
				// removePlugins : 'list,indent,enterkey,showblocks,stylescombo,styles',
				extraPlugins : 'imagemaps,autogrow,uploadimage',
				filebrowserUploadUrl:baseUrl + 'mgmt/images/upload_terms/dm_image',
				autoGrow_onStartup : true,
				height:400,
				allowedContent: true
			}
			config.removeButtons = 'Save,NewPage,Preview,Print,Templates,Cut,Copy,Paste,PasteText,PasteFromWord,Find,SelectAll,Scayt,About';

		try {
			CKEDITOR.instances['m_swot_s'].destroy(true);
			CKEDITOR.instances['m_swot_w'].destroy(true);
			CKEDITOR.instances['m_swot_o'].destroy(true);
			CKEDITOR.instances['m_swot_t'].destroy(true);
			CKEDITOR.instances['m_swot_s_o'].destroy(true);
			CKEDITOR.instances['m_swot_w_o'].destroy(true);
			CKEDITOR.instances['m_swot_s_t'].destroy(true);
			CKEDITOR.instances['m_swot_s'].destroy(true);

		} catch (e) {
		}
		CKEDITOR.replace("m_swot_s", config);
		CKEDITOR.replace("m_swot_w", config);
		CKEDITOR.replace("m_swot_o", config);
		CKEDITOR.replace("m_swot_t", config);
		CKEDITOR.replace("m_swot_s_o", config);
		CKEDITOR.replace("m_swot_w_o", config);
		CKEDITOR.replace("m_swot_s_t", config);
		CKEDITOR.replace("m_swot_w_t", config);

		CKEDITOR.instances['m_swot_s'].on('change', function() { CKEDITOR.instances['m_swot_s'].updateElement() });
		CKEDITOR.instances['m_swot_w'].on('change', function() { CKEDITOR.instances['m_swot_w'].updateElement() });
		CKEDITOR.instances['m_swot_o'].on('change', function() { CKEDITOR.instances['m_swot_o'].updateElement() });
		CKEDITOR.instances['m_swot_t'].on('change', function() { CKEDITOR.instances['m_swot_t'].updateElement() });
		CKEDITOR.instances['m_swot_s_o'].on('change', function() { CKEDITOR.instances['m_swot_s_o'].updateElement() });
		CKEDITOR.instances['m_swot_w_o'].on('change', function() { CKEDITOR.instances['m_swot_w_o'].updateElement() });
		CKEDITOR.instances['m_swot_s_t'].on('change', function() { CKEDITOR.instances['m_swot_s_t'].updateElement() });
		CKEDITOR.instances['m_swot_w_t'].on('change', function() { CKEDITOR.instances['m_swot_w_t'].updateElement() });

		if($('#item_id').val()>0){
			if($('#is_use').val()==1){
				$('#edit_div input').attr('readonly', true);
				$('#edit_div select').attr('readonly', true);
				$('#edit_div textarea').attr('readonly', true);
				// $('#edit_div button').attr('readonly', true);
				alert('目前檔案使用人員：'<?= isset($user_name) ? $user_name : ''?>);
			} else{
				currentApp.isUse($('#item_id').val());
			}
		}
	});

	function do_save() {
		// if(!$('#app-edit-form').data('bootstrapValidator').validate().isValid()) return;
		var url = baseUrl + 'mgmt/swot/insert'; // the script where you handle the form input.
		$.ajax({
			type : "POST",
			url : url,
			data : {
				id: $('#item_id').val(),
				title: $('#title').val(),
				swot_style: $('#swot_style').val(),
				department: $('#department').val(),
				m_swot_s: CKEDITOR.instances.m_swot_s.getData(),
				m_swot_w: CKEDITOR.instances.m_swot_w.getData(),
				m_swot_o: CKEDITOR.instances.m_swot_o.getData(),
				m_swot_t: CKEDITOR.instances.m_swot_t.getData(),
				m_swot_s_o: CKEDITOR.instances.m_swot_s_o.getData(),
				m_swot_w_o: CKEDITOR.instances.m_swot_w_o.getData(),
				m_swot_s_t: CKEDITOR.instances.m_swot_s_t.getData(),
				m_swot_w_t: CKEDITOR.instances.m_swot_w_t.getData(),
			},
			success : function(data) {
				if(data.error_msg) {
					layer.msg(data.error_msg);
					
				} else {
					currentApp.mDtTable.ajax.reload(null, false);
					currentApp.back(<?= isset($item) ? $item -> id : '0' ?>);
				}
			}
		});
	};

	$('#add_swot').click(function() {
		layer.open({
			type:2,
			title:'',
			closeBtn:0,
			area:['400px','200px'],
			shadeClose:true,
			content:'<?=base_url('mgmt/swot/new_swot_style')?>'
		})
	});

	function load_swot_style() {
		$.ajax({
			url: '<?= base_url() ?>' + 'mgmt/swot/find_swot_style',
			type: 'POST',
			data: {},
			dataType: 'json',
			success: function(d) {
				if(d) {
					// console.log(d);
					$swot_style = $('#swot_style').empty();
					$.each(d.swot, function(){
						if(this.id==$('#s_style').val()){
							$('<option/>', {
								'value': this.id,
								'text': this.swot_name
							}).attr("selected", true).appendTo($swot_style);
						}else{
							$('<option/>', {
								'value': this.id,
								'text': this.swot_name
							}).appendTo($swot_style);
						}
					});
				}
			},
			failure:function(){
				alert('faialure');
			}
		});
}
load_swot_style();
</script>
