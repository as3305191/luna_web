
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
		
		</thead>
		<tbody>
			<tr>
				<td class="min100" colspan="5" style="text-align:center;vertical-align:middle;">專利詳細資訊</td>
			</tr>
			<tr>
				<td class="min100" colspan="5" style="text-align:center;vertical-align:middle;">專利家族代碼:<?= isset($item) ? $item -> patent_family : '' ?></td>
			</tr>
			<tr>
				<td class="min200">專利項目</td>
				<td colspan="3"></td>
				<td rowspan="5"><img src="<?= base_url("api/images/get/".$item->img_id[0]."/thumb") ?>" style="height:500%;width:100%" ></td>
			</tr>
			<tr>
				<td>專利名稱</td>
				<td colspan="3"><?= isset($item) ? $item -> patent_name : '' ?></td>
				
			</tr>
			<tr>
				<td>專利國家</td>
				<td><?= isset($country) ? $country -> country_name : '' ?></td>
				<td>專利類別</td>
				<td><?= isset($patnet_category) ? $patnet_category -> name : '' ?></td>
			</tr>
			<tr>
				<td>申請號</td>
				<td><?= isset($item) ? $item -> application_num : '' ?></td>
				<td>申請日</td>
				<td><?= isset($item) ? $item -> application_date : '' ?></td>
			</tr>	
			<tr>
				<td>公開號</td>
				<td><?= isset($item) ? $item -> public_num : '' ?></td>
				<td>公開日</td>
				<td><?= isset($item) ? $item -> public_date : '' ?></td>
			</tr>
			<tr>
				<td>專利號</td>
				<td><?= isset($item) ? $item -> patnet_num : '' ?></td>
				<td>公告日</td>
				<td colspan="2"><?= isset($item) ? $item -> announcement_date : '' ?></td>
			</tr>
			<tr>
				<td>申請人</td>
				<td><?= isset($item) ? $item -> applicant : '' ?></td>
				<td>發明人</td>
				<td colspan="2"><?= isset($item) ? $item -> inventor : '' ?></td>
			</tr>
			<tr>
				<td>受讓人</td>
				<td><?= isset($item) ? $item -> assignee : '' ?></td>
				<td>專利狀態</td>
				<td colspan="2">
					<?php if($item -> patnet_status==1): ?>
						有效
					<?php elseif($item -> patnet_status==2): ?>
						無效
					<?php endif?>
				</td>	
			</tr>
			<tr>
				<td>專利授權期間</td>
				<td colspan="2"><?= isset($item) ? $item -> patent_start_dt : '' ?>~<?= isset($item) ? $item -> patent_end_dt : '' ?></td>
				<td>專利截止日</td>
				<td><?= isset($item) ? $item -> patent_finish_date : '' ?></td>
			</tr>
			<tr>
				<td>專利摘要</td>
				<td colspan="4"><?= isset($item) ? $item -> patent_note : '' ?></td>
			</tr>
			<tr>
				<td>專利範圍</td>
				<td colspan="4"><?= isset($item) ? $item -> patent_range : '' ?></td>
			</tr>
		</tbody>
	</table>
</div>
<!-- end widget -->
<script>
</script>
