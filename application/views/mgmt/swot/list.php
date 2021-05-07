<style>
thead tr th {
	position:sticky;
	top:0;
	background-color:#FFFFFF !important;
	text-align:center;
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
							<div class="widget-toolbar pull-left">
								<?php if(!empty($login_user) ): ?>
									<?php if($login_user->role_id==17 || $login_user->role_id==6 || $login_user->role_id==16 || $login_user->role_id=9): ?>
										<label class="col-md-3 control-label">部門/課</label>
										<select class="col-md-6 control-label" id="d_or_c"  >
											<option value="0">請選擇</option>
											<option value="3">寬仕</option>
											<?php foreach ($all_department_list as $each) : ?>
													<option value="<?= $each -> id?>"><?=  $each -> name ?></option>
											<?php endforeach ?>	
										</select>
									<?php endif?>
								<?php endif?>
							</div>
							<div class="widget-toolbar pull-left">
								<?php if(!empty($login_user) ): ?>
									<?php if($login_user->role_id==17 || $login_user->role_id==6 || $login_user->role_id==16 || $login_user->role_id=9): ?>
										<label class="col-md-3 control-label">合併標題：</label>
										<select class="col-md-6 control-label" id="list_title"  >
											<!-- option from javascript -->
										</select>
										<button type="button" class=" btn btn-sm btn-primary btn-group" id="add_title"><i class="fa fa-plus-circle fa-lg"></i></button>
										<button onclick="unify();" class=" btn btn-xs btn-success btn-group" data-toggle="dropdown">
											整合公司
										</button>
									<?php endif?>
								<?php endif?>
							</div>
							<div class="widget-toolbar pull-left">
								<div class="btn-group">
									<button onclick="currentApp.do_remove();" class="btn btn-xs btn-success" data-toggle="dropdown">
										<i class="fa fa-refresh"></i>一鍵清除自己使用中檔案
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
								<table id="dt_list" class="table table-striped table-bordered table-hover" width="100%">
									<thead>
										<tr>
											<th class="min25"></th>
											<th class="min100">部/課</th>
											<th class="min100">標題</th>
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
<script type="text/javascript">
	var baseUrl = '<?=base_url('')?>';

	var mCols = [null,{
		data : 'd_or_c_name',
		render: function(d,t,r){
			if(r.department_list){
				return r.department_list.name+'+'+d;
			} else{
				return d;
			}
		}
	},{
		data : 's_title_name'
	},{
		data : 'create_time'
	}];

	var mOrderIdx = 3;
	
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
		loadScript(baseUrl + "js/app/swot/list.js", function(){
			currentApp = new SwotAppClass(new BaseAppClass({}));
			
		});
	});
	function load_list_title() {
		$.ajax({
			url: '<?= base_url() ?>' + 'mgmt/swot/find_swot_title',
			type: 'POST',
			data: {},
			dataType: 'json',
			success: function(d) {
				if(d) {
					// console.log(d);
					$swot_title = $('#list_title').empty();
					$("#list_title").prepend("<option value='0'>請選擇</option>");
					$.each(d.swot, function(){
						$('<option/>', {
							'value': this.id,
							'text': this.swot_title
						}).appendTo($swot_title);
					});
					$('#list_title').select2();
					$('#d_or_c').select2();

				}
			},
			failure:function(){
				alert('faialure');
			}
		});
	}
	load_list_title();


	function unify() {
		var title=$('#list_title').val();
		currentApp.doEdit(0,title);
	}

</script>
