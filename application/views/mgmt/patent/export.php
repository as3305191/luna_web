<!DOCTYPE html>
<html lang="en-us">
<head>
		<?php $this->load->view('layout/head'); ?>
		<script>
			var baseUrl = '<?= base_url(); ?>';
			var currentApp;


			/* utilities */
			function numberWithCommas(x) {
			  if(!x) {
			  	return 0;
			  }
			  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
			}
		</script>
	</head>
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
<div class="jarviswidget" id="wid-id-7" data-widget-colorbutton="false"	data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
	<header>
		<div class="widget-toolbar pull-left">
			<a href="javascript:void(0);" id="back_parent" onclick="currentApp.backTo()" class="btn btn-default">
				<i class="fa fa-arrow-circle-left"></i>返回
			</a>
		</div>
		<?php if($login_user->role_id==52 ||$login_user->role_id==26): ?>
		<div class="widget-toolbar pull-left">
			<a href="javascript:void(0);" id="" onclick="do_save();" class="btn btn-default btn-danger">
				<i class="fa fa-save"></i>存檔
			</a>
		</div>
		<?php endif?>
		<?php if(isset($item) && $item->id>0): ?>
			<div class="widget-toolbar pull-right">
				<div class="btn-group">
					<button onclick="currentApp.doExportAll(<?=$item -> id ?>)" class="btn dropdown-toggle btn-xs btn-warning" data-toggle="dropdown">
						<i class="fa fa-save"></i>匯出
					</button>
				</div>
			</div>
		<?php endif?>
	</header>
	<!-- widget div-->
	<div>
		<!-- widget edit box -->
		<div class="jarviswidget-editbox">
			<!-- This area used as dropdown edit box -->
			<input class="form-control" type="text">
		</div>
		<!-- end widget edit box -->
		<!-- widget content -->
    </div>
	<table id="export_table_list" class="table table-striped table-bordered table-hover" width="100%">
		<thead>
			<tr>
				<th class="min25"></th>
				<th class="min100">專利名稱</th>
				<th class="min100">代表圖</th>
				<th class="min100">申請人</th>
				<th class="min100">發明人</th>
				<th class="min100">申請號</th>
				<th class="min100">公開號</th>
				<th class="min100">申請日</th>
				<th class="min100">公告日</th>
				<th class="min100">更新日</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>

</div>
<!-- end widget -->
<script src="http://www.appelsiini.net/download/jquery.jeditable.mini.js"></script>

<style>
	.kv-file-zoom {
		display: none;
	}	
</style>

<script>
var current_app = [];
$(document).ready(function() {
	if($('#item_id').val()==0){
		var url = baseUrl + 'mgmt/patent/new_patent_family'; // the script where you handle the form input.
		$.ajax({
			type : "POST",
			url : url,
			// data : {},
			success : function(d) {
				$('#patent_family').val(d.family_num);
			}
		});
	} 
});

$('#app-edit-form').bootstrapValidator({
		feedbackIcons : {
			valid : 'glyphicon glyphicon-ok',
			invalid : 'glyphicon glyphicon-remove',
			validating : 'glyphicon glyphicon-refresh'
		},
		fields: {
			account: {
				validators: {
					remote: {
						message: '已經存在',
						url: baseUrl + 'mgmt/users/check_account/' + ($('#item_id').val().length > 0 ? $('#item_id').val() : '0')
					}
				}
			 }
      	}

	}).bootstrapValidator('validate');


var img=false,pdf_array=false,public_num_input=false,patnet_num_input=false;


function check_family(){
	var url = baseUrl + 'mgmt/patent/check_family'; 
	$.ajax({
		type : "POST",
		url : url,
		data : {
			patent_family: $('#patent_family').val(),
		},
		success : function(d) {
			if(d.valid=='TRUE'){//沒有重複
				$('#patent_family').removeClass('not_ok');
				$('#patent_family').addClass('is_ok');
			} else{//有重複
				$('#patent_family').removeClass('is_ok');
				$('#patent_family').addClass('not_ok');
			}
		}
	});
}

$('#add_country').click(function() {
	layer.open({
		type:2,
		title:'',
		closeBtn:0,
		area:['400px','200px'],
		shadeClose:true,
		content:'<?=base_url('mgmt/patent/new_country')?>'
    })
})

