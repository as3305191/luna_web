<style>
  .s_sum {
  	display: none;
  }
  .menu_img_unsuccess {
  	display: none;
  }
  .hide_s_i {
  	display: none;
  }
</style>
<div>
<header>
<link rel="stylesheet" href="<?= base_url('assets/vendor/fancybox/jquery.fancybox.min.css'); ?>" />
<!-- <link rel="stylesheet" href="<?= base_url('assets/smoke.css'); ?>" /> -->
</header>
<div class="tab-content">

	
				<div class="row" style="padding:0px 0px 6px 12px;">

					<div class="col-md-12 col-xs-12 col-sm-12 " style="padding:0px 0px 6px 0px;">
						<span style="font-size: 16pt;color:#0d0d56">開放的菜單</span>
					</div>
					<?php if($open_menu_count>0): ?>
						<?php if($open_menu_count==1): ?>
							<button class="btn_active btn-success text-light  menu_btn menu_<?= $menu_list[0]->id ?>" style="border-radius: 5px; padding: 10px; width: 160px; height: 48px;" onclick="menu_click(<?= $menu_list[0]->id ?>)"><?= $menu_list[0]->menu_name ?></button>
							<input type="hidden" class="form-control" id="menu_id"value="<?= $menu_list[0]->id ?>">

						<?php else: ?>		
							<button class="btn_active btn-success text-light  menu_btn menu_<?= $menu_list[0]->id ?>" style="border-radius: 5px; padding: 10px; width: 160px; height: 48px;" onclick="menu_click(<?= $menu_list[0]->id ?>)"><?= $menu_list[0]->menu_name ?></button>
							<input type="hidden" class="form-control" id="menu_id" value="<?= $menu_list[0]->id ?>">

							<?php for ($i=1;$i<count($menu_list);$i++) : ?>
								<button class="btn-light text-light btn_unsuccess menu_btn menu_<?= $menu_list[$i]->id ?>" style="border-radius: 5px; padding: 10px; width: 160px; height: 48px;" onclick="menu_click(<?= $menu_list[$i]->id ?>)"><?= $menu_list[$i]->menu_name ?></button>
							<?php endfor ?>
						<?php endif?>
					<?php endif?>
					<div id="img_album" class="g-pos-rel" style="padding:10px 0px 6px 12px;">
					
					</div>

					<!-- <button class="btn-success text-light btn_active menu_1" style="border-radius: 5px; padding: 10px; width: 160px; height: 48px;" onclick="backStep1()">菜單1</button>
					<button class="btn-light text-light btn_unsuccess menu_3" style="border-radius: 5px; padding: 10px; width: 160px; height: 48px;">菜單3</button> -->
				</div>

					<!-- widget content -->
				</hr>
					<div >
						<label class="col-md-3" style="font-weight:bold;font-size:large;">自己的:</label>
						<table id="dt_list_menu" class="table table-striped table-bordered table-hover" width="100%">

							<thead>
								<tr>
									<th></th>
									<th>選擇店家</th>
									<th>品項</th>
									<th class="s_i">糖</th>
									<th class="s_i">冰</th>
									<th>金額</th>
									<th>備註</th>
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

										<td class="s_i">
											<div class="input-group col-md-12">
												<input type="text" class="form-control" id="sugar" placeholder="糖">
											</div>
										</td>
										<td class="s_i">
											<div class="input-group col-md-12">
												<input type="text" class="form-control" id="ice" placeholder="冰">
											</div>
										</td>
								

									<td style="border-right:none;">
										<div class="input-group col-md-12">
											<input type="text" class="form-control" id="amount" placeholder="金錢總額">
										</div>
									</td>
									<td style="border-right:none;">
										<div class="input-group col-md-10">
											<input type="text" class="form-control" id="note" placeholder="備註">
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
					</hr>
					<div >
						<label class="col-md-3" style="font-weight:bold;font-size:large;">別人點的:</label>
						<table id="dt_list_other" class="table table-striped table-bordered table-hover" width="100%">
							<thead>
								<tr>
									<th class="min100">店名</th>
									<th class="min100">名字</th>
									<th class="min100">品項</th>
									<th class="min100 s_i">糖</th>
									<th class="min100 s_i">冰</th>
									<th class="min100">金額</th>
									<th class="min100">備註</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
	

</div>
<?php $this -> load -> view('general/delete_modal'); ?>
<script src="<?= base_url() ?>assets/vendor/fancybox1/jquery.fancybox.min.js"></script>

