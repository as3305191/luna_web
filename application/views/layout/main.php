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
	</head>
	<!-- #BODY -->
	<body class="smart-style-1">
		<?php $logout = 'login/logout';?>
		<?php $this->load->view('layout/header'); ?>
		<?php $this->load->view('layout/navigation'); ?>

		<!-- #MAIN PANEL -->
		<div id="main" role="main">

			<!-- RIBBON -->
			<div id="ribbon">

				<!-- breadcrumb -->
				<ol class="breadcrumb">
					<!-- This is auto generated -->
				</ol>
				<!-- end breadcrumb -->

				<!-- You can also add more buttons to the
				ribbon for further usability

				Example below:

				<span class="ribbon-button-alignment pull-right" style="margin-right:25px">
					<a href="#" id="search" class="btn btn-ribbon hidden-xs" data-title="search"><i class="fa fa-grid"></i> Change Grid</a>
					<span id="add" class="btn btn-ribbon hidden-xs" data-title="add"><i class="fa fa-plus"></i> Add</span>
					<button id="search" class="btn btn-ribbon" data-title="search"><i class="fa fa-search"></i> <span class="hidden-mobile">Search</span></button>
				</span> -->

			</div>
			<!-- END RIBBON -->

			<!-- #MAIN CONTENT -->
			<div id="content">

			</div>

			<!-- END #MAIN CONTENT -->

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
				// if (!('Notification' in window)) {
				// 	console.log('This browser does not support notification');
				// }

				var notifyConfig = {
					body: '\\ ^o^ /', // 設定內容
					icon: '<?= base_url('img/ktx_img/logo_1.png') ?>', // 設定 icon
					tag: 'newArrival' // 設定標籤
				};

				if (Notification.permission === 'default' || Notification.permission === 'undefined') {
					Notification.requestPermission(function(permission) {
						if (permission === 'granted') {
						// 使用者同意授權
						var notification = new Notification('Hi there!', notifyConfig); // 建立通知
						}
					});
				}
	    });
	    //Ajax 發生例外時，要做的事情
	    $(document).ajaxError(function () {
        	layui.layer.close(window._ajaxLoading);
	    });
		</script>
	</body>
</html>
