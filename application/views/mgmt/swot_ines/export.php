
<meta charset="utf-8">
<meta name="description" content="">
<meta name="author" content="">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<!-- <meta name=”google-site-verification” content=”4AWlkYHST6nMramtRF-oITkJO3oojQ5pZLS_YbiocQU” /> -->

<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<link rel="stylesheet" type="text/css" media="all" href="<?= base_url('css/bootstrap.min.css') ?>">
<link rel="stylesheet" type="text/css" media="all" href="<?= base_url('css/font-awesome.min.css') ?>">

<!-- bootstrap fileinput -->
<link href="<?= base_url('js/plugin/bootstrap-fileinput/css/fileinput.css') ?>" media="all" rel="stylesheet" type="text/css" />

<!-- bootstrap datetimepicker -->
<link href="<?= base_url('js/plugin/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') ?>" media="all" rel="stylesheet" type="text/css" />

<!-- datatables -->
<link href="<?= base_url('js/plugin/datatable-scroller/css/scroller.bootstrap.min.css') ?>" media="all" rel="stylesheet" type="text/css" />

<!--  -->
<link rel="stylesheet" type="text/css" media="all" href="<?= base_url('css/smartadmin-production-plugins.min.css') ?>">
<link rel="stylesheet" type="text/css" media="all" href="<?= base_url('css/smartadmin-production.min.css') ?>">
<link rel="stylesheet" type="text/css" media="all" href="<?= base_url('css/smartadmin-skins.min.css') ?>">

<!-- SmartAdmin RTL Support -->
<link rel="stylesheet" type="text/css" media="screen" href="<?= base_url('css/smartadmin-rtl.min.css') ?>">

<link rel="stylesheet" type="text/css" media="screen" href="<?= base_url('css/my.css') ?>">

<!-- #FAVICONS -->
<link rel="icon" type="image/png" href="<?= base_url('img/ktx_img/logo_1.png')  ?>" />

<!-- #APP SCREEN / ICONS -->
<!-- Specifying a Webpage Icon for Web Clip
Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
<link rel="apple-touch-icon" href="<?= base_url('img/splash/sptouch-icon-iphone.png')?>">
<link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('img/splash/touch-icon-ipad.png') ?>">
<link rel="apple-touch-icon" sizes="120x120" href="<?= base_url('img/splash/touch-icon-iphone-retina.png') ?>">
<link rel="apple-touch-icon" sizes="152x152" href="<?= base_url('img/splash/touch-icon-ipad-retina.png') ?>">


<!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">


<link rel="stylesheet" href="<?= base_url('js/layui/dist/css/layui.css') ?>">
<style>
td{
	height:1px;
}

.layui-table1{ 
	/* border-style:groove !important; */
	margin: 0px 100px 0px 10px !important;
}
.td_table{
 	padding: 0px!important;
	border-color:#000 !important;
}
.pageDiv{
        position:relative;
        background-repeat:no-repeat;
        background-position: center;
        page-break-after: always;  
		page-break-inside: avoid;
    }
.pageDiv:last-of-type{ 
	page-break-after: auto; 
}

td > div{
	height: 100%!important;

}
  /*模擬對角線*/
  .out{
		border-top:#fff solid;/*上邊框寬度等於表格第一行行高*/
		border-left: #fff solid;/*左邊框寬度等於表格第一行第一格寬度*/
		position:relative;/*讓裡面的兩個子容器絕對定位*/
		top:120px
	}
	b{font-style:normal;display:block;position:absolute;width:35px;
	top:0;
	right:0;
	z-index:300;}
	em{font-style:normal;display:block;position:absolute;bottom:0px;left:0;width:55x;}

