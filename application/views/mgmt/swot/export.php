
<?php $this->load->view('layout/head'); ?>
<style>
/* #header { 
	width: 300px;height: 300px  !important;
} */
@media print  
{
    div{
        page-break-inside: avoid;
    }
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
				<td ></td>
				<td ><span style="border-style:none;background-color:transparent;color:#666666;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;word-wrap:break-word;white-space:pre-wrap;"><?= isset($item) ? $item -> m_swot_s : '' ?></span></td>
				<td ><span style="border-style:none;background-color:transparent;color:#666666;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;word-wrap:break-word;white-space:pre-wrap;"><?= isset($item) ? $item -> m_swot_w : '' ?></span></td>
			</tr>
			<tr>
				<td ><span style="border-style:none;background-color:transparent;color:#666666;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;word-wrap:break-word;white-space:pre-wrap;"><?= isset($item) ? $item -> m_swot_o : '' ?></span></td>
				<td ><span style="border-style:none;background-color:transparent;color:#666666;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;word-wrap:break-word;white-space:pre-wrap;"><?= isset($item) ? $item -> m_swot_s_o : '' ?></span></td>
				<td ><span style="border-style:none;background-color:transparent;color:#666666;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;word-wrap:break-word;white-space:pre-wrap;"><?= isset($item) ? $item -> m_swot_w_o : '' ?></span></td>
			</tr>
			<tr>
				<td ><span style="border-style:none;background-color:transparent;color:#666666;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;word-wrap:break-word;white-space:pre-wrap;"><?= isset($item) ? $item -> m_swot_t : '' ?></span></td>
				<td ><span style="border-style:none;background-color:transparent;color:#666666;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;word-wrap:break-word;white-space:pre-wrap;"><?= isset($item) ? $item -> m_swot_s_t : '' ?></span></td>
				<td ><span style="border-style:none;background-color:transparent;color:#666666;font:14px Helvetica Neue,Helvetica,PingFang SC,\5FAE\8F6F\96C5\9ED1,Tahoma,Arial,sans-serif;word-wrap:break-word;white-space:pre-wrap;"><?= isset($item) ? $item -> m_swot_w_t : '' ?></span></td>
			</tr>
		</tbody>
	</table>
</div>
<!-- end widget -->

<script>

	function line(header,line_width,line_color,line_number){
		var table = document.getElementById(header); 
		var xpos = table.clientWidth;
		var ypos = table.clientHeight;
		var canvas = document.getElementById('line');
		if(canvas.getContext){
			var ctx = canvas.getContext('2d');
			ctx.clearRect(0,0,xpos,ypos); 
			ctx.fill();
			ctx.lineWidth = line_width;
			ctx.strokeStyle = line_color;
			ctx.beginPath();
			switch(line_number){
				case 1:
					ctx.moveTo(0,0);
					ctx.lineTo(xpos,ypos);
					break;
				case 2:
					ctx.moveTo(0,0);
					ctx.lineTo(xpos/2,ypos);
					ctx.moveTo(0,0);
					ctx.lineTo(xpos,ypos/2);
					break;
				case 3:
					ctx.moveTo(0,0);
					ctx.lineTo(xpos,ypos);
					ctx.moveTo(0,0);
					ctx.lineTo(xpos/2,ypos);
					ctx.moveTo(0,0);
					ctx.lineTo(xpos,ypos/2);
					break;
				default:
				return 0;	
			}
					
			ctx.stroke();
			ctx.closePath();
			document.getElementById(header).style.backgroundImage = 'url("' + ctx.canvas.toDataURL() + '")';
			// document.getElementById(header).style.background-attachment = 'fixed';
		}
	}
	window.onload = function (){ 
		line('header',2,'black',1);
		window.onresize = function(){
			line('header',2,'black',1);
		}
	}


</script>
