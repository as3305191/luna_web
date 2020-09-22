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
                            <div class="widget-toolbar pull-left">
								<label>範圍查詢 <input id="s_multiple" type="checkbox" class="" value="" /></label>
							</div>
							<div class="widget-toolbar pull-left">
								<input id="s_dt" placeholder="請輸入日期" type="text" class="dt_picker" value="<?= date('Y-m-d') ?>" />
							</div>
							<div class="widget-toolbar pull-left" disabled>
								~ <input id="e_dt" disabled placeholder="請輸入日期" type="text" class="dt_picker" value="<?= date('Y-m-d') ?>" />
							</div>
							<div class="widget-toolbar pull-left">
								<label>原料/成品</label>
							</div>
							<div class="widget-toolbar pull-left">
								<select name="" id="s_storage" class="">
									<option value="0">原料</option>
									<option value="2">成品</option>

								</select>
							</div>

							<div class="widget-toolbar pull-left">
								<label>原料櫃號</label>
							</div>
							<div class="widget-toolbar pull-left">
								<input id="s_container_sn" ondragover="" autocomplete="off" type="text" class="form-control" />
							</div>
							<div class="widget-toolbar pull-left">
								<label>工單編號</label>
							</div>
							<div class="widget-toolbar pull-left">
								<input id="s_sn" type="text" class="form-control" autocomplete="off" />
							</div>
							<div class="widget-toolbar pull-left">
								<label>料號</label>
							</div>
							<div class="widget-toolbar pull-left">
								<input id="s_lot_number" ondragover="" type="text" class="form-control" autocomplete="off"/>
							</div>

							<div class="widget-toolbar pull-left">
								<label>品名</label>
							</div>
							<div class="widget-toolbar pull-left">
								<input id="s_product_name1"  type="text" class="form-control" style="background:#FFFFFF" value="" readonly/>
								<input id="s_product_name"  type="button" style="width:171px;position:relative;z-index:300;top:-30px;background-color: transparent; border: 0" class="form-control" autocomplete="off"/>
							</div>

							<div class="widget-toolbar pull-left">
								<label>批號</label>
							</div>
							<div class="widget-toolbar pull-left">
								<input id="s_trace_batch" type="text" class="form-control"autocomplete="off" />
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
											<th class="min25"></th>
											<th class="min100">id</th>
											<th class="min100">plant</th>
											<th class="min100">sloc</th>
											<th class="min100">desc</th>
											<th class="min100">is_show</th>
										</tr>
										<tr class="search_box">
									    <th></th>
									    <th><input class="form-control input-xs min100" type="text" /></th>
									    <th><input class="form-control input-xs min100" type="text" /></th>
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
	var mCols = [null, {
		data : 'id'
	}, {
		data : 'plant'
	}, {
		data : 'sloc'
	}, {
		data : 'desc',
		render: function(d,t,r) {
			return d + " / " + r.reward_foreign;
		}
	}, {
		data : 'is_show'
	}];

	var mOrderIdx = 5;

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
		"targets" : [1,2,3,4],
		"orderable" : false
	}];

	loadScript(baseUrl + "js/class/BaseAppClass.js", function(){
		loadScript(baseUrl + "js/app/patent/list.js", function(){
			currentApp = new patentAppClass(new BaseAppClass({}));
		});
	});
</script>
