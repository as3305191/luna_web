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
							<!-- <div class="widget-toolbar pull-left">
								<div class="btn-group">
									<button onclick="currentApp.doEdit(0)" class="btn dropdown-toggle btn-xs btn-success" data-toggle="dropdown">
										<i class="fa fa-plus"></i>新增
									</button>
								</div>
							</div> -->
						</header>
						<table>
		<tr>
		  <td>潛在風險(外部/內部)</td>
		  <td>是</td>
		  <td>否</td>
		  <td>風險類型</td>
		  <td>可能性<br>
			(發生機率)</td>
		  <td>嚴重性<br>
			(傷害程度)</td>
		  <td>風險等級<br>
			(可能性×嚴重性)</td>
		  <td>現有控制措施</td>
		  <td>降低風險措施</td>
		</tr>
		<tr>
			<td>外部不法侵害(註：勾否者該項無需評估)</td>
		</tr>
		<tr>
			<td>是否有組織外之人員(承攬商、客戶、服務對象或親友等)因其行為無法預知，可能成為該區工作者不法侵害來源</td>
			<td>
				<input type="radio" id="Q_Y" name="Q1_Yn" value="是" class="btnY1"/>
			</td>
			<td>
				<input type="radio" id="Q_N" name="Q1_Yn" value="否" class="btnN1"/>
				<label for="Q1_Id"></label>
			</td>
				<td  class="R1">
					<input type="radio" id="Q1_R_Id1" name="Q1_R" value="肢體"/>
					<label for="Q1_R_Id1">肢體</label><br>
					<input type="radio" id="Q1_R_Id2" name="Q1_R" value="語言"/>
					<label for="Q1_R_Id2">語言</label><br>
					<input type="radio" id="Q1_R_Id3" name="Q1_R" value="心理"/>
					<label for="Q1_R_Id3">心理</label><br>
					<input type="radio" id="Q1_R_Id4" name="Q1_R" value="性騷擾"/>
					<label for="Q1_R_Id4">性騷擾</label>
				</td>
				<td  class="R1">
					<input type="radio" id="Q1_P_Id1" name="Q1_P" value="可能3分"/>
					<label for="Q1_P_Id1">可能3分</label><br>
					<input type="radio" id="Q1_P_Id2" name="Q1_P" value="不太可能2分"/>
					<label for="Q1_P_Id2">不太可能2分</label><br>
					<input type="radio" id="Q1_P_Id3" name="Q1_P" value="極不可能1分"/>
					<label for="Q1_P_Id3">極不可能1分</label>
				</td>
				<td  class="R1">
					<input type="radio" id="Q1_S_Id1" name="Q1_S" value="嚴重3分"/>
					<label for="Q1_S_Id1">嚴重3分</label><br>
					<input type="radio" id="Q1_S_Id2" name="Q1_S" value="中度2分"/>
					<label for="Q1_S_Id2">中度2分</label><br>
					<input type="radio" id="Q1_S_Id3" name="Q1_S" value="輕度1分"/>
					<label for="Q1_S_Id3">輕度1分</label>
				</td>
				<td  class="R1">
					<input type="radio" id="Q1_R_L_Id1" name="Q1_R_L" value="高度6-9分"/>
					<label for="Q1_R_L_Id1">高度6-9分</label><br>
					<input type="radio" id="Q1_R_L_Id2" name="Q1_R_L" value="中度3-4分"/>
					<label for="Q1_R_L_Id2">中度3-4分</label><br>
					<input type="radio" id="Q1_R_L_Id3" name="Q1_R_L" value="輕度1-2分"/>
					<label for="Q1_R_L_Id3">輕度1-2分</label>
				</td>
				<td  class="R1">
					<input type="radio" id="Q1_C_Id1" name="Q1_C" value="工程控制"/>
					<label for="Q1_C_Id1">工程控制</label><br>
					<input type="radio" id="Q1_C_Id2" name="Q1_C" value="個人防護"/>
					<label for="Q1_C_Id2">個人防護</label><br>
					<input type="radio" id="Q1_C_Id3" name="Q1_C" value="管理控制"/>
					<label for="Q1_C_Id3">管理控制</label>
				</td>
				<td class="R1">
					<input type="radio" id="Q1_Lr_Id1" name="Q1_Lr" value="無"/>
					<label for="Q1_Lr_Id1">無</label><br>
					<input type="radio" id="Q1_Lr_Id2" name="Q1_Lr" value="有：敘述"/>
					<label for="Q1_Lr_Id2">有：敘述</label>
				</td>
		</tr>
		<tr>
			<td>是否有已知工作會接觸有暴力史客戶</td>
			<td><input type="radio" id="Q_Y" name="Q2_Yn" value="是" class="btnY2"/>
			</td>
			<td><input type="radio" id="Q_N" name="Q2_Yn" value="否" class="btnN2"/>
				<label for="Q2_Id"></label>
			</td>
			<td class="R2">
				<input type="radio" id="Q2_R_Id1" name="Q2_R" value="肢體"/>
				<label for="Q2_R_Id1">肢體</label><br>
				<input type="radio" id="Q2_R_Id2" name="Q2_R" value="語言"/>
				<label for="Q2_R_Id2">語言</label><br>
				<input type="radio" id="Q2_R_Id3" name="Q2_R" value="心理"/>
				<label for="Q2_R_Id3">心理</label><br>
				<input type="radio" id="Q2_R_Id4" name="Q2_R" value="性騷擾"/>
				<label for="Q2_R_Id4">性騷擾</label>
			</td>
			<td class="R2">
				<input type="radio" id="Q2_P_Id1" name="Q2_P" value="可能3分"/>
				<label for="Q2_P_Id1">可能3分</label><br>
				<input type="radio" id="Q2_P_Id2" name="Q2_P" value="不太可能2分"/>
				<label for="Q2_P_Id2">不太可能2分</label><br>
				<input type="radio" id="Q2_P_Id3" name="Q2_P" value="極不可能1分"/>
				<label for="Q2_P_Id3">極不可能1分</label>
			</td>
			<td class="R2">
				<input type="radio" id="Q2_S_Id1" name="Q2_S" value="嚴重3分"/>
				<label for="Q2_S_Id1">嚴重3分</label><br>
				<input type="radio" id="Q2_S_Id2" name="Q2_S" value="中度2分"/>
				<label for="Q2_S_Id2">中度2分</label><br>
				<input type="radio" id="Q2_S_Id3" name="Q2_S" value="輕度1分"/>
				<label for="Q2_S_Id3">輕度1分</label>
			</td>
			<td class="R2">
				<input type="radio" id="Q2_R_L_Id1" name="Q2_R_L" value="高度6-9分"/>
				<label for="Q2_R_L_Id1">高度6-9分</label><br>
				<input type="radio" id="Q2_R_L_Id2" name="Q2_R_L" value="中度3-4分"/>
				<label for="Q2_R_L_Id2">中度3-4分</label><br>
				<input type="radio" id="Q2_R_L_Id3" name="Q2_R_L" value="輕度1-2分"/>
				<label for="Q2_R_L_Id3">輕度1-2分</label>
			</td>
			<td class="R2">
				<input type="radio" id="Q2_C_Id1" name="Q2_C" value="工程控制"/>
				<label for="Q2_C_Id1">工程控制</label><br>
				<input type="radio" id="Q2_C_Id2" name="Q2_C" value="個人防護"/>
				<label for="Q2_C_Id2">個人防護</label><br>
				<input type="radio" id="Q2_C_Id3" name="Q2_C" value="管理控制"/>
				<label for="Q2_C_Id3">管理控制</label>
			</td>
			<td class="R2">
				<input type="radio" id="Q2_Lr_Id1" name="Q2_Lr" value="無"/>
				<label for="Q2_Lr_Id1">無</label><br>
				<input type="radio" id="Q2_Lr_Id2" name="Q2_Lr" value="有：敘述"/>
				<label for="Q2_Lr_Id2">有：敘述</label>
		   </td>
		</tr>
		<tr>
			<td>勞工工作性質是否為執行公共安全業務</td>
			<td><input type="radio" id="Q_Y" name="Q3_Yn" value="是"/>
			</td>
			<td><input type="radio" id="Q_N" name="Q3_Yn" value="否"/>
				<label for="Q3_Id"></label>
			</td>
			<td>
				<input type="radio" id="Q3_R_Id1" name="Q3_R" value="肢體"/>
				<label for="Q3_R_Id1">肢體</label><br>
				<input type="radio" id="Q3_R_Id2" name="Q3_R" value="語言"/>
				<label for="Q3_R_Id2">語言</label><br>
				<input type="radio" id="Q3_R_Id3" name="Q3_R" value="心理"/>
				<label for="Q3_R_Id3">心理</label><br>
				<input type="radio" id="Q3_R_Id4" name="Q3_R" value="性騷擾"/>
				<label for="Q3_R_Id4">性騷擾</label>
			</td>
			<td>
				<input type="radio" id="Q3_P_Id1" name="Q3_P" value="可能3分"/>
				<label for="Q3_P_Id1">可能3分</label><br>
				<input type="radio" id="Q3_P_Id2" name="Q3_P" value="不太可能2分"/>
				<label for="Q3_P_Id2">不太可能2分</label><br>
				<input type="radio" id="Q3_P_Id3" name="Q3_P" value="極不可能1分"/>
				<label for="Q3_P_Id3">極不可能1分</label>
			</td>
			<td>
				<input type="radio" id="Q3_S_Id1" name="Q3_S" value="嚴重3分"/>
				<label for="Q3_S_Id1">嚴重3分</label><br>
				<input type="radio" id="Q3_S_Id2" name="Q3_S" value="中度2分"/>
				<label for="Q3_S_Id2">中度2分</label><br>
				<input type="radio" id="Q3_S_Id3" name="Q3_S" value="輕度1分"/>
				<label for="Q3_S_Id3">輕度1分</label>
			</td>
			<td>
				<input type="radio" id="Q3_R_L_Id1" name="Q3_R_L" value="高度6-9分"/>
				<label for="Q3_R_L_Id1">高度6-9分</label><br>
				<input type="radio" id="Q3_R_L_Id2" name="Q3_R_L" value="中度3-4分"/>
				<label for="Q3_R_L_Id2">中度3-4分</label><br>
				<input type="radio" id="Q3_R_L_Id3" name="Q3_R_L" value="輕度1-2分"/>
				<label for="Q3_R_L_Id3">輕度1-2分</label>
			</td>
			<td>
				<input type="radio" id="Q3_C_Id1" name="Q3_C" value="工程控制"/>
				<label for="Q3_C_Id1">工程控制</label><br>
				<input type="radio" id="Q3_C_Id2" name="Q3_C" value="個人防護"/>
				<label for="Q3_C_Id2">個人防護</label><br>
				<input type="radio" id="Q3_C_Id3" name="Q3_C" value="管理控制"/>
				<label for="Q3_C_Id3">管理控制</label>
			</td>
			<td><input type="radio" id="Q3_Lr_Id1" name="Q3_Lr" value="無"/>
				<label for="Q3_Lr_Id1">無</label><br>
				<input type="radio" id="Q3_Lr_Id2" name="Q3_Lr" value="有：敘述"/>
				<label for="Q3_Lr_Id2">有：敘述</label>
		   </td>
		</tr>
		<tr>
			<td>勞工工作是否為單獨作業</td>
			<td><input type="radio" id="Q_Y" name="Q4_Yn" value="是"/>
			</td>
			<td><input type="radio" id="Q_N" name="Q4_Yn" value="否"/>
				<label for="Q4_Id"></label>
			</td>
			<td>
				<input type="radio" id="Q4_R_Id1" name="Q4_R" value="肢體"/>
				<label for="Q4_R_Id1">肢體</label><br>
				<input type="radio" id="Q4_R_Id2" name="Q4_R" value="語言"/>
				<label for="Q4_R_Id2">語言</label><br>
				<input type="radio" id="Q4_R_Id3" name="Q4_R" value="心理"/>
				<label for="Q4_R_Id3">心理</label><br>
				<input type="radio" id="Q4_R_Id4" name="Q4_R" value="性騷擾"/>
				<label for="Q4_R_Id4">性騷擾</label>
			</td>
			<td>
				<input type="radio" id="Q4_P_Id1" name="Q4_P" value="可能3分"/>
				<label for="Q4_P_Id1">可能3分</label><br>
				<input type="radio" id="Q4_P_Id2" name="Q4_P" value="不太可能2分"/>
				<label for="Q4_P_Id2">不太可能2分</label><br>
				<input type="radio" id="Q4_P_Id3" name="Q4_P" value="極不可能1分"/>
				<label for="Q4_P_Id3">極不可能1分</label>
			</td>
			<td>
				<input type="radio" id="Q4_S_Id1" name="Q4_S" value="嚴重3分"/>
				<label for="Q4_S_Id1">嚴重3分</label><br>
				<input type="radio" id="Q4_S_Id2" name="Q4_S" value="中度2分"/>
				<label for="Q4_S_Id2">中度2分</label><br>
				<input type="radio" id="Q4_S_Id3" name="Q4_S" value="輕度1分"/>
				<label for="Q4_S_Id3">輕度1分</label>
			</td>
			<td>
				<input type="radio" id="Q4_R_L_Id1" name="Q4_R_L" value="高度6-9分"/>
				<label for="Q4_R_L_Id1">高度6-9分</label><br>
				<input type="radio" id="Q4_R_L_Id2" name="Q4_R_L" value="中度3-4分"/>
				<label for="Q4_R_L_Id2">中度3-4分</label><br>
				<input type="radio" id="Q4_R_L_Id3" name="Q4_R_L" value="輕度1-2分"/>
				<label for="Q4_R_L_Id3">輕度1-2分</label>
			</td>
			<td>
				<input type="radio" id="Q4_C_Id1" name="Q4_C" value="工程控制"/>
				<label for="Q4_C_Id1">工程控制</label><br>
				<input type="radio" id="Q4_C_Id2" name="Q4_C" value="個人防護"/>
				<label for="Q4_C_Id2">個人防護</label><br>
				<input type="radio" id="Q4_C_Id3" name="Q4_C" value="管理控制"/>
				<label for="Q4_C_Id3">管理控制</label>
			</td>
			<td><input type="radio" id="Q4_Lr_Id1" name="Q4_Lr" value="無"/>
				<label for="Q4_Lr_Id1">無</label><br>
				<input type="radio" id="Q4_Lr_Id2" name="Q4_Lr" value="有：敘述"/>
				<label for="Q4_Lr_Id2">有：敘述</label>
		   </td>
		</tr>
		<tr>
			<td>勞工是否需於深夜或凌晨工作</td>
			<td><input type="radio" id="Q_Y" name="Q5_Yn" value="是"/>
			</td>
			<td><input type="radio" id="Q_N" name="Q5_Yn" value="否"/>
				<label for="Q5_Id"></label>
			</td>
			<td>
				<input type="radio" id="Q5_R_Id1" name="Q5_R" value="肢體"/>
				<label for="Q5_R_Id1">肢體</label><br>
				<input type="radio" id="Q5_R_Id2" name="Q5_R" value="語言"/>
				<label for="Q5_R_Id2">語言</label><br>
				<input type="radio" id="Q5_R_Id3" name="Q5_R" value="心理"/>
				<label for="Q5_R_Id3">心理</label><br>
				<input type="radio" id="Q5_R_Id4" name="Q5_R" value="性騷擾"/>
				<label for="Q5_R_Id4">性騷擾</label>
			</td>
			<td>
				<input type="radio" id="Q5_P_Id1" name="Q5_P" value="可能3分"/>
				<label for="Q5_P_Id1">可能3分</label><br>
				<input type="radio" id="Q5_P_Id2" name="Q5_P" value="不太可能2分"/>
				<label for="Q5_P_Id2">不太可能2分</label><br>
				<input type="radio" id="Q5_P_Id3" name="Q5_P" value="極不可能1分"/>
				<label for="Q5_P_Id3">極不可能1分</label>
			</td>
			<td>
				<input type="radio" id="Q5_S_Id1" name="Q5_S" value="嚴重3分"/>
				<label for="Q5_S_Id1">嚴重3分</label><br>
				<input type="radio" id="Q5_S_Id2" name="Q5_S" value="中度2分"/>
				<label for="Q5_S_Id2">中度2分</label><br>
				<input type="radio" id="Q5_S_Id3" name="Q5_S" value="輕度1分"/>
				<label for="Q5_S_Id3">輕度1分</label>
			</td>
			<td>
				<input type="radio" id="Q5_R_L_Id1" name="Q5_R_L" value="高度6-9分"/>
				<label for="Q5_R_L_Id1">高度6-9分</label><br>
				<input type="radio" id="Q5_R_L_Id2" name="Q5_R_L" value="中度3-4分"/>
				<label for="Q5_R_L_Id2">中度3-4分</label><br>
				<input type="radio" id="Q5_R_L_Id3" name="Q5_R_L" value="輕度1-2分"/>
				<label for="Q5_R_L_Id3">輕度1-2分</label>
			</td>
			<td>
				<input type="radio" id="Q5_C_Id1" name="Q5_C" value="工程控制"/>
				<label for="Q5_C_Id1">工程控制</label><br>
				<input type="radio" id="Q5_C_Id2" name="Q5_C" value="個人防護"/>
				<label for="Q5_C_Id2">個人防護</label><br>
				<input type="radio" id="Q5_C_Id3" name="Q5_C" value="管理控制"/>
				<label for="Q5_C_Id3">管理控制</label>
			</td>
			<td><input type="radio" id="Q5_Lr_Id1" name="Q5_Lr" value="無"/>
				<label for="Q5_Lr_Id1">無</label><br>
				<input type="radio" id="Q5_Lr_Id2" name="Q5_Lr" value="有：敘述"/>
				<label for="Q5_Lr_Id2">有：敘述</label>
		   </td>
		</tr>
		<tr>
			<td>勞工是否需於較陌生環境工作</td>
			<td><input type="radio" id="Q_Y" name="Q6_Yn" value="是"/>
			</td>
			<td><input type="radio" id="Q_N" name="Q6_Yn" value="否"/>
				<label for="Q6_Id"></label>
			</td>
			<td>
				<input type="radio" id="Q6_R_Id1" name="Q6_R" value="肢體"/>
				<label for="Q6_R_Id1">肢體</label><br>
				<input type="radio" id="Q6_R_Id2" name="Q6_R" value="語言"/>
				<label for="Q6_R_Id2">語言</label><br>
				<input type="radio" id="Q6_R_Id3" name="Q6_R" value="心理"/>
				<label for="Q6_R_Id3">心理</label><br>
				<input type="radio" id="Q6_R_Id4" name="Q6_R" value="性騷擾"/>
				<label for="Q6_R_Id4">性騷擾</label>
			</td>
			<td>
				<input type="radio" id="Q6_P_Id1" name="Q6_P" value="可能3分"/>
				<label for="Q6_P_Id1">可能3分</label><br>
				<input type="radio" id="Q6_P_Id2" name="Q6_P" value="不太可能2分"/>
				<label for="Q6_P_Id2">不太可能2分</label><br>
				<input type="radio" id="Q6_P_Id3" name="Q6_P" value="極不可能1分"/>
				<label for="Q6_P_Id3">極不可能1分</label>
			</td>
			<td>
				<input type="radio" id="Q6_S_Id1" name="Q6_S" value="嚴重3分"/>
				<label for="Q6_S_Id1">嚴重3分</label><br>
				<input type="radio" id="Q6_S_Id2" name="Q6_S" value="中度2分"/>
				<label for="Q6_S_Id2">中度2分</label><br>
				<input type="radio" id="Q6_S_Id3" name="Q6_S" value="輕度1分"/>
				<label for="Q6_S_Id3">輕度1分</label>
			</td>
			<td>
				<input type="radio" id="Q6_R_L_Id1" name="Q6_R_L" value="高度6-9分"/>
				<label for="Q6_R_L_Id1">高度6-9分</label><br>
				<input type="radio" id="Q6_R_L_Id2" name="Q6_R_L" value="中度3-4分"/>
				<label for="Q6_R_L_Id2">中度3-4分</label><br>
				<input type="radio" id="Q6_R_L_Id3" name="Q6_R_L" value="輕度1-2分"/>
				<label for="Q6_R_L_Id3">輕度1-2分</label>
			</td>
			<td>
				<input type="radio" id="Q6_C_Id1" name="Q6_C" value="工程控制"/>
				<label for="Q6_C_Id1">工程控制</label><br>
				<input type="radio" id="Q6_C_Id2" name="Q6_C" value="個人防護"/>
				<label for="Q6_C_Id2">個人防護</label><br>
				<input type="radio" id="Q6_C_Id3" name="Q6_C" value="管理控制"/>
				<label for="Q6_C_Id3">管理控制</label>
			</td>
			<td><input type="radio" id="Q6_Lr_Id1" name="Q6_Lr" value="無"/>
				<label for="Q6_Lr_Id1">無</label><br>
				<input type="radio" id="Q6_Lr_Id2" name="Q6_Lr" value="有：敘述"/>
				<label for="Q6_Lr_Id2">有：敘述</label>
		   </td>
		</tr>
		<tr>
			<td>勞工工作是否涉及現金交易、運送或處理貴重物品</td>
			<td><input type="radio" id="Q_Y" name="Q7_Yn" value="是"/>
			</td>
			<td><input type="radio" id="Q_N" name="Q7_Yn" value="否"/>
				<label for="Q7_Id"></label>
			</td>
			<td>
				<input type="radio" id="Q7_R_Id1" name="Q7_R" value="肢體"/>
				<label for="Q7_R_Id1">肢體</label><br>
				<input type="radio" id="Q7_R_Id2" name="Q7_R" value="語言"/>
				<label for="Q7_R_Id2">語言</label><br>
				<input type="radio" id="Q7_R_Id3" name="Q7_R" value="心理"/>
				<label for="Q7_R_Id3">心理</label><br>
				<input type="radio" id="Q7_R_Id4" name="Q7_R" value="性騷擾"/>
				<label for="Q7_R_Id4">性騷擾</label>
			</td>
			<td>
				<input type="radio" id="Q7_P_Id1" name="Q7_P" value="可能3分"/>
				<label for="Q7_P_Id1">可能3分</label><br>
				<input type="radio" id="Q7_P_Id2" name="Q7_P" value="不太可能2分"/>
				<label for="Q7_P_Id2">不太可能2分</label><br>
				<input type="radio" id="Q7_P_Id3" name="Q7_P" value="極不可能1分"/>
				<label for="Q7_P_Id3">極不可能1分</label>
			</td>
			<td>
				<input type="radio" id="Q7_S_Id1" name="Q7_S" value="嚴重3分"/>
				<label for="Q7_S_Id1">嚴重3分</label><br>
				<input type="radio" id="Q7_S_Id2" name="Q7_S" value="中度2分"/>
				<label for="Q7_S_Id2">中度2分</label><br>
				<input type="radio" id="Q7_S_Id3" name="Q7_S" value="輕度1分"/>
				<label for="Q7_S_Id3">輕度1分</label>
			</td>
			<td>
				<input type="radio" id="Q7_R_L_Id1" name="Q7_R_L" value="高度6-9分"/>
				<label for="Q7_R_L_Id1">高度6-9分</label><br>
				<input type="radio" id="Q7_R_L_Id2" name="Q7_R_L" value="中度3-4分"/>
				<label for="Q7_R_L_Id2">中度3-4分</label><br>
				<input type="radio" id="Q7_R_L_Id3" name="Q7_R_L" value="輕度1-2分"/>
				<label for="Q7_R_L_Id3">輕度1-2分</label>
			</td>
			<td>
				<input type="radio" id="Q7_C_Id1" name="Q7_C" value="工程控制"/>
				<label for="Q7_C_Id1">工程控制</label><br>
				<input type="radio" id="Q7_C_Id2" name="Q7_C" value="個人防護"/>
				<label for="Q7_C_Id2">個人防護</label><br>
				<input type="radio" id="Q7_C_Id3" name="Q7_C" value="管理控制"/>
				<label for="Q7_C_Id3">管理控制</label>
			</td>
			<td><input type="radio" id="Q7_Lr_Id1" name="Q7_Lr" value="無"/>
				<label for="Q7_Lr_Id1">無</label><br>
				<input type="radio" id="Q7_Lr_Id2" name="Q7_Lr" value="有：敘述"/>
				<label for="Q7_Lr_Id2">有：敘述</label>
		   </td>
		</tr>
		<tr>
			<td>勞工工作是否為直接面對群眾之第一線服務工作</td>
			<td><input type="radio" id="Q_Y" name="Q8_Yn" value="是"/>
			</td>
			<td><input type="radio" id="Q_N" name="Q8_Yn" value="否"/>
				<label for="Q8_Id"></label>
			</td>
			<td>
				<input type="radio" id="Q8_R_Id1" name="Q8_R" value="肢體"/>
				<label for="Q8_R_Id1">肢體</label><br>
				<input type="radio" id="Q8_R_Id2" name="Q8_R" value="語言"/>
				<label for="Q8_R_Id2">語言</label><br>
				<input type="radio" id="Q8_R_Id3" name="Q8_R" value="心理"/>
				<label for="Q8_R_Id3">心理</label><br>
				<input type="radio" id="Q8_R_Id4" name="Q8_R" value="性騷擾"/>
				<label for="Q8_R_Id4">性騷擾</label>
			</td>
			<td>
				<input type="radio" id="Q8_P_Id1" name="Q8_P" value="可能3分"/>
				<label for="Q8_P_Id1">可能3分</label><br>
				<input type="radio" id="Q8_P_Id2" name="Q8_P" value="不太可能2分"/>
				<label for="Q8_P_Id2">不太可能2分</label><br>
				<input type="radio" id="Q8_P_Id3" name="Q8_P" value="極不可能1分"/>
				<label for="Q8_P_Id3">極不可能1分</label>
			</td>
			<td>
				<input type="radio" id="Q8_S_Id1" name="Q8_S" value="嚴重3分"/>
				<label for="Q8_S_Id1">嚴重3分</label><br>
				<input type="radio" id="Q8_S_Id2" name="Q8_S" value="中度2分"/>
				<label for="Q8_S_Id2">中度2分</label><br>
				<input type="radio" id="Q8_S_Id3" name="Q8_S" value="輕度1分"/>
				<label for="Q8_S_Id3">輕度1分</label>
			</td>
			<td>
				<input type="radio" id="Q8_R_L_Id1" name="Q8_R_L" value="高度6-9分"/>
				<label for="Q8_R_L_Id1">高度6-9分</label><br>
				<input type="radio" id="Q8_R_L_Id2" name="Q8_R_L" value="中度3-4分"/>
				<label for="Q8_R_L_Id2">中度3-4分</label><br>
				<input type="radio" id="Q8_R_L_Id3" name="Q8_R_L" value="輕度1-2分"/>
				<label for="Q8_R_L_Id3">輕度1-2分</label>
			</td>
			<td>
				<input type="radio" id="Q8_C_Id1" name="Q8_C" value="工程控制"/>
				<label for="Q8_C_Id1">工程控制</label><br>
				<input type="radio" id="Q8_C_Id2" name="Q8_C" value="個人防護"/>
				<label for="Q8_C_Id2">個人防護</label><br>
				<input type="radio" id="Q8_C_Id3" name="Q8_C" value="管理控制"/>
				<label for="Q8_C_Id3">管理控制</label>
			</td>
			<td><input type="radio" id="Q8_Lr_Id1" name="Q8_Lr" value="無"/>
				<label for="Q8_Lr_Id1">無</label><br>
				<input type="radio" id="Q8_Lr_Id2" name="Q8_Lr" value="有：敘述"/>
				<label for="Q8_Lr_Id2">有：敘述</label>
		   </td>
		</tr>
		<tr>
			<td>勞工工作是否會與酗酒、毒癮或精神疾病患者接觸</td>
			<td><input type="radio" id="Q_Y" name="Q9_Yn" value="是"/>
			</td>
			<td><input type="radio" id="Q_N" name="Q9_Yn" value="否"/>
				<label for="Q9_Id"></label>
			</td>
			<td>
				<input type="radio" id="Q9_R_Id1" name="Q9_R" value="肢體"/>
				<label for="Q9_R_Id1">肢體</label><br>
				<input type="radio" id="Q9_R_Id2" name="Q9_R" value="語言"/>
				<label for="Q9_R_Id2">語言</label><br>
				<input type="radio" id="Q9_R_Id3" name="Q9_R" value="心理"/>
				<label for="Q9_R_Id3">心理</label><br>
				<input type="radio" id="Q9_R_Id4" name="Q9_R" value="性騷擾"/>
				<label for="Q9_R_Id4">性騷擾</label>
			</td>
			<td>
				<input type="radio" id="Q9_P_Id1" name="Q9_P" value="可能3分"/>
				<label for="Q9_P_Id1">可能3分</label><br>
				<input type="radio" id="Q9_P_Id2" name="Q9_P" value="不太可能2分"/>
				<label for="Q9_P_Id2">不太可能2分</label><br>
				<input type="radio" id="Q9_P_Id3" name="Q9_P" value="極不可能1分"/>
				<label for="Q9_P_Id3">極不可能1分</label>
			</td>
			<td>
				<input type="radio" id="Q9_S_Id1" name="Q9_S" value="嚴重3分"/>
				<label for="Q9_S_Id1">嚴重3分</label><br>
				<input type="radio" id="Q9_S_Id2" name="Q9_S" value="中度2分"/>
				<label for="Q9_S_Id2">中度2分</label><br>
				<input type="radio" id="Q9_S_Id3" name="Q9_S" value="輕度1分"/>
				<label for="Q9_S_Id3">輕度1分</label>
			</td>
			<td>
				<input type="radio" id="Q9_R_L_Id1" name="Q9_R_L" value="高度6-9分"/>
				<label for="Q9_R_L_Id1">高度6-9分</label><br>
				<input type="radio" id="Q9_R_L_Id2" name="Q9_R_L" value="中度3-4分"/>
				<label for="Q9_R_L_Id2">中度3-4分</label><br>
				<input type="radio" id="Q9_R_L_Id3" name="Q9_R_L" value="輕度1-2分"/>
				<label for="Q9_R_L_Id3">輕度1-2分</label>
			</td>
			<td>
				<input type="radio" id="Q9_C_Id1" name="Q9_C" value="工程控制"/>
				<label for="Q9_C_Id1">工程控制</label><br>
				<input type="radio" id="Q9_C_Id2" name="Q9_C" value="個人防護"/>
				<label for="Q9_C_Id2">個人防護</label><br>
				<input type="radio" id="Q9_C_Id3" name="Q9_C" value="管理控制"/>
				<label for="Q9_C_Id3">管理控制</label>
			</td>
			<td><input type="radio" id="Q9_Lr_Id1" name="Q9_Lr" value="無"/>
				<label for="Q9_Lr_Id1">無</label><br>
				<input type="radio" id="Q9_Lr_Id2" name="Q9_Lr" value="有：敘述"/>
				<label for="Q9_Lr_Id2">有：敘述</label>
		   </td>
		</tr>
		<tr>
			<td>勞工工作是否需接觸絕望或恐懼或極需被關懷照顧者</td>
			<td><input type="radio" id="Q_Y" name="Q10_Yn" value="是"/>
			</td>
			<td><input type="radio" id="Q_N" name="Q10_Yn" value="否"/>
				<label for="Q10_Id"></label>
			</td>
			<td>
				<input type="radio" id="Q10_R_Id1" name="Q10_R" value="肢體"/>
				<label for="Q10_R_Id1">肢體</label><br>
				<input type="radio" id="Q10_R_Id2" name="Q10_R" value="語言"/>
				<label for="Q10_R_Id2">語言</label><br>
				<input type="radio" id="Q10_R_Id3" name="Q10_R" value="心理"/>
				<label for="Q10_R_Id3">心理</label><br>
				<input type="radio" id="Q10_R_Id4" name="Q10_R" value="性騷擾"/>
				<label for="Q10_R_Id4">性騷擾</label>
			</td>
			<td>
				<input type="radio" id="Q10_P_Id1" name="Q10_P" value="可能3分"/>
				<label for="Q10_P_Id1">可能3分</label><br>
				<input type="radio" id="Q10_P_Id2" name="Q10_P" value="不太可能2分"/>
				<label for="Q10_P_Id2">不太可能2分</label><br>
				<input type="radio" id="Q10_P_Id3" name="Q10_P" value="極不可能1分"/>
				<label for="Q10_P_Id3">極不可能1分</label>
			</td>
			<td>
				<input type="radio" id="Q10_S_Id1" name="Q10_S" value="嚴重3分"/>
				<label for="Q10_S_Id1">嚴重3分</label><br>
				<input type="radio" id="Q10_S_Id2" name="Q10_S" value="中度2分"/>
				<label for="Q10_S_Id2">中度2分</label><br>
				<input type="radio" id="Q10_S_Id3" name="Q10_S" value="輕度1分"/>
				<label for="Q10_S_Id3">輕度1分</label>
			</td>
			<td>
				<input type="radio" id="Q10_R_L_Id1" name="Q10_R_L" value="高度6-9分"/>
				<label for="Q10_R_L_Id1">高度6-9分</label><br>
				<input type="radio" id="Q10_R_L_Id2" name="Q10_R_L" value="中度3-4分"/>
				<label for="Q10_R_L_Id2">中度3-4分</label><br>
				<input type="radio" id="Q10_R_L_Id3" name="Q10_R_L" value="輕度1-2分"/>
				<label for="Q10_R_L_Id3">輕度1-2分</label>
			</td>
			<td>
				<input type="radio" id="Q10_C_Id1" name="Q10_C" value="工程控制"/>
				<label for="Q10_C_Id1">工程控制</label><br>
				<input type="radio" id="Q10_C_Id2" name="Q10_C" value="個人防護"/>
				<label for="Q10_C_Id2">個人防護</label><br>
				<input type="radio" id="Q10_C_Id3" name="Q10_C" value="管理控制"/>
				<label for="Q10_C_Id3">管理控制</label>
			</td>
			<td><input type="radio" id="Q10_Lr_Id1" name="Q10_Lr" value="無"/>
				<label for="Q10_Lr_Id1">無</label><br>
				<input type="radio" id="Q10_Lr_Id2" name="Q10_Lr" value="有：敘述"/>
				<label for="Q10_Lr_Id2">有：敘述</label>
		   </td>
		</tr>
		<tr>
			<td>勞工當中是否有自行通報因私人關係遭受不法侵害威脅者或為家庭暴力受害者</td>
			<td><input type="radio" id="Q_Y" name="Q11_Yn" value="是"/>
			</td>
			<td><input type="radio" id="Q_N" name="Q11_Yn" value="否"/>
				<label for="Q11_Id"></label>
			</td>
			<td>
				<input type="radio" id="Q11_R_Id1" name="Q11_R" value="肢體"/>
				<label for="Q11_R_Id1">肢體</label><br>
				<input type="radio" id="Q11_R_Id2" name="Q11_R" value="語言"/>
				<label for="Q11_R_Id2">語言</label><br>
				<input type="radio" id="Q11_R_Id3" name="Q11_R" value="心理"/>
				<label for="Q11_R_Id3">心理</label><br>
				<input type="radio" id="Q11_R_Id4" name="Q11_R" value="性騷擾"/>
				<label for="Q11_R_Id4">性騷擾</label>
			</td>
			<td>
				<input type="radio" id="Q11_P_Id1" name="Q11_P" value="可能3分"/>
				<label for="Q11_P_Id1">可能3分</label><br>
				<input type="radio" id="Q11_P_Id2" name="Q11_P" value="不太可能2分"/>
				<label for="Q11_P_Id2">不太可能2分</label><br>
				<input type="radio" id="Q11_P_Id3" name="Q11_P" value="極不可能1分"/>
				<label for="Q11_P_Id3">極不可能1分</label>
			</td>
			<td>
				<input type="radio" id="Q11_S_Id1" name="Q11_S" value="嚴重3分"/>
				<label for="Q11_S_Id1">嚴重3分</label><br>
				<input type="radio" id="Q11_S_Id2" name="Q11_S" value="中度2分"/>
				<label for="Q11_S_Id2">中度2分</label><br>
				<input type="radio" id="Q11_S_Id3" name="Q11_S" value="輕度1分"/>
				<label for="Q11_S_Id3">輕度1分</label>
			</td>
			<td>
				<input type="radio" id="Q11_R_L_Id1" name="Q11_R_L" value="高度6-9分"/>
				<label for="Q11_R_L_Id1">高度6-9分</label><br>
				<input type="radio" id="Q11_R_L_Id2" name="Q11_R_L" value="中度3-4分"/>
				<label for="Q11_R_L_Id2">中度3-4分</label><br>
				<input type="radio" id="Q11_R_L_Id3" name="Q11_R_L" value="輕度1-2分"/>
				<label for="Q11_R_L_Id3">輕度1-2分</label>
			</td>
			<td>
				<input type="radio" id="Q11_C_Id1" name="Q11_C" value="工程控制"/>
				<label for="Q11_C_Id1">工程控制</label><br>
				<input type="radio" id="Q11_C_Id2" name="Q11_C" value="個人防護"/>
				<label for="Q11_C_Id2">個人防護</label><br>
				<input type="radio" id="Q11_C_Id3" name="Q11_C" value="管理控制"/>
				<label for="Q11_C_Id3">管理控制</label>
			</td>
			<td><input type="radio" id="Q11_Lr_Id1" name="Q11_Lr" value="無"/>
				<label for="Q11_Lr_Id1">無</label><br>
				<input type="radio" id="Q11_Lr_Id2" name="Q11_Lr" value="有：敘述"/>
				<label for="Q11_Lr_Id2">有：敘述</label>
		   </td>
		</tr>
		<tr>
			<td>新進勞工是否有尚未接受職場不法侵害預防教育訓練者</td>
			<td><input type="radio" id="Q_Y" name="Q12_Yn" value="是"/>
			</td>
			<td><input type="radio" id="Q_N" name="Q12_Yn" value="否"/>
				<label for="Q12_Id"></label>
			</td>
			<td>
				<input type="radio" id="Q12_R_Id1" name="Q12_R" value="肢體"/>
				<label for="Q12_R_Id1">肢體</label><br>
				<input type="radio" id="Q12_R_Id2" name="Q12_R" value="語言"/>
				<label for="Q12_R_Id2">語言</label><br>
				<input type="radio" id="Q12_R_Id3" name="Q12_R" value="心理"/>
				<label for="Q12_R_Id3">心理</label><br>
				<input type="radio" id="Q12_R_Id4" name="Q12_R" value="性騷擾"/>
				<label for="Q12_R_Id4">性騷擾</label>
			</td>
			<td>
				<input type="radio" id="Q12_P_Id1" name="Q12_P" value="可能3分"/>
				<label for="Q12_P_Id1">可能3分</label><br>
				<input type="radio" id="Q12_P_Id2" name="Q12_P" value="不太可能2分"/>
				<label for="Q12_P_Id2">不太可能2分</label><br>
				<input type="radio" id="Q12_P_Id3" name="Q12_P" value="極不可能1分"/>
				<label for="Q12_P_Id3">極不可能1分</label>
			</td>
			<td>
				<input type="radio" id="Q12_S_Id1" name="Q12_S" value="嚴重3分"/>
				<label for="Q12_S_Id1">嚴重3分</label><br>
				<input type="radio" id="Q12_S_Id2" name="Q12_S" value="中度2分"/>
				<label for="Q12_S_Id2">中度2分</label><br>
				<input type="radio" id="Q12_S_Id3" name="Q12_S" value="輕度1分"/>
				<label for="Q12_S_Id3">輕度1分</label>
			</td>
			<td>
				<input type="radio" id="Q12_R_L_Id1" name="Q12_R_L" value="高度6-9分"/>
				<label for="Q12_R_L_Id1">高度6-9分</label><br>
				<input type="radio" id="Q12_R_L_Id2" name="Q12_R_L" value="中度3-4分"/>
				<label for="Q12_R_L_Id2">中度3-4分</label><br>
				<input type="radio" id="Q12_R_L_Id3" name="Q12_R_L" value="輕度1-2分"/>
				<label for="Q12_R_L_Id3">輕度1-2分</label>
			</td>
			<td>
				<input type="radio" id="Q12_C_Id1" name="Q12_C" value="工程控制"/>
				<label for="Q12_C_Id1">工程控制</label><br>
				<input type="radio" id="Q12_C_Id2" name="Q12_C" value="個人防護"/>
				<label for="Q12_C_Id2">個人防護</label><br>
				<input type="radio" id="Q12_C_Id3" name="Q12_C" value="管理控制"/>
				<label for="Q12_C_Id3">管理控制</label>
			</td>
			<td><input type="radio" id="Q12_Lr_Id1" name="Q12_Lr" value="無"/>
				<label for="Q12_Lr_Id1">無</label><br>
				<input type="radio" id="Q12_Lr_Id2" name="Q12_Lr" value="有：敘述"/>
				<label for="Q12_Lr_Id2">有：敘述</label>
		   </td>
		</tr>
		<tr>
			<td>工作場所是否位於交通不便，偏遠地區</td>
			<td><input type="radio" id="Q_Y" name="Q13_Yn" value="是"/>
			</td>
			<td><input type="radio" id="Q_N" name="Q13_Yn" value="否"/>
				<label for="Q13_Id"></label>
			</td>
			<td>
				<input type="radio" id="Q13_R_Id1" name="Q13_R" value="肢體"/>
				<label for="Q13_R_Id1">肢體</label><br>
				<input type="radio" id="Q13_R_Id2" name="Q13_R" value="語言"/>
				<label for="Q13_R_Id2">語言</label><br>
				<input type="radio" id="Q13_R_Id3" name="Q13_R" value="心理"/>
				<label for="Q13_R_Id3">心理</label><br>
				<input type="radio" id="Q13_R_Id4" name="Q13_R" value="性騷擾"/>
				<label for="Q13_R_Id4">性騷擾</label>
			</td>
			<td>
				<input type="radio" id="Q13_P_Id1" name="Q13_P" value="可能3分"/>
				<label for="Q13_P_Id1">可能3分</label><br>
				<input type="radio" id="Q13_P_Id2" name="Q13_P" value="不太可能2分"/>
				<label for="Q13_P_Id2">不太可能2分</label><br>
				<input type="radio" id="Q13_P_Id3" name="Q13_P" value="極不可能1分"/>
				<label for="Q13_P_Id3">極不可能1分</label>
			</td>
			<td>
				<input type="radio" id="Q13_S_Id1" name="Q13_S" value="嚴重3分"/>
				<label for="Q13_S_Id1">嚴重3分</label><br>
				<input type="radio" id="Q13_S_Id2" name="Q13_S" value="中度2分"/>
				<label for="Q13_S_Id2">中度2分</label><br>
				<input type="radio" id="Q13_S_Id3" name="Q13_S" value="輕度1分"/>
				<label for="Q13_S_Id3">輕度1分</label>
			</td>
			<td>
				<input type="radio" id="Q13_R_L_Id1" name="Q13_R_L" value="高度6-9分"/>
				<label for="Q13_R_L_Id1">高度6-9分</label><br>
				<input type="radio" id="Q13_R_L_Id2" name="Q13_R_L" value="中度3-4分"/>
				<label for="Q13_R_L_Id2">中度3-4分</label><br>
				<input type="radio" id="Q13_R_L_Id3" name="Q13_R_L" value="輕度1-2分"/>
				<label for="Q13_R_L_Id3">輕度1-2分</label>
			</td>
			<td>
				<input type="radio" id="Q13_C_Id1" name="Q13_C" value="工程控制"/>
				<label for="Q13_C_Id1">工程控制</label><br>
				<input type="radio" id="Q13_C_Id2" name="Q13_C" value="個人防護"/>
				<label for="Q13_C_Id2">個人防護</label><br>
				<input type="radio" id="Q13_C_Id3" name="Q13_C" value="管理控制"/>
				<label for="Q13_C_Id3">管理控制</label>
			</td>
			<td><input type="radio" id="Q13_Lr_Id1" name="Q13_Lr" value="無"/>
				<label for="Q13_Lr_Id1">無</label><br>
				<input type="radio" id="Q13_Lr_Id2" name="Q13_Lr" value="有：敘述"/>
				<label for="Q13_Lr_Id2">有：敘述</label>
		   </td>
		</tr>
		<tr>
			<td>工作環境中是否有讓施暴者隱藏的地方</td>
			<td><input type="radio" id="Q_Y" name="Q14_Yn" value="是"/>
			</td>
			<td><input type="radio" id="Q_N" name="Q14_Yn" value="否"/>
				<label for="Q14_Id"></label>
			</td>
			<td>
				<input type="radio" id="Q14_R_Id1" name="Q14_R" value="肢體"/>
				<label for="Q14_R_Id1">肢體</label><br>
				<input type="radio" id="Q14_R_Id2" name="Q14_R" value="語言"/>
				<label for="Q14_R_Id2">語言</label><br>
				<input type="radio" id="Q14_R_Id3" name="Q14_R" value="心理"/>
				<label for="Q14_R_Id3">心理</label><br>
				<input type="radio" id="Q14_R_Id4" name="Q14_R" value="性騷擾"/>
				<label for="Q14_R_Id4">性騷擾</label>
			</td>
			<td>
				<input type="radio" id="Q14_P_Id1" name="Q14_P" value="可能3分"/>
				<label for="Q14_P_Id1">可能3分</label><br>
				<input type="radio" id="Q14_P_Id2" name="Q14_P" value="不太可能2分"/>
				<label for="Q14_P_Id2">不太可能2分</label><br>
				<input type="radio" id="Q14_P_Id3" name="Q14_P" value="極不可能1分"/>
				<label for="Q14_P_Id3">極不可能1分</label>
			</td>
			<td>
				<input type="radio" id="Q14_S_Id1" name="Q14_S" value="嚴重3分"/>
				<label for="Q14_S_Id1">嚴重3分</label><br>
				<input type="radio" id="Q14_S_Id2" name="Q14_S" value="中度2分"/>
				<label for="Q14_S_Id2">中度2分</label><br>
				<input type="radio" id="Q14_S_Id3" name="Q14_S" value="輕度1分"/>
				<label for="Q14_S_Id3">輕度1分</label>
			</td>
			<td>
				<input type="radio" id="Q14_R_L_Id1" name="Q14_R_L" value="高度6-9分"/>
				<label for="Q14_R_L_Id1">高度6-9分</label><br>
				<input type="radio" id="Q14_R_L_Id2" name="Q14_R_L" value="中度3-4分"/>
				<label for="Q14_R_L_Id2">中度3-4分</label><br>
				<input type="radio" id="Q14_R_L_Id3" name="Q14_R_L" value="輕度1-2分"/>
				<label for="Q14_R_L_Id3">輕度1-2分</label>
			</td>
			<td>
				<input type="radio" id="Q14_C_Id1" name="Q14_C" value="工程控制"/>
				<label for="Q14_C_Id1">工程控制</label><br>
				<input type="radio" id="Q14_C_Id2" name="Q14_C" value="個人防護"/>
				<label for="Q14_C_Id2">個人防護</label><br>
				<input type="radio" id="Q14_C_Id3" name="Q14_C" value="管理控制"/>
				<label for="Q14_C_Id3">管理控制</label>
			</td>
			<td><input type="radio" id="Q14_Lr_Id1" name="Q14_Lr" value="無"/>
				<label for="Q14_Lr_Id1">無</label><br>
				<input type="radio" id="Q14_Lr_Id2" name="Q14_Lr" value="有：敘述"/>
				<label for="Q14_Lr_Id2">有：敘述</label>
		   </td>
		</tr>
		<tr>
			<td>離開工作場所後，是否可能遭遇因執行職務所致之不法侵害行為</td>
			<td><input type="radio" id="Q_Y" name="Q15_Yn" value="是"/>
			</td>
			<td><input type="radio" id="Q_N" name="Q15_Yn" value="否"/>
				<label for="Q15_Id"></label>
			</td>
			<td>
				<input type="radio" id="Q15_R_Id1" name="Q15_R" value="肢體"/>
				<label for="Q15_R_Id1">肢體</label><br>
				<input type="radio" id="Q15_R_Id2" name="Q15_R" value="語言"/>
				<label for="Q15_R_Id2">語言</label><br>
				<input type="radio" id="Q15_R_Id3" name="Q15_R" value="心理"/>
				<label for="Q15_R_Id3">心理</label><br>
				<input type="radio" id="Q15_R_Id4" name="Q15_R" value="性騷擾"/>
				<label for="Q15_R_Id4">性騷擾</label>
			</td>
			<td>
				<input type="radio" id="Q15_P_Id1" name="Q15_P" value="可能3分"/>
				<label for="Q15_P_Id1">可能3分</label><br>
				<input type="radio" id="Q15_P_Id2" name="Q15_P" value="不太可能2分"/>
				<label for="Q15_P_Id2">不太可能2分</label><br>
				<input type="radio" id="Q15_P_Id3" name="Q15_P" value="極不可能1分"/>
				<label for="Q15_P_Id3">極不可能1分</label>
			</td>
			<td>
				<input type="radio" id="Q15_S_Id1" name="Q15_S" value="嚴重3分"/>
				<label for="Q15_S_Id1">嚴重3分</label><br>
				<input type="radio" id="Q15_S_Id2" name="Q15_S" value="中度2分"/>
				<label for="Q15_S_Id2">中度2分</label><br>
				<input type="radio" id="Q15_S_Id3" name="Q15_S" value="輕度1分"/>
				<label for="Q15_S_Id3">輕度1分</label>
			</td>
			<td>
				<input type="radio" id="Q15_R_L_Id1" name="Q15_R_L" value="高度6-9分"/>
				<label for="Q15_R_L_Id1">高度6-9分</label><br>
				<input type="radio" id="Q15_R_L_Id2" name="Q15_R_L" value="中度3-4分"/>
				<label for="Q15_R_L_Id2">中度3-4分</label><br>
				<input type="radio" id="Q15_R_L_Id3" name="Q15_R_L" value="輕度1-2分"/>
				<label for="Q15_R_L_Id3">輕度1-2分</label>
			</td>
			<td>
				<input type="radio" id="Q15_C_Id1" name="Q15_C" value="工程控制"/>
				<label for="Q15_C_Id1">工程控制</label><br>
				<input type="radio" id="Q15_C_Id2" name="Q15_C" value="個人防護"/>
				<label for="Q15_C_Id2">個人防護</label><br>
				<input type="radio" id="Q15_C_Id3" name="Q15_C" value="管理控制"/>
				<label for="Q15_C_Id3">管理控制</label>
			</td>
			<td><input type="radio" id="Q15_Lr_Id1" name="Q15_Lr" value="無"/>
				<label for="Q15_Lr_Id1">無</label><br>
				<input type="radio" id="Q15_Lr_Id2" name="Q15_Lr" value="有：敘述"/>
				<label for="Q15_Lr_Id2">有：敘述</label>
		   </td>
		</tr>
		<tr>
			<td>內部不法侵害(註：勾否者該項無需評估)</td>
		</tr>
		<tr>
			<td>組織內是否曾發生主管或勞工遭受同事(含上司)不當言行對待</td>
			<td><input type="radio" id="Q_Y" name="Q16_Yn" value="是"/>
			</td>
			<td><input type="radio" id="Q_N" name="Q16_Yn" value="否"/>
				<label for="Q16_Id"></label>
			</td>
			<td>
				<input type="radio" id="Q16_R_Id1" name="Q16_R" value="肢體"/>
				<label for="Q16_R_Id1">肢體</label><br>
				<input type="radio" id="Q16_R_Id2" name="Q16_R" value="語言"/>
				<label for="Q16_R_Id2">語言</label><br>
				<input type="radio" id="Q16_R_Id3" name="Q16_R" value="心理"/>
				<label for="Q16_R_Id3">心理</label><br>
				<input type="radio" id="Q16_R_Id4" name="Q16_R" value="性騷擾"/>
				<label for="Q16_R_Id4">性騷擾</label>
			</td>
			<td>
				<input type="radio" id="Q16_P_Id1" name="Q16_P" value="可能3分"/>
				<label for="Q16_P_Id1">可能3分</label><br>
				<input type="radio" id="Q16_P_Id2" name="Q16_P" value="不太可能2分"/>
				<label for="Q16_P_Id2">不太可能2分</label><br>
				<input type="radio" id="Q16_P_Id3" name="Q16_P" value="極不可能1分"/>
				<label for="Q16_P_Id3">極不可能1分</label>
			</td>
			<td>
				<input type="radio" id="Q16_S_Id1" name="Q16_S" value="嚴重3分"/>
				<label for="Q16_S_Id1">嚴重3分</label><br>
				<input type="radio" id="Q16_S_Id2" name="Q16_S" value="中度2分"/>
				<label for="Q16_S_Id2">中度2分</label><br>
				<input type="radio" id="Q16_S_Id3" name="Q16_S" value="輕度1分"/>
				<label for="Q16_S_Id3">輕度1分</label>
			</td>
			<td>
				<input type="radio" id="Q16_R_L_Id1" name="Q16_R_L" value="高度6-9分"/>
				<label for="Q16_R_L_Id1">高度6-9分</label><br>
				<input type="radio" id="Q16_R_L_Id2" name="Q16_R_L" value="中度3-4分"/>
				<label for="Q16_R_L_Id2">中度3-4分</label><br>
				<input type="radio" id="Q16_R_L_Id3" name="Q16_R_L" value="輕度1-2分"/>
				<label for="Q16_R_L_Id3">輕度1-2分</label>
			</td>
			<td>
				<input type="radio" id="Q16_C_Id1" name="Q16_C" value="工程控制"/>
				<label for="Q16_C_Id1">工程控制</label><br>
				<input type="radio" id="Q16_C_Id2" name="Q16_C" value="個人防護"/>
				<label for="Q16_C_Id2">個人防護</label><br>
				<input type="radio" id="Q16_C_Id3" name="Q16_C" value="管理控制"/>
				<label for="Q16_C_Id3">管理控制</label>
			</td>
			<td><input type="radio" id="Q16_Lr_Id1" name="Q16_Lr" value="無"/>
				<label for="Q16_Lr_Id1">無</label><br>
				<input type="radio" id="Q16_Lr_Id2" name="Q16_Lr" value="有：敘述"/>
				<label for="Q16_Lr_Id2">有：敘述</label>
		   </td>
		</tr>
		<tr>
			<td>是否有無法接受不同性別、年齡、國籍或宗教信仰工作者</td>
			<td><input type="radio" id="Q_Y" name="Q17_Yn" value="是"/>
			</td>
			<td><input type="radio" id="Q_N" name="Q17_Yn" value="否"/>
				<label for="Q17_Id"></label>
			</td>
			<td>
				<input type="radio" id="Q17_R_Id1" name="Q17_R" value="肢體"/>
				<label for="Q17_R_Id1">肢體</label><br>
				<input type="radio" id="Q17_R_Id2" name="Q17_R" value="語言"/>
				<label for="Q17_R_Id2">語言</label><br>
				<input type="radio" id="Q17_R_Id3" name="Q17_R" value="心理"/>
				<label for="Q17_R_Id3">心理</label><br>
				<input type="radio" id="Q17_R_Id4" name="Q17_R" value="性騷擾"/>
				<label for="Q17_R_Id4">性騷擾</label>
			</td>
			<td>
				<input type="radio" id="Q17_P_Id1" name="Q17_P" value="可能3分"/>
				<label for="Q17_P_Id1">可能3分</label><br>
				<input type="radio" id="Q17_P_Id2" name="Q17_P" value="不太可能2分"/>
				<label for="Q17_P_Id2">不太可能2分</label><br>
				<input type="radio" id="Q17_P_Id3" name="Q17_P" value="極不可能1分"/>
				<label for="Q17_P_Id3">極不可能1分</label>
			</td>
			<td>
				<input type="radio" id="Q17_S_Id1" name="Q17_S" value="嚴重3分"/>
				<label for="Q17_S_Id1">嚴重3分</label><br>
				<input type="radio" id="Q17_S_Id2" name="Q17_S" value="中度2分"/>
				<label for="Q17_S_Id2">中度2分</label><br>
				<input type="radio" id="Q17_S_Id3" name="Q17_S" value="輕度1分"/>
				<label for="Q17_S_Id3">輕度1分</label>
			</td>
			<td>
				<input type="radio" id="Q17_R_L_Id1" name="Q17_R_L" value="高度6-9分"/>
				<label for="Q17_R_L_Id1">高度6-9分</label><br>
				<input type="radio" id="Q17_R_L_Id2" name="Q17_R_L" value="中度3-4分"/>
				<label for="Q17_R_L_Id2">中度3-4分</label><br>
				<input type="radio" id="Q17_R_L_Id3" name="Q17_R_L" value="輕度1-2分"/>
				<label for="Q17_R_L_Id3">輕度1-2分</label>
			</td>
			<td>
				<input type="radio" id="Q17_C_Id1" name="Q17_C" value="工程控制"/>
				<label for="Q17_C_Id1">工程控制</label><br>
				<input type="radio" id="Q17_C_Id2" name="Q17_C" value="個人防護"/>
				<label for="Q17_C_Id2">個人防護</label><br>
				<input type="radio" id="Q17_C_Id3" name="Q17_C" value="管理控制"/>
				<label for="Q17_C_Id3">管理控制</label>
			</td>
			<td><input type="radio" id="Q17_Lr_Id1" name="Q17_Lr" value="無"/>
				<label for="Q17_Lr_Id1">無</label><br>
				<input type="radio" id="Q17_Lr_Id2" name="Q17_Lr" value="有：敘述"/>
				<label for="Q17_Lr_Id2">有：敘述</label>
		   </td>
		</tr>
		<tr>
			<td>是否有同仁離職或請求調職原因源於職場不法侵害事件之發生</td>
			<td><input type="radio" id="Q_Y" name="Q18_Yn" value="是"/>
			</td>
			<td><input type="radio" id="Q_N" name="Q18_Yn" value="否"/>
				<label for="Q18_Id"></label>
			</td>
			<td>
				<input type="radio" id="Q18_R_Id1" name="Q18_R" value="肢體"/>
				<label for="Q18_R_Id1">肢體</label><br>
				<input type="radio" id="Q18_R_Id2" name="Q18_R" value="語言"/>
				<label for="Q18_R_Id2">語言</label><br>
				<input type="radio" id="Q18_R_Id3" name="Q18_R" value="心理"/>
				<label for="Q18_R_Id3">心理</label><br>
				<input type="radio" id="Q18_R_Id4" name="Q18_R" value="性騷擾"/>
				<label for="Q18_R_Id4">性騷擾</label>
			</td>
			<td>
				<input type="radio" id="Q18_P_Id1" name="Q18_P" value="可能3分"/>
				<label for="Q18_P_Id1">可能3分</label><br>
				<input type="radio" id="Q18_P_Id2" name="Q18_P" value="不太可能2分"/>
				<label for="Q18_P_Id2">不太可能2分</label><br>
				<input type="radio" id="Q18_P_Id3" name="Q18_P" value="極不可能1分"/>
				<label for="Q18_P_Id3">極不可能1分</label>
			</td>
			<td>
				<input type="radio" id="Q18_S_Id1" name="Q18_S" value="嚴重3分"/>
				<label for="Q18_S_Id1">嚴重3分</label><br>
				<input type="radio" id="Q18_S_Id2" name="Q18_S" value="中度2分"/>
				<label for="Q18_S_Id2">中度2分</label><br>
				<input type="radio" id="Q18_S_Id3" name="Q18_S" value="輕度1分"/>
				<label for="Q18_S_Id3">輕度1分</label>
			</td>
			<td>
				<input type="radio" id="Q18_R_L_Id1" name="Q18_R_L" value="高度6-9分"/>
				<label for="Q18_R_L_Id1">高度6-9分</label><br>
				<input type="radio" id="Q18_R_L_Id2" name="Q18_R_L" value="中度3-4分"/>
				<label for="Q18_R_L_Id2">中度3-4分</label><br>
				<input type="radio" id="Q18_R_L_Id3" name="Q18_R_L" value="輕度1-2分"/>
				<label for="Q18_R_L_Id3">輕度1-2分</label>
			</td>
			<td>
				<input type="radio" id="Q18_C_Id1" name="Q18_C" value="工程控制"/>
				<label for="Q18_C_Id1">工程控制</label><br>
				<input type="radio" id="Q18_C_Id2" name="Q18_C" value="個人防護"/>
				<label for="Q18_C_Id2">個人防護</label><br>
				<input type="radio" id="Q18_C_Id3" name="Q18_C" value="管理控制"/>
				<label for="Q18_C_Id3">管理控制</label>
			</td>
			<td><input type="radio" id="Q18_Lr_Id1" name="Q18_Lr" value="無"/>
				<label for="Q18_Lr_Id1">無</label><br>
				<input type="radio" id="Q18_Lr_Id2" name="Q18_Lr" value="有：敘述"/>
				<label for="Q18_Lr_Id2">有：敘述</label>
		   </td>
		</tr>
		<tr>
			<td>是否有被同仁排擠或工作適應不良者</td>
			<td><input type="radio" id="Q_Y" name="Q19_Yn" value="是"/>
			</td>
			<td><input type="radio" id="Q_N" name="Q19_Yn" value="否"/>
				<label for="Q19_Id"></label>
			</td>
			<td>
				<input type="radio" id="Q19_R_Id1" name="Q19_R" value="肢體"/>
				<label for="Q19_R_Id1">肢體</label><br>
				<input type="radio" id="Q19_R_Id2" name="Q19_R" value="語言"/>
				<label for="Q19_R_Id2">語言</label><br>
				<input type="radio" id="Q19_R_Id3" name="Q19_R" value="心理"/>
				<label for="Q19_R_Id3">心理</label><br>
				<input type="radio" id="Q19_R_Id4" name="Q19_R" value="性騷擾"/>
				<label for="Q19_R_Id4">性騷擾</label>
			</td>
			<td>
				<input type="radio" id="Q19_P_Id1" name="Q19_P" value="可能3分"/>
				<label for="Q19_P_Id1">可能3分</label><br>
				<input type="radio" id="Q19_P_Id2" name="Q19_P" value="不太可能2分"/>
				<label for="Q19_P_Id2">不太可能2分</label><br>
				<input type="radio" id="Q19_P_Id3" name="Q19_P" value="極不可能1分"/>
				<label for="Q19_P_Id3">極不可能1分</label>
			</td>
			<td>
				<input type="radio" id="Q19_S_Id1" name="Q19_S" value="嚴重3分"/>
				<label for="Q19_S_Id1">嚴重3分</label><br>
				<input type="radio" id="Q19_S_Id2" name="Q19_S" value="中度2分"/>
				<label for="Q19_S_Id2">中度2分</label><br>
				<input type="radio" id="Q19_S_Id3" name="Q19_S" value="輕度1分"/>
				<label for="Q19_S_Id3">輕度1分</label>
			</td>
			<td>
				<input type="radio" id="Q19_R_L_Id1" name="Q19_R_L" value="高度6-9分"/>
				<label for="Q19_R_L_Id1">高度6-9分</label><br>
				<input type="radio" id="Q19_R_L_Id2" name="Q19_R_L" value="中度3-4分"/>
				<label for="Q19_R_L_Id2">中度3-4分</label><br>
				<input type="radio" id="Q19_R_L_Id3" name="Q19_R_L" value="輕度1-2分"/>
				<label for="Q19_R_L_Id3">輕度1-2分</label>
			</td>
			<td>
				<input type="radio" id="Q19_C_Id1" name="Q19_C" value="工程控制"/>
				<label for="Q19_C_Id1">工程控制</label><br>
				<input type="radio" id="Q19_C_Id2" name="Q19_C" value="個人防護"/>
				<label for="Q19_C_Id2">個人防護</label><br>
				<input type="radio" id="Q19_C_Id3" name="Q19_C" value="管理控制"/>
				<label for="Q19_C_Id3">管理控制</label>
			</td>
			<td><input type="radio" id="Q19_Lr_Id1" name="Q19_Lr" value="無"/>
				<label for="Q19_Lr_Id1">無</label><br>
				<input type="radio" id="Q19_Lr_Id2" name="Q19_Lr" value="有：敘述"/>
				<label for="Q19_Lr_Id2">有：敘述</label>
		   </td>
		</tr>
		<tr>
			<td>內部是否有酗酒、毒癮之工作者</td>
			<td><input type="radio" id="Q_Y" name="Q20_Yn" value="是"/>
			</td>
			<td><input type="radio" id="Q_N" name="Q20_Yn" value="否"/>
				<label for="Q20_Id"></label>
			</td>
			<td>
				<input type="radio" id="Q20_R_Id1" name="Q20_R" value="肢體"/>
				<label for="Q20_R_Id1">肢體</label><br>
				<input type="radio" id="Q20_R_Id2" name="Q20_R" value="語言"/>
				<label for="Q20_R_Id2">語言</label><br>
				<input type="radio" id="Q20_R_Id3" name="Q20_R" value="心理"/>
				<label for="Q20_R_Id3">心理</label><br>
				<input type="radio" id="Q20_R_Id4" name="Q20_R" value="性騷擾"/>
				<label for="Q20_R_Id4">性騷擾</label>
			</td>
			<td>
				<input type="radio" id="Q20_P_Id1" name="Q20_P" value="可能3分"/>
				<label for="Q20_P_Id1">可能3分</label><br>
				<input type="radio" id="Q20_P_Id2" name="Q20_P" value="不太可能2分"/>
				<label for="Q20_P_Id2">不太可能2分</label><br>
				<input type="radio" id="Q20_P_Id3" name="Q20_P" value="極不可能1分"/>
				<label for="Q20_P_Id3">極不可能1分</label>
			</td>
			<td>
				<input type="radio" id="Q20_S_Id1" name="Q20_S" value="嚴重3分"/>
				<label for="Q20_S_Id1">嚴重3分</label><br>
				<input type="radio" id="Q20_S_Id2" name="Q20_S" value="中度2分"/>
				<label for="Q20_S_Id2">中度2分</label><br>
				<input type="radio" id="Q20_S_Id3" name="Q20_S" value="輕度1分"/>
				<label for="Q20_S_Id3">輕度1分</label>
			</td>
			<td>
				<input type="radio" id="Q20_R_L_Id1" name="Q20_R_L" value="高度6-9分"/>
				<label for="Q20_R_L_Id1">高度6-9分</label><br>
				<input type="radio" id="Q20_R_L_Id2" name="Q20_R_L" value="中度3-4分"/>
				<label for="Q20_R_L_Id2">中度3-4分</label><br>
				<input type="radio" id="Q20_R_L_Id3" name="Q20_R_L" value="輕度1-2分"/>
				<label for="Q20_R_L_Id3">輕度1-2分</label>
			</td>
			<td>
				<input type="radio" id="Q20_C_Id1" name="Q20_C" value="工程控制"/>
				<label for="Q20_C_Id1">工程控制</label><br>
				<input type="radio" id="Q20_C_Id2" name="Q20_C" value="個人防護"/>
				<label for="Q20_C_Id2">個人防護</label><br>
				<input type="radio" id="Q20_C_Id3" name="Q20_C" value="管理控制"/>
				<label for="Q20_C_Id3">管理控制</label>
			</td>
			<td><input type="radio" id="Q20_Lr_Id1" name="Q20_Lr" value="無"/>
				<label for="Q20_Lr_Id1">無</label><br>
				<input type="radio" id="Q20_Lr_Id2" name="Q20_Lr" value="有：敘述"/>
				<label for="Q20_Lr_Id2">有：敘述</label>
		   </td>
		</tr>
		<tr>
			<td>內部是否有處於情緒低落、絕望或恐懼，極需被關懷照顧工作者</td>
			<td><input type="radio" id="Q_Y" name="Q21_Yn" value="是"/>
			</td>
			<td><input type="radio" id="Q_N" name="Q21_Yn" value="否"/>
				<label for="Q21_Id"></label>
			</td>
			<td>
				<input type="radio" id="Q21_R_Id1" name="Q21_R" value="肢體"/>
				<label for="Q21_R_Id1">肢體</label><br>
				<input type="radio" id="Q21_R_Id2" name="Q21_R" value="語言"/>
				<label for="Q21_R_Id2">語言</label><br>
				<input type="radio" id="Q21_R_Id3" name="Q21_R" value="心理"/>
				<label for="Q21_R_Id3">心理</label><br>
				<input type="radio" id="Q21_R_Id4" name="Q21_R" value="性騷擾"/>
				<label for="Q21_R_Id4">性騷擾</label>
			</td>
			<td>
				<input type="radio" id="Q21_P_Id1" name="Q21_P" value="可能3分"/>
				<label for="Q21_P_Id1">可能3分</label><br>
				<input type="radio" id="Q21_P_Id2" name="Q21_P" value="不太可能2分"/>
				<label for="Q21_P_Id2">不太可能2分</label><br>
				<input type="radio" id="Q21_P_Id3" name="Q21_P" value="極不可能1分"/>
				<label for="Q21_P_Id3">極不可能1分</label>
			</td>
			<td>
				<input type="radio" id="Q21_S_Id1" name="Q21_S" value="嚴重3分"/>
				<label for="Q21_S_Id1">嚴重3分</label><br>
				<input type="radio" id="Q21_S_Id2" name="Q21_S" value="中度2分"/>
				<label for="Q21_S_Id2">中度2分</label><br>
				<input type="radio" id="Q21_S_Id3" name="Q21_S" value="輕度1分"/>
				<label for="Q21_S_Id3">輕度1分</label>
			</td>
			<td>
				<input type="radio" id="Q21_R_L_Id1" name="Q21_R_L" value="高度6-9分"/>
				<label for="Q21_R_L_Id1">高度6-9分</label><br>
				<input type="radio" id="Q21_R_L_Id2" name="Q21_R_L" value="中度3-4分"/>
				<label for="Q21_R_L_Id2">中度3-4分</label><br>
				<input type="radio" id="Q21_R_L_Id3" name="Q21_R_L" value="輕度1-2分"/>
				<label for="Q21_R_L_Id3">輕度1-2分</label>
			</td>
			<td>
				<input type="radio" id="Q21_C_Id1" name="Q21_C" value="工程控制"/>
				<label for="Q21_C_Id1">工程控制</label><br>
				<input type="radio" id="Q21_C_Id2" name="Q21_C" value="個人防護"/>
				<label for="Q21_C_Id2">個人防護</label><br>
				<input type="radio" id="Q21_C_Id3" name="Q21_C" value="管理控制"/>
				<label for="Q21_C_Id3">管理控制</label>
			</td>
			<td><input type="radio" id="Q21_Lr_Id1" name="Q21_Lr" value="無"/>
				<label for="Q21_Lr_Id1">無</label><br>
				<input type="radio" id="Q21_Lr_Id2" name="Q21_Lr" value="有：敘述"/>
				<label for="Q21_Lr_Id2">有：敘述</label>
		   </td>
		</tr>
		<tr>
			<td>是否有超時工作，反應工作壓力大工作者</td>
			<td><input type="radio" id="Q_Y" name="Q22_Yn" value="是"/>
			</td>
			<td><input type="radio" id="Q_N" name="Q22_Yn" value="否"/>
				<label for="Q22_Id"></label>
			</td>
			<td>
				<input type="radio" id="Q22_R_Id1" name="Q22_R" value="肢體"/>
				<label for="Q22_R_Id1">肢體</label><br>
				<input type="radio" id="Q22_R_Id2" name="Q22_R" value="語言"/>
				<label for="Q22_R_Id2">語言</label><br>
				<input type="radio" id="Q22_R_Id3" name="Q22_R" value="心理"/>
				<label for="Q22_R_Id3">心理</label><br>
				<input type="radio" id="Q22_R_Id4" name="Q22_R" value="性騷擾"/>
				<label for="Q22_R_Id4">性騷擾</label>
			</td>
			<td>
				<input type="radio" id="Q22_P_Id1" name="Q22_P" value="可能3分"/>
				<label for="Q22_P_Id1">可能3分</label><br>
				<input type="radio" id="Q22_P_Id2" name="Q22_P" value="不太可能2分"/>
				<label for="Q22_P_Id2">不太可能2分</label><br>
				<input type="radio" id="Q22_P_Id3" name="Q22_P" value="極不可能1分"/>
				<label for="Q22_P_Id3">極不可能1分</label>
			</td>
			<td>
				<input type="radio" id="Q22_S_Id1" name="Q22_S" value="嚴重3分"/>
				<label for="Q22_S_Id1">嚴重3分</label><br>
				<input type="radio" id="Q22_S_Id2" name="Q22_S" value="中度2分"/>
				<label for="Q22_S_Id2">中度2分</label><br>
				<input type="radio" id="Q22_S_Id3" name="Q22_S" value="輕度1分"/>
				<label for="Q22_S_Id3">輕度1分</label>
			</td>
			<td>
				<input type="radio" id="Q22_R_L_Id1" name="Q22_R_L" value="高度6-9分"/>
				<label for="Q22_R_L_Id1">高度6-9分</label><br>
				<input type="radio" id="Q22_R_L_Id2" name="Q22_R_L" value="中度3-4分"/>
				<label for="Q22_R_L_Id2">中度3-4分</label><br>
				<input type="radio" id="Q22_R_L_Id3" name="Q22_R_L" value="輕度1-2分"/>
				<label for="Q22_R_L_Id3">輕度1-2分</label>
			</td>
			<td>
				<input type="radio" id="Q22_C_Id1" name="Q22_C" value="工程控制"/>
				<label for="Q22_C_Id1">工程控制</label><br>
				<input type="radio" id="Q22_C_Id2" name="Q22_C" value="個人防護"/>
				<label for="Q22_C_Id2">個人防護</label><br>
				<input type="radio" id="Q22_C_Id3" name="Q22_C" value="管理控制"/>
				<label for="Q22_C_Id3">管理控制</label>
			</td>
			<td><input type="radio" id="Q22_Lr_Id1" name="Q22_Lr" value="無"/>
				<label for="Q22_Lr_Id1">無</label><br>
				<input type="radio" id="Q22_Lr_Id2" name="Q22_Lr" value="有：敘述"/>
				<label for="Q22_Lr_Id2">有：敘述</label>
		   </td>
		</tr>
		<tr>
			<td>工作環境是否有空間擁擠，照明設備不足問題，工作場所出入是否未有相當管制措施</td>
			<td><input type="radio" id="Q_Y" name="Q23_Yn" value="是"/>
			</td>
			<td><input type="radio" id="Q_N" name="Q23_Yn" value="否"/>
				<label for="Q23_Id"></label>
			</td>
			<td>
				<input type="radio" id="Q23_R_Id1" name="Q23_R" value="肢體"/>
				<label for="Q23_R_Id1">肢體</label><br>
				<input type="radio" id="Q23_R_Id2" name="Q23_R" value="語言"/>
				<label for="Q23_R_Id2">語言</label><br>
				<input type="radio" id="Q23_R_Id3" name="Q23_R" value="心理"/>
				<label for="Q23_R_Id3">心理</label><br>
				<input type="radio" id="Q23_R_Id4" name="Q23_R" value="性騷擾"/>
				<label for="Q23_R_Id4">性騷擾</label>
			</td>
			<td>
				<input type="radio" id="Q23_P_Id1" name="Q23_P" value="可能3分"/>
				<label for="Q23_P_Id1">可能3分</label><br>
				<input type="radio" id="Q23_P_Id2" name="Q23_P" value="不太可能2分"/>
				<label for="Q23_P_Id2">不太可能2分</label><br>
				<input type="radio" id="Q23_P_Id3" name="Q23_P" value="極不可能1分"/>
				<label for="Q23_P_Id3">極不可能1分</label>
			</td>
			<td>
				<input type="radio" id="Q23_S_Id1" name="Q23_S" value="嚴重3分"/>
				<label for="Q23_S_Id1">嚴重3分</label><br>
				<input type="radio" id="Q23_S_Id2" name="Q23_S" value="中度2分"/>
				<label for="Q23_S_Id2">中度2分</label><br>
				<input type="radio" id="Q23_S_Id3" name="Q23_S" value="輕度1分"/>
				<label for="Q23_S_Id3">輕度1分</label>
			</td>
			<td>
				<input type="radio" id="Q23_R_L_Id1" name="Q23_R_L" value="高度6-9分"/>
				<label for="Q23_R_L_Id1">高度6-9分</label><br>
				<input type="radio" id="Q23_R_L_Id2" name="Q23_R_L" value="中度3-4分"/>
				<label for="Q23_R_L_Id2">中度3-4分</label><br>
				<input type="radio" id="Q23_R_L_Id3" name="Q23_R_L" value="輕度1-2分"/>
				<label for="Q23_R_L_Id3">輕度1-2分</label>
			</td>
			<td>
				<input type="radio" id="Q23_C_Id1" name="Q23_C" value="工程控制"/>
				<label for="Q23_C_Id1">工程控制</label><br>
				<input type="radio" id="Q23_C_Id2" name="Q23_C" value="個人防護"/>
				<label for="Q23_C_Id2">個人防護</label><br>
				<input type="radio" id="Q23_C_Id3" name="Q23_C" value="管理控制"/>
				<label for="Q23_C_Id3">管理控制</label>
			</td>
			<td><input type="radio" id="Q23_Lr_Id1" name="Q23_Lr" value="無"/>
				<label for="Q23_Lr_Id1">無</label><br>
				<input type="radio" id="Q23_Lr_Id2" name="Q23_Lr" value="有：敘述"/>
				<label for="Q23_Lr_Id2">有：敘述</label>
		   </td>
		</tr>
	</table>
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
	<div class="tab-pane animated fadeIn" id="export_page">
		<section class="">
			<!-- row -->
			<div class="row">
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="export-modal-body">

				</article>
			</div>
		</section>
	</div>
</div>
<?php $this -> load -> view('general/delete_modal'); ?>

<script type="text/javascript">
	loadScript(baseUrl + "js/class/BaseAppClass.js", function(){
		loadScript(baseUrl + "js/app/question_option/list.js", function(){
			currentApp = new QuestionoptionAppClass(new BaseAppClass({}));
		
		});
	});
	var btnA = document.querySelector(".btnY1");
        var btnB = document.querySelector(".btnN1");
        btnA.addEventListener("click",function () {
            if ($('.R1').is(':hidden')) {
                $('.R1').show();
              } else {
              }
			});
        btnB.addEventListener("click",function () {
            if ($('.R1').is(':hidden')) {
                $('.R1').show();
              } else {
                $('.R1').hide();
              }
			});
</script>
