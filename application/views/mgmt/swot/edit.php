<style>

</style>
<!-- Widget ID (each widget will need unique ID)-->
<div class="jarviswidget" id="wid-id-7" data-widget-colorbutton="false"	data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
	<header>
	
		<?php if(!empty($item -> id) && $item -> id>0): ?>
			<div class="widget-toolbar pull-left">
				<a href="javascript:void(0);" id="back_parent" onclick="currentApp.back('<?= isset($item) ? $item -> id : 0 ?>')" class="btn btn-default btn-danger" style="border-color:gray;background-color:#3276B1;">
					<i class="fa fa-arrow-circle-left"></i>返回
				</a>
			</div>
		<?php else: ?>
			<div class="widget-toolbar pull-left">
				<a href="javascript:void(0);" id="back_parent" onclick="currentApp.backTo()" class="btn btn-default btn-danger" style="border-color:gray;background-color:#3276B1;">
					<i class="fa fa-arrow-circle-left"></i>返回
				</a>
			</div>
		<?php endif?>
			<?php if(!empty($item -> id)  ): ?>
				<?php if($item -> s_t_is_lock == 0 && $item -> is_lock== 0): ?>
					<?php if($item -> is_use==1 ): ?>
						<?php if($item -> is_use_user_id== $login_user->id): ?>
							<div class="widget-toolbar pull-left">
								<a href="javascript:void(0);"  onclick="do_save();" class="btn btn-default btn-danger">
									<i class="fa fa-save"></i>存檔
								</a>
							</div>
						<?php endif?>
					<?php else:?>
						<div class="widget-toolbar pull-left">
							<a href="javascript:void(0);"  onclick="do_save();" class="btn btn-default btn-danger">
								<i class="fa fa-save"></i>存檔
							</a>
						</div>
						
					<?php endif?>
				<?php endif?>
				<div class="widget-toolbar pull-right">
					<a href="javascript:void(0);"  onclick="do_save_new();" class="btn btn-default btn-danger">
						<i class="fa fa-save"></i>引用
					</a>
				</div>
			<?php else:?>
				<div class="widget-toolbar pull-left">
					<a href="javascript:void(0);"  onclick="do_save();" class="btn btn-default btn-danger">
						<i class="fa fa-save"></i>存檔
					</a>
				</div>
			<?php endif?>
		<div class="widget-toolbar pull-left">
			<button onclick="re_num();" class="btn dropdown-toggle btn-xs btn-warning" data-toggle="dropdown">
				<i class="fa fa-save"></i>全部重新編碼
			</button>
		</div>
		<?php if($login_user->role_id==17 || $login_user->role_id==6 || $login_user->role_id==16 || $login_user->role_id==9|| $login_user->role_id==69): ?>
			<?php if(!empty($item -> unify) && $item -> unify==1): ?>

			<div class="pull-left">
				<?= isset($swot_class) ? $swot_class.'(整合)': '' ?>
			</div>
			<?php else: ?>
				<div class="pull-left">
					<?= isset($swot_class) ? $swot_class: '' ?>
				</div>
			<?php endif?>

		<?php endif?>
		<?php if(!empty( $item -> id) && $item -> id>0): ?>
			<div class="widget-toolbar pull-right">
				<div class="btn-group">
					<button onclick="currentApp.doExportAll(<?=isset($item->id) && $item->id>0? $item -> id : ''?>)" class="btn dropdown-toggle btn-xs btn-warning" data-toggle="dropdown">
						<i class="fa fa-save"></i>匯出
					</button>
				</div>
			</div>
		<?php endif?>
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
				<input type="hidden" name="id" id="item_id" value="<?= isset($item -> id) ?  $item -> id: '0' ?>" />
				<input type="hidden" id="role_id" value="<?= isset($login_user->role_id) ? $login_user->role_id : '' ?>" />
				<input type="hidden" id="is_use" value="<?= isset($item -> is_use) ? $item -> is_use : ''?>" />
				<input type="hidden" id="unify" value="<?= isset($item -> unify) ? $item -> unify : 0?>" />
				<input type="hidden" id="unify_for_0" value="<?= isset($unify) ? $unify: 0?>" />

				<div class="form-group" style="padding:0px 26px">
        <div class="clearfix"></div>
    </div>
    <hr/>
	<?php if(!empty($unify) && $unify==1): ?>
		<div id="edit_div">
			<input type="hidden" id="class_id" value="<?= isset($new_class_id) ? $new_class_id: '' ?>" />
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">文件種類</label>
					<div class="col-md-6">
						<input type="hidden"  id="s_style" value="<?= isset($item['swot_style_id']) ? $item['swot_style_id']: '' ?>"/>
						<select name="swot_style" id="swot_style" class="form-control" >
							<!-- option from javascript -->
						</select>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">標題</label>
					<div class="col-md-6">
						<input type="hidden"  id="s_title" value="<?= isset($item['title']) ? $item['title'] : '' ?>"/>
						<select name="title" id="swot_title" class="form-control" >
							<!-- option from javascript -->
						</select>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">製表人</label>
					<div class="col-md-6">
						<input type="text"  style="font-family:PMingLiU;"  class="form-control"  id="make_user" value="<?= isset($item['make_user']) ? $item['make_user'] : '' ?>" />
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="swot_leader form-group">
					<label class="col-md-3 control-label">管理代表</label>
					<div class="col-md-6">
						<input type="text"  style="font-family:PMingLiU;"  class=" form-control"  id="swot_leader" value="<?= isset($item['swot_leader']) ? $item['swot_leader'] : '' ?>" />
					</div>
				</div>
			</fieldset>
			<fieldset id='swot_s'>
				<div class="form-group">
					<label class="col-md-3 control-label">內部議題-S:優勢</label>
					<div class="col-md-9">
						<textarea required class="form-control" id="m_swot_s" name="m_swot_s"><?= isset($item['m_swot_s']) ? $item['m_swot_s']: '' ?></textarea>
					</div>
				</div>
			</fieldset>
			<fieldset id='swot_w'>
				<div class="form-group">
					<label class="col-md-3 control-label">內部議題-W:弱勢</label>
					<div class="col-md-9">
						<textarea required class="form-control" id="m_swot_w" name="m_swot_w"><?= isset($item['m_swot_w']) ? $item['m_swot_w']: '' ?></textarea>
					</div>
				</div>
			</fieldset>
			<fieldset id='swot_o'>
				<div class="form-group">
					<label class="col-md-3 control-label">外部議題-O:機會</label>
					<div class="col-md-9">
						<textarea required class="form-control" id="m_swot_o" name="m_swot_o"><?= isset($item['m_swot_o']) ? $item['m_swot_o'] : '' ?></textarea>
					</div>
				</div>
			</fieldset>
			<fieldset id='swot_t'>
				<div class="form-group">
					<label class="col-md-3 control-label">外部議題-T:威脅</label>
					<div class="col-md-9">
						<textarea required class="form-control" id="m_swot_t" name="m_swot_t"><?= isset($item['m_swot_t']) ? $item['m_swot_t']: '' ?></textarea>
					</div>
				</div>
			</fieldset>
			<fieldset id='swot_s_o'>
				<div class="form-group">
					<label class="col-md-3 control-label">S+O策略:優勢+機會</label>
					<div class="col-md-9">
						<textarea required class="form-control" id="m_swot_s_o" name="m_swot_s_o"><?= isset($item['m_swot_s_o']) ? $item['m_swot_s_o'] : '' ?></textarea>
					</div>
				</div>
			</fieldset>
			<fieldset id='swot_w_o'>
				<div class="form-group">
					<label class="col-md-3 control-label">W+O策略:弱勢+機會</label>
					<div class="col-md-9">
						<textarea required class="form-control" id="m_swot_w_o" name="m_swot_w_o"><?= isset($item['m_swot_w_o']) ? $item['m_swot_w_o'] : '' ?></textarea>
					</div>
				</div>
			</fieldset>
			<fieldset id='swot_s_t'>
				<div class="form-group">
					<label class="col-md-3 control-label">S+T策略:優勢+威脅</label>
					<div class="col-md-9">
						<textarea required class="form-control" id="m_swot_s_t" name="m_swot_s_t"><?= isset($item['m_swot_s_t'] ) ? $item['m_swot_s_t'] : '' ?></textarea>
					</div>
				</div>
			</fieldset>
			<fieldset id='swot_w_t'>
				<div class="form-group">
					<label class="col-md-3 control-label">W+T策略:弱勢+威脅</label>
					<div class="col-md-9">
						<textarea required class="form-control" id="m_swot_w_t" name="m_swot_w_t"><?= isset($item['m_swot_w_t']) ? $item['m_swot_w_t'] : '' ?></textarea>
					</div>
				</div>
			</fieldset>
		</div>
	<?php else: ?>
		<input type="hidden" id="class_id" value="0" />
		<div id="edit_div">
			<?php if(empty($item -> id) || $item -> id==0): ?>
				<?php if(!empty($login_user_role_array) && count($login_user_role_array)>1): ?>
					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">選擇部門</label>
							<div class="col-md-6">
								<select name="department" id="department" class="form-control" >
									<?php foreach ($department_list as $each) : ?>
										<?php foreach ($login_user_role_array as $each_role) : ?>
											<?php if($each->id==$each_role): ?>
												<option value="<?= $each -> id?>" <?= isset($item -> role_id) && $item -> role_id == $each -> id ? 'selected' : '' ?>><?=  $each -> name ?></option>
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
				<input type="hidden" id="department" value=" <?= isset($item -> role_id) ? $item -> role_id : '' ?>" />
			<?php endif?>
			<?php if(!empty($item -> id) && $item -> id && $item -> is_use==1 ): ?>
				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label" style="color:red;">目前正在使用人員</label>
						<div class="col-md-6">
							<span type="text" ><?= isset($user_name) ? $user_name : '' ?></span>
						</div>
					</div>
				</fieldset>
			<?php endif?>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">文件種類</label>
					<div class="col-md-6">
						<input type="hidden"  id="s_style" value="<?= isset($item -> swot_style_id) ? $item -> swot_style_id : '' ?>"/>
						<select name="swot_style" id="swot_style" class="form-control" >
							<!-- option from javascript -->
						</select>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">標題</label>
					<div class="col-md-6">
						<input type="hidden"  id="s_title" value="<?= isset($item -> title) ? $item -> title : '' ?>"/>
						<select name="title" id="swot_title" class="form-control" >
							<!-- option from javascript -->
						</select>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<label class="col-md-3 control-label">製表人</label>
					<div class="col-md-6">
						<input type="text" style="font-family:PMingLiU;" class="form-control"  id="make_user" value="<?= isset($item->make_user) ? $item->make_user: '' ?>" />
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="swot_leader form-group">
					<label class="col-md-3 control-label">管理代表</label>
					<div class="col-md-6">
						<input type="text"  style="font-family:PMingLiU;"  class="swot_leader form-control"  id="swot_leader" value="<?= isset($item->swot_leader) ? $item->swot_leader: '' ?>" />
				</div>
			</fieldset>
			<fieldset id='swot_s'>
				<div class="form-group">
					<label class="col-md-3 control-label">內部議題-S:優勢</label>
					<div class="col-md-9">
						<textarea required class="form-control" id="m_swot_s" name="m_swot_s"><?= isset($item -> m_swot_s) ? $item -> m_swot_s : '' ?></textarea>
					</div>
				</div>
			</fieldset>
			<fieldset id='swot_w'>
				<div class="form-group">
					<label class="col-md-3 control-label">內部議題-W:劣勢</label>
					<div class="col-md-9">
						<textarea required class="form-control" id="m_swot_w" name="m_swot_w"><?= isset($item -> m_swot_w) ? $item -> m_swot_w : '' ?></textarea>
					</div>
				</div>
			</fieldset>
			<fieldset id='swot_o'>
				<div class="form-group">
					<label class="col-md-3 control-label">外部議題-O:機會</label>
					<div class="col-md-9">
						<textarea required class="form-control" id="m_swot_o" name="m_swot_o"><?= isset($item -> m_swot_o) ? $item -> m_swot_o : '' ?></textarea>
					</div>
				</div>
			</fieldset>
			<fieldset id='swot_t'>
				<div class="form-group">
					<label class="col-md-3 control-label">外部議題-T:威脅</label>
					<div class="col-md-9">
						<textarea required class="form-control" id="m_swot_t" name="m_swot_t"><?= isset($item -> m_swot_t) ? $item -> m_swot_t : '' ?></textarea>
					</div>
				</div>
			</fieldset>
			<fieldset id='swot_s_o'>
				<div class="form-group">
					<label class="col-md-3 control-label">S+O策略:優勢+機會</label>
					<div class="col-md-9">
						<textarea required class="form-control" id="m_swot_s_o" name="m_swot_s_o"><?= isset($item-> m_swot_s_o) ? $item -> m_swot_s_o : '' ?></textarea>
					</div>
				</div>
			</fieldset>
			<fieldset id='swot_w_o'>
				<div class="form-group">
					<label class="col-md-3 control-label">W+O策略:劣勢+機會</label>
					<div class="col-md-9">
						<textarea required class="form-control" id="m_swot_w_o" name="m_swot_w_o"><?= isset($item-> m_swot_w_o) ? $item -> m_swot_w_o : '' ?></textarea>
					</div>
				</div>
			</fieldset>
			<fieldset id='swot_s_t'>
				<div class="form-group">
					<label class="col-md-3 control-label">S+T策略:優勢+威脅</label>
					<div class="col-md-9">
						<textarea required class="form-control" id="m_swot_s_t" name="m_swot_s_t"><?= isset($item-> m_swot_s_t) ? $item -> m_swot_s_t : '' ?></textarea>
					</div>
				</div>
			</fieldset>
			<fieldset id='swot_w_t'>
				<div class="form-group">
					<label class="col-md-3 control-label">W+T策略:劣勢+威脅</label>
					<div class="col-md-9">
						<textarea required class="form-control" id="m_swot_w_t" name="m_swot_w_t"><?= isset($item-> m_swot_w_t) ? $item -> m_swot_w_t : '' ?></textarea>
					</div>
				</div>
			</fieldset>
		</div>		
	<?php endif?>

		</form>

		</div>
		<!-- end widget content -->
	</div>
	<!-- end widget div -->

