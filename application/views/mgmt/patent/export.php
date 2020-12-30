
<?php $this->load->view('layout/head'); ?>
<style>
.file-drag-handle {
	display: none;
}
.btn_1 {
	background-color: #FFD22F !important;
	color: #F57316 !important;
}
.is_ok {
	background-color:lightgreen;
}
.not_ok {
	background-color:red;
}

</style>
<!-- Widget ID (each widget will need unique ID)-->
<div style="padding:50px 50px 50px 50px">
	<table  class="table table-striped table-bordered table-hover" width="70%">
		<thead>
			<tr>
				<th class="min100" colspan="5" style="text-align:center;vertical-align:middle;">專利詳細資訊</th>
			</tr>
			<tr>
				<th class="min100" colspan="5" style="text-align:center;vertical-align:middle;">專利家族代碼:<?= isset($item) ? $item -> patent_family : '' ?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="min100" >專利項目</td>
				<td colspan="3"></td>
				<td rowspan="5"><img src="<?= base_url("api/images/get/".$item->img_id[0]."/thumb") ?>" style="max-height:600px;max-width:600px" ></td>
			</tr>
			<tr>
				<td>專利名稱</td>
				<td colspan="3"><?= isset($item) ? $item -> patent_name : '' ?></td>
				
			</tr>
			<tr>
				<td>專利國家</td>
				<td></td>
				<td>專利類別</td>
				<td></td>
			</tr>
			<tr>
				<td>申請號</td>
				<td></td>
				<td>申請日</td>
				<td></td>
			</tr>	
			<tr>
				<td>公開號</td>
				<td></td>
				<td>公開日</td>
				<td></td>
			</tr>
			<tr>
				<td>專利號</td>
				<td></td>
				<td>公告日</td>
				<td colspan="2"></td>
			</tr>
			<tr>
				<td>申請人</td>
				<td></td>
				<td>發明人</td>
				<td colspan="2"></td>
			</tr>
			<tr>
				<td>受讓人</td>
				<td></td>
				<td>專利狀態</td>
				<td colspan="2"></td>
			</tr>
			<tr>
				<td>專利授權期間</td>
				<td colspan="2"></td>
				<td>專利截止日</td>
				<td></td>
			</tr>
			<tr>
				<td>專利摘要</td>
				<td colspan="4"></td>
			
			</tr>
			<tr>
				<td>專利範圍</td>
				<td colspan="4"></td>
			
			</tr>
			<tr>
				<td>專利分析相關資訊</td>
				<td colspan="4"></td>
				
			</tr>
			<tr>
				<td>專利家族</td>
				<td colspan="4"></td>
				
			</tr>
			<tr>
				<td>關鍵字</td>
				<td colspan="4"></td>

			</tr>
		</tbody>
	</table>
</div>
<!-- end widget -->
<script>
</script>
