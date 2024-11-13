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
									<label>開放日期:</label>
								</div>
								<div class="widget-toolbar pull-left">
									<input class="form-control input-xs min100 dt_picker"  id="s_date" type="text"  value="" />
								</div>
								

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
											<th class="min100">比賽名稱</th>
											<th class="min100">日期</th>
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

	$(".dt_picker").datetimepicker({
		format : 'YYYY.MM.DD'
	}).on('dp.change',function(event){

	});

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
			var html ='';
			
			if(row.open_date!=='0000-00-00'){
				var weekarrary=["日","一","二","三","四","五","六"];
				var d = new Date(row.open_date);
				var month = '' + (d.getMonth() + 1);
				var day = '' + d.getDate();
				var weekday = d.getDay();
				html += month+'.'+day+' ('+weekarrary[weekday]+')'+' '+data;
			}  else{
				html += data;
			}
			if(row.open_dep!=='0'){
				html +='&nbsp;<i class="fa fa-lg fa-lock"></i>';
			}
			return html;

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
		loadScript(baseUrl + "js/app/sing_status/list.js", function(){
			currentApp = new SingstatusAppClass(new BaseAppClass({}));
			
		});
	});

</script>
