<style>
  .s_sum {
  	display: none;
  }
</style>
<div>
    <header>
</header>
    <div class="col-md-12 col-xs-12 col-sm-12" style="padding:10px 20px 10px 13px;">
        <div class="col-md-12 col-xs-12 col-sm-12 " style="padding:0px 0px 6px 0px;">
            <span style="font-size: 16pt;color:#0d0d56">開放的菜單</span>
        </div>
        <button class="btn-success text-light btn_active menu_1" style="border-radius: 5px; padding: 10px; width: 160px; height: 48px;" onclick="backStep1()">菜單1</button>
        <!-- <button class="btn-warning text-light" style="border-radius: 5px; padding: 10; width: 160px; height: 48px; background-color: #FFD835; color: #f56b10;">場次設定</button> -->
        <button class="btn-light text-light btn_unsuccess menu_2" style="border-radius: 5px; padding: 10px; width: 160px; height: 48px;">菜單2</button>
        <button class="btn-light text-light btn_unsuccess menu_3" style="border-radius: 5px; padding: 10px; width: 160px; height: 48px;">菜單3</button>
       
       
        <hr/>
    </div>
	<div class="card-body">
		<div class="product-list">
			<table class="table table-bordered order">
				<thead>
					<tr>
						<th></th>
						<th>選擇店家</th>
						<th>品項</th>
						<th>金額</th>
						<th>備注</th>
						<th></th>
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
							<div class="input-group col-md-12">
								<input type="text" class="form-control" id="note" placeholder="備注">
							</div>
						</td>
						
						<td style="border-right:none;">
							<button type="button" class="btn btn-sm btn-primary" onclick="add_order()"><i class="fa fa-plus-circle fa-lg"></i></button>
						</td>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
			</table>


		</div>
	</div>

<?php $this -> load -> view('general/delete_modal'); ?>
<script type="text/javascript">
	var baseUrl = '<?=base_url('')?>';

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
	function add_order(){//按下+按鈕時新增畫面以及寫入資料庫
		var menu_name = $('#menu_name').val();
		var order_name = $('#menorder_nameorder_nameu_name').val();
		var amount = $('#amount').val();
		var note = $('#note').val();
		
		$.ajax({
			url: '<?= base_url() ?>' + 'mgmt/menu_order/insert',
			type: 'POST',
			data: {
				menu_name : menu_name,
				order_name :order_name,
				amount :amount,
				note:note
			},
			dataType: 'json',
			success: function(d) {
				if(d) {
					// var $now_fix_list = $('<div class="col-sm-12" style="border-width:3px;border-style:double;border-color:#ccc;padding:5px;"><div class="col-sm-12"><span fix_id="">  維修原因:  '+fix_reason+'  處置情形:  '+fix_way+'  維修者:  '+$('#fix_user option:selected').text()+'</span></div></div></hr>').appendTo($('#now_fix'));
					// now_fix_record.push(d.last_id);
				}
			},
			failure:function(){
				alert('faialure');
			}
		});

	}
</script>
