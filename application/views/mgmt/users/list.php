<div class="tab-content">
	<div class="tab-pane active" id="list_page">

		<!-- widget grid -->
		<section id="widget-grid" class="">

			<!-- row -->
			<div class="row">

				<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget">
						<header>
							<?php if($login_user -> id == 205||$login_user -> id == 2||$login_user -> id == 467):?>
							<div class="widget-toolbar pull-left">
								<div class="btn-group">
									<button onclick="currentApp.doEdit(0)" class="btn dropdown-toggle btn-xs btn-success" data-toggle="dropdown">
										<i class="fa fa-plus"></i>新增
									</button>
									<!-- <button class="btn dropdown-toggle btn-xs btn-success" data-toggle="dropdown">
									測試
									</button> -->
								</div>


							</div>
							<?php endif ?>

							<?php if($login_user -> role_id == 107 || $login_user -> role_id == 1):?>
								<!-- <div class="widget-toolbar pull-left">
									<div class="btn-group">
										<button onclick="currentApp.doExportAll()" class="btn dropdown-toggle btn-xs btn-warning" data-toggle="dropdown">
											<i class="fa fa-save"></i>匯出
										</button>
									</div>
								</div> -->
							<?php endif ?>

						</header>

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
											<th class="min100">帳號</th>
											<th class="min100">名稱</th>
											<th class="min100">部門/課</th>

										</tr>
										<tr class="search_box">
									    <th></th>
									    <th><input class="form-control input-xs min100" type="text" /></th>
									    <th><input class="form-control input-xs min100" type="text" /></th>
										<th></th>
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
	var mCols = [null,
	{
		data : 'account'
	}, {
		data : 'user_name'
	},{
		data : 'd_name'
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
		"targets" : [1,2,3],
		"orderable" : false
	}];

	loadScript(baseUrl + "js/class/BaseAppClass.js", function(){
		loadScript(baseUrl + "js/app/users/list.js", function(){
			currentApp = new UsersAppClass(new BaseAppClass({}));
		});
	});

	// if (!("Notification" in window)) {
	// 	 alert("This browser does not support desktop notification");
	// } 
	// var prm = Notification.permission;
	// console.log(prm);
	// if (prm == 'default' || prm == 'undefined' || prm == 'denied') {
	// 	Notification.requestPermission(function(permission) {
	// 		// permission 可為「granted」（同意）、「denied」（拒絕）和「default」（未授權）
	// 		// 在這裡可針對使用者的授權做處理
	// 	});
	// }	
</script>