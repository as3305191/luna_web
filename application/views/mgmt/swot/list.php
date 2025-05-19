<style>
thead tr th {
	position:sticky;
	top:0;
	background-color:#FFFFFF !important;
	text-align:center;
}

.hide {
	display: none;
}
</style>

<!-- CSS Unify Theme -->
<!-- <link rel="stylesheet" href="<?= base_url() ?>assets_co/assets_/css/styles.multipage-real-estate.css"> -->
  
<div class="tab-content">
	<div class="tab-pane active" id="list_page">

		<!-- widget grid -->
		<section id="widget-grid" class="">
			<!-- row -->
			<div class="row">
				<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget" > 
						<header >
							<div class="widget-toolbar pull-left">
								<div class="btn-group">
									<button onclick="currentApp.doEdit(0)" class="btn btn-xs btn-success" data-toggle="dropdown">
										<i class="fa fa-plus"></i>新增
									</button>
								</div>
							</div>
							<?php if($login_user->role_id==17 || $login_user->role_id==6 || $login_user->role_id==16 || $login_user->role_id==9|| $login_user->role_id==69): ?>
								<div class="pull-left " style="width:150px;line-height:32px">
									<select class="col-md-11 control-label" id="d_or_c" >
										<option value="0">請選擇部門</option>
										<option value="3">寬仕</option>
										<?php foreach ($all_department_list as $each) : ?>
											<option value="<?= $each -> id?>"><?=  $each -> name ?></option>
										<?php endforeach ?>	
									</select>
								</div>
							<?php else:?>
								<input id="d_or_c" type="hidden" value="<?= $login_user_d?>">
							<?php endif?>

							<input id="d_or_c1" type="hidden" value="<?= $login_user->role_id?>">

								<div class="pull-left " style="width:200px;line-height:32px">
									<select class="col-md-9 control-label" id="list_title"  >
										<!-- option from javascript -->
									</select>
									<?php if($login_user->role_id==17 || $login_user->role_id==6 || $login_user->role_id==16 || $login_user->role_id==9|| $login_user->role_id==69): ?>

										<button type="button" class=" btn btn-sm btn-primary btn-group" id="add_title"><i class="fa fa-plus-circle fa-lg"></i></button>
									<?php endif?>
								</div>
								<div class="pull-left " style="width:200px;line-height:32px">
									<select class="col-md-9 control-label" id="list_style"  >
										<!-- option from javascript -->
									</select>
									<?php if($login_user->role_id==17 || $login_user->role_id==6 || $login_user->role_id==16 || $login_user->role_id==9|| $login_user->role_id==69): ?>
										<button type="button" class=" btn btn-sm btn-primary btn-group" id="add_swot"><i class="fa fa-plus-circle fa-lg"></i></button>
									<?php endif?>

								</div>
								<div class="pull-left ">
									<?php if($login_user->role_id==17 || $login_user->role_id==6 || $login_user->role_id==16 || $login_user->role_id==9|| $login_user->role_id==69): ?>
										<button onclick="unify(1);" class=" btn btn-xs btn-success btn-group" data-toggle="dropdown">
											整合各部
										</button>
										<button onclick="unify(0);" class=" btn btn-xs btn-success btn-group" data-toggle="dropdown">
											整合各課
										</button>
										<!-- <button onclick="unify_all_inspection();" class=" btn btn-xs btn-success btn-group" data-toggle="dropdown">
											整合部門總檢 
										</button> -->
									<?php else:?>
										<button onclick="unify(0);" class=" btn btn-xs btn-success btn-group" data-toggle="dropdown">
											整合各課
										</button>
										<!-- <button onclick="unify_all_inspection();" class=" btn btn-xs btn-success btn-group" data-toggle="dropdown">
											整合部門總檢
										</button> -->
									<?php endif?>
								</div>
								<div class="widget-toolbar pull-right">
									<button onclick="currentApp.do_remove();" class="btn btn-xs btn-success" data-toggle="dropdown">
										<i class="fa fa-refresh"></i>一鍵清除自己使用中檔案
									</button>
								</div>
						</header>

						<input type="hidden" name="l_user_id" id="l_user_id" value="<?= isset($login_user->role_id) ? $login_user->role_id: '' ?>" />
						<!-- widget div-->
						<div>
							<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->
							</div>
							<!-- end widget edit box -->
							<!-- widget content -->
							<div class="widget-body no-padding">
								<table id="dt_list" class="table table-striped table-bordered table-hover" width="100%">
									
									<thead>
										<tr>
											<th class="min25"></th>
											<th class="min100">部/課</th>
											<th class="min100">標題</th>
											<th class="min100">文件種類</th>
											<th class="min100">更新時間</th>
											<th class="min100">建立時間</th>
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
<script type="text/javascript">
	var baseUrl = '<?=base_url('')?>';

	var mCols = [null,{
		data : 'swot_pos',
		render: function(d,t,r){
			if(r.department_list){
				if(r.unify==1){
					return r.department_list.name+'+'+r.d_or_c_name+'(整合)';
				}else{
					return r.department_list.name+'+'+r.d_or_c_name;
				}
			} else{
				if(r.unify==1){
					return r.d_or_c_name+'(整合)';
				}else{
					return r.d_or_c_name;
				}
			}
		}
	},{
		data : 's_title_name'
	},{
		data : 's_style_name'
	},{
		data : 'update_date'
	},{
		data : 'create_time'
	}];

	var mOrderIdx = 4;
	
	var defaultContent = '<a href="#deleteModal" role="button" data-toggle="modal" style="margin-right: 5px;"><i class="fa fa-trash fa-lg"></i></a>';

	var mColDefs = [{
		targets : 0,
		data : null,
		defaultContent : defaultContent,
		searchable : false,
		orderable : false,
		width : "5%",
		className : ''
	}, {
		"targets" : [0,2,4],
		"orderable" : false
	}];

	loadScript(baseUrl + "js/class/BaseAppClass.js", function(){
		loadScript(baseUrl + "js/app/swot/list.js", function(){
			currentApp = new SwotAppClass(new BaseAppClass({}));
			
		});
	});
	function load_list_title() {
		$.ajax({
			url: '<?= base_url() ?>' + 'mgmt/swot/find_swot_title_list',
			type: 'POST',
			data: {},
			dataType: 'json',
			success: function(d) {
				if(d) {
					// console.log(d);
					$swot_title = $('#list_title').empty();
					$("#list_title").prepend("<option value='0'>請選擇標題</option>");
					$.each(d.swot, function(){
						$('<option/>', {
							'value': this.id,
							'text': this.swot_title
						}).appendTo($swot_title);
					});
					load_list_style();
					$('#list_title').select2();
					if($('#d_or_c1').val()==17 || $('#d_or_c1').val()==6 || $('#d_or_c1').val()==16 || $('#d_or_c1').val()==9|| $('#d_or_c1').val()==69){
						$('#d_or_c').select2();
					}

				}
			},
			failure:function(){
				alert('faialure');
			}
		});
	}
	load_list_title();

	function load_list_style() {
		$.ajax({
			url: '<?= base_url() ?>' + 'mgmt/swot/find_swot_style',
			type: 'POST',
			data: {},
			dataType: 'json',
			success: function(d) {
				if(d) {
					// console.log(d);
					$swot_style = $('#list_style').empty();
					$("#list_style").prepend("<option value='0'>請選擇類型</option>");
					$.each(d.swot, function(){
						$('<option/>', {
							'value': this.id,
							'text': this.swot_name
						}).appendTo($swot_style);
					});
					$('#list_style').select2();
				}
			},
			failure:function(){
				alert('faialure');
			}
		});
	}
	// function unify_unify() {
	// 	var style=$('#list_style').val();
	// 	// if(style!=="8"){
			
	// 	// } else{
	// 	// 	// alert("總檢無法使用整合公司");
	// 	// }
	// 	var title=$('#list_title').val();
	// 	var dep=$('#d_or_c').val();
	// 	currentApp.doEdit(0,title,style,dep,1);
		
	}
	function unify($t_type) {
		var style=$('#list_style').val();
		var title=$('#list_title').val();
		var dep=$('#d_or_c').val();
		currentApp.doEdit(0,title,style,dep,$t_type);
		
	}
	// function unify_all_inspection() {
	// 	var style=$('#list_style').val();
	// 	if(style=="8"){
	// 		var title=$('#list_title').val();
	// 		var dep_id = 0;
	// 		if($('#d_or_c1').val()==17 ||$('#d_or_c1').val()==69 || $('#d_or_c1').val()==6 || $('#d_or_c1').val()==16 || $('#d_or_c1').val()==9){
	// 			dep_id=$('#d_or_c').val();
	// 		} else{
	// 			dep_id=$('#d_or_c1').val();
	// 		}

	// 		currentApp.doEdit1(0,title,8,dep_id);
	// 	} else{
	// 		alert("請選擇總檢");
	// 	}
		

	// }
	$('#add_title').click(function() {
		layer.open({
			type:2,
			title:'',
			closeBtn:0,
			area:['400px','200px'],
			shadeClose:true,
			content:'<?=base_url('mgmt/swot/new_swot_title')?>'
		})
	});

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
</script>
