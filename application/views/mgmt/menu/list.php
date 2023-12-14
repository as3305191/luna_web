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
								<div class="widget-toolbar pull-left">
									<div class="btn-group">
										<button onclick="currentApp.doEdit(0)" class="btn btn-xs btn-success" data-toggle="dropdown">
											<i class="fa fa-plus"></i>新增
										</button>
									</div>
								</div>
								<div class="widget-toolbar pull-left">
									<label>類型:</label>
								</div>
								<div class="widget-toolbar pull-left">
									<select id="s_menu_style" class="form-control">
										<!-- option from javascript -->
									</select>
								</div>
									
								<div class="widget-toolbar pull-left">
									<label>店名:</label>
								</div>
								<div class="widget-toolbar pull-left">
									<input id="s_menu_name" type="text" class="form-control"autocomplete="off" />
								</div>
								<div class="widget-toolbar pull-right">
									<div class="btn-group">
										<button onclick="currentApp.doExportAll()" class="btn btn-xs btn-warning" data-toggle="dropdown">
											<i class="fa fa-save"></i>匯出
										</button>
									</div>
								</div>
								<input type="hidden" name="l_user_id" id="l_user_id" value="<?= isset($login_user->role_id) ? $login_user->role_id: '' ?>" />

						</header>
					<!-- widget div-->
					<div>

						<!-- widget edit box -->
						<div class="jarviswidget-editbox">
							<!-- This area used as dropdown edit box -->

						</div>
						<!-- end widget edit box -->

						<div class="widget-body no-padding">
								<table id="dt_list" class="table table-striped table-bordered table-hover" width="100%">
									<thead>
										<tr>
											<th class="min25">開放</th>
											<th class="min100">分類</th>
											<th class="min100">店名</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>

						</div>
					
						</div>
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


<?php $this -> load -> view('general/delete_modal'); ?>
<script type="text/javascript">
	var baseUrl = '<?=base_url('')?>';
	var mCols = [{
				targets : 0,
				data : 'status',
				render:function ( data, type, row ) {
					var input = '';
					var is_stop_html ='';
					if(row.status >0){//開放
						if(row.is_stop==0){//可以點
							is_stop_html  = '<button type="button" style="color:red;" class="btn btn-sm  pull-right" onclick="order_set('+row.id+')">暫停點餐</button>';
						} else{
							is_stop_html  = '<button type="button" style="color:green;" class="btn btn-sm  pull-right" onclick="order_set('+row.id+')">重啟點餐</button>';
						}
						input = '<input type="checkbox"  class="product-post onoffswitch-checkbox" checked id="'+row.id+'" >'
						var html = '<span class="onoffswitch" style="margin-top: 10px;">'
						+input
						+'<label class="onoffswitch-label" for="'+row.id+'">'
							+'<span class="onoffswitch-inner" data-swchon-text="開放" data-swchoff-text="開放"></span>'
							+'<span class="onoffswitch-switch"></span>'
						+'</label>'
					+'</span>'
					+is_stop_html
					+'<button type="button" class="btn btn-sm btn-primary pull-right" onclick="finish_menu('+row.id+')">完成</button>';
					}else{
						input = '<input type="checkbox"  class="product-post onoffswitch-checkbox" id="'+row.id+'" >'
						var html = '<span class="onoffswitch" style="margin-top: 10px;">'
						+input
						+'<label class="onoffswitch-label" for="'+row.id+'">'
							+'<span class="onoffswitch-inner" data-swchon-text="開放" data-swchoff-text="開放"></span>'
							+'<span class="onoffswitch-switch"></span>'
						+'</label>'
					+'</span>'
					+ '<a href="#deleteModal" role="button" data-toggle="modal" style="margin-left: 10px;"><i class="fa fa-trash fa-lg"></i></a>'
					+'<button type="button" class="btn btn-sm btn-primary pull-right" onclick="finish_menu('+row.id+')">完成</button>';
					}
					return html;
		    },
				searchable : false,
				orderable : false,
				width : "8%",
				className: ''
			},{
		data : 'style_name'
	},{
		data : 'menu_name',
		render:function ( data, type, row ) {

			var html =data;
			if(row.open_date!=='0000-00-00'){
				var weekarrary=["日","一","二","三","四","五","六"];
				var d = new Date(row.open_date);
				var month = '' + (d.getMonth() + 1);
				var day = '' + d.getDate();
				var weekday = d.getDay();
				return month+'.'+day+'('+weekarrary[weekday]+')'+' '+html;
			} else{
				return html;
			}
			
		}
	}];

	var mOrderIdx = 0;
	
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
		"targets" : [0,1,2],
		"orderable" : false
	}];

	loadScript(baseUrl + "js/class/BaseAppClass.js", function(){
		loadScript(baseUrl + "js/app/menu/list.js", function(){
			currentApp = new listmenuAppClass(new BaseAppClass({}));
			
		});
	});
	function order_set(id) {
		$.ajax({
			url: '<?= base_url() ?>' + 'mgmt/menu/order_set',
			type: 'POST',
			data: {
				id: id
			},
			dataType: 'json',
			success: function(d) {
					// console.log(d);
				currentApp.tableReload();
			},
			failure:function(){
				alert('faialure');
			}
		});
	}

	function finish_menu(id) {
		$.ajax({
			url: '<?= base_url() ?>' + 'mgmt/menu/finish_menu',
			type: 'POST',
			data: {
				id: id
			},
			dataType: 'json',
			success: function(d) {
					// console.log(d);
				currentApp.tableReload();
			},
			failure:function(){
				alert('faialure');
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
					$img_style = $('#s_menu_style').empty();
					var option = '<option value="0">全部</option>';
					$img_style.append(option);
					$.each(d.menu_style, function(){
						$('<option/>', {
							'value': this.id,
							'text': this.menu_style
						}).appendTo($img_style);
					});
				}
			},
			failure:function(){
				alert('faialure');
			}
		});
	}
load_menu_style();
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
</script>
