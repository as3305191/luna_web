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
							<div class="widget-toolbar pull-left">
								<div class="btn-group">
									<button onclick="currentApp.doEdit(0)" class="btn dropdown-toggle btn-xs btn-success" data-toggle="dropdown">
										<i class="fa fa-plus"></i>新增
									</button>
								</div>
							</div>
						
						
						</header>

						<!-- widget div-->
						<div>

							<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->
							</div>
							
							<input type="hidden" class="form-control" id="user_id" name="user_id" value="<?= isset($login_user) ? $login_user->id : '' ?>"  />
							<input type="hidden"  id="role_id"  value="<?= isset($login_user) ? $login_user-> role_id : '' ?>"/>

							<!-- widget content -->
							<div class="widget-body no-padding">
								<table id="dt_list" class="table table-striped table-bordered table-hover" width="100%">
									<thead>
										<tr>
											<th class="min25"></th>
											<th class="min100">編號</th>
											<th class="min100">刪除碼</th>
											<th class="min100">名稱</th>
											<th class="min100">餐別名</th>
											<th class="min100">菜色類別</th>
										</tr>
										<tr class="search_box">
											<th></th>
											<th></th>
											<th><input class="form-control input-xs min100" type="text" /></th>
											<th><input class="form-control input-xs min100" type="text" /></th>
											<th><input class="form-control input-xs min100" type="text" /></th>
											<th><input class="form-control input-xs min100" type="text" /></th>
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
	loadScript(baseUrl + "js/class/BaseAppClass.js", function(){
		loadScript(baseUrl + "js/app/menu/list.js", function(){
			currentApp = new MenuAppClass(new BaseAppClass({}));
		});
	});

</script>
