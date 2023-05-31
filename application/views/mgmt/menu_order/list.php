<style>
  .s_sum {
  	display: none;
  }
  .menu_img_unsuccess {
  	display: none;
  }
</style>
<div>
    <header>
</header>
<div class="tab-content">
	<div class="tab-pane active" id="list_page">

		<!-- widget grid -->
		<section id="widget-grid" class="">
			<!-- row -->
			<div class="row">
				<!-- NEW WIDGET START -->
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			


				<div class="row" style="padding:0px 0px 6px 12px;">

					<div class="col-md-12 col-xs-12 col-sm-12 " style="padding:0px 0px 6px 0px;">
						<span style="font-size: 16pt;color:#0d0d56">開放的菜單</span>
					</div>
					<?php if($open_menu_count>0): ?>
						<?php if($open_menu_count==1): ?>
							<button class="btn_active btn-success text-light  menu_btn menu_<?= $menu_list[0]->id ?>" style="border-radius: 5px; padding: 10px; width: 160px; height: 48px;" onclick="menu_click(<?= $menu_list[0]->id ?>)"><?= $menu_list[0]->menu_name ?></button>
						<?php else: ?>		
							<button class="btn_active btn-success text-light  menu_btn menu_<?= $menu_list[0]->id ?>" style="border-radius: 5px; padding: 10px; width: 160px; height: 48px;" onclick="menu_click(<?= $menu_list[0]->id ?>)"><?= $menu_list[0]->menu_name ?></button>
							<?php for ($i=1;$i<count($menu_list);$i++) : ?>
								<button class="btn-light text-light btn_unsuccess menu_btn menu_<?= $menu_list[$i]->id ?>" style="border-radius: 5px; padding: 10px; width: 160px; height: 48px;" onclick="menu_click(<?= $menu_list[$i]->id ?>)"><?= $menu_list[$i]->menu_name ?></button>
							<?php endfor ?>
						<?php endif?>
					<?php endif?>
					<div class="row" style="padding:0px 0px 6px 12px;">
						<?php if($open_menu_count>0): ?>
							<?php if($open_menu_count==1): ?>
								<div class="js-slide g-px-3">
									<a class="js-fancybox d-block text-light  menu_img menu_img_<?= $menu_list[0]->id ?>" href="javascript:;" data-fancybox="lightbox-gallery--01" data-src="<?= base_url().'mgmt/images/get/'.$menu_list[0]->img_id?>" data-speed="350" data-caption="Lightbox Gallery">'+
										<img class="img-fluid" src="<?= base_url().'mgmt/images/get/'.$menu_list[0]->img_id?>" alt="Image Description">'+
									</a>
								</div>
							<?php else: ?>	
								<div class="js-slide g-px-3">
									<a class="js-fancybox d-block text-light  menu_img menu_img_<?= $menu_list[0]->id ?>" href="javascript:;" data-fancybox="lightbox-gallery--01" data-src="<?= base_url().'mgmt/images/get/'.$menu_list[0]->img_id?>" data-speed="350" data-caption="Lightbox Gallery">'+
										<img class="img-fluid" src="<?= base_url().'mgmt/images/get/'.$menu_list[0]->img_id?>" alt="Image Description">'+
									</a>
								</div>
								<?php for ($i=1;$i<count($menu_list);$i++) : ?>
									<div class="js-slide g-px-3">
										<a class="js-fancybox d-block menu_img_unsuccess btn-light text-light  menu_img menu_img_<?= $menu_list[$i]->id ?>" href="javascript:;" data-fancybox="lightbox-gallery--01" data-src="<?= base_url().'mgmt/images/get/'.$menu_list[$i]->img_id?>" data-speed="350" data-caption="Lightbox Gallery">'+
											<img class="img-fluid" src="<?= base_url().'mgmt/images/get/'.$menu_list[$i]->img_id?>" alt="Image Description">'+
										</a>
									</div>
								<?php endfor ?>
							<?php endif?>
						<?php endif?>
					</div>

					<!-- <button class="btn-success text-light btn_active menu_1" style="border-radius: 5px; padding: 10px; width: 160px; height: 48px;" onclick="backStep1()">菜單1</button>
					<button class="btn-light text-light btn_unsuccess menu_3" style="border-radius: 5px; padding: 10px; width: 160px; height: 48px;">菜單3</button> -->
				</div>

					<!-- widget content -->
				</hr>
						<table id="dt_list" class="table table-striped table-bordered table-hover" >
						<thead>
						<tr>
							<th></th>
							<th>選擇店家</th>
							<th>品項</th>
							<th>金額</th>
							<th>備注</th>
						</tr>
						<tr>
							<td class="min50" style="border-right:none;"></td>
							<td class="min120" style="border-right:none;">
								<div class="input-group col-md-12">
									<select id="menu_name" class="form-control">
										
									</select> 
								</div>
							</td>
							<td style="border-right:none;">
								<div class="input-group col-md-12">
									<input type="text" class="form-control" id="order_name" placeholder="品項">
								</div>
							</td>
							<td style="border-right:none;">
								<div class="input-group col-md-12">
									<input type="text" class="form-control" id="amount" placeholder="金錢總額">
								</div>
							</td>
							<td style="border-right:none;">
								<div class="input-group col-md-10">
									<input type="text" class="form-control" id="note" placeholder="備注">
								</div>

									<button type="button" class="btn btn-sm btn-primary" onclick="add_order()"><i class="fa fa-plus-circle fa-lg"></i></button>

							</td>
							
							
						</tr>
					</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					<!-- end widget content -->

				<!-- end widget div -->


				</article>
				<!-- WIDGET END -->

			</div>

			<!-- end row -->

		</section>
		<!-- end widget grid -->
	</div>

