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
											<th class="min15">開放</th>
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

	var mCols = [{
				targets : 0,
				data : 'status',
				render:function ( data, type, row ) {
					var input = '';
					var is_stop_html ='';
					if(row.status <1){//開放
						input = '<input type="checkbox"  class="product-post onoffswitch-checkbox" checked id="'+row.id+'" >'
						var html = '<span class="onoffswitch" style="margin-top: 10px;">'
						+input
						+'<label class="onoffswitch-label" for="'+row.id+'">'
							+'<span class="onoffswitch-inner" data-swchon-text="開放" data-swchoff-text="開放"></span>'
							+'<span class="onoffswitch-switch"></span>'
						+'</label>'
					+'</span>'

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
					}
					return html;
		    },
				searchable : false,
				orderable : false,
				width : "8%",
				className: ''
			},{
		data : 'open_date'
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
		"targets" : [0,1],
		"orderable" : false
	}];

	loadScript(baseUrl + "js/class/BaseAppClass.js", function(){
		loadScript(baseUrl + "js/app/sing_status/list.js", function(){
			currentApp = new SingstatusAppClass(new BaseAppClass({}));
			
		});
	});

	function switch_sing(id) {
		$.ajax({
			url: '<?= base_url() ?>' + 'mgmt/sing_status/switch_sing',
			type: 'POST',
			data: {
				id: id
			},
			dataType: 'json',
			success: function(d) {
				currentApp.tableReload();
			},
			failure:function(){
				alert('failure');
			}
		});
	}
</script>