@page {
	margin: 10px 100px 0px 0px !important;
}
@media print{
	*{
		-webkit-print-color-adjust: exact !important;
	}

	.layui-table1{ 
		/* border-style:groove !important; */
		margin: 20px 100px 10px 10px !important;
	}

	.td_table{
		padding: 0px!important;
		border-color:#000 !important;
	}

	.pageDiv{
        position:relative;
        background-repeat:no-repeat;
        background-position: center;
        page-break-after: always;  
		page-break-inside: avoid;
    }

	.pageDiv:last-of-type{ 
		page-break-after: auto; 
	}	


	.noBreak {
		break-inside: avoid;
	}
}
</style>
<!-- Widget ID (each widget will need unique ID)-->
<div class="ex_page " style="padding:20px 20px 20px 20px;" width="70%">
<?php if(!empty( $item -> unify) && $item -> unify>0 && $item -> class_id==3): ?>

	<table class="noBreak layui-table pageDiv layui-table1" style="border-color:#000;padding:0px 30px 0px 30px;pointer-events: none;" >
			<tbody class="" width="100%">
				<tr>
					<td class="" colspan="3" style="border:none;text-align:center;vertical-align:middle;">
						<div style="border:none;text-align:center;vertical-align:middle;font-weight:bold;font-size:250%;padding:50px 50px 30px 50px;color:#000">寬仕工業股份有限公司</div>
						<?php if(!empty( $item -> unify) && $item -> unify>0): ?>
							<div style="text-align:center;vertical-align:middle;font-weight:bold;font-size:150%;padding:0px 0px 0px 0px;color:#000"><?= isset($item) ? $item -> d_or_c_name.'(整合)' : '' ?>-<?= isset($item) ? $item -> s_title_name : '' ?>-<?= date('Ymd')?></div>
						<?php else: ?>
							<div style="text-align:center;vertical-align:middle;font-weight:bold;font-size:150%;padding:0px 0px 0px 0px;color:#000"><?= isset($item) ? $item -> d_or_c_name : '' ?>-<?= isset($item) ? $item -> s_title_name : '' ?>-<?= date('Ymd')?></div>
						<?php endif?>
						<div style="text-align:right;color:#000;font-size:125%">文件種類：<?= isset($item) ? $item -> s_style_name : ''?></div>
					</td>
				</tr>
				<tr class="noBreak">
					<td colspan="1" class="noBreak td_table col-xs-4">
						<table class="swot_table" width="100%" height="100%"  align="center">
							<tr >

									<div class="out">
										<b>類別</b>
										<em>姓名</em>
									</div>	
					
							</tr>

						</table>
					</td>
					<td colspan="1" valign="top" class="noBreak td_table col-xs-4">
						<table class="swot_table" width="100%" height="100%"  align="center">
							<tr >
								<td style="text-align:center;vertical-align:middle;border-color:#FFF #FFF #000 #FFF;">內部議題-S(優勢)</td>
							</tr>
							<tr style="border:none">
								<td style="border:none"><div style="border:none;color:#000;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;font-family:PMingLiU;word-wrap:break-word;"><?= isset($item) ? trim($item -> m_swot_s) : '' ?></div></td>
							</tr>
						</table>
					</td>
					<td colspan="1" valign="top" class="noBreak td_table col-xs-4">
						<table class="swot_table" width="100%" height="100%"  align="center">
							<tr>
								<td style="text-align:center;vertical-align:middle;border-color:#FFF #FFF #000 #FFF;">內部議題-W(劣勢)</td>
							</tr>
							<tr style="border:none">
								<td style="border:none"><div style="border:none;color:#000;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;font-family:PMingLiU;word-wrap:break-word;"><?= isset($item) ? trim($item -> m_swot_w) : '' ?></div></td>
							</tr>
						</table>
					</td>
				</tr>
			</tbody>

		</table>
		<table class="noBreak layui-table pageDiv layui-table1"   style="border-color:#000;padding:0px 30px 0px 30px;" >
			<tbody class="" width="100%">

				<tr class="noBreak">
					<td colspan="1" valign="top" class="noBreak td_table col-xs-4">
						<table class="swot_table" width="100%" height="100%"  align="center">
							<tr>
								<td style="text-align:center;vertical-align:middle;border-color:#FFF #FFF #000 #FFF;">外部議題-O(機會)</td>
							</tr>
							<tr style="border:none">
								<td style="border:none;"><div style="border:none;color:#000;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;font-family:PMingLiU;word-wrap:break-word;"><?= isset($item) ? trim($item -> m_swot_o): '' ?></div></td>
							</tr>
						</table>
					</td>
					<td colspan="1" valign="top" class="noBreak td_table col-xs-4">
						<table class="swot_table" width="100%" height="100%"  align="center">
							<tr>
								<td style="text-align:center;vertical-align:middle;border-color:#FFF #FFF #000 #FFF;">SO策略(優勢+機會)</td>
							</tr>
							<tr style="border:none">
								<td style="border:none;"><div style="border:none;color:#000;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;font-family:PMingLiU;word-wrap:break-word;"><?= isset($item) ? trim($item -> m_swot_s_o) : '' ?></div></td>
							</tr>
						</table>
					</td>
					<td colspan="1" valign="top" class="noBreak td_table col-xs-4">
						<table class="swot_table" width="100%" height="100%"  align="center">
							<tr>
								<td style="text-align:center;vertical-align:middle;border-color:#FFF #FFF #000 #FFF;">WO策略(劣勢+機會)</td>
							</tr>
							<tr style="border:none">
								<td style="border:none;"><div style="border:none;color:#000;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;font-family:PMingLiU;word-wrap:break-word;"><?= isset($item) ? trim($item -> m_swot_w_o): '' ?></div></td>
							</tr>
						</table>
					</td>
				</tr>
			</tbody>

		</table>

		<table class="noBreak layui-table pageDiv layui-table1"   style="border-color:#000;padding:0px 30px 0px 30px;" >
			<tbody class="" width="100%">

				<tr class="noBreak">
					<td colspan="1" valign="top" class="noBreak td_table col-xs-4">
						<table class="swot_table" width="100%" height="100%"  align="center">
							<tr>
								<td style="text-align:center;vertical-align:middle;border-color:#FFF #FFF #000 #FFF;">外部議題-T(威脅)</td>
							</tr>
							<tr style="border:none">
								<td style="border:none;"><div style="border:none;color:#000;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;font-family:PMingLiU;word-wrap:break-word;"><?= isset($item) ? trim($item -> m_swot_t) : '' ?></div></td>
							</tr>
						</table>
					</td>
					<td colspan="1" valign="top"class="noBreak td_table col-xs-4">
						<table class="swot_table" width="100%" height="100%"  align="center">
							<tr>
								<td style="text-align:center;vertical-align:middle;border-color:#FFF #FFF #000 #FFF;">ST策略(優勢+威脅)</td>
							</tr>
							<tr style="border:none">
								<td style="border:none;"><div style="border:none;color:#000;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;font-family:PMingLiU;word-wrap:break-word;"><?= isset($item) ? trim($item -> m_swot_s_t) : '' ?></div></td>
							</tr>
						</table>
					</td>
					<td colspan="1" valign="top" class="noBreak td_table col-xs-4">
						<table class="swot_table" width="100%" height="100%"  align="center">
							<tr>
								<td style="text-align:center;vertical-align:middle;border-color:#FFF #FFF #000 #FFF;">WT策略(劣勢+威脅)</td>
							</tr>
							<tr style="border:none">
								<td style="border:none;"><div style="border:none;color:#000;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;font-family:PMingLiU;word-wrap:break-word;"><?= isset($item) ? trim($item -> m_swot_w_t): '' ?></div></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr style="border:none;" >
					<td colspan="1" valign="top" class="td_table col-xs-4" style="border:none;" >
					</td>
					<td colspan="1" valign="top" class="td_table col-xs-4" style="border:none;" >
						<span style="text-align:right;font-size:125%;color:#000;">管理代表：<?= isset($item) ? trim($item -> swot_leader) : '' ?></span>
					</td>
					<td colspan="1" valign="top" class="td_table col-xs-4" style="text-align:right;border:none;" >
						<div  style="text-align:left;font-size:125%;color:#000;" >製表：<?= isset($item) ? trim($item -> make_user) : '' ?></div>
						<div style="text-align:right;padding:0px 40px 0px 0px;font-size:125%;color:#000;">RA2602-A</div>
					</td>
				</tr>
		</tbody>
	</table>
	<?php else: ?>
		<table class="noBreak layui-table pageDiv layui-table1"   style="border-color:#000;padding:0px 30px 0px 30px;pointer-events: none;" >
			<tbody class="" width="100%">
				<tr>
					<td class="" colspan="3" style="border:none;text-align:center;vertical-align:middle;">
						<div style="border:none;text-align:center;vertical-align:middle;font-weight:bold;font-size:250%;padding:50px 50px 30px 50px;color:#000">寬仕工業股份有限公司</div>
						<?php if(!empty( $item -> unify) && $item -> unify>0): ?>
							<div style="text-align:center;vertical-align:middle;font-weight:bold;font-size:150%;padding:0px 0px 0px 0px;color:#000"><?= isset($item) ? $item -> d_or_c_name.'(整合)' : '' ?>-<?= isset($item) ? $item -> s_title_name : '' ?>-<?= date('Ymd')?></div>
						<?php else: ?>
							<div style="text-align:center;vertical-align:middle;font-weight:bold;font-size:150%;padding:0px 0px 0px 0px;color:#000"><?= isset($item) ? $item -> d_or_c_name : '' ?>-<?= isset($item) ? $item -> s_title_name : '' ?>-<?= date('Ymd')?></div>
						<?php endif?>
						<div style="text-align:right;color:#000;font-size:125%">文件種類：<?= isset($item) ? $item -> s_style_name : ''?></div>
					</td>
				</tr>
				<tr class="noBreak">
					<td colspan="1" class="noBreak td_table col-xs-4">
						<table class="swot_table" width="100%" height="100%"  align="center">
							<tr >

								<div class="out">
									<b>類別</b>
									<em>姓名</em>
								</div>	
				
							</tr>					
						</table>
					</td>
					<td colspan="1" valign="top" class="noBreak td_table col-xs-4">
						<table class="swot_table" width="100%" height="100%"  align="center">
							<tr >
								<td style="text-align:center;vertical-align:middle;border-color:#FFF #FFF #000 #FFF;">內部議題-S(優勢)</td>
							</tr>
							<tr style="border:none">
								<td style="border:none"><div style="border:none;color:#000;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;font-family:PMingLiU;word-wrap:break-word;"><?= isset($item) ? trim($item -> m_swot_s) : '' ?></div></td>
							</tr>
						</table>
					</td>
					<td colspan="1" valign="top" class="noBreak td_table col-xs-4">
						<table class="swot_table" width="100%" height="100%"  align="center">
							<tr>
								<td style="text-align:center;vertical-align:middle;border-color:#FFF #FFF #000 #FFF;">內部議題-W(劣勢)</td>
							</tr>
							<tr style="border:none">
								<td style="border:none"><div style="border:none;color:#000;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;font-family:PMingLiU;word-wrap:break-word;"><?= isset($item) ? trim($item -> m_swot_w) : '' ?></div></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr class="noBreak">
					<td colspan="1" valign="top" class="noBreak td_table col-xs-4">
						<table class="swot_table" width="100%" height="100%"  align="center">
							<tr>
								<td style="text-align:center;vertical-align:middle;border-color:#FFF #FFF #000 #FFF;">外部議題-O(機會)</td>
							</tr>
							<tr style="border:none">
								<td style="border:none;"><div style="border:none;color:#000;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;font-family:PMingLiU;word-wrap:break-word;"><?= isset($item) ? trim($item -> m_swot_o): '' ?></div></td>
							</tr>
						</table>
					</td>
					<td colspan="1" valign="top" class="noBreak td_table col-xs-4">
						<table class="swot_table" width="100%" height="100%"  align="center">
							<tr>
								<td style="text-align:center;vertical-align:middle;border-color:#FFF #FFF #000 #FFF;">SO策略(優勢+機會)</td>
							</tr>
							<tr style="border:none">
								<td style="border:none;"><div style="border:none;color:#000;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;font-family:PMingLiU;word-wrap:break-word;"><?= isset($item) ? trim($item -> m_swot_s_o) : '' ?></div></td>
							</tr>
						</table>
					</td>
					<td colspan="1" valign="top" class="noBreak td_table col-xs-4">
						<table class="swot_table" width="100%" height="100%"  align="center">
							<tr>
								<td style="text-align:center;vertical-align:middle;border-color:#FFF #FFF #000 #FFF;">WO策略(劣勢+機會)</td>
							</tr>
							<tr style="border:none">
								<td style="border:none;"><div style="border:none;color:#000;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;font-family:PMingLiU;word-wrap:break-word;"><?= isset($item) ? trim($item -> m_swot_w_o): '' ?></div></td>
							</tr>
						</table>
					</td>
				</tr>
		

				<tr class="noBreak">
					<td colspan="1" valign="top" class="noBreak td_table col-xs-4">
						<table class="swot_table" width="100%" height="100%"  align="center">
							<tr>
								<td style="text-align:center;vertical-align:middle;border-color:#FFF #FFF #000 #FFF;">外部議題-T(威脅)</td>
							</tr>
							<tr style="border:none">
								<td style="border:none;"><div style="border:none;color:#000;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;font-family:PMingLiU;word-wrap:break-word;"><?= isset($item) ? trim($item -> m_swot_t) : '' ?></div></td>
							</tr>
						</table>
					</td>
					<td colspan="1" valign="top"class="noBreak td_table col-xs-4">
						<table class="swot_table" width="100%" height="100%"  align="center">
							<tr>
								<td style="text-align:center;vertical-align:middle;border-color:#FFF #FFF #000 #FFF;">ST策略(優勢+威脅)</td>
							</tr>
							<tr style="border:none">
								<td style="border:none;"><div style="border:none;color:#000;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;font-family:PMingLiU;word-wrap:break-word;"><?= isset($item) ? trim($item -> m_swot_s_t) : '' ?></div></td>
							</tr>
						</table>
					</td>
					<td colspan="1" valign="top" class="noBreak td_table col-xs-4">
						<table class="swot_table" width="100%" height="100%"  align="center">
							<tr>
								<td style="text-align:center;vertical-align:middle;border-color:#FFF #FFF #000 #FFF;">WT策略(劣勢+威脅)</td>
							</tr>
							<tr style="border:none">
								<td style="border:none;"><div style="border:none;color:#000;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;font-family:PMingLiU;word-wrap:break-word;"><?= isset($item) ? trim($item -> m_swot_w_t): '' ?></div></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr style="border:none;" >
					<td colspan="1" valign="top" class="td_table col-xs-4" style="border:none;" >
					</td>
					<td colspan="1" valign="top" class="td_table col-xs-4" style="border:none;" >
						<span style="text-align:right;font-size:125%;color:#000;">管理代表：<?= isset($item) ? trim($item -> swot_leader) : '' ?></span>
					</td>
					<td colspan="1" valign="top" class="td_table col-xs-4" style="text-align:right;border:none;" >
						<div  style="text-align:left;font-size:125%;color:#000;" >製表：<?= isset($item) ? trim($item -> make_user) : '' ?></div>
						<div style="text-align:right;padding:0px 40px 0px 0px;font-size:125%;color:#000;">RA2602-A</div>
					</td>
				</tr>
		</tbody>
	</table>
	<?php endif?>
</div>
