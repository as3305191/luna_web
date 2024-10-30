<?php
	include_once 'cooent.php';
?>


<html lang="en-us">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=1">
<style>
			table {
			    border: 1px solid #ccc;
			    width: 100%;
			    margin: 0;
			    padding: 0;
			    border-collapse: collapse;
			    border-spacing: 0;
			}
			.not_do{
				background-color: #dddddd;
				pointer-events:none;
			}
			table tr {
			    border: 1px solid #ddd;
			    padding: 5px;
			}
			table td {
			    padding: 10px;
			    text-align: center;
			}
			table th {
			    text-transform: uppercase;
			    font-size: 14px;
			    letter-spacing: 1px;
			}
			/* <= 568px */
			@media screen and (max-width: 568px) {
			    table {
					margin:0 auto;
			        border: 0;
					width: 100%;
					text-align:center;
					
					max-width: 300 px !important;
			    }
			    table thead {
			        display: none;
			    }
			    table tr {
			        margin-bottom: 10px;
			        display: block;
			        border-bottom: 2px solid #ddd;
			    }
			    table td {
			        display: block;
			        text-align: right;
			        font-size: 10px;
			        border-bottom: 1px dotted #ccc;
			    }
			    table td:last-child {
			        border-bottom: 0;
			   }
			    table td:before {
			        content: attr(data-label);
			        float: left;
			        text-transform: uppercase;
			        font-weight: bold;
			    }
			}
			
		</style>
