
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


</style>
<!-- Widget ID (each widget will need unique ID)-->
<div class="" style="padding:50px 50px 50px 50px;">
<canvas id="line" style="display:none;"></canvas>

	<table  class="layui-table" width="70%">
		<thead>
		
		</thead>
		<tbody class="">
			<tr>
				<td class="min100" colspan="12" style="text-align:center;vertical-align:middle;">寬仕工業股份有限公司</td>
			</tr>
			<tr>
				<td class="min100" colspan="12" style="text-align:center;vertical-align:middle;">SWOT分析表-<?= date('Ymd')?></td>
			</tr>
			<tr>
				<td id="header"  align='left'>
					<!-- <div style="font-size:27px" >
						<span>SW</span> <span>OT</span>
					</div> -->
				</td>
				<td >123</td>
				<td >123</td>
			</tr>
			<tr>
				<td >123</td>
				<td >123</td>
				<td >123</td>
			</tr>
			<tr>
				<td >123</td>
				<td >123</td>
				<td >123</td>
			</tr>
		</tbody>
	</table>
</div>
<!-- end widget -->

<script>
function line(header,line_width,line_color,line_number){//该方法不用动
	var table = document.getElementById(header); 
	var xpos = table.clientWidth;
	var ypos = table.clientHeight;
	var canvas = document.getElementById('line');
	if(canvas.getContext){
		var ctx = canvas.getContext('2d');
		ctx.clearRect(0,0,xpos,ypos); //清空画布，多个表格时使用
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
	line('header',0.5,'black',0.5);
	
}
window.onresize = function(){
	line('header',0.5,'black',0.5);

}
</script>
