
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
<div class="jarviswidget" id="wid-id-7" data-widget-colorbutton="false"	data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false" style="padding:50px 50px 50px 50px">
	<table id="export_table_list" class="table table-striped table-bordered table-hover" width="70%">
		<thead>
			<tr>
				<th class="min100" colspan="5" style="text-align:center;vertical-align:middle;">專利詳細資訊</th>
			</tr>
			<tr>
				<th class="min100" colspan="5" style="text-align:right">專利家族代碼:<?= isset($item) ? $item -> patent_family : '' ?></th>
			</tr>
		</thead>
		<tbody>
			<tr class="min100">專利項目</tr>
			<tr></tr>
			<tr></tr>
			<tr></tr>
			<tr></tr>
		</tbody>
		<tbody>
			<tr>專利名稱</tr>
			<tr></tr>
			<tr></tr>
			<tr></tr>
			<tr></tr>
		</tbody>
		<tbody>
			<tr>專利國家</tr>
			<tr></tr>
			<tr>專利類別</tr>
			<tr></tr>
			<tr></tr>
		</tbody>
		<tbody>
			<tr>申請號</tr>
			<tr></tr>
			<tr>申請日</tr>
			<tr></tr>
			<tr></tr>
		</tbody>
		<tbody>
			<tr>公開號</tr>
			<tr></tr>
			<tr>公開日</tr>
			<tr></tr>
			<tr></tr>
		</tbody>
		<tbody>
			<tr>專利號</tr>
			<tr></tr>
			<tr>公告日</tr>
			<tr></tr>
			<tr></tr>
		</tbody>
		<tbody>
			<tr>申請人</tr>
			<tr></tr>
			<tr>發明人</tr>
			<tr></tr>
			<tr></tr>
		</tbody>
		<tbody>
			<tr>受讓人</tr>
			<tr></tr>
			<tr>專利狀態</tr>
			<tr></tr>
			<tr></tr>
		</tbody>
		<tbody>
			<tr>專利授權期間</tr>
			<tr></tr>
			<tr></tr>
			<tr>專利截止日</tr>
			<tr></tr>
		</tbody>
		<tbody>
			<tr>專利摘要</tr>
			<tr></tr>
			<tr></tr>
			<tr></tr>
			<tr></tr>
		</tbody>
		<tbody>
			<tr>專利範圍</tr>
			<tr></tr>
			<tr></tr>
			<tr></tr>
			<tr></tr>
		</tbody>
		<tbody>
			<tr>專利分析相關資訊</tr>
			<tr></tr>
			<tr></tr>
			<tr></tr>
			<tr></tr>
		</tbody>
		</tbody>
		<tbody>
			<tr>專利家族</tr>
			<tr></tr>
			<tr></tr>
			<tr></tr>
			<tr></tr>
		</tbody>
		</tbody>
		<tbody>
			<tr>關鍵字</tr>
			<tr></tr>
			<tr></tr>
			<tr></tr>
			<tr></tr>
		</tbody>
	</table>
</div>
<!-- end widget -->
<script>
</script>
