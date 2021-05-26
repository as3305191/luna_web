
<?php $this->load->view('layout/head'); ?>
<style>
.layui-table1{ 
	/* border-style:groove !important; */
	margin: 0;
}
.td_table{
 	padding: 0px 0px 0px 0px !important;
	border-color:#000 !important;
}
.pageDiv{
        display:block;
        position:relative;
        background-repeat:no-repeat;
        background-position: center;
        page-break-after: always;  
		page-break-inside: avoid;
    }
.pageDiv:last-of-type{ 
	page-break-after: auto; 
}

@page {
  margin: 0; /*邊界與內容的距離*/
}

@media print{

	.layui-table1{ 
		/* border-style:groove !important; */
		margin: 0;
	}

	.td_table{
		padding: 0px 0px 0px 0px !important;
		border-color:#000 !important;
	}

	.pageDiv{
        display:block;
        position:relative;
        background-repeat:no-repeat;
        background-position: center;
        page-break-after: always;  
		page-break-inside: avoid;
    }

	.pageDiv:last-of-type{ 
		page-break-after: auto; 
	}	

	.ex_page{ 
		-webkit-print-color-adjust: exact; 
	} 
}
</style>
<!-- Widget ID (each widget will need unique ID)-->
<div class="ex_page " style="padding:20px 20px 20px 20px;">
	<table class="layui-table pageDiv layui-table1" width="70%"  style="border-color:#000;padding:30px 30px 30px 30px;" >
		<thead>
		</thead>
		<tbody class="">
			<!-- <tr>
				<td class="" colspan="3" style="border:none;text-align:center;vertical-align:middle;font-weight:bold;font-size:200%;padding:50px 50px 50px 50px;">寬仕工業股份有限公司</td>
			</tr> -->
			<tr>
				<td class="" colspan="3" style="border:none;text-align:center;vertical-align:middle;">
					<div style="border:none;text-align:center;vertical-align:middle;font-weight:bold;font-size:200%;padding:50px 50px 50px 50px;">寬仕工業股份有限公司</div>
					<div style="text-align:center;vertical-align:middle;font-weight:bold;font-size:150%;padding:0px 0px 0px 0px;"><?= isset($item) ? $item -> d_or_c_name : '' ?>-<?= isset($item) ? $item -> s_title_name : '' ?>-<?= date('Ymd')?></div>
					<div style="text-align:right;">文件種類：<?= isset($item) ? $item -> s_style_name : ''?></div>
				</td>
			</tr>
			<tr >
				<td colspan="1" class="td_table col-xs-4"><img src="<?= base_url("api/images/get/947")?>" style="min-width:100%;min-height: 100%;-webkit-background-size:cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;" ></td>
				<td colspan="1" valign="top" class="td_table col-xs-4">
					<table class="swot_table" width="100%" height="100%"  align="center">
						<tr >
							<td style="text-align:center;vertical-align:middle;border-color:#FFF #FFF #000 #FFF;">內部議題-S(優勢)</td>
						</tr>
						<tr style="border:none">
							<td style="border:none"><div style="border:none;background-color:transparent;color:#000;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;font-family:PMingLiU;word-wrap:break-word;"><?= isset($item) ? trim($item -> m_swot_s) : '' ?></div></td>
						</tr>
					</table>
				</td>
				<td colspan="1" valign="top" class="td_table col-xs-4">
					<table class="swot_table" width="100%" height="100%"  align="center">
						<tr>
							<td style="text-align:center;vertical-align:middle;border-color:#FFF #FFF #000 #FFF;">內部議題-W(劣勢)</td>
						</tr>
						<tr style="border:none">
							<td style="border:none"><div style="border:none;background-color:transparent;color:#000;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;font-family:PMingLiU;word-wrap:break-word;"><?= isset($item) ? trim($item -> m_swot_w) : '' ?></div></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr >
				<td colspan="1" valign="top" class="td_table col-xs-4">
					<table class="swot_table" width="100%" height="100%"  align="center">
						<tr>
							<td style="text-align:center;vertical-align:middle;border-color:#FFF #FFF #000 #FFF;">外部議題-O(機會)</td>
						</tr>
						<tr style="border:none">
							<td style="border:none;"><div style="border:none;background-color:transparent;color:#000;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;font-family:PMingLiU;word-wrap:break-word;"><?= isset($item) ? trim($item -> m_swot_o): '' ?></div></td>
						</tr>
					</table>
				</td>
				<td colspan="1" valign="top" class="td_table col-xs-4">
					<table class="swot_table" width="100%" height="100%"  align="center">
						<tr>
							<td style="text-align:center;vertical-align:middle;border-color:#FFF #FFF #000 #FFF;">SO策略(優勢+機會)</td>
						</tr>
						<tr style="border:none">
							<td style="border:none;"><div style="border:none;background-color:transparent;color:#000;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;font-family:PMingLiU;word-wrap:break-word;"><?= isset($item) ? trim($item -> m_swot_s_o) : '' ?></div></td>
						</tr>
					</table>
				</td>
				<td colspan="1" valign="top" class="td_table col-xs-4">
					<table class="swot_table" width="100%" height="100%"  align="center">
						<tr>
							<td style="text-align:center;vertical-align:middle;border-color:#FFF #FFF #000 #FFF;">WO策略(劣勢+機會)</td>
						</tr>
						<tr style="border:none">
							<td style="border:none;"><div style="border:none;background-color:transparent;color:#000;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;font-family:PMingLiU;word-wrap:break-word;"><?= isset($item) ? trim($item -> m_swot_w_o): '' ?></div></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr >
				<td colspan="1" valign="top" class="td_table col-xs-4">
					<table class="swot_table" width="100%" height="100%"  align="center">
						<tr>
							<td style="text-align:center;vertical-align:middle;border-color:#FFF #FFF #000 #FFF;">外部議題-T(威脅)</td>
						</tr>
						<tr style="border:none">
							<td style="border:none;"><div style="border:none;background-color:transparent;color:#000;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;font-family:PMingLiU;word-wrap:break-word;"><?= isset($item) ? trim($item -> m_swot_t) : '' ?></div></td>
						</tr>
					</table>
				</td>
				<td colspan="1" valign="top"class="td_table col-xs-4">
					<table class="swot_table" width="100%" height="100%"  align="center">
						<tr>
							<td style="text-align:center;vertical-align:middle;border-color:#FFF #FFF #000 #FFF;">ST策略(優勢+威脅)</td>
						</tr>
						<tr style="border:none">
							<td style="border:none;"><div style="border:none;background-color:transparent;color:#000;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;font-family:PMingLiU;word-wrap:break-word;"><?= isset($item) ? trim($item -> m_swot_s_t) : '' ?></div></td>
						</tr>
					</table>
				</td>
				<td colspan="1" valign="top" class="td_table col-xs-4">
					<table class="swot_table" width="100%" height="100%"  align="center">
						<tr>
							<td style="text-align:center;vertical-align:middle;border-color:#FFF #FFF #000 #FFF;">WT策略(劣勢+威脅)</td>
						</tr>
						<tr style="border:none">
							<td style="border:none;"><div style="border:none;background-color:transparent;color:#000;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;font-family:PMingLiU;word-wrap:break-word;"><?= isset($item) ? trim($item -> m_swot_w_t): '' ?></div></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr style="border:none;" >
				<td colspan="1" valign="top" class="td_table col-xs-4" style="border:none;" >
				</td>
				<td colspan="1" valign="top" class="td_table col-xs-4" style="border:none;" >
					<span style="text-align:right;font:14px;">管理代表：</span>
				</td>
				<td colspan="1" valign="top" class="td_table col-xs-4" style="text-align:right;border:none;" >
					<div  style="text-align:left;font-family:PMingLiU;font:14px;" >製表：<?= isset($item) ? trim($item -> make_user) : '' ?></div>
					<div style="text-align:right;padding:0px 40px 0px 0px;font:14px;">RA2602-A</div>
				</td>
			</tr>
		</tbody>
	</table>

</div>