</div>
<?php $this -> load -> view('general/delete_modal'); ?>
<script type="text/javascript">

var mCols = [null,{
	data : 'menu_name'
},{
	data : 'order_name'
},{
	data : 'amount'
},{
	data : 'note'
}];

var mOrderIdx = 6;

var defaultContent = '<a href="#deleteModal" role="button" data-toggle="modal" style="margin-right: 5px;"><i class="fa fa-trash fa-lg"></i></a>';

var mColDefs = [{
	targets : 0,
	data : null,
	defaultContent : defaultContent,
	searchable : false,
	orderable : false,
	width : "5%",
	className : ''
}, {
	"targets" : [0,1,2,3,4],
	"orderable" : false
}];

	loadScript(baseUrl + "js/class/BaseAppClass.js", function(){
		loadScript(baseUrl + "js/app/menu_order/list.js", function(){
			currentApp = new menuorderAppClass(new BaseAppClass({}));
			
		});
	});
	function load_menu() {
		$.ajax({
			url: '<?= base_url() ?>' + 'mgmt/menu_order/find_all_menu',
			type: 'POST',
			dataType: 'json',
			success: function(d) {
				if(d) {
					// console.log(d);
					$menu_name = $('#menu_name').empty();
					// var option = '<option value="0">全部</option>';
					// $img_style.append(option);
					$.each(d.list, function(){
						$('<option/>', {
							'value': this.id,
							'text': this.menu_name
						}).appendTo($menu_name);
					});
				}
			},
			failure:function(){
				alert('faialure');
			}
		});
	}
	load_menu();

	menu_click
	function menu_click(id) {
		//   document.getElementById(id).show();
		$('.menu_img').addClass('menu_img_unsuccess');
		$('.menu_img_'+id).removeClass('menu_img_unsuccess');
		// $('.menu_btn').removeClass('btn_active');
		$('.menu_btn').removeClass('btn_active btn-success ');
		$('.menu_btn').addClass('btn_unsuccess');
		$('.menu_'+id).removeClass('btn_unsuccess');
		$('.menu_'+id).addClass('btn_active btn-success ');
	}
	function add_order(){//按下+按鈕時新增畫面以及寫入資料庫
		var menu_id = $('#menu_name').val();
		var order_name = $('#order_name').val();
		var amount = $('#amount').val();
		var note = $('#note').val();
		
		$.ajax({
			url: '<?= base_url() ?>' + 'mgmt/menu_order/insert',
			type: 'POST',
			data: {
				menu_id : menu_id,
				order_name :order_name,
				amount :amount,
				note:note
			},
			dataType: 'json',
			success: function(d) {
				if(d.success) {
					// var $now_fix_list = $('<div class="col-sm-12" style="border-width:3px;border-style:double;border-color:#ccc;padding:5px;"><div class="col-sm-12"><span fix_id="">  維修原因:  '+fix_reason+'  處置情形:  '+fix_way+'  維修者:  '+$('#fix_user option:selected').text()+'</span></div></div></hr>').appendTo($('#now_fix'));
					// now_fix_record.push(d.last_id);
					currentApp.tableReload();
				}
			},
			failure:function(){
				alert('faialure');
			}
		});

	}
</script>
