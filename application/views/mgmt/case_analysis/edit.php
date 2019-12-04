<style>
.file-drag-handle {
	display: none;
}

</style>
<!-- Widget ID (each widget will need unique ID)-->
	<div class="jarviswidget" id="wid-id-7" data-widget-colorbutton="false"	data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
		<header>
			<div class="widget-toolbar pull-left">
				<a href="javascript:void(0);" id="back_parent" onclick="currentApp.backTo()" class="btn btn-default ">
					<i class="fa fa-arrow-circle-left"></i>返回
				</a>
			</div>
			<!-- <div class="widget-toolbar pull-left">
				<label>區間：</label>
			</div>
			<div class="widget-toolbar pull-left">
				<select name="" id="during_time" class="" >
					<option  value="0" >週</option>
					<option  value="1" >一個月</option>
					<option  value="2" >四個月</option>

				</select>
			</div> -->

			<div class="widget-toolbar pull-left">
				<input id="s_dt" placeholder="請輸入日期" type="text" class="dt_picker " value="<?= date('Y-m-d',strtotime("-7 day")) ?>" autocomplete="off"  />
			</div>
			<div class="widget-toolbar pull-left" >
				~ <input id="e_dt"  placeholder="請輸入日期" type="text" class="dt_picker" value="<?= date('Y-m-d') ?>" autocomplete="off"  />
			</div>
		</header>
	</div>

	<!-- widget div-->
	<div>
		<!-- widget edit box -->
		<div class="jarviswidget-editbox">
			<!-- This area used as dropdown edit box -->
			<input class="form-control" type="text">
		</div>
		<!-- end widget edit box -->

		<!-- widget content -->
		<div class="widget-body">

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
		</div>
		<!-- end widget content -->

	</div>
	<!-- end widget div -->

</div>
<!-- end widget -->
<style>
	.kv-file-zoom {
		display: none;
	}
</style>
<script>
$(".dt_picker").datetimepicker({
		format: 'YYYY-MM-DD'
	}).on('dp.change',function(event){
		ajaxCallblood();

	});

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
										'rgba(54, 162, 235, 0.2)',
										'rgba(255, 206, 86, 0.2)',
										'rgba(75, 192, 192, 0.2)',
										'rgba(153, 102, 255, 0.2)',
										'rgba(255, 159, 64, 0.2)'
								],
								borderColor: [
										'rgba(255, 99, 132, 1)',
										'rgba(54, 162, 235, 1)',
										'rgba(255, 206, 86, 1)',
										'rgba(75, 192, 192, 1)',
										'rgba(153, 102, 255, 1)',
										'rgba(255, 159, 64, 1)'
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
		                'rgba(54, 162, 235, 0.2)',
		                'rgba(255, 206, 86, 0.2)',
		                'rgba(75, 192, 192, 0.2)',
		                'rgba(153, 102, 255, 0.2)',
		                'rgba(255, 159, 64, 0.2)'
		            ],
		            borderColor: [
		                'rgba(255, 99, 132, 1)',
		                'rgba(54, 162, 235, 1)',
		                'rgba(255, 206, 86, 1)',
		                'rgba(75, 192, 192, 1)',
		                'rgba(153, 102, 255, 1)',
		                'rgba(255, 159, 64, 1)'
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
										'rgba(54, 162, 235, 0.2)',
										'rgba(255, 206, 86, 0.2)',
										'rgba(75, 192, 192, 0.2)',
										'rgba(153, 102, 255, 0.2)',
										'rgba(255, 159, 64, 0.2)'
								],
								borderColor: [
										'rgba(255, 99, 132, 1)',
										'rgba(54, 162, 235, 1)',
										'rgba(255, 206, 86, 1)',
										'rgba(75, 192, 192, 1)',
										'rgba(153, 102, 255, 1)',
										'rgba(255, 159, 64, 1)'
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
										'rgba(54, 162, 235, 0.2)',
										'rgba(255, 206, 86, 0.2)',
										'rgba(75, 192, 192, 0.2)',
										'rgba(153, 102, 255, 0.2)',
										'rgba(255, 159, 64, 0.2)'
								],
								borderColor: [
										'rgba(255, 99, 132, 1)',
										'rgba(54, 162, 235, 1)',
										'rgba(255, 206, 86, 1)',
										'rgba(75, 192, 192, 1)',
										'rgba(153, 102, 255, 1)',
										'rgba(255, 159, 64, 1)'
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
										'rgba(54, 162, 235, 0.2)',
										'rgba(255, 206, 86, 0.2)',
										'rgba(75, 192, 192, 0.2)',
										'rgba(153, 102, 255, 0.2)',
										'rgba(255, 159, 64, 0.2)'
								],
								borderColor: [
										'rgba(255, 99, 132, 1)',
										'rgba(54, 162, 235, 1)',
										'rgba(255, 206, 86, 1)',
										'rgba(75, 192, 192, 1)',
										'rgba(153, 102, 255, 1)',
										'rgba(255, 159, 64, 1)'
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
			var url = '<?= base_url() ?>' + 'mgmt/Case_analysis/blood';
			 $.ajax({
				 url: url,
				 type: 'POST',
				 data: {
					dt: $('#s_dt').val(),
					e_dt: $('#e_dt').val(),
					member_id: currentApp.lastDoEditId
				 },
				 dataType: 'json',

				 success: function(d){

					var me =d.blood;
					var comfortable_type_0 =d.comfortable_type_0;
					var comfortable_type_1 =d.comfortable_type_1;
					var count_type_0 =d.count_type_0;
					var count_type_1 =d.count_type_1;
					var count =d.count;
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
						comfortable.data.labels.push(comfortable_type_0[j].date1);
						comfortable.data.datasets[0].data.push(comfortable_type_0[j].score);
						comfortable.update();
					}
					for(k=0;k<count_type_1;k++){
						comfortable.data.datasets[1].data.push(comfortable_type_1[k].score);
						comfortable.update();
					}
					for(x=0;x<count_question_14;x++){
						question_14.data.datasets[0].data.push(question[x].group1);
						question_14.data.datasets[1].data.push(question[x].group2);
						question_14.data.datasets[2].data.push(question[x].group3);
						question_14.data.labels.push(question[x].date1);
						question_14.update();
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
