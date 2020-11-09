<?php $this -> load -> view('layout/head'); ?>
<div class="tab-content">
	<div class="tab-pane active" id="list_page">

		<!-- widget grid -->
		<section id="widget-grid" class="">

			<!-- row -->
			<div class="row">

				<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget">
						<header style="width:100%;position:fixed;z-index:1">
							<div class="widget-toolbar pull-left" style="padding:5px 10px">
								<div class="btn-group" style="margin:auto 0px">
									<button type="button" onclick="edit_inv()" class="btn dropdown-toggle btn-xs btn-default" data-toggle="dropdown">
										<i class="fa fa-plus"></i>新增
									</button>
								</div>
							</div>

							<div class="widget-toolbar pull-left" style="padding:5px 10px">
								<div class="btn-group" style="margin:auto 0px">
									目前擁有庫存：<?=$now_stock?>
								</div>
							</div>

						</header>

						<!-- widget div-->
						<div>

							<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->

							</div>
							<!-- end widget edit box -->

							<!-- widget content -->
							<div class="widget-body no-padding">

								<table id="rp_lists" class="table table-striped table-bordered table-hover" width="100%" style="margin-top:30px">
									<thead>
										<tr>
											<th>商品庫存</th>
											<th>庫存訂單</th>
											<th>建立時間</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($inv_detail as $inv_d): ?>
											<tr class="cart-item">
                        <td><?=$inv_d -> in_stock?></td>
                        <td><?=$inv_d -> order_id?></td>
												<td><?=$inv_d -> create_time?></td>
                    </tr>
										<?php endforeach; ?>
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
<?php $this -> load -> view('layout/plugins'); ?>
<script type="text/javascript">
function edit_inv() {
	parent.layer.open({
		title:'',
		type: 2,
		area: ['700px', '450px'],
		fixed: false, //不固定
		maxmin: false,
		border: [0],
		content: 'store/inventory/inv_edit/<?=$m_id?>',
		id:"inv_edit"
	});
	var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
	parent.layer.close(index);
}

</script>
