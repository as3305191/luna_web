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
							<!-- end widget edit box -->

							<!-- widget content -->
							<div class="widget-body no-padding">

								<table id="dt_list" class="table table-striped table-bordered table-hover" width="100%">
									<thead>
										<tr>
											<th class="min100">購物網站帳號</th>
											<th class="min100">帳號</th>

											<th class="min100">名稱</th>
											<th class="min100">身份</th>
											<th class="min100">建立時間</th>
										</tr>
										<tr class="search_box">
											    <th><input class="form-control input-xs min100" type="text" /></th>
											    <th><input class="form-control input-xs min100" type="text" /></th>
													<th><input class="form-control input-xs min100" type="text" /></th>
													<th>
														<select name="type" id="type" class="form-control">
															<option value="-1">無</option>
															<option value="0" >一般會員</option>
															<option value="1" >教練</option>
															<option value="2" >訪客</option>
														</select>
													</th>
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
	var mCols = [{
		data : 'account'
	},{
		data : 'v_account'
	},{
		data : 'user_name'
	},{
		data : 'type',
		render:function(d,t,r) {
			if(d == 0) {
				return '一般會員';
			}
			if(d == 1) {
				return '教練';
			}
			if(d == 2) {
				return '訪客';
			}
			return d;
		}
	},{
		data : 'create_time'
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
		"targets" : [1,2],
		"orderable" : false
	}];

	loadScript(baseUrl + "js/class/BaseAppClass.js", function(){
		loadScript(baseUrl + "js/app/members/list.js", function(){
			currentApp = new MembersAppClass(new BaseAppClass({}));
		});
	});
</script>
