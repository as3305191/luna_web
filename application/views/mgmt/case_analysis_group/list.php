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
									<div class="widget-toolbar pull-left">
										<label>區間：</label>
									</div>
									<div class="widget-toolbar pull-left">
										<input id="s_dt" placeholder="請輸入日期" type="text" class="dt_picker " value="<?= date('Y-m-d',strtotime("-7 day")) ?>" autocomplete="off"  />
									</div>
									<div class="widget-toolbar pull-left" >
										~ <input id="e_dt"  placeholder="請輸入日期" type="text" class="dt_picker" value="<?= date('Y-m-d') ?>" autocomplete="off"  />
									</div>
									<div class="widget-toolbar pull-left" >
										<select id="algorithm" class="form-control" >
											<option value="1">平均</option>
											<option value="2">標準差</option>
											<option value="3">中位數</option>

										</select>
									</div>
									<div class="widget-toolbar pull-left">
										<label>醫院：</label>
									</div>
									<div class="widget-toolbar pull-left" >
										<select name="hospital_id" id="f_hospital" class="form-control" onchange="hospital()">
											<option value="-1">無</option>
											<?php
												foreach ($hospital_list as $each) {
													$selected = ((isset($item) && isset($item -> hospital_id) && $item -> hospital_id == $each -> id) ? 'selected' : '');
													echo "<option value='{$each -> id}' $selected>{$each -> hospital_name}</option>";
												}
											?>
										</select>
									</div>
									<div class="widget-toolbar pull-left">
										<label>醫生：</label>
									</div>
									<div class="widget-toolbar pull-left" >
										<select name="user_doctor_id" id="f_doctor" class="form-control" >
											<option value="-1">無</option>
											<?php foreach($doctor as $each): ?>
												<option value="<?= $each -> id?>" ><?=  $each -> user_name ?></option>
											<?php endforeach ?>
										</select>
									</div>
									<div class="widget-toolbar pull-left">
										<label>個管師：</label>
									</div>
									<div class="widget-toolbar pull-left" >
										<select name="user_manager_id" id="f_manager" class="form-control">
											<option value="-1">無</option>
											<?php foreach($manager as $each): ?>
												<option value="<?= $each -> id?>" ><?=  $each -> user_name ?></option>
											<?php endforeach ?>
										</select>
									</div>
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
								<div class="col-xs-12" style="">

									<div class="col-xs-6" style="width:30%;height:30%">
										<canvas id="blood" width="200" height="200"></canvas>
									</div>
									<div class="col-xs-6" style="width:30%;height:30%">
										<canvas id="heart" width="200" height="200"></canvas>
									</div>
								</div>


								<div class="col-xs-12" style="">

									<div class="col-xs-6" style="width:30%;height:30%">
										<canvas id="weight" width="200" height="200"></canvas>
									</div>
									<div class="col-xs-6" style="width:30%;height:30%">
										<canvas id="drink" width="200" height="200"></canvas>
									</div>
								</div>

								<div class="col-xs-12" style="">

									<div class="col-xs-6" style="width:30%;height:30%">
										<canvas id="walk" width="200" height="200"></canvas>
									</div>
									<div class="col-xs-6" style="width:30%;height:30%">
										<canvas id="comfortable" width="200" height="200"></canvas>
									</div>
								</div>
								<div class="col-xs-12" style="">

									<div class="col-xs-12" style="width:60%;height:30%">
										<canvas id="question_14" width=400 height="200"></canvas>
									</div>

								</div>
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
		loadScript(baseUrl + "js/app/case_analysis_group/list.js", function(){
			currentApp = new CaseanalysisgroupAppClass(new BaseAppClass({}));
		});
	});
</script>
<script>

	$(".dt_picker").datetimepicker({
		format: 'YYYY-MM-DD'
	}).on('dp.change',function(event){
		ajaxCallblood();

	});
	$('#f_hospital').on('change', function(){
		hospital();
	});
	$('#f_doctor').on('change', function(){
		ajaxCallblood();
	});
	$('#f_manager').on('change', function(){
		ajaxCallblood();
	});
	$('#algorithm').on('change', function(){
		ajaxCallblood();
	});
	function hospital(){
			$.ajax({
				url: '<?= base_url() ?>' + 'mgmt/members/find_doctor',
				type: 'POST',
				data: {
					hospital: $('#f_hospital').find(':selected').attr('value')
				},
				dataType: 'json',
				success: function(d) {
					if(d) {
						console.log(d);
						$doctor_id= $('#f_doctor').empty();
						$manager_id= $('#f_manager').empty();

						var html = '<option value="-1">無</option>';
						$doctor_id.append(html);
						$manager_id.append(html);

						$.each(d.list, function(){
							$('<option/>', {
									'value': this.id,
									'text': this.user_name
							}).appendTo($doctor_id);
					});

					$.each(d.list_1, function(){
						$('<option/>', {
								'value': this.id,
								'text': this.user_name
						}).appendTo($manager_id);
				});
					}
					ajaxCallblood();
				},
				failure:function(){
					alert('faialure');
				}
			});
		}
