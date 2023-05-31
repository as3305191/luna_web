<style>
/* thead tr th {
	position:sticky;
	top:0;
	background-color:#FFFFFF !important;
	text-align:center;
} */
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
							
                               
                            </div>
							<!-- <div class="widget-toolbar pull-left">
								<div class="btn-group">
									<button onclick="do_remove();" class="btn btn-xs btn-success" data-toggle="dropdown">
										<i class="fa fa-refresh"></i>一鍵清除
									</button>
								</div>
							</div> -->
							
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
											
											<th class="min25">是否預設</th>
											<th class="min100">分類</th>
											<th class="min100">照片</th>
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
<script type="text/javascript">
	var baseUrl = '<?=base_url('')?>';

	var mCols = [null,{
		data : 'menu_name',
		render: function(d,t,r){
			if(r.patent_key_id_array.length == 0){
				var html = '<span style="color:red;">'+d+'</span>';
				return html;
			} else{
				return d;
			}
		}
	}, {
		data : 'style_name'
	},{
		data : 'img_id',
		render: function (data) {
			if(data>0){
				return (data && data > 0 ? '<div class="img_con" style="width:150px;height:150px;background-image:url(' + baseUrl + 'api/images/get/' + data + '/thumb)" />' : "");
			} else{
				return '';
			}
		} 
	}];

	var mOrderIdx = 6;
	
	if($('#l_user_id').val()=='9' || $('#l_user_id').val()=='28'|| $('#l_user_id').val()=='11' ){
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

	
	
	function do_remove() {//一鍵清除所有篩選
		$('#patent_header input').val('');
		$("input[name='patent_status[]']").removeAttr("checked");
		load_category();
		currentApp.tableReload();
		
	}

</script>
