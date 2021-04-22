<style>

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
				<input type="hidden" id="role_id" value="<?= isset($login_user->role_id) ? $login_user->role_id : '' ?>" />
				<div class="form-group" style="padding:0px 26px">
        <div class="clearfix"></div>
    </div>
    <hr/>
		<div >
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
			<fieldset id='first'>
				<div class="form-group">
					<label class="col-md-3 control-label">首要目標</label>
					<div class="col-md-9">
						<textarea required class="form-control" id="m_first" name="m_first"><?= isset($item) ? $item -> m_first : '' ?></textarea>
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
			CKEDITOR.instances['m_first'].destroy(true);

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
		CKEDITOR.replace("m_first", config);

		CKEDITOR.instances['m_swot_s'].on('change', function() { CKEDITOR.instances['m_swot_s'].updateElement() });
		CKEDITOR.instances['m_swot_w'].on('change', function() { CKEDITOR.instances['m_swot_w'].updateElement() });
		CKEDITOR.instances['m_swot_o'].on('change', function() { CKEDITOR.instances['m_swot_o'].updateElement() });
		CKEDITOR.instances['m_swot_t'].on('change', function() { CKEDITOR.instances['m_swot_t'].updateElement() });
		CKEDITOR.instances['m_swot_s_o'].on('change', function() { CKEDITOR.instances['m_swot_s_o'].updateElement() });
		CKEDITOR.instances['m_swot_w_o'].on('change', function() { CKEDITOR.instances['m_swot_w_o'].updateElement() });
		CKEDITOR.instances['m_swot_s_t'].on('change', function() { CKEDITOR.instances['m_swot_s_t'].updateElement() });
		CKEDITOR.instances['m_swot_w_t'].on('change', function() { CKEDITOR.instances['m_swot_w_t'].updateElement() });
		CKEDITOR.instances['m_first'].on('change', function() { CKEDITOR.instances['m_first'].updateElement() });

	});

	function do_save() {
		// if(!$('#app-edit-form').data('bootstrapValidator').validate().isValid()) return;
		var url = baseUrl + 'mgmt/news_edit/insert'; // the script where you handle the form input.
		$.ajax({
			type : "POST",
			url : url,
			data : {
				id: $('#item_id').val(),
				title: $('#title').val(),
				m_swot_s: CKEDITOR.instances.m_swot_s.getData(),
				m_swot_w: CKEDITOR.instances.m_swot_w.getData(),
				m_swot_o: CKEDITOR.instances.m_swot_o.getData(),
				m_swot_t: CKEDITOR.instances.m_swot_t.getData(),
				m_swot_s_o: CKEDITOR.instances.m_swot_s_o.getData(),
				m_swot_w_o: CKEDITOR.instances.m_swot_w_o.getData(),
				m_swot_s_t: CKEDITOR.instances.m_swot_s_t.getData(),
				m_swot_w_t: CKEDITOR.instances.m_swot_w_t.getData(),
				m_first: CKEDITOR.instances.m_first.getData(),

			},
			success : function(data) {
				if(data.error_msg) {
					layer.msg(data.error_msg);
				} else {
					currentApp.mDtTable.ajax.reload(null, false);
					currentApp.backTo();
				}
			}
		});
	};
</script>
