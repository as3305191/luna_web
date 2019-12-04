<!DOCTYPE html>
<html lang="en-us">
	<head>
		<?php $this->load->view('layout/head'); ?>
		<script>
			var baseUrl = '<?= base_url(); ?>';
			var currentApp;


			/* utilities */
			function numberWithCommas(x) {
			  if(!x) {
			  	return 0;
			  }
			  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
			}
		</script>

		<style>
		@media print {
        .no-print {
            display: none;
        }

        .print-only{
            display: block;
        }

				table td{
					border: 1px solid gray;
				}
		}
		</style>
	</head>
	<!-- #BODY -->
	<body class="smart-style-1">
		<?php $logout = 'login/logout';?>

		<!-- #MAIN PANEL -->
		<div id="" role="">

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
				<header class="no-print">
					<div class="widget-toolbar pull-left">
						<a href="javascript:void(0);" id="back_parent" onclick="window.close()" class="btn btn-default ">
							<i class="fa fa-window-close"></i>關閉
						</a>
					</div>
					<div class="widget-toolbar pull-left">
						<a href="javascript:void(0)" id="" onclick="window.print()" class="btn btn-default btn-danger">
							<i class="fa fa-print"></i>列印
						</a>
					</div>
				</header>

				<!-- widget div-->
				<div>
					<!-- widget edit box -->

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

		</div>
		<!-- END #MAIN PANEL -->

		<?php $this->load->view('layout/footer'); ?>
		<?php //$this->load->view('layout/shortcut'); ?>

		<!--================================================== -->

		<?php $this->load->view('layout/plugins'); ?>
		<!-- Scripts -->
		<script>
			var wOnResize = function(){
				var currentListElId = "#dt_list";
				// if(currentApp && currentApp.dtListId) {
				// 	currentListElId = currentApp.dtListId;
				// }

				if($(window).height() < 700) {
					if($(currentListElId).height() > 0) {
						// fix zero height in modal
						$(currentListElId).parent('.t-box').css('min-height', ($(currentListElId).height()) + 10 + 'px');
						$(currentListElId).parent('.t-box').css('height', ($(currentListElId).height()) + 'px');
						$(currentListElId).parent('.t-box').css('max-height', ($(currentListElId).height()) + 'px');
						// $('.t-box').css('height', 'auto');
					}
				} else {
					$(currentListElId).parent('.t-box').css('height', 'auto');
					$(currentListElId).parent('.t-box').css('min-height', ($(window).height() - 300) + 'px');
					$(currentListElId).parent('.t-box').css('max-height', ($(window).height() - 300) + 'px');
				}
				$('#widget-grid').width($('#content').width() - 13);
			};
			$(window).on('resize', wOnResize);

			$(document).ajaxComplete(function( event, xhr, settings ) {
			    if(xhr && xhr.responseText && xhr.responseText.indexOf('<script>window.location') > -1) {
			    	window.location.reload();
			    }
			});

			//Ajax 開始後，要做的事情
	    $(document).ajaxStart(function () {
				window._ajaxLoading = layui.layer.load(2);
	    });
	    //Ajax 結束後，要做的事情
	    $(document).ajaxStop(function () {
				layui.layer.close(window._ajaxLoading);
	    });
	    //Ajax 發生例外時，要做的事情
	    $(document).ajaxError(function () {
        layui.layer.close(window._ajaxLoading);
	    });

		</script>
	</body>
</html>
