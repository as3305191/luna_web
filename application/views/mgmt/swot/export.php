
<?php $this->load->view('layout/head'); ?>
<style>
.layui-table{ 
	border-style:none !important;
}

@page {
  size: portrait; /* 直向 */
  size: landscape; /* 橫向 */
  size: A4; /* 紙張大小 */
  size: A4 portrait; /* 混合使用 */
  
  margin: 0; /* 邊界與內容的距離 */
}

</style>
<!-- Widget ID (each widget will need unique ID)-->
<div class="ex_page" style="padding:50px 50px 50px 50px;">
	<table  class="layui-table" width="70%">
		<thead>
		</thead>
		<tbody class="">
			<tr>
				<td class="" colspan="3" style="border:none;text-align:center;vertical-align:middle;font-weight:bold;font-size:200%;padding:50px 50px 50px 50px;">寬仕工業股份有限公司</td>
			</tr>
			<tr>
				<td class="" colspan="3" style="border:none;text-align:center;vertical-align:middle;">
					<span style="text-align:center;vertical-align:middle;font-weight:bold;font-size:120%;"><?= isset($item) ? $item -> d_or_c_name : '' ?>-<?= isset($item) ? $item -> s_title_name : '' ?>-<?= date('Ymd')?></span>
					<div style="text-align:right;">文件種類：<?= isset($item) ? $item -> s_style_name : ''?></div>
				</td>
			</tr>
			<tr>
				<td class="td_table"><img src="<?= base_url("api/images/get/603")?>" style="min-width:100%;min-height: 100%;-webkit-background-size:cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;" ></td>
				<td valign="top" class="td_table">
					<table class="swot_table" width="100%" height="100%"  align="center">
						<tr >
							<td style="text-align:center;vertical-align:middle;">內部議題-s(優勢)</td>
						</tr>
						<tr style="border:none">
							<td style="border:none"><div style="border:none;background-color:transparent;color:#666666;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;word-wrap:break-word;white-space:pre-wrap;object-fit:cover;"><?= isset($item) ? str_replace("<br>"," ",trim($item -> m_swot_s)) : '' ?></div></td>
						</tr>
					</table>
				</td>
				<td  valign="top" class="td_table">
					<table class="swot_table" width="100%" height="100%"  align="center">
						<tr>
							<td style="text-align:center;vertical-align:middle;">內部議題-w(劣勢)</td>
						</tr>
						<tr style="border:none">
							<td style="border:none"><div style="border:none;background-color:transparent;color:#666666;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;word-wrap:break-word;white-space:pre-wrap;"><?= isset($item) ? str_replace("<br>"," ",trim($item -> m_swot_w)) : '' ?></div></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td valign="top" class="td_table">
					<table class="swot_table" width="100%" height="100%"  align="center">
						<tr>
							<td style="text-align:center;vertical-align:middle;">外部議題-o(機會)</td>
						</tr>
						<tr style="border:none">
							<td style="border:none;"><div style="border:none;background-color:transparent;color:#666666;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;word-wrap:break-word;white-space:pre-wrap;"><?= isset($item) ? str_replace("<br>"," ",trim($item -> m_swot_o)) : '' ?></div></td>
						</tr>
					</table>
				</td>
				<td valign="top" class="td_table">
					<table class="swot_table" width="100%" height="100%"  align="center">
						<tr>
							<td style="text-align:center;vertical-align:middle;">so策略(優勢+機會)</td>
						</tr>
						<tr style="border:none">
							<td style="border:none;"><div style="border:none;background-color:transparent;color:#666666;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;word-wrap:break-word;white-space:pre-wrap;"><?= isset($item) ? str_replace("<br>"," ",trim($item -> m_swot_s_o)) : '' ?></div></td>
						</tr>
					</table>
				</td>
				<td valign="top" class="td_table">
					<table class="swot_table" width="100%" height="100%"  align="center">
						<tr>
							<td style="text-align:center;vertical-align:middle;">wo策略(劣勢+機會)</td>
						</tr>
						<tr style="border:none">
							<td style="border:none;"><div style="border:none;background-color:transparent;color:#666666;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;word-wrap:break-word;white-space:pre-wrap;"><?= isset($item) ? str_replace("<br>"," ",trim($item -> m_swot_w_o)) : '' ?></div></td>
						</tr>
					</table>
				</td>
				
			</tr>
			<tr>
				<td valign="top" class="td_table">
					<table class="swot_table" width="100%" height="100%"  align="center">
						<tr>
							<td style="text-align:center;vertical-align:middle;">外部議題-t(威脅)</td>
						</tr>
						<tr style="border:none">
							<td style="border:none;"><div style="border:none;background-color:transparent;color:#666666;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;word-wrap:break-word;white-space:pre-wrap;"><?= isset($item) ? str_replace("<br>"," ",trim($item -> m_swot_t)) : '' ?></div></td>
						</tr>
					</table>
				</td>
				<td valign="top"class="td_table">
					<table class="swot_table" width="100%" height="100%"  align="center">
						<tr>
							<td style="text-align:center;vertical-align:middle;">st策略(優勢+威脅)</td>
						</tr>
						<tr style="border:none">
							<td style="border:none;"><div style="border:none;background-color:transparent;color:#666666;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;word-wrap:break-word;white-space:pre-wrap;"><?= isset($item) ? str_replace("<br>"," ",trim($item -> m_swot_s_t)) : '' ?></div></td>
						</tr>
					</table>
				</td>
				<td valign="top" class="td_table">
					<table class="swot_table" width="100%" height="100%"  align="center">
						<tr>
							<td style="text-align:center;vertical-align:middle;">wt策略(劣勢+威脅)</td>
						</tr>
						<tr style="border:none">
							<td style="border:none;"><div style="border:none;background-color:transparent;color:#666666;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;word-wrap:break-word;white-space:pre-wrap;"><?= isset($item) ? str_replace("<br>"," ",trim($item -> m_swot_w_t)) : '' ?></div></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr style="border:none;" >
				<td valign="top" class="td_table" style="border:none;" >
				</td>
				<td valign="top" class="td_table" style="border:none;" >
					<span style="text-align:right;">管理代表：</span>
				</td>
				<td valign="top" class="td_table" style="text-align:right;border:none;" >
					<div  style="text-align:left;">製表：<?= isset($item) ? str_replace("<br>"," ",trim($item -> make_user)) : '' ?></div>
					<div style="text-align:right;">RA2602-1</div>
				</td>
			</tr>
		</tbody>
	</table>

