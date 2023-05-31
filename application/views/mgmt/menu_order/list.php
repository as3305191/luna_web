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
						<th>選擇店家</th>
						<th>品項</th>
						<th>金額</th>
						<th>備注</th>
						<th></th>
					</tr>
					<tr>
						
						<td class="min120" style="border-right:none;">
							<div class="input-group col-md-12">
									<select id="fix_user" class="form-control">
									<option selected disabled style="display:none">請選擇</option>
									<?php foreach($engineer as $each): ?>
										<option value="<?= $each -> id?>"><?=  $each -> user_name ?></option>
									<?php endforeach ?>
								</select> 
							</div>
						</td>
						<td class="min150" style="border-right:none;">
							<div class="input-group col-md-12">
								<input type="text" class="form-control dt_picker" id="fix_date" placeholder="選擇店家">
							</div>
						</td>
						<td style="border-right:none;">
							<div class="input-group col-md-12">
								<input type="text" class="form-control" id="fix_reason" placeholder="品項">
							</div>
						</td>
						<td style="border-right:none;">
							<div class="input-group col-md-12">
								<input type="text" class="form-control" id="fix_way_" placeholder="金額">
							</div>
						</td>
						
						<td style="border-right:none;">
							<button type="button" class="btn btn-sm btn-primary" onclick="add_fix()"><i class="fa fa-plus-circle fa-lg"></i></button>
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
	

	loadScript(baseUrl + "js/class/BaseAppClass.js", function(){
		loadScript(baseUrl + "js/app/menu_order/list.js", function(){
			currentApp = new menuorderAppClass(new BaseAppClass({}));
			
		});
	});

	
</script>