function load_country() {
	$.ajax({
			url: '<?= base_url() ?>' + 'mgmt/patent/find_country',
			type: 'POST',
			data: {},
			dataType: 'json',
			success: function(d) {
				if(d) {
					// console.log(d);
					$patnet_country = $('#patent_country').empty();
					$.each(d.country, function(){
						if(this.id==$('#p_country').val()){
							$('<option/>', {
								'value': this.id,
								'text': this.country_name
							}).attr("selected", true).appendTo($patnet_country);
						}else{
							$('<option/>', {
								'value': this.id,
								'text': this.country_name
							}).appendTo($patnet_country);
						}
										
					});
				}
			},
			failure:function(){
				alert('faialure');
			}
		});

}
// load_country();


	var total_edit_category=0;
	function load_edit_category() {
		$.ajax({
				url: '<?= base_url() ?>' + 'mgmt/patent/find_all_category',
				type: 'POST',
				data: {},
				dataType: 'json',
				success: function(d) {
					if(d) {
						// console.log(d);
						$category = $('#patnet_status').empty();
						var i=0;
						var html='';
						total_edit_category = d.max;
						for(i;i<=d.max;i++){
							if($('#role_id').val()=='52'||$('#role_id').val()=='26'){
							

								html+='<div class="widget-toolbar pull-left">'+
										'<select id="patnet_status_'+i+'" class="p_patnet_status form-control" data-val="'+i+'" >'+
											'<option value="all">全部</option>'+
										'</select>'+
									'</div>';
								
							} else{
							
								html+='<div class="widget-toolbar pull-left">'+
											'<select id="patnet_status_'+i+'" class="p_patnet_status form-control" data-val="'+i+'" disabled>'+
												'<option value="all">全部</option>'+
											'</select>'+
										'</div>';
							}
							
						}
						$(html).appendTo($category);
						$.each(d.category, function(){
							var level = this.level;
								if($('#role_id').val()=='52'||$('#role_id').val()=='26'){
									
									if(current_app[0]['patnet_status_'+level] &&current_app[0]['patnet_status_'+level]==this.id){
											$('<option />', {
												'value': this.id,
												'text': this.name,
											}).attr("selected", true).appendTo($('#patnet_status_'+level));										
									} else{
										$('<option />', {
											'value': this.id,
											'text': this.name,
										}).appendTo($('#patnet_status_'+level));
									}
								} else{
									if(current_app[0]['patnet_status_'+level] && current_app[0]['patnet_status_'+level]==this.id){
											$('<option />', {
												'value': this.id,
												'text': this.name,
											}).attr("selected", true).appendTo($('#patnet_status_'+level));
									} else{
										$('<option />', {
											'value': this.id,
											'text': this.name,
										}).appendTo($('#patnet_status_'+level));
									}
									
									$('#patnet_status_'+level).attr("disabled",true);
								}
								
						});

						$('.p_patnet_status').on('change', function(){
							
							var me = $(this);
							var _dataVal = me.data("val");
							var select_Val = me.val();
							$.each(current_app[0], function(key,value){
								var keynum_d_val = $('#'+key).data("val");
								if(keynum_d_val>_dataVal){
									$('#patnet_status_'+keynum_d_val).empty();
									$('<option value="all">全部</option>').appendTo($('#patnet_status_'+keynum_d_val));
								}
							});
							var before_dataVal = _dataVal-1;
							if(select_Val=='all'){
								if(_dataVal>0){
									$('#in_patnet_status').val($('#patnet_status_'+before_dataVal).val());
								}else{
									$('#in_patnet_status').val("0");

								}
							} else{
								$('#in_patnet_status').val(select_Val);
							}
								var next_c =_dataVal+1;
								// console.log(next_c);
								$.ajax({
									url:  baseUrl + 'mgmt/patent/find_next_category',
									type: 'POST',
									data: {
										next_level:next_c,
										this_val:select_Val,
									},
									dataType: 'json',
									success: function(d) {
										var category_option = '<option value="all">全部</option>';
										var $category = $('#patnet_status_'+next_c).empty();
										$category.append(category_option);
										if(d.category){
											$.each(d.category, function(){
												if($('#role_id').val()=='52'||$('#role_id').val()=='26'){

													if(current_app[0]['patnet_status_'+next_c] && current_app[0]['patnet_status_'+next_c]==this.id){
															$('<option />', {
																'value': this.id,
																'text': this.name,
															}).attr("selected", true).appendTo($category);										
													} else{
														$('<option />', {
															'value': this.id,
															'text': this.name,
														}).appendTo($category);
													}

												} else{
													if(current_app[0]['patnet_status_'+next_c] && current_app[0]['patnet_status_'+next_c]==this.id){
															$('<option />', {
																'value': this.id,
																'text': this.name,
															}).attr("selected", true).appendTo($category);									
													} else{
														$('<option />', {
															'value': this.id,
															'text': this.name,
														}).appendTo($category);
													}
													
													$('#patnet_status_'+next_c).attr("disabled",true);
												}
												
											});
											
										}
									},
									failure:function(){
									}
								});

						});
						
						
					}
				},
				failure:function(){
					alert('faialure');
				}
		});

	}	
	load_edit_category();



</script>
