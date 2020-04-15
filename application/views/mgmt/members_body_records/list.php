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
									<input id="s_dt" placeholder="請輸入日期" type="text" class="dt_picker" value="<?= date('Y-m-d') ?>" />
								</div>
								<div class="widget-toolbar pull-left" >
									~ <input id="e_dt"  placeholder="請輸入日期" type="text" class="dt_picker" value="<?= date('Y-m-d') ?>" />
								</div>
							<div class="widget-toolbar pull-left">
								<div class="btn-group">
									<button onclick="currentApp.doExportAll()" class="btn dropdown-toggle btn-xs btn-warning" data-toggle="dropdown">
										<i class="fa fa-save"></i>匯出
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
											<th></th>
											<th class="min100">會員</th>
											<th class="min100">阻抗</th>
											<th class="min100">身高</th>
											<th class="min100">實際年齡</th>
											<th class="min100">體重</th>
											<th class="min100">體脂率</th>
											<th class="min100">脂肪</th>
											<th class="min100">內臟脂肪率</th>
											<th class="min100">蛋白率</th>
											<th class="min100">水分率</th>
											<th class="min100">肌肉率</th>
											<th class="min100">骨骼肌率</th>
											<th class="min100">骨重率</th>
											<th class="min100">皮下脂肪率</th>
											<th class="min100">肥胖等級</th>
											<th class="min100">BMR</th>
											<th class="min100">身體年齡</th>
											<th class="min100">BMI</th>
											<th class="min100">BMI最佳</th>
											<th class="min100">體重最佳</th>
											<th class="min100">體脂率最佳</th>
											<th class="min100">體脂最佳</th>
											<th class="min100">建立時間</th>
										</tr>
										<tr class="search_box">
											    <th></th>
											    <th><input class="form-control input-xs min100" type="text" /></th>
													<th></th>
													<th></th>
													<th></th>
													<th></th>
													<th></th>
													<th></th>
													<th></th>
													<th></th>
													<th></th>
													<th></th>
													<th></th>
													<th></th>
													<th></th>
													<th></th>
													<th></th>
													<th></th>
													<th></th>
													<th></th>
													<th></th>
													<th></th>
													<th></th>
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
	var mCols = [null,{
		data : 'user_name'
	},{
		data : 'adc1'
	},{
		data : 'height'
	},{
		data : 'age'
	},{
		data : 'weight',
		render: function(d,t,r) {
			return parseFloat(d / 1000).toFixed(2);
		}
	},{
		data : 'body_fat_rate',
		render: function(d,t,r) {
			return parseFloat(d).toFixed(2);
		}
	},{
		data : 'body_fat',
		render: function(d,t,r) {
			return parseFloat(d / 1000).toFixed(2);
		}
	},{
		data : 'visceral_fat_rate'
	},{
		data : 'protein_rate'
	},{
		data : 'moisture_rate'
	},{
		data : 'muscle_rate'
	},{
		data : 'skeletal_muscle_rate',
		render: function(d,t,r) {
			return parseFloat(d).toFixed(2);
		}
	},{
		data : 'bone_mass_rate'
	},{
		data : 'subcutaneous_fat_rate'
	},{
		data : 'fat_info'
	},{
		data : 'bmr'
	},{
		data : 'physical_age'
	},{
		data : 'bmi'
	},{
		data : 'bmi_best'
	},{
		data : 'weight_best'
	},{
		data : 'fat_rate_best'
	},{
		data : 'fat_best'
	},{
		data : 'create_time'

	}];

	var mOrderIdx = 6;

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
		"targets" : [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23],
		"orderable" : false
	}];

	loadScript(baseUrl + "js/class/BaseAppClass.js", function(){
		loadScript(baseUrl + "js/app/members_body_records/list.js", function(){
			currentApp = new MembersBodyRecordsClass(new BaseAppClass({}));
		});
	});


</script>
