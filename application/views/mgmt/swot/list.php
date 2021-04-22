<style>
thead tr th {
	position:sticky;
	top:0;
	background-color:#FFFFFF !important;
	text-align:center;
}
</style>

<!-- CSS Unify Theme -->
<!-- <link rel="stylesheet" href="<?= base_url() ?>assets_co/assets_/css/styles.multipage-real-estate.css"> -->
  
<div class="tab-content">
	<div class="tab-pane active" id="list_page">

		<!-- widget grid -->
		<section id="widget-grid" class="">
			<!-- row -->
			<div class="row">
				<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget" > 
						<header >
							<div class="widget-toolbar pull-left">
								<div class="btn-group">
									<button onclick="currentApp.doEdit(0)" class="btn btn-xs btn-success" data-toggle="dropdown">
										<i class="fa fa-plus"></i>新增
									</button>
								</div>
							</div>
							<div>
							
								<!-- <div class="widget-toolbar pull-left">
									<label>申請人</label>
								</div>
							 -->
				
							</div>
                           
						</header>
						<input type="hidden" name="l_user_id" id="l_user_id" value="<?= isset($login_user->role_id) ? $login_user->role_id: '' ?>" />

						<!-- widget div-->
						<div>
							<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->

							</div>
							<!-- end widget edit box -->

							<!-- widget content -->
							<div class="widget-body no-padding">
								<table id="dt_list" class="table table-striped table-bordered table-hover" width="100%">
									<thead>
										<tr>
											<th class="min25"></th>
											<th class="min100">檔案名稱</th>
											<th class="min100">建立時間</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
							<!-- end widget content -->

						</div>
						<!-- end widget div -->

					</div>
					<!-- end widget -->

				</article>
				<!-- WIDGET END -->

			</div>

			<!-- end row -->

		</section>
		<!-- end widget grid -->
	</div>

	<div class="tab-pane animated fadeIn" id="edit_page">
		<section class="">
			<!-- row -->
			<div class="row">
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="edit-modal-body">
									
				</article>
			</div>
		</section>
	</div>
</div>

<?php $this -> load -> view('general/delete_modal'); ?>
<script type="text/javascript">
	var baseUrl = '<?=base_url('')?>';

	var mCols = [null,{
		data : 'patent_name'
	}, {
		data : 'image',
		render: function(d,t,r){
			if(d>0){
				var html = '<img src="'+baseUrl+'api/images/get/'+d+'/thumb" loading="lazy" style="max-height:200px;max-width:200px" >';
				return html;
			} else{
				return '';
			}
		}
	},{
		data : 'applicant',
		render: function(d,t,r){
			if(d){
				var html = '<span style="word-wrap:break-word;white-space:pre-wrap;">'+d+'</span>';
				return html;
			} else{
				return '';
			}
		}
	},{
		data : 'inventor',
		render: function(d,t,r){
			if(d){
				var html = '<span style="word-wrap:break-word;white-space:pre-wrap;">'+d+'</span>';
				return html;
			} else{
				return '';
			}
		}
	},{
		data : 'total_country'
	}, {
		data : 'patnet_num',
		render: function(d,t,r){
			if(d){
				var html = '<span style="color:red;">'+d+'</span>';
				return html;
			} else{
				return '';
			}
		}
	}, {
		data : 'public_num'
	}, {
		data : 'application_date'
	}, {
		data : 'announcement_date'
	}, {
		data : 'update_date'
	}];

	var mOrderIdx = 6;
	
	if($('#l_user_id').val()=='9' || $('#l_user_id').val()=='28'|| $('#l_user_id').val()=='11' ){
		var defaultContent = '<a href="#deleteModal" role="button" data-toggle="modal" style="margin-right: 5px;"><i class="fa fa-trash fa-lg"></i></a>';
	} else{
		var defaultContent = '<a role="button" data-toggle="modal" style="margin-right: 5px;" ><i class="fa fa-trash fa-lg"></i></a>';
	}

	var mColDefs = [{
		targets : 0,
		data : null,
		defaultContent : defaultContent,
		searchable : false,
		orderable : false,
		width : "5%",
		className : ''
	}, {
		"targets" : [0,1,2,3,4,5,6,7],
		"orderable" : false
	}];

	loadScript(baseUrl + "js/class/BaseAppClass.js", function(){
		loadScript(baseUrl + "js/app/patent/list.js", function(){
			currentApp = new patentAppClass(new BaseAppClass({}));
			// $('#family-num-add-form').submit(function(e){
			// 	familyChange();
			// 	e.preventDefault();
			// });
		});
	});

	var total_category=0;

	function load_category() {
		$.ajax({
			url: '<?= base_url() ?>' + 'mgmt/patent/find_all_category',
			type: 'POST',
			data: {},
			dataType: 'json',
			success: function(d) {
				if(d) {
					// console.log(d);
					$category = $('#category').empty();
					var i=0;
					var html='';
					total_category = d.max;
					for(i;i<=d.max;i++){
						html+='<div class="widget-toolbar pull-left">'+
								'<select id="category_'+i+'" class="p_list_patnet_status" data-val="'+i+'" >'+
								'</select>'+
							'</div>';
					}
					$(html).appendTo($category);
					var category_option = '<option value="all">全部</option>';
					var $category_0 = $('#category_0').empty();
					$category_0.append(category_option);
					$.each(d.category, function(){
						if(this.level==0){
							$('<option />', {
								'value': this.id,
								'text': this.name,
							}).appendTo($category_0);
						}
					});

					$('.p_list_patnet_status').on('change', function(){
						var me = $(this);
						var _dataVal = me.data("val");
						var select_Val = me.val();
						$('#now_category').val(select_Val);
						var next_c =_dataVal+1;
						console.log(next_c);
						$.ajax({
							url:  baseUrl + currentApp.basePath + '/find_next_category',
							type: 'POST',
							data: {
								next_level:next_c,
								this_val:select_Val,
							},
							dataType: 'json',
							success: function(d) {
								var category_option = '<option value="all">全部</option>';
								var $category = $('#category_'+next_c).empty();
								$category.append(category_option);
								if(d.category){
									$.each(d.category, function(){
										$('<option />', {
											'value': this.id,
											'text': this.name,
										}).appendTo($category);
									});
									currentApp.tableReload();

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
	load_category();
	
	function do_remove() {//一鍵清除所有篩選
		$('#patent_header input').val('');
		$("input[name='patent_status[]']").removeAttr("checked");
		load_category();
		currentApp.tableReload();
		
	}

	$('.p_list_patnet_status').on('change', function(){
		var me = $(this);
		var _dataVal = me.data("val");
		// console.log(me);
		// console.log(_dataVal);
		$( "select .p_list_patnet_status" ).each(function(){
			var other_me = $(this);
			var other_dataVal = other_me.data("val");
			if(other_dataVal!=="all" && other_dataVal>_dataVal){
				$('<option />', {
					'value': this.id,
					'text': this.name,
				}).appendTo(other_me);
			}
		});
	});
</script>
