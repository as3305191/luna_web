<style>
.file-drag-handle {
	display: none;
}

.table td {
	padding: 20px!important;
}

.table .row>.col, .table .row>[class^=col-] {
    padding-top: .75rem;
    padding-bottom: .75rem;
    background-color: rgba(86,61,124,.15);
    border: 1px solid rgba(86,61,124,.2);
}

.table .row > :nth-child(3n), .table .row > :nth-child(3n-1){
  background-color: #dcdcdc;
}
.table .row > :nth-child(3n-2){
  background-color: #aaaaaa;
}
</style>
<!-- Widget ID (each widget will need unique ID)-->
<div class="jarviswidget" id="wid-id-7" data-widget-colorbutton="false"	data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
	<header>
		<div class="widget-toolbar pull-left">
			<a href="javascript:void(0);" id="back_parent" onclick="currentApp.backTo()" class="btn btn-default ">
				<i class="fa fa-arrow-circle-left"></i>返回
			</a>
		</div>
		<div class="widget-toolbar pull-left">
			<a href="<?= base_url("mgmt/orders/flow_print/{$item->id}") ?>" id="" target="_blank" class="btn btn-default btn-danger">
				<i class="fa fa-print"></i>前往列印頁面
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
		<div class="widget-body table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th class="min100">工站</th>
						<th class="" style="max-wdith: 400px; width: 400px;">發料統計</th>
						<th class="" style="max-wdith: 400px; width: 400px;">收料統計</th>
						<th class="" style="max-wdith: 400px; width: 400px;">即時商品流向</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($order_station_list as $each): ?>
						<tr>
							<td><?= $each -> name ?></td>
							<td>
								<div class="">
								<?php foreach($each -> osr_product_list_0 as $each_product): ?>
									  <div class="row show-grid">
									    <div class="col-md-6">
									      <?= $each_product -> product_name ?>
									    </div>
									    <div class="col-md-3">
									      <?= $each_product -> total_number ?>
									    </div>
									    <div class="col-md-3">
									      <?= number_format($each_product -> total_weight, 2)  ?>
									    </div>
									  </div>
								<?php endforeach ?>
								</div>
							</td>
							<td>
								<div class="">
								<?php foreach($each -> osr_product_list as $each_product): ?>
									  <div class="row show-grid">
									    <div class="col-md-6">
									      <?= $each_product -> product_name ?>
									    </div>
									    <div class="col-md-3">
									      <?= $each_product -> total_number ?>
									    </div>
									    <div class="col-md-3">
									      <?= number_format($each_product -> total_weight, 2)  ?>
									    </div>
									  </div>
								<?php endforeach ?>
								</div>
							</td>
							<td>
								<div class="">
								<?php foreach($each -> or_product_list as $each_product): ?>
									  <div class="row show-grid">
									    <div class="col-md-6">
									      <?= $each_product -> product_name ?>
									    </div>
									    <div class="col-md-3">
									      <?= $each_product -> total_number ?>
									    </div>
									    <div class="col-md-3">
									      <?= number_format($each_product -> total_weight, 2) ?>
									    </div>
									  </div>
								<?php endforeach ?>
								</div>
							</td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>

		</div>
		<!-- end widget content -->

	</div>
	<!-- end widget div -->

</div>
<!-- end widget -->

<style>

</style>
<script>

</script>
