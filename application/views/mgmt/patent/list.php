<style>
thead tr th {
	position:sticky;
	top:0;
	background-color:#FFFFFF !important;
	text-align:center;
}
</style>

<!-- CSS Unify Theme -->
<link rel="stylesheet" href="<?= base_url() ?>assets_co/assets_/css/styles.multipage-real-estate.css">
  
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
							<?php if($login_user->role_id==9 ||$login_user->role_id==69 ||$login_user->role_id==11||$login_user->role_id==28): ?>
								<div class="widget-toolbar pull-left">
									<div class="btn-group">
										<button onclick="currentApp.doEdit(0)" class="btn btn-xs btn-success" data-toggle="dropdown">
											<i class="fa fa-plus"></i>新增
										</button>
									</div>
								</div>
							<?php endif?>
							<div id="patent_header">
								<div class="widget-toolbar pull-left">
									<label>專利類型</label>
								</div>
								<input id="now_category" type="hidden"/>
								<div id="category">
								</div>
								<div class="widget-toolbar pull-left">
									<label>專利名稱</label>
								</div>
								<div class="widget-toolbar pull-left">
									<input id="s_patent_name" ondragover="" autocomplete="off" type="text" class="form-control" />
								</div>
								<div class="widget-toolbar pull-left">
									<label>申請人</label>
								</div>
								<div class="widget-toolbar pull-left">
									<input id="application_person" ondragover="" autocomplete="off" type="text" class="form-control" />
								</div>
								<div class="widget-toolbar pull-left">
									<label>發明人</label>
								</div>
								<div class="widget-toolbar pull-left">
									<input id="invention_person_search" ondragover="" type="text" class="form-control" autocomplete="off"/>
								</div>
								<div class="widget-toolbar pull-left">
									<label>申請號</label>
								</div>
								<div class="widget-toolbar pull-left">
									<input id="application_num_search" type="text" class="form-control" autocomplete="off" />
								</div>
								
								<div class="widget-toolbar pull-left">
									<label>公開號</label>
								</div>
								<div class="widget-toolbar pull-left">
									<input id="public_num_search"  type="text" class="form-control" style="background:#FFFFFF" autocomplete="off"/>
								</div>
								<div class="widget-toolbar pull-left">
									<label>專利號</label>
								</div>
								<div class="widget-toolbar pull-left">
									<input id="patent_search" type="text" class="form-control"autocomplete="off" />
								</div>
								<div class="widget-toolbar pull-left">
									<label>專利家族</label>
								</div>
								<div class="widget-toolbar pull-left">
									<input id="patent_family_search" type="text" class="form-control"autocomplete="off" />
								</div>
								<div class="widget-toolbar pull-left">
									<label>和：<input id="or_and_type" type="checkbox" class="" value="" /></label>
								</div> 
								<div class="widget-toolbar pull-left">
									<label>關鍵字(或)</label>
								</div>
								<div class="widget-toolbar pull-left" style="z-index: 9999;">
									<!-- <input id="key_search" type="text" class="form-control"autocomplete="off" /> -->
									<select id="key_search_array" class="form-control"  multiple>
									</select>
								</div>
				
							</div>
                            <div class="widget-toolbar pull-left" id="patent_status">
                                <div>
									<?php foreach ($patent_status as $each) : ?>
										<label class="u-check g-pl-0">
											<input class="g-hidden-xs-up g-pos-abs g-top-0 g-left-0" name="patent_status[]" type="checkbox" value="<?= $each->id ?>">
											<span class="btn btn-md btn-block u-btn-outline-lightgray g-color-white--checked g-bg-primary--checked rounded-0"><?= $each->name ?></span>
										</label>
									<?php endforeach ?>
                                </div>
                            </div>
							<div class="widget-toolbar pull-left">
								<div class="btn-group">
									<button onclick="do_remove();" class="btn btn-xs btn-success" data-toggle="dropdown">
										<i class="fa fa-refresh"></i>一鍵清除
									</button>
								</div>
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
								<div >
									專利申請國家代號說明：<span style="color:red;">TW:台灣 US:美國 JP:日本 CN:大陸 CA:加拿大 EP:歐洲 AU:澳洲</span>
								</div>
								<table id="dt_list" class="table table-striped table-bordered table-hover" width="100%">
									<thead>
										<tr>
											
											<th class="min25"></th>
											<th class="min100">專利名稱</th>
											<th class="min100">代表圖</th>
											<th class="min100">申請人</th>
											<th class="min100">發明人</th>
											<th class="min100">已申請國家</th>
											<th class="min100">專利號</th>
											<th class="min100">公開號</th>
											<th class="min100">申請日</th>
											<th class="min100">公開日</th>
											<th class="min100">公告日</th>
											<th class="min100">更新日</th>
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
<!-- Station Serach Modal -->
<div class="modal fade" id="family_search_Modal" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
			</div>
			<div class="modal-body" id="station-edit-modal-body">
				<form id="family-num-search">
					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">搜尋專利家族碼</label>
							<div class="col-md-9">
								<div class="input-group">
									<input type="text" class="form-control" id="s-family-name" placeholder="請輸入公開號或專利號或申請號" />
									<span class="input-group-btn">
										<button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i></button>
									</span>
								</div>
							</div>
						</div>
					</fieldset>
					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">搜尋結果</label>
							<div class="col-md-9">
								<table class="table table-hover">
									<thead>
										<tr>
											<td>申請號</td>
										</tr>
									</thead>
									<tbody id="family_num_serach_body">
									</tbody>
								</table>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
					<i class="fa fa-close"></i> 關閉
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="patent_num_search_Modal" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
			</div>

			<div class="modal-body" id="station-edit-modal-body">
				<form id="patent-num-search">
					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">搜尋</label>
							<div class="col-md-9">
								<div class="input-group">
									<input type="text" class="form-control" id="s-patent-num-name" placeholder="請輸入公開號或專利號或申請號" />
									<span class="input-group-btn">
										<button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i></button>
									</span>
								</div>
							</div>
						</div>
					</fieldset>
					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">搜尋結果</label>
							<div class="col-md-9">
								<table class="table table-hover">
									<thead>
										<tr>
											<td>申請號</td>
										</tr>
									</thead>
									<tbody id="patent_num_serach_body">
									</tbody>
								</table>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
					<i class="fa fa-close"></i> 關閉
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Product Serach Modal -->
<div class="modal fade" id="s_key_all" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
			</div>
			<div class="modal-body" id="key-edit-modal-body">
				<form id="key-seach-form" class="">
					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">搜尋關鍵字</label>
							<div class="col-md-9">
								<div class="input-group">
									<input type="text" class="form-control" id="s-key-patent"  value="" placeholder="請輸入開始搜尋" />
									<span class="input-group-btn">
										<button type="submit" onclick="" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i></button>
									</span>
			      				</div>
							</div>
						</div>
					</fieldset>
					<fieldset>
						<div class="form-group">
							<label class="col-md-3 control-label">搜尋結果</label>
							<div class="col-md-9">
								<table class="table table-hover">
									<thead>
										<tr>
											<td>勾選</td>
											<td>關鍵字</td>
									
										</tr>
									</thead>
									<tbody id="all_key_list_serach_body">

									</tbody>
								</table>
							</div>
						</div>
					</fieldset>

				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-sm" onclick="savekeyitem()">
					<i class="fa fa-save"></i> 存擋
				</button>
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
					<i class="fa fa-close"></i> 關閉
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php $this -> load -> view('general/delete_modal'); ?>
<script type="text/javascript">
	var baseUrl = '<?=base_url('')?>';

	var mCols = [null,{
		data : 'patent_name',
		render: function(d,t,r){
			if(r.patent_key_id_array.length == 0){
				var html = '<span style="color:red;">'+d+'</span>';
				return html;
			} else{
				return d;
			}
		}
	}, {
		data : 'image',
		render: function(d,t,r){
			if(d>0){
				var html = '<img src="'+baseUrl+'api/images/get/'+d+'/thumb" loading="lazy" style="max-height:200px;max-width:200px" >';
				return html;
			} else{
				return '';
			}
		}
	},{
		data : 'applicant',
		render: function(d,t,r){
			if(d){
				var html = '<span style="word-wrap:break-word;white-space:pre-wrap;">'+d+'</span>';
				return html;
			} else{
				return '';
			}
		}
	},{
		data : 'inventor',
		render: function(d,t,r){
			if(d){
				var html = '<span style="word-wrap:break-word;white-space:pre-wrap;">'+d+'</span>';
				return html;
			} else{
				return '';
			}
		}
	},{
		data : 'total_country',
		render: function(d,t,r){
			if(d){
				return d;
			} else{
				if(r.my_patent_country){
					var html = '<span style="word-wrap:break-word;white-space:pre-wrap;color:red;">'+r.my_patent_country+'</span>';
					return html;
				}
			}
		}
	}, {
		data : 'patnet_num',
		render: function(d,t,r){
			if(d){
				var html = '<span style="color:red;">'+d+'</span>';
				return html;
			} else{
				return '';
			}
		}
	}, {
		data : 'public_num'
	}, {
		data : 'application_date'
	}, {
		data : 'public_date'
	}, {
		data : 'announcement_date'
	},{
		data : 'update_date'
	}];

	var mOrderIdx = 6;
	
	if($('#l_user_id').val()=='9' || $('#l_user_id').val()=='69'|| $('#l_user_id').val()=='28'|| $('#l_user_id').val()=='11' ){
		var defaultContent = '<a href="#deleteModal" role="button" data-toggle="modal" style="margin-right: 5px;"><i class="fa fa-trash fa-lg"></i></a>';
	} else{
		var defaultContent = '<a role="button" data-toggle="modal" style="margin-right: 5px;" ><i class="fa fa-trash fa-lg"></i></a>';
	}

	var mColDefs = [{
		targets : 0,
		data : null,
		defaultContent : defaultContent,
		searchable : false,
		orderable : false,
		width : "5%",
		className : ''
	}, {
		"targets" : [0,1,2,3,4,5,6,7],
		"orderable" : false
	}];

	loadScript(baseUrl + "js/class/BaseAppClass.js", function(){
		loadScript(baseUrl + "js/app/patent/list.js", function(){
			currentApp = new patentAppClass(new BaseAppClass({}));
			$('#key-seach-form').submit(function(e){
				keyChange();
				e.preventDefault();
			});
			
		});
	});

	var total_category=0;

	function load_category() {
		$.ajax({
			url: '<?= base_url() ?>' + 'mgmt/patent/find_all_category',
			type: 'POST',
			data: {},
			dataType: 'json',
			success: function(d) {
				if(d) {
					// console.log(d);
					$category = $('#category').empty();
					var i=0;
					var html='';
					total_category = d.max;
					for(i;i<=d.max;i++){
						html+='<div class="widget-toolbar pull-left">'+
								'<select id="category_'+i+'" class="p_list_patnet_status" data-val="'+i+'" >'+
								'</select>'+
							'</div>';
					}
					$(html).appendTo($category);
					var category_option = '<option value="all">全部</option>';
					var $category_0 = $('#category_0').empty();
					$category_0.append(category_option);
					$.each(d.category, function(){
						if(this.level==0){
							$('<option />', {
								'value': this.id,
								'text': this.name,
							}).appendTo($category_0);
						}
					});

					$('.p_list_patnet_status').on('change', function(){
						var me = $(this);
						var _dataVal = me.data("val");
						var select_Val = me.val();
						$('#now_category').val(select_Val);
						var next_c =_dataVal+1;
						console.log(next_c);
						$.ajax({
							url:  baseUrl + currentApp.basePath + '/find_next_category',
							type: 'POST',
							data: {
								next_level:next_c,
								this_val:select_Val,
							},
							dataType: 'json',
							success: function(d) {
								var category_option = '<option value="all">全部</option>';
								var $category = $('#category_'+next_c).empty();
								$category.append(category_option); 
								if(d.category){
									$.each(d.category, function(){
										$('<option />', {
											'value': this.id,
											'text': this.name,
										}).appendTo($category);
									});
									currentApp.tableReload();

								}
							},
							failure:function(){
							}
						});
					});

				}
			},
			failure:function(){
				alert('faialure');
			}
		});
	}	
	load_category();
	
	function do_remove() {//一鍵清除所有篩選
		$('#patent_header input').val('');
		$("input[name='patent_status[]']").removeAttr("checked");
		load_category();
		currentApp.tableReload();
		
	}

	$('.p_list_patnet_status').on('change', function(){
		var me = $(this);
		var _dataVal = me.data("val");
		// console.log(me);
		// console.log(_dataVal);
		$( "select .p_list_patnet_status" ).each(function(){
			var other_me = $(this);
			var other_dataVal = other_me.data("val");
			if(other_dataVal!=="all" && other_dataVal>_dataVal){
				$('<option />', {
					'value': this.id,
					'text': this.name,
				}).appendTo(other_me);
			}
		});
	});



	function find_s_key() {	
		
		$.ajax({
			url: '<?= base_url() ?>' + 'mgmt/patent/find_key',
			type: 'POST',
			data: {},
			dataType: 'json',
			success: function(d) {
				if(d) {
					// console.log(d);
					$patent_s_key = $('#key_search_array').empty();
					option ='';
					$.each(d.key, function(){
						option +='<option value="'+this.id+'">'+this.key+'</option>';
					});
					$patent_s_key.append(option).select2();
					// select2()
				}	
			},
			failure:function(){
				alert('faialure');
			}
		});

	}
	find_s_key();

</script>