</head>
	<!-- #BODY -->
	<body id="form_div" width: 100%;>
	<table border="" class="flowtable">
						
							<caption>寬仕盤點飲料

							</caption>
							

							<tr>
								<th style="width: 80px;"><font color="red" size="4" >上午</font>盤點區域：</th>
									<td colspan="3">
                                    <font color="red" size="4" >上午飲料會分發到各位的盤點區域</font>
									<select class="" id="area" >
										<option area_num="0" value="0">請選擇盤點區域</option>
										<option area_num="1" value="螺絲區I1～I13區、J區(堆高機+大地磅+天車)">螺絲區I1～I13區、J區(堆高機+大地磅+天車)</option>
										<option area_num="2" value="螺絲區H1～H13(堆高機+大地磅+天車)">螺絲區H1～H13(堆高機+大地磅+天車)</option>
										<option area_num="3" value="螺絲區G1～G15、不良品區(堆高機+大地磅+天車)">螺絲區G1～G15、不良品區(堆高機+大地磅+天車)</option>
										<option area_num="4" value="五甲一廠">五甲一廠</option>
										<option area_num="5" value="鏈袋組裝區、研發工廠(堆高機+大地磅+天車)">鏈袋組裝區、研發工廠(堆高機+大地磅+天車)</option>
										<option area_num="6" value="螺絲J區(螺絲成品)">螺絲J區(螺絲成品)</option>
										<option area_num="7" value="螺絲F區(螺絲成品)">螺絲F區(螺絲成品)</option>
										<option area_num="8" value="成品C區(C01-C15)">成品C區(C01-C15)</option>
										<option area_num="9" value="成品D區(D01-D15)">成品D區(D01-D15)</option>
										<option area_num="10" value="成品打板區">成品打板區</option>
										<option area_num="11" value="BIT、撞針">BIT、撞針</option>
										<option area_num="12" value="包材棧板區">包材棧板區</option>
										<option area_num="13" value="包材支柱區、包材暫存區">包材支柱區、包材暫存區</option>
										<option area_num="14" value="包材塑袋區、配件區、包材B區(X)">包材塑袋區、配件區、包材B區(X)</option>
										<option area_num="15" value="包材鐵架區(B區二側)及(Y)">包材鐵架區(B區二側)及(Y)</option>
										<option area_num="16" value="包材C區">包材C區</option>
										<option area_num="17" value="包材E區">包材E區</option>
										<option area_num="18" value="包材區(H1-H6)">包材區(H1-H6)</option>
										<option area_num="19" value="包材區(H8-H15)&包材K區">包材區(H8-H15)&包材K區</option>
										<option area_num="20" value="標籤">標籤</option>
										<option area_num="21" value="尾數螺絲整理(區分輪流存與否)">尾數螺絲整理(區分輪流存與否)</option>
										<option area_num="22" value="堆高機">堆高機</option>
										<option area_num="23" value="固定資產-北花廠、寬仕農場、沙崙廠">固定資產-北花廠、寬仕農場、沙崙廠</option>
										<option area_num="24" value="固定資產-品保課、測試室、樣品室、品保實驗室、會議室十、F.G.H.I區、倉管課">固定資產-品保課、測試室、樣品室、品保實驗室、會議室十、F.G.H.I區、倉管課</option>
										<option area_num="25" value="固定資產-B區、B區餐廳、包裝部、會議室六、包裝作業課、標籤組、會議室十二">固定資產-B區、B區餐廳、包裝部、會議室六、包裝作業課、標籤組、會議室十二</option>
										<option area_num="26" value="固定資產-財務部、會議室五、資訊部、資訊部機房、管理部、會議室三">固定資產-財務部、會議室五、資訊部、資訊部機房、管理部、會議室三</option>
										<option area_num="27" value="固定資產-A區、研發工廠、A區廚房、資料庫房、領料組">固定資產-A區、研發工廠、A區廚房、資料庫房、領料組</option>
										<option area_num="28" value="固定資產-研發部、研發測試室、研發樣品室、會議室四、實驗室、會議室七">固定資產-研發部、研發測試室、研發樣品室、會議室四、實驗室、會議室七</option>
										<option area_num="29" value="固定資產-生產部、會議室一、業務部、業務庫品室、會議室二、會議室九、守衛室">固定資產-生產部、會議室一、業務部、業務庫品室、會議室二、會議室九、守衛室</option>
										<option area_num="30" value="固定資產-婦幼室、總經理室、實驗餐廳、接待室、運動室、閱覽室、視覺攝影室">固定資產-婦幼室、總經理室、實驗餐廳、接待室、運動室、閱覽室、視覺攝影室</option>
                                        <option area_num="31" value="五甲調度">五甲調度</option>
                                        <option area_num="32" value="餐點分配">餐點分配</option>
                                        <option area_num="33" value="深緣及水本廠-行政課">深緣及水本廠-行政課</option>
                                        <option area_num="34" value="廁所清潔">廁所清潔</option>
										<option area_num="35" value="關廟店">關廟店</option>
									</select>
									</td>
							</tr>
							<tr>
								
								<th style="width: 60px;">姓名：</th>
								<td  colspan="3">
									<!-- <input type="" id="user_name"/> -->
									<select class="" id="user_name" >
										<option value="0">請選擇人員</option>
										
									</select>
								</td>
						
							</tr>
							<tr>
								<th style="width: 80px;">上午飲料(白巷子)：</th>
									<td colspan="3">
									<select class="" id="morning_drink" >
										<option value="0">請選擇品項</option>
										<option value="紅烏龍茶王">紅烏龍茶王</option>
										<option value="紅茶拿鐵">紅茶拿鐵</option>
										<option value="百香雙Q果">百香雙Q果</option>
										<option value="椰果奶茶(奶精)">椰果奶茶(奶精)</option>
									</select>
									</td>
							</tr>
							<tr>
								<th style="width: 60px;">糖：</th>
									<td>
									<select class="" id="morning_s" >
										<option value="0">請選擇糖</option>
										<option value="無糖">無糖</option>
										<option value="微糖">微糖</option>
										<option value="正常">正常</option>
									</select>
									</td>
								<th style="width: 60px;">冰：</th>
								<td>
									<select class="" id="morning_i" >
										<option value="0">請選擇冰</option>
										<option value="去冰">去冰</option>
										<option value="溫">溫</option>
									</select>
								</td>
						
							</tr>
							
						    <th style="width: 60px;"><font color="red" size="4" >下午</font>部門:</th>
                            
								<td  colspan="3">
                                <font color="red" size="4" >下午飲料會分發到各位的辦公室</font>
									<select class="" id="dep" >
										<option value="0">請選擇部門</option>
										<option value="研發部">研發部</option>
										<option value="業務部">業務部</option>
										<option value="管理部">管理部</option>
										<option value="財務部">財務部</option>
										<option value="生產部">生產部</option>
										<option value="包裝部">包裝部</option>
										<option value="資訊部">資訊部</option>
										<option value="五甲一廠">五甲一廠</option>
										<option value="深緣及水">深緣及水</option>
									</select>
								</td>

							<tr>
								<th style="width: 80px;">下午飲料(迷客夏)：</th>
									<td  colspan="3">
									<select class="" id="afternoon_drink" >
										<option value="0">請選擇品項</option>
										<option value="焙香決明大麥">焙香決明大麥</option>
										<option value="珍珠冬瓜茶">珍珠冬瓜茶</option>
										<option value="綠茶拿鐵">綠茶拿鐵</option>
										<option value="蜂蜜檸檬晶凍">蜂蜜檸檬晶凍</option>
									</select>
									</td>
							</tr>

							<tr>
								<th style="width: 60px;">糖：</th>
									<td>
									<select class="" id="afternoon_s" >
										<option value="0">請選擇糖</option>
										<option value="無糖">無糖</option>
										<option value="微糖">微糖</option>
										<option value="正常">正常</option>
										
									</select>
									</td>
								<th style="width: 60px;">冰：</th>
								<td>
									<select class="" id="afternoon_i" >
										<option value="0">請選擇冰</option>
										<option value="去冰">去冰</option>
										<option value="溫">溫</option>
									</select>
								</td>
						
							</tr>


							<tr>
								
								<td colspan="4">
									<button type="button" onclick="do_save();">送出訂單</button>
								</td>
							</tr>	
						</table>
			<div id="content">
			</div > 
		<!-- <div >
			<div class="pull-left " style="width:150px;line-height:32px">
				
			</div>
			<div class="pull-left " style="width:150px;line-height:32px">
				
			</div>           
			<div class="pull-left " style="width:150px;line-height:32px">
				<div class="pull-left " style="width:150px;line-height:32px">
					上午飲料：<select class="" id="morning_drink" >
								<option value="0">請選擇品項</option>
								<option value="紅茶">紅茶</option>
								
							</select>
				</div> 
				<div class="pull-left " style="width:150px;line-height:32px">
				糖：<select class="" id="morning_s" >
						<option value="0">請選擇糖</option>
						<option value="1分糖">1分糖</option>
						
					</select>
				</div> 
				<div class="pull-left " style="width:150px;line-height:32px">
				冰：<select class="" id="morning_i" >
						<option value="0">請選擇冰</option>
						<option value="微冰">微冰</option>
						
					</select>
				</div> 
					
					
			</div>
			<div class="pull-left " style="width:150px;line-height:32px">
			<div class="pull-left " style="width:150px;line-height:32px">
			下午飲料：<select class="" id="afternoon_drink" >
						<option value="0">請選擇品項</option>
						<option value="紅茶">紅茶</option>
						
					</select>
				</div> 
				<div class="pull-left " style="width:150px;line-height:32px">
				糖：<select class="" id="afternoon_s" >
						<option value="0">請選擇糖</option>
						<option value="1分糖">1分糖</option>
						
					</select>
				</div> 
				<div class="pull-left " style="width:150px;line-height:32px">
						
				冰：<select class="" id="afternoon_i" >
						<option value="0">請選擇冰</option>
						<option value="微冰">微冰</option>
						
					</select>
				</div> 
				
				
			</div>
			<div id="content">
			</div>
			<button type="button" onclick="do_save();">送出訂單</button>
			<div id="content">
			</div > 
		</div> -->
		
	

		
	</body>