</script>
<script>
	var ajaxCallblood = function(){
		var ctx = document.getElementById('blood').getContext('2d');
		var ctx1 = document.getElementById('heart').getContext('2d');
		var ctx2 = document.getElementById('weight').getContext('2d');
		var ctx3 = document.getElementById('drink').getContext('2d');
		var ctx4 = document.getElementById('walk').getContext('2d');
		var ctx5 = document.getElementById('comfortable').getContext('2d');
		var ctx6 = document.getElementById('question_14').getContext('2d');

		var blood = new Chart(ctx, {
				type: 'line',
				data: {
						labels: [],
						datasets: [{
								label: '血壓(舒張壓)',
								data: [],
								backgroundColor: [
										'rgba(255, 99, 132, 0.2)',
										'rgba(255, 99, 132, 0.2)',
										'rgba(255, 99, 132, 0.2)',
										'rgba(255, 99, 132, 0.2)',
										'rgba(255, 99, 132, 0.2)',
										'rgba(255, 99, 132, 0.2)'
								],
								borderColor: [
										'rgba(255, 99, 132, 1)',
										'rgba(255, 99, 132, 1)',
										'rgba(255, 99, 132, 1)',
										'rgba(255, 99, 132, 1)',
										'rgba(255, 99, 132, 1)',
										'rgba(255, 99, 132, 1)'
								],
								borderWidth: 1
						},
						{
								label: '血壓(收縮壓)',
								data: [],
								backgroundColor: [
										'rgba(0, 100, 100, 0.2)',
										'rgba(0, 100, 100, 0.2)',
										'rgba(0, 100, 100, 0.2)',
										'rgba(0, 100, 100, 0.2)',
										'rgba(0, 100, 100, 0.2)',
										'rgba(0, 100, 100, 0.2)'
								],
								borderColor: [
										'rgba(0, 100, 100, 1)',
										'rgba(0, 100, 100, 1)',
										'rgba(0, 100, 100, 1)',
										'rgba(0, 100, 100, 1)',
										'rgba(0, 100, 100, 1)',
										'rgba(0, 100, 100, 1)'
								],
								borderWidth: 1
						}
					]

				},
				options: {
						scales: {
								yAxes: [{
										ticks: {
												beginAtZero: true
										}
								}]
						}
				}
		});
		var heart = new Chart(ctx1, {
				type: 'line',
				data: {
						labels: [],
						datasets: [{
								label: '心跳',
								data: [],
								backgroundColor: [
										'rgba(255, 99, 132, 0.2)',
										'rgba(255, 99, 132, 0.2)',
										'rgba(255, 99, 132, 0.2)',
										'rgba(255, 99, 132, 0.2)',
										'rgba(255, 99, 132, 0.2)',
										'rgba(255, 99, 132, 0.2)'
								],
								borderColor: [
										'rgba(255, 99, 132, 1)',
										'rgba(255, 99, 132, 1)',
										'rgba(255, 99, 132, 1)',
										'rgba(255, 99, 132, 1)',
										'rgba(255, 99, 132, 1)',
										'rgba(255, 99, 132, 1)'
								],
								borderWidth: 1
						}]
				},
				options: {
						scales: {
								yAxes: [{
										ticks: {
												beginAtZero: true
										}
								}]
						}
				}
		});
		var weight = new Chart(ctx2, {
				type: 'line',
				data: {
						labels: [],
						datasets: [{
								label: '體重',
								data: [],
								backgroundColor: [
										'rgba(255, 99, 132, 0.2)',
										'rgba(255, 99, 132, 0.2)',
										'rgba(255, 99, 132, 0.2)',
										'rgba(255, 99, 132, 0.2)',
										'rgba(255, 99, 132, 0.2)',
										'rgba(255, 99, 132, 0.2)'
								],
								borderColor: [
										'rgba(255, 99, 132, 1)',
										'rgba(255, 99, 132, 1)',
										'rgba(255, 99, 132, 1)',
										'rgba(255, 99, 132, 1)',
										'rgba(255, 99, 132, 1)',
										'rgba(255, 99, 132, 1)'
								],
								borderWidth: 1
						}]
				},
				options: {
						scales: {
								yAxes: [{
										ticks: {
												beginAtZero: true
										}
								}]
						}
				}
		});
		var drink = new Chart(ctx3, {
				type: 'line',
				data: {
						labels: [],
						datasets: [{
								label: '喝水量 1:<1000,2:1000-2000,3:>2000',
								data: [],
								backgroundColor: [
										'rgba(255, 99, 132, 0.2)',
										'rgba(255, 99, 132, 0.2)',
										'rgba(255, 99, 132, 0.2)',
										'rgba(255, 99, 132, 0.2)',
										'rgba(255, 99, 132, 0.2)',
										'rgba(255, 99, 132, 0.2)'
								],
								borderColor: [
										'rgba(255, 99, 132, 1)',
										'rgba(255, 99, 132, 1)',
										'rgba(255, 99, 132, 1)',
										'rgba(255, 99, 132, 1)',
										'rgba(255, 99, 132, 1)',
										'rgba(255, 99, 132, 1)'
								],
								borderWidth: 1
						}]
				},
				options: {
						scales: {
								yAxes: [{
										ticks: {
												data :[0,'<1000','1000-2000','>2000'],
												min:0,
												max:3,
												stepSize: 1,
												beginAtZero: true
										}
								}]
						}
				}
		});
		var walk = new Chart(ctx4, {
				type: 'line',
				data: {
						labels: [],
						datasets: [{
								label: '走路步數',
								data: [],
								backgroundColor: [
										'rgba(255, 99, 132, 0.2)',
										'rgba(255, 99, 132, 0.2)',
										'rgba(255, 99, 132, 0.2)',
										'rgba(255, 99, 132, 0.2)',
										'rgba(255, 99, 132, 0.2)',
										'rgba(255, 99, 132, 0.2)'
								],
								borderColor: [
										'rgba(255, 99, 132, 1)',
										'rgba(255, 99, 132, 1)',
										'rgba(255, 99, 132, 1)',
										'rgba(255, 99, 132, 1)',
										'rgba(255, 99, 132, 1)',
										'rgba(255, 99, 132, 1)'
								],
								borderWidth: 1
						}]
				},
				options: {
						scales: {
								yAxes: [{
										ticks: {
												beginAtZero: true
										}
								}]
						}
				}
		});
		var comfortable = new Chart(ctx5, {
				type: 'line',
				data: {
						labels: [],
						datasets: [{
								label: '自我安心放鬆程度(腹式呼吸)',
								data: [],
								backgroundColor: [
										'rgba(255, 0, 0, 0.2)',
										'rgba(255, 0, 0, 0.2)',
										'rgba(255, 0, 0, 0.2)',
										'rgba(255, 0, 0, 0.2)',
										'rgba(255, 0, 0, 0.2)',
										'rgba(255, 0, 0, 0.2)',
								],
								borderColor: [
										'rgba(255, 0, 0, 1)',
										'rgba(255, 0, 0, 1)',
										'rgba(255, 0, 0, 1)',
										'rgba(255, 0, 0, 1)',
										'rgba(255, 0, 0, 1)',
										'rgba(255, 0, 0, 1)',
								],
								borderWidth: 1
						},
						{
								label: '自我安心放鬆程度(壓力橡皮擦)',
								data: [],
								backgroundColor: [
										'rgba(0, 100, 100, 0.2)',
										'rgba(0, 100, 100, 0.2)',
										'rgba(0, 100, 100, 0.2)',
										'rgba(0, 100, 100, 0.2)',
										'rgba(0, 100, 100, 0.2)',
										'rgba(0, 100, 100, 0.2)'
								],
								borderColor: [
										'rgba(0, 100, 100, 1)',
										'rgba(0, 100, 100, 1)',
										'rgba(0, 100, 100, 1)',
										'rgba(0, 100, 100, 1)',
										'rgba(0, 100, 100, 1)',
										'rgba(0, 100, 100, 1)'
								],
								borderWidth: 1
						}

					]

				},
				options: {
						scales: {
								yAxes: [{
										ticks: {
												beginAtZero: true
										}
								}]
						}
				}
		});
		var question_14 = new Chart(ctx6, {
				type: 'line',
				data: {
						labels: [],
						datasets: [{
								label: '每日14題(症狀)',
								data: [],
								backgroundColor: [
										'rgba(255, 0, 0, 0.2)',
										'rgba(255, 0, 0, 0.2)',
										'rgba(255, 0, 0, 0.2)',
										'rgba(255, 0, 0, 0.2)',
										'rgba(255, 0, 0, 0.2)',
										'rgba(255, 0, 0, 0.2)',
								],
								borderColor: [
										'rgba(255, 99, 132, 1)',
										'rgba(54, 162, 235, 1)',
										'rgba(255, 206, 86, 1)',
										'rgba(75, 192, 192, 1)',
										'rgba(153, 102, 255, 1)',
										'rgba(255, 159, 64, 1)'
								],
								borderWidth: 2
						},
						{
								label: '每日14題(健康行為)',
								data: [],
								backgroundColor: [
										'rgba(0, 255, 0, 0.2)',
										'rgba(0, 255, 0, 0.2)',
										'rgba(0, 255, 0, 0.2)',
										'rgba(0, 255, 0, 0.2)',
										'rgba(0, 255, 0, 0.2)',
										'rgba(0, 255, 0, 0.2)',
								],
								borderColor: [
										'rgba(0, 100, 100, 1)',
										'rgba(0, 100, 100, 1)',
										'rgba(0, 100, 100, 1)',
										'rgba(0, 100, 100, 1)',
										'rgba(0, 100, 100, 1)',
										'rgba(0, 100, 100, 1)'
								],
								borderWidth: 2
						},
						{
								label: '每日14題(情緒)',
								data: [],
								backgroundColor: [
									'rgba(0, 0, 255, 0.2)',
									'rgba(0, 0, 255, 0.2)',
									'rgba(0, 0, 255, 0.2)',
									'rgba(0, 0, 255, 0.2)',
									'rgba(0, 0, 255, 0.2)',
									'rgba(0, 0, 255, 0.2)',
								],
								borderColor: [
										'rgba(0, 10, 255, 1)',
										'rgba(0, 10, 255, 1)',
										'rgba(0, 10, 255, 1)',
										'rgba(0, 10, 255, 1)',
										'rgba(0, 10, 255, 1)',
										'rgba(0, 10, 255, 1)',
								],
								borderWidth: 2
						}
					]

				},
				options: {
						scales: {
								yAxes: [{
										ticks: {
												beginAtZero: true
										}
								}]
						}
				}
		});
		var doAjax = function() {
			var url = '<?= base_url() ?>' + 'mgmt/case_analysis_group/blood';
			 $.ajax({
				 url: url,
				 type: 'POST',
				 data: {
					dt: $('#s_dt').val(),
					e_dt: $('#e_dt').val(),
					hospital:  $('#f_hospital').val(),
					doctor: $('#f_doctor').val(),
					manager: $('#f_manager').val(),
					algorithm: $('#algorithm').val(),
				 },
				 dataType: 'json',

				 success: function(d){
					if (d.algorithm==1) {
						var me =d.blood;
						var count =d.count;
						var comfortable_type_0 =d.comfortable_type_0;
						var comfortable_type_1 =d.comfortable_type_1;
						var count_type_0 =d.count_type_0;
						var count_type_1 =d.count_type_1;
						var count_question_14 =d.count_question_14;
						var question =d.question_14;
						for(i=0;i<count;i++){
							blood.data.labels.push(me[i].date);
							blood.data.datasets[0].data.push(me[i].diastolic_blood_pressure);
							blood.data.datasets[1].data.push(me[i].systolic_blood_pressure);
							blood.update();

							heart.data.labels.push(me[i].date);
							heart.data.datasets[0].data.push(me[i].heart_beat);
							heart.update();

							weight.data.labels.push(me[i].date);
							weight.data.datasets[0].data.push(me[i].weight);
							weight.update();

							drink.data.labels.push(me[i].date);
							drink.data.datasets[0].data.push(me[i].drinking);
							drink.update();

							walk.data.labels.push(me[i].date);
							walk.data.datasets[0].data.push(me[i].walking_steps);
							walk.update();
						}
						for(j=0;j<count_type_0;j++){
							comfortable.data.labels.push(comfortable_type_0[j].date);
							comfortable.data.datasets[0].data.push(comfortable_type_0[j].type_0);
							comfortable.update();
						}
						for(k=0;k<count_type_1;k++){
							comfortable.data.datasets[1].data.push(comfortable_type_1[k].type_1);
							comfortable.update();
						}
						for(x=0;x<count_question_14;x++){
							question_14.data.datasets[0].data.push(question[x].group1);
							question_14.data.datasets[1].data.push(question[x].group2);
							question_14.data.datasets[2].data.push(question[x].group3);
							question_14.data.labels.push(question[x].date);
							question_14.update();
						}
					}

					if (d.algorithm==3) {
						var me =d.blood;
						var count =d.count;
						var comfortable_type_0 =d.comfortable_type_0;
						var comfortable_type_1 =d.comfortable_type_1;
						var count_type_0 =d.count_type_0;
						var count_type_1 =d.count_type_1;
						var count_question_14 =d.count_question_14;
						var question =d.question_14;
						for(i=0;i<count;i++){
							blood.data.labels.push(me[i].date);
							blood.data.datasets[0].data.push(me[i].mid.mid_diastolic[0]);
							blood.data.datasets[1].data.push(me[i].mid.mid_systolic[0]);
							blood.update();

							heart.data.labels.push(me[i].date);
							heart.data.datasets[0].data.push(me[i].mid.mid_heart_beat[0]);
							heart.update();

							weight.data.labels.push(me[i].date);
							weight.data.datasets[0].data.push(me[i].mid.mid_weight[0]);
							weight.update();

							drink.data.labels.push(me[i].date);
							drink.data.datasets[0].data.push(me[i].mid.mid_drinking[0]);
							drink.update();

							walk.data.labels.push(me[i].date);
							walk.data.datasets[0].data.push(me[i].mid.mid_walking_steps[0]);
							walk.update();
						}
						for(j=0;j<count_type_0;j++){
							comfortable.data.labels.push(comfortable_type_0[j].date);
							comfortable.data.datasets[0].data.push(comfortable_type_0[j].mid.mid_score[0]);
							comfortable.update();
						}
						for(k=0;k<count_type_1;k++){
							comfortable.data.datasets[1].data.push(comfortable_type_1[k].mid.mid_score[0]);
							comfortable.update();
						}
						for(x=0;x<count_question_14;x++){
							question_14.data.datasets[0].data.push(question[x].mid.mid_group1[0]);
							question_14.data.datasets[1].data.push(question[x].mid.mid_group2[0]);
							question_14.data.datasets[2].data.push(question[x].mid.mid_group3[0]);
							question_14.data.labels.push(question[x].date);
							question_14.update();
						}
					}

					if (d.algorithm==2) {

						var me =d.blood;
						var count =d.count;
						var comfortable_type_0 =d.comfortable_type_0;
						var comfortable_type_1 =d.comfortable_type_1;
						var count_type_0 =d.count_type_0;
						var count_type_1 =d.count_type_1;
						var count_question_14 =d.count_question_14;
						var question =d.question_14;
						for(i=0;i<count;i++){
							if(me[i].s_d.s_d_diastolic!=="" ||me[i].s_d.s_d_systolic!==""){
								blood.data.labels.push(me[i].date);
								blood.data.datasets[0].data.push(me[i].s_d.s_d_diastolic);
								blood.data.datasets[1].data.push(me[i].s_d.s_d_systolic);
								blood.update();
							}
							if(me[i].s_d.s_d_heart_beat!==""){
								heart.data.labels.push(me[i].date);
								heart.data.datasets[0].data.push(me[i].s_d.s_d_heart_beat);
								heart.update();
							}

							if(me[i].s_d.s_d_weight!==""){
								weight.data.labels.push(me[i].date);
								weight.data.datasets[0].data.push(me[i].s_d.s_d_weight);
								weight.update();
							}
							if(me[i].s_d.s_d_drinking!==""){
								drink.data.labels.push(me[i].date);
								drink.data.datasets[0].data.push(me[i].s_d.s_d_drinking);
								drink.update();
							}
							if(me[i].s_d.s_d_walking_steps!==""){
								walk.data.labels.push(me[i].date);
								walk.data.datasets[0].data.push(me[i].s_d.s_d_walking_steps);
								walk.update();
							}
						}
						for(j=0;j<count_type_0;j++){
							if(comfortable_type_0[j].s_d.s_d_score!==""){
								comfortable.data.labels.push(comfortable_type_0[j].date);
								comfortable.data.datasets[0].data.push(comfortable_type_0[j].s_d.s_d_score);
								comfortable.update();
							}
						}
						for(k=0;k<count_type_1;k++){
							if(comfortable_type_1[k].s_d.s_d_score!==""){
								comfortable.data.datasets[1].data.push(comfortable_type_1[k].s_d.s_d_score);
								comfortable.update();
							}
						}
						for(x=0;x<count_question_14;x++){
							if(question[x].s_d.s_d_group1!==""){
								question_14.data.datasets[0].data.push(question[x].s_d.s_d_group1);
								question_14.data.datasets[1].data.push(question[x].s_d.s_d_group2);
								question_14.data.datasets[2].data.push(question[x].s_d.s_d_group3);
								question_14.data.labels.push(question[x].date);
								question_14.update();
							}
						}
					}
				 },

			failure:function(){
				alert('faialure');
			}
		 });
	 };
		doAjax();
	};
	ajaxCallblood();
</script>

<script>

</script>
