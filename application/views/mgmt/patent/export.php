
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

@media print  
{
    div{
        page-break-inside: avoid;
    }
}

@page {
  size: A4 portrait;
  margin-top: 1cm;
}
</style>
<!-- Widget ID (each widget will need unique ID)-->
<div class="" style="padding:50px 50px 50px 50px;">
	<table  class="layui-table" width="70%">
		<thead>
		
		</thead>
		<tbody class="">
			<tr>
				<td class="min100" colspan="5" style="text-align:center;vertical-align:middle;">專利詳細資訊</td>
			</tr>
			<tr>
				<td class="min100" colspan="5" style="text-align:center;vertical-align:middle;">專利家族代碼:<?= isset($item) ? $item -> patent_family : '' ?></td>
			</tr>
			<tr>
				<td class="min200">專利類型</td>
				<td id="patnet_status" colspan="3"><?= isset($all_patent_status_name) ? $all_patent_status_name: '' ?></td>
				<?php if(!empty($item->image) && $item->image !==''): ?>
					<td rowspan="5"><img src="<?= base_url("api/images/get/".$item->image[0]) ?>" style="max-height:100%;max-width:100%" ></td>
				<?php else : ?>
					<td rowspan="5">沒有圖片</td>
				<?php endif?>
			</tr>
			<tr>
				<td>專利名稱</td>
				<td colspan="3"><?= isset($item) ? $item -> patent_name : '' ?></td>
			</tr>
			<tr>
				<td>專利國家</td>
				<td><?= isset($country) ? $country -> country_name : '' ?></td>
				<td>專利類別</td>
				<td>
					<?php if(!empty($item->patnet_category)): ?>
						<?php if($item->patnet_category==1): ?>
							發明
						<?php elseif($item->patnet_category==2) : ?>
							新型
						<?php elseif($item->patnet_category==3) : ?>
							設計
						<?php endif?>
					<?php endif?>
				</td>
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
					<?php if($item -> patnet_type==3): ?>
						<?php if($patnet_fail_status->id <>5): ?>
							<?= isset($patnet_type_name) ? $patnet_type_name.'('.$patnet_fail_status->name.')' : '' ?>
						<?php else: ?>
							<?= isset($patnet_type_name) ? $patnet_type_name.'('.$patnet_fail_status->name.'：'.$item->patent_fail_person.')' : '' ?>
						<?php endif?>					
					<?php else: ?>
						<?= isset($patnet_type_name) ? $patnet_type_name : '' ?>
					<?php endif?>					
				</td>	
			</tr>
			<tr>
				<td>專利權期間</td>
				<td><?= isset($item) ? $item -> patent_start_dt : '' ?>~<?= isset($item) ? $item -> patent_end_dt : '' ?></td>
				<td>專利權止日</td>
				<td colspan="2"><?= isset($item) ? $item -> patent_finish_date : '' ?></td>
			</tr>
			<tr>
				<td>專利摘要</td>
				<td colspan="4"><?= isset($item) ? $item -> patent_note : '' ?></td>
			</tr>
			<tr>
				<td>專利範圍</td>
				<td colspan="4"><pre style="border-style:none;background-color:transparent;color:#666666;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;"><?= isset($item) ? $item -> patent_range : '' ?></pre></td>
			</tr>
			<tr>
				<td>專利分析相關文件</td>
				<td colspan="4"><pre style="border-style:none;background-color:transparent;color:#666666;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;"><?= isset($item) ? $item -> patent_range : '' ?></pre></td>
			</tr>
		</tbody>
	</table>
</div>
<!-- end widget -->

<script>

</script>