</div>
<!-- end widget -->

<script src="<?= base_url('js/plugin/ckeditor/adapters/jquery.js') ?>"></script>
<script>
	$(function() {
	
		if($('#s_style').val()=='8'){
			$('.swot_leader').addClass('hide');
		}

		$('#swot_style').on('change', function(){
			if($('#swot_style').val()=="8"){
				$('.swot_leader').addClass('hide');
			} else{
				$('.swot_leader').removeClass('hide');
			}
		})
		
		// $('#c_h_name').select2();
		// $('#c_s_name').select2();
		// ckeditor
		pushHistory(); 
		window.addEventListener("popstate", function(e) { 
			if($('#item_id').val()>0){
				currentApp.back($('#item_id').val());
			} else{
				currentApp.backTo();
			}
		}, false); 
		function pushHistory() { 
			var state = { 
				title: "title", 
				url: "#"
			};
			window.history.pushState(state, "title", "#"); 
		} 
		var config = {
				customConfig : '',
				toolbarCanCollapse : false,
				colorButton_enableMore : false,
				removePlugins : 'list,blocks,bidi',
				extraPlugins : 'imagemaps,autogrow,uploadimage',
				filebrowserUploadUrl:baseUrl + 'mgmt/images/upload_terms/dm_image',
				autoGrow_onStartup : true,
				height:400,
				allowedContent: true,
				
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
		var is_use_user_id=false,login_user_id=false
		if($('#item_id').val()>0){
			if($('#is_use').val()==1){
				is_use_user_id=<?= isset($item->is_use_user_id) ? $item->is_use_user_id : '0' ?>;
				login_user_id=<?= isset($login_user->id) ? $login_user->id : '0' ?>;
				if(is_use_user_id!==login_user_id){
					$('#edit_div input').attr('readonly', true);
					$('#edit_div select').attr('readonly', true);
					$('#edit_div textarea').attr('readonly', true);
				} 
			} else{
				currentApp.isUse($('#item_id').val());
			}
		}
		load_swot_title();
		load_swot_style_edit();

		// $('.cke_toolgroup').remove();
	});

	

	function do_save() {
		// if(!$('#app-edit-form').data('bootstrapValidator').validate().isValid()) return;
		var url = baseUrl + 'mgmt/swot/insert'; // the script where you handle the form input.
		if($('#item_id').val()==0){
			var unify = $('#unify_for_0').val();
		} else{
			var unify = $('#unify').val();
		}

		$.ajax({
			type : "POST",
			url : url,
			data : {
				
				id: $('#item_id').val(),
				class_id: $('#class_id').val(),	
				title: $('#swot_title').val(),
				swot_style: $('#swot_style').val(),
				department: $('#department').val(),
				make_user: $('#make_user').val(),
				swot_leader:$('#swot_leader').val(),
				unify:unify,
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
					var this_id = $('#item_id').val;
					if(this_id>0){
						currentApp.mDtTable.ajax.reload(null, false);
						currentApp.back(this_id);
					} else{
						currentApp.mDtTable.ajax.reload(null, false);
						currentApp.backTo();
					}
				}
			}
		});
		
	};

	function do_save_new() {
		var url = baseUrl + 'mgmt/swot/insert_new'; // the script where you handle the form input.
		if($('#item_id').val()==0){
			var unify = $('#unify_for_0').val();
		} else{
			var unify = $('#unify').val();
		}
		$.ajax({
			type : "POST",
			url : url,
			data : {
				class_id: $('#class_id').val(),	
				swot_style: $('#swot_style').val(),
				department: $('#department').val(),
				make_user: $('#make_user').val(),
				swot_leader:$('#swot_leader').val(),
				unify:unify,
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
					// currentApp.mDtTable.ajax.reload(null, false);
				} else {
					var this_id = $('#item_id').val();
					if(this_id>0){
						currentApp.mDtTable.ajax.reload(null, false);
						currentApp.back(this_id);
						layer.msg('另存成功');
					} else{
						currentApp.mDtTable.ajax.reload(null, false);
						currentApp.backTo();
					}
				}
			},
			failure:function(){
				alert('faialure');
			}
		});
		
	};

	function load_swot_title() {
		$.ajax({
			url: '<?= base_url() ?>' + 'mgmt/swot/find_swot_title',
			type: 'POST',
			data: {
				id: $('#item_id').val(),
			},
			dataType: 'json',
			success: function(d) {
				if(d) {
					// console.log(d);
					$swot_title = $('#swot_title').empty();
					$.each(d.swot, function(){
						if(this.id==$('#s_title').val()){
							$('<option/>', {
								'value': this.id,
								'text': this.swot_title
							}).attr("selected", true).appendTo($swot_title);
						}else{
							$('<option/>', {
								'value': this.id,
								'text': this.swot_title
							}).appendTo($swot_title);
						}
					});
					$('#swot_title').select2();
				}
			},
			failure:function(){
				alert('faialure');
			}
		});
	}
	

	function load_swot_style_edit() {
		if($('#item_id').val()>0){
			url = '<?= base_url() ?>' + 'mgmt/swot/find_swot_style';
		} else{
			url = '<?= base_url() ?>' + 'mgmt/swot/find_swot_style_edit';
		}
		$.ajax({
			url: url,
			type: 'POST',
			data: {
				s_title_val:$('#swot_title').val(),
			},
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
					$('#swot_style').select2();
				}
			},
			failure:function(){
				alert('faialure');
			}
		});
	}

	function re_num() {
		$.ajax({
			url: '<?= base_url() ?>' + 'mgmt/swot/replace_num_title_after_del',
			type: 'POST',
			data: {
				m_swot_s: CKEDITOR.instances.m_swot_s.getData(),
				m_swot_w: CKEDITOR.instances.m_swot_w.getData(),
				m_swot_o: CKEDITOR.instances.m_swot_o.getData(),
				m_swot_t: CKEDITOR.instances.m_swot_t.getData(),
				m_swot_s_o: CKEDITOR.instances.m_swot_s_o.getData(),
				m_swot_w_o: CKEDITOR.instances.m_swot_w_o.getData(),
				m_swot_s_t: CKEDITOR.instances.m_swot_s_t.getData(),
				m_swot_w_t: CKEDITOR.instances.m_swot_w_t.getData()
			},
			dataType: 'json',
			success: function(d) {
				if(d) {
				
					// CKEDITOR.instances.m_swot_s.setData('');
					// CKEDITOR.instances.m_swot_w.setData('');
					// CKEDITOR.instances.m_swot_o.setData('');
					// CKEDITOR.instances.m_swot_t.setData('');
					// CKEDITOR.instances.m_swot_s_o.setData('');
					// CKEDITOR.instances.m_swot_w_o.setData('');
					// CKEDITOR.instances.m_swot_s_t.setData('');
					// CKEDITOR.instances.m_swot_w_t.setData('');

					CKEDITOR.instances.m_swot_s.setData(d.new_swot_s);
					CKEDITOR.instances.m_swot_w.setData(d.new_swot_w);
					CKEDITOR.instances.m_swot_o.setData(d.new_swot_o);
					CKEDITOR.instances.m_swot_t.setData(d.new_swot_t);
					CKEDITOR.instances.m_swot_s_o.setData(d.new_swot_s_o);
					CKEDITOR.instances.m_swot_w_o.setData(d.new_swot_w_o);
					CKEDITOR.instances.m_swot_s_t.setData(d.new_swot_s_t);
					CKEDITOR.instances.m_swot_w_t.setData(d.new_swot_w_t);
	
				}
			},
			failure:function(){
				alert('faialure');
			}
		});
	}
</script>
