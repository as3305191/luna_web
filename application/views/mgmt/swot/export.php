
<?php $this->load->view('layout/head'); ?>
<style>
/* .swot_table{ 
	border-style:none !important;
} */

tbody tr td {
 	padding: 0px 0px 0px 0px !important;
}

@media print  
{
    /* div{
        page-break-inside: avoid;
    } */
}


</style>
<!-- Widget ID (each widget will need unique ID)-->
<div class="" style="padding:50px 50px 50px 50px;">
<canvas id="line" style="display:none;"></canvas>

	<table  class="layui-table" width="70%">
		<thead>
		</thead>
		<tbody class="">
			<tr>
				<td class="min100" colspan="3" style="text-align:center;vertical-align:middle;">寬仕工業股份有限公司</td>
			</tr>
			<tr>
				<td class="min100" colspan="3" style="text-align:center;vertical-align:middle;">SWOT分析表-<?= date('Ymd')?></td>
			</tr>
			<tr>
				<td style=""><img src="<?= base_url("api/images/get/603")?>" style="min-width:100%;min-height: 100%;-webkit-background-size:cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;" ></td>
				<td valign="top">
					<table class="swot_table" width="100%" height="100%"  align="center" border-size="none">
						<tr >
							<td style="text-align:center;vertical-align:middle;">s</td>
						</tr>
						<tr style="border-style:none">
							<td style="border-style:none"><div style="border-style:none;background-color:transparent;color:#666666;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;word-wrap:break-word;white-space:pre-wrap;object-fit:cover;"><?= isset($item) ? $item -> m_swot_s : '' ?></div></td>
						</tr>
					</table>
				</td>
				<td  valign="top">
					<table class="swot_table" width="100%" height="100%"  align="center">
						<tr>
							<td style="text-align:center;vertical-align:middle;">w</td>
						</tr>
						<tr style="border-style:none">
							<td style="border-style:none"><div style="border-style:none;background-color:transparent;color:#666666;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;word-wrap:break-word;white-space:pre-wrap;"><?= isset($item) ? $item -> m_swot_w : '' ?></div></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td valign="top">
					<table class="swot_table" width="100%" height="100%"  align="center">
						<tr>
							<td style="text-align:center;vertical-align:middle;">o</td>
						</tr>
						<tr style="border-style:none">
							<td><div style="border-style:none;background-color:transparent;color:#666666;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;word-wrap:break-word;white-space:pre-wrap;"><?= isset($item) ? $item -> m_swot_o : '' ?></div></td>
						</tr>
					</table>
				</td>
				<td valign="top">
					<table class="swot_table" width="100%" height="100%"  align="center">
						<tr>
							<td style="text-align:center;vertical-align:middle;">so</td>
						</tr>
						<tr style="border-style:none">
							<td><div style="border-style:none;background-color:transparent;color:#666666;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;word-wrap:break-word;white-space:pre-wrap;"><?= isset($item) ? $item -> m_swot_s_o : '' ?></div></td>
						</tr>
					</table>
				</td>
				<td valign="top">
					<table class="swot_table" width="100%" height="100%"  align="center">
						<tr>
							<td style="text-align:center;vertical-align:middle;">wo</td>
						</tr>
						<tr style="border-style:none">
							<td><div style="border-style:none;background-color:transparent;color:#666666;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;word-wrap:break-word;white-space:pre-wrap;"><?= isset($item) ? $item -> m_swot_w_o : '' ?></div></td>
						</tr>
					</table>
				</td>
				
			</tr>
			<tr>
				<td valign="top">
					<table class="swot_table" width="100%" height="100%"  align="center">
						<tr>
							<td style="text-align:center;vertical-align:middle;">t</td>
						</tr>
						<tr style="border-style:none">
							<td><div style="border-style:none;background-color:transparent;color:#666666;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;word-wrap:break-word;white-space:pre-wrap;"><?= isset($item) ? $item -> m_swot_t : '' ?></div></td>
						</tr>
					</table>
				</td>
				<td valign="top">
					<table class="swot_table" width="100%" height="100%"  align="center">
						<tr>
							<td style="text-align:center;vertical-align:middle;">st</td>
						</tr>
						<tr style="border-style:none">
							<td><div style="border-style:none;background-color:transparent;color:#666666;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;word-wrap:break-word;white-space:pre-wrap;"><?= isset($item) ? $item -> m_swot_s_t : '' ?></div></td>
						</tr>
					</table>
				</td>
				<td valign="top">
					<table class="swot_table" width="100%" height="100%"  align="center">
						<tr>
							<td style="text-align:center;vertical-align:middle;">wt</td>
						</tr>
						<tr style="border-style:none">
							<td><div style="border-style:none;background-color:transparent;color:#666666;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;word-wrap:break-word;white-space:pre-wrap;"><?= isset($item) ? $item -> m_swot_w_t : '' ?></div></td>
						</tr>
					</table>
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
