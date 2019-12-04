<style>
.file-drag-handle {
	display: none;
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

	</header>

	<!-- widget div-->
	<div>
		<table class="table ">
			<tbody>
				<tr>
					<td>工單編號</td>
					<td><?= isset($item) ? $item -> sn : '' ?></td>
				</tr>
				<tr>
					<td>工單編號SAP</td>
					<td><?= isset($item) ? $item -> sn_sap : '' ?></td>
				</tr>
				<tr>
					<td>工單執行日期</td>
					<td><?= isset($item) ? $item -> start_time : '' ?></td>
				</tr>
				<tr>
					<td>完工日期</td>
					<td><?= isset($item) ? $item -> start_time : '' ?></td>
				</tr>
				<tr>
					<td>狀態</td>
					<td>
						<select name="status" class="form-control" disabled>
							<option value="0" <?= isset($item) && $item -> status == 0 ? 'selected' : '' ?>>未完工</option>
							<option value="1" <?= isset($item) && $item -> status == 1 ? 'selected' : '' ?>>已完工</option>
							<option value="-1" <?= isset($item) && $item -> status == -1 ? 'selected' : '' ?>>取消</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>備註</td>
					<td><?= isset($item) ? $item -> note : '' ?></td>
				</tr>
			</tbody>
		</table>

		<div class="">原料列表</div>
		<table class="table table-hover">
			<thead>
				<tr>
					<td class="min100">料號</td>
					<td class="min100">品名</td>
					<td class="min100">櫃號</td>
					<td class="min100">批號</td>
					<td class="min100">需求重量</td>
					<td class="min100">實際重量</td>
					<td>解凍方式/日期</td>
				</tr>
			</thead>
			<tbody id="">
				<?php foreach($type_0_list as $each): ?>
					<tr>
						<td><?= $each -> lot_number ?></td>
						<td><?= $each -> name ?></td>
						<td><?= $each -> container_sn ?></td>
						<td><?= $each -> trace_batch ?></td>
						<td><?= $each -> weight ?></td>
						<td><?= $each -> actual_weight ?></td>
						<td><?= $each -> thaw_name ?>/<?= $each -> thaw_date ?></td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>

		<div class="">成品列表</div>
		<table class="table table-hover">
			<thead>
				<tr>
					<td class="min100">料號</td>
					<td class="min100">品名</td>
					<td class="min100">櫃號</td>
					<td class="min100">批號</td>
					<td class="min100">需求重量</td>
					<td>實際重量</td>
				</tr>
			</thead>
			<tbody id="">
				<?php foreach($type_2_list as $each): ?>
					<tr>
						<td><?= $each -> lot_number ?></td>
						<td><?= $each -> name ?></td>
						<td><?= $each -> container_sn ?></td>
						<td><?= $each -> trace_batch ?></td>
						<td><?= $each -> weight ?></td>
						<td><?= $each -> actual_weight ?></td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
	<!-- end widget div -->

</div>
<!-- end widget -->

<style>
</style>
<script>
</script>
