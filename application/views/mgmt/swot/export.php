
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
.out {
	border-top: 5em #199fff solid; 
	border-left: 200px #ff8838 solid; 
	position: relative;
	color:white;
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
				<td class="min100" colspan="6" style="text-align:center;vertical-align:middle;">寬仕工業股份有限公司</td>
			</tr>
			<tr>
				<td class="min100" colspan="6" style="text-align:center;vertical-align:middle;">SWOT分析表-<?= date('Ymd')?></td>
			</tr>
			<tr>
				<td rowspan="4">
					<div class="out" style="font-size:27px">
						<b>SW</b> <em>OT</em>
					</div>
				</td>
				<td rowspan="4">沒有圖片</td>
				<td rowspan="4">沒有圖片</td>
			</tr>
			<tr>
				<td rowspan="4">沒有圖片</td>
				<td rowspan="4">沒有圖片</td>
				<td rowspan="4">沒有圖片</td>
			</tr>
			<tr>
				<td rowspan="4">沒有圖片</td>
				<td rowspan="4">沒有圖片</td>
				<td rowspan="4">沒有圖片</td>
			</tr>
		</tbody>
	</table>
</div>
<!-- end widget -->

<script>

</script>
