<style>
	.has-feedback .form-control{
		padding-right:15px !important;
	}
</style>
<?php $this -> load -> view('layout/head'); ?>
<!-- Widget ID (each widget will need unique ID)-->
<div class="jarviswidget" id="wid-id-7" data-widget-colorbutton="false"	data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
	<header>
		<div class="widget-toolbar pull-left" style="padding-top:10px">
			<a href="javascript:void(0);" id="do_rp_edit" onclick="do_rp_edit()" class="btn btn-default ">
				<i class="fa fp-save"></i>儲存
			</a>
		</div>

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
		<div class="widget-body">

			<form id="app-edit-form" method="post" class="form-horizontal">
				<input type="hidden" name="product_id" value="<?= $id ?>" />


				<div>
					<span style="font-size:26px;color:red">
						商品名稱：<?=$product_detail[0] -> product_name?>
					</span>
				</div>


				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">庫存類型</label>
						<div class="col-md-6">
							<select class="form-control" name="stock_type" id="stock_type">
									<option value="0" >增加</option>
									<option value="1" >減少</option>
							</select>
						</div>
					</div>
				</fieldset>

				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">庫存</label>
						<div class="col-md-6">
							<input type="number" class="form-control" name="in_stock" value="" placeholder="請直接填寫數字"/>
						</div>
					</div>
				</fieldset>



			</form>

		</div>
		<!-- end widget content -->

	</div>
	<!-- end widget div -->

</div>
<!-- end widget -->
<?php $this -> load -> view('layout/plugins'); ?>
<style>
	.kv-file-zoom {
		display: none;
	}
</style>
<script>
	var baseUrl = '<?=base_url('')?>';
	function do_rp_edit() {
		$.ajax({
      type:'POST',
      url: baseUrl + 'store/inventory/edit_inv',
      data:$('#app-edit-form').serialize(),
      success:function(r){

				do99();
      }

    })

	}
	function do99() {
		var index = parent.layer.getFrameIndex(window.name);
		parent.layer.close(index);
		parent.success_rp();
	}
</script>