</html>
<script src="<?= base_url('jquery.min.js') ?>"></script>
<!-- <script src="jquery-migrate.min.js"></script> -->
<script src="<?= base_url('jquery.loading.min.js') ?>"></script>
	<script>
	  var baseUrl = '<?=base_url('')?>';

		function do_save() {
			var $dep =  $('#dep').val();
			var $user_name = $('#user_name').val();
			var $morning_drink = $('#morning_drink').val();
			var $morning_s = $('#morning_s').val();
			var $morning_i = $('#morning_i').val();
			var $afternoon_drink = $('#afternoon_drink').val();
			var $afternoon_s = $('#afternoon_s').val();
			var $afternoon_i = $('#afternoon_i').val();
			var $area = $('#area').val();
			
			if($user_name!=='0'&& $dep!=='0'&& $area!=='0' && $morning_drink!=='0' && $morning_s!=='0' && $morning_i!=='0' && $afternoon_drink!=='0' && $afternoon_s!=='0' && $afternoon_i!=='0'){
				$('#content') .empty();
				$('#form_div').loading();
				
				$.ajax({
					url: 'api_drink.php',
					type: 'POST',
					data: {
						dep: $dep,
						area: $area,
						user_name: $user_name,
						morning_drink: $morning_drink,
						morning_s: $morning_s,
						morning_i: $morning_i,
						afternoon_drink: $afternoon_drink,
						afternoon_s: $afternoon_s,
						afternoon_i: $afternoon_i,

					},
					dataType: 'json',
					success: function(d) {
						$('#form_div').loading('stop');

						if(d){
							if(d.item=='update'){
								alert('餐點已經更新');
								// $('#content').append ("餐點已經更新");
							} else if(d.item=='done'){
								alert('點餐成功');
								// $('#content').append ("點餐成功") ;
							}
						}
						// location.reload();
					},
					failure:function(){
						$('#form_div').loading('stop');
						alert('faialure');
					}
				});
			} else{
				alert('請填寫全部欄位');
			}
			
		}

		$('#morning_drink').on('change', function(){
			if($('#morning_drink').val()=='百香雙Q果'){
				$('#morning_i').addClass('not_do');
				$('#morning_i').val('去冰'); 
			} else{
				$('#morning_i').removeClass('not_do');
			}
		});
		$('#afternoon_drink').on('change', function(){
			if($('#afternoon_drink').val()=='珍珠冬瓜茶'){
				$('#afternoon_s').addClass('not_do');
				$('#afternoon_s').val('正常');
			} else{
				$('#afternoon_s').removeClass('not_do');
			}
			if($('#afternoon_drink').val()=='蜂蜜檸檬晶凍'){
				$('#afternoon_i').addClass('not_do');
				$('#afternoon_i').val('去冰');
			} else{
				$('#afternoon_i').removeClass('not_do');
			}
		});
		$('#area').on('change', function(){
			$('#form_div').loading();
			var $area_num = $(this).find("option:selected").attr("area_num");;
			
			// console.log($area_num);
			$.ajax({
				url: 'api_find_user.php',
				type: 'POST',
				data: {
					area_num:$area_num,
				},
				dataType: 'json',
				success: function(d) {
					var user_name_option = '<option value="0">請選擇人員</option>';
					var $user_name = $('#user_name').empty();
					$user_name.append(user_name_option); 
					if(d){
						// console.log(d.list[0]);
						$.each(d, function(){
							$('<option />', {
								'value': this.user_name,
								'text': this.user_name,
							}).appendTo($user_name);
						});

					}
					$('#form_div').loading('stop');

				},
				failure:function(){
					$('#form_div').loading('stop');
				}
			});
		});
	</script>