<script type="text/javascript">
	loadScript(baseUrl + "js/class/BaseAppClass.js", function(){
		loadScript(baseUrl + "js/app/menu_order/list.js", function(){
			currentApp = new menuorderAppClass(new BaseAppClass({}));
			currentApp_other = new menu_otherAppClass(new BaseAppClass({}));
			
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
					var option = '';
					$menu_name.append(option);
					if(d.list.length>0){
						$.each(d.list, function(){
							$('<option/>', {
								'value': this.id,
								'text': this.menu_name
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

	function img_album() {
		$.ajax({
			url: '<?= base_url() ?>' + 'mgmt/menu_order/find_all_open_menu',
			type: "POST",
			data: {
				id: $('#menu_id').val()
			},
			success: function(data) {

				$('#img_album').empty();

				var img_album_html =
				'<div id="album" style="display:flex;" class="js-carousel g-pt-6 g-mx-2" data-infinite="true" data-slides-show="5" data-slides-scroll="1" data-rows="1" data-responsive=\'[{"breakpoint": 1200,"settings": {"slidesToShow": 5} }, {"breakpoint": 992,"settings": {"slidesToShow": 4}}, {"breakpoint": 768,"settings": { "slidesToShow": 1}}, { "breakpoint": 576,"settings": {"slidesToShow": 1}}, {"breakpoint": 446,"settings": { "slidesToShow": 1}}]\'>'+
				'</div>';
				$('#img_album').append(img_album_html);
				var menu_note ='';
				if(data.note!=""&&data.note!=null&&data.note!=undefined){
						
					menu_note='<div class="" style="color:#a90329;">備註: '+data.note+'</div>';
				}
				$('#img_album').append(menu_note);
				
				

				$.each(data.list_image, function() {
					var me = this;
					var img_html =
					'<div class="js-slide g-px-3">'+
						'<a class="js-fancybox d-block" href="javascript:;" data-fancybox="lightbox-gallery--01" data-src="<?= base_url() ?>api/images/get/'+me+'" data-speed="350" data-caption="Lightbox Gallery">'+
						'<img class="img-fluid" width="300" height="400" src="<?= base_url() ?>api/images/get/'+me+'/thumb" alt="Image Description">'+
						'</a>'+
					'</div>';
					$('#album').append(img_html);					
       	 		});
				
				
			}
		});
	}
	img_album();

	function menu_click(id) {
		//   document.getElementById(id).show();
		
		$('.menu_img').addClass('menu_img_unsuccess');
		$('.menu_img_'+id).removeClass('menu_img_unsuccess');
		// $('.menu_btn').removeClass('btn_active');
		$('.menu_btn').removeClass('btn_active btn-success ');
		$('.menu_btn').addClass('btn_unsuccess');
		$('.menu_'+id).removeClass('btn_unsuccess');
		$('.menu_'+id).addClass('btn_active btn-success ');
		// $('#menu_id').val(id);
		document.querySelector('#menu_id').value = id;
		img_album();
		document.querySelector('#menu_name').value = id;
		
	}

	function add_order(){//按下+按鈕時新增畫面以及寫入資料庫
		var menu_id = $('#menu_name').val();
		var order_name = $('#order_name').val();
		var amount = $('#amount').val();
		var note = $('#note').val();
		if($('#ice').val()!=""&&$('#ice').val()!=null&&$('#ice').val()!=undefined){
			var ice = $('#ice').val();
		} else{
			var ice = '';
		}
		if($('#sugar').val()!=""&&$('#sugar').val()!=null&&$('#sugar').val()!=undefined){
			var sugar = $('#sugar').val();
		} else{
			var sugar = '';
		}
		
		
		$.ajax({
			url: '<?= base_url() ?>' + 'mgmt/menu_order/insert',
			type: 'POST',
			data: {
				menu_id : menu_id,
				order_name :order_name,
				amount :amount,
				note:note,
				ice:ice,
				sugar:sugar
			},
			dataType: 'json',
			success: function(d) {
				if(d.success) {
					// var $now_fix_list = $('<div class="col-sm-12" style="border-width:3px;border-style:double;border-color:#ccc;padding:5px;"><div class="col-sm-12"><span fix_id="">  維修原因:  '+fix_reason+'  處置情形:  '+fix_way+'  維修者:  '+$('#fix_user option:selected').text()+'</span></div></div></hr>').appendTo($('#now_fix'));
					// now_fix_record.push(d.last_id);
	
					// $('#menu_name').val('');
					$('#order_name').val('');
					$('#amount').val('');
					$('#note').val('');
					$('#ice').val('');
					$('#sugar').val('');
					currentApp.tableReload();
				}
			},
			failure:function(){
				alert('faialure');
			}
		});

	}


	$('#menu_name').on('change', function(){
		// menu_click($('#menu_name').val());
		$.ajax({
			url: '<?= base_url() ?>' + 'mgmt/menu_order/find_menu_style',
			type: "POST",
			data: {
				id: $('#menu_name').val()
			},
			success: function(data) {
				
				if(data.list.menu_style_id==4){

					$('.s_i').removeClass('hide_s_i');
					
				} else{
					$('.s_i').addClass('hide_s_i');

				}    
				menu_click($('#menu_name').val());
				// $('#menu_id').val($('#menu_name').val());
				// currentApp.tableReload();
				// currentApp_other.tableReload();
			}
		});


	});
</script>