</div>
<!-- end widget -->
<script>
// function line(header,line_width,line_color,line_number){
// 		var table = document.getElementById(header); 
// 		// var xpos = false;var ypos = false;
// 		var xpos = table.clientWidth;
// 		var ypos = table.clientHeight;
// 		var canvas = document.getElementById('line');
// 		if(canvas.getContext){
// 			var ctx = canvas.getContext('2d');
// 			ctx.clearRect(0,0,xpos,ypos); 
// 			ctx.fill();
// 			ctx.lineWidth = line_width;
// 			ctx.strokeStyle = line_color;
// 			ctx.beginPath();
// 			switch(line_number){
// 				case 1:
// 					ctx.moveTo(0,0);
// 					ctx.lineTo(xpos,ypos);
// 					break;
// 				case 2:
// 					ctx.moveTo(0,0);
// 					ctx.lineTo(xpos/2,ypos);
// 					ctx.moveTo(0,0);
// 					ctx.lineTo(xpos,ypos/2);
// 					break;
// 				case 3:
// 					ctx.moveTo(0,0);
// 					ctx.lineTo(xpos,ypos);
// 					ctx.moveTo(0,0);
// 					ctx.lineTo(xpos/2,ypos);
// 					ctx.moveTo(0,0);
// 					ctx.lineTo(xpos,ypos/2);
// 					break;
// 				default:
// 				return 0;	
// 			}
// 			ctx.stroke();
// 			ctx.closePath();
// 			document.getElementById(header).style.backgroundImage = 'url("' + ctx.canvas.toDataURL() + '")';
// 			// document.getElementById(header).style.background-attachment ='fixed';
// 		}
// 	}

	// window.onload = function (){ 
	// 	line('header',1,'black',1);
	// }
	// window.onresize = function(){
	// 	line('header',1,'black',1);
	// }

</script>
