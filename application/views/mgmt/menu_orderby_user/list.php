<style>
thead tr th {
	position:sticky;
	top:0;
	background-color:#FFFFFF !important;
	text-align:center;
}
</style>

<!-- CSS Unify Theme -->
<link rel="stylesheet" href="<?= base_url() ?>assets_co/assets_/css/styles.multipage-real-estate.css">
  
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
								<label>菜單:</label>
							</div>
							<div class="widget-toolbar pull-left">
								<select id="menu_name" class="form-control">
									<!-- option from javascript -->
								</select>
							</div>
							<div class="widget-toolbar pull-left">
								<span style="color:red">總金額：<span style="color:red" id="total"></span></span>
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
											<th class="min100">店名</th>
											<th class="min100">名字</th>
											<th class="min100">品項</th>
											<th class="min100">糖</th>
											<th class="min100">冰</th>
											<th class="min100">金額</th>
											<th class="min100">備註</th>
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
<!-- Station Serach Modal -->


<?php $this -> load -> view('general/delete_modal'); ?>
<script type="text/javascript">
	// var baseUrl = '<?=base_url('')?>';

	var mCols = [null,{
		data : 'menu_name',
		render:function ( data, type, row ) {

			return data+' '+row.timestamp;

		}
	},{
		data : 'user_name'
	},{
		data : 'order_name'
	},{
		data : 'sugar'
	},{
		data : 'ice'
	},{
		data : 'amount'
	},{
		data : 'note'
	}];

	var mOrderIdx = 6;
	
	// var defaultContent = '<a href="#deleteModal" role="button" data-toggle="modal" style="margin-right: 5px;"><i class="fa fa-trash fa-lg"></i></a>';
	var defaultContent = '';

	var mColDefs = [{
		targets : 0,
		data : null,
		defaultContent : defaultContent,
		searchable : false,
		orderable : false,
		width : "5%",
		className : ''
	}, {
		"targets" : [0,1,2,3,4,5],
		"orderable" : false
	}];

	loadScript(baseUrl + "js/class/BaseAppClass.js", function(){
		loadScript(baseUrl + "js/app/menu_orderby_user/list.js", function(){
			currentApp = new menuorderuserAppClass(new BaseAppClass({}));
			
		});
	});

	function load_menu_style() {
		$.ajax({
			url: '<?= base_url() ?>' + 'mgmt/menu/find_menu_style',
			type: 'POST',
			dataType: 'json',
			success: function(d) {
				if(d) {
					// console.log(d);
					$img_style = $('#s_menu_name').empty();
					var option = '<option value="0">全部</option>';
					$img_style.append(option);
					$.each(d.menu_style, function(){
						$('<option/>', {
							'value': this.id,
							'text': this.menu_style
						}).appendTo($img_style);
					});
				}
			},
			failure:function(){
				alert('faialure');
			}
		});
	}
$('#add_img_style').click(function() {
		layer.open({
			type:2,
			title:'',
			closeBtn:0,
			area:['400px','200px'],
			shadeClose:true,
			content:'<?=base_url('mgmt/menu/new_menu_style')?>'
		})
	})



	function load_menu() {
		$.ajax({
			url: '<?= base_url() ?>' + 'mgmt/menu_orderby_user/find_all_menu',
			type: 'POST',
			dataType: 'json',
			success: function(d) {
				if(d) {
					// console.log(d);
					$menu_name = $('#menu_name').empty();
					var option = '<option value="0">全部</option>';
					$menu_name.append(option);
					if(d.list.length>0){
						$.each(d.list, function(){
							$('<option/>', {
								'value': this.id,
								'text': this.timestamp+' '+this.menu_name
							}).appendTo($menu_name);
						});
						if(d.list[0].menu_style_id==4){

							$('.s_i').removeClass('hide_s_i');

						} else{
							$('.s_i').addClass('hide_s_i');

						}   
					}
					
				}
			},
			failure:function(){
				alert('faialure');
			}
		});
	}
	load_menu();

</script>
