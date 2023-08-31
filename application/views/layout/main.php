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
			.black_overlay{ 
				display: none; 
				position: absolute; 
				top: 0%; 
				left: 0%; 
				width: 100%; 
				height: 100%; 
				background-color: black; 
				z-index:1001; 
				-moz-opacity: 0.8; 
				opacity:.80; 
				filter: alpha(opacity=88); 
			} 
			.white_content { 
				display: none; 
				position: absolute; 
				top: 25%; 
				left: 25%; 
				width: 55%; 
				height: 55%; 
				padding: 20px; 
				border: 5px solid #ff4c00; 
				background-color: white; 
				z-index:1002; 
				overflow: auto; 
			} 
		</style> 
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
			<div >
				<button class="btn-light text-light btn_unsuccess" id="message_s" style="border-radius: 5px; padding: 10px; width: 160px; height: 48px;" onclick="message()">聊天室</button>
			</div>
			<!-- END #MAIN CONTENT -->
		
		</div>
		<!-- END #MAIN PANEL -->

		<?php $this->load->view('layout/footer'); ?>
		<?php //$this->load->view('layout/shortcut'); ?>

		<!--================================================== -->

		<?php $this->load->view('layout/plugins'); ?>
		<!-- Scripts -->
		<?php $this -> load -> view('mgmt/message/message_script'); ?>
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
			// if (!('Notification' in window)) {
			// 		console.log('本瀏覽器不支援推播通知');
			// 	} else{
			// 		console.log('本瀏覽器有推播');
			// 	}	

			// 	var notifyConfig = {
			// 		body: '~~~test~~~', // 設定內容
			// 		icon: '<?= base_url('img/ktx_img/logo_1.png') ?>', // 設定 icon
			// 		tag: 'newArrival' // 設定標籤
			// 	};
							

			// 	if (Notification.permission === 'default' || Notification.permission === 'undefined') {
			// 		Notification.requestPermission(function(permission) {
			// 			if (permission === 'granted') {// 使用者同意授權
			// 				var notification = new Notification('通知測試!', notifyConfig); // 建立通知
			// 			}
			// 		});
			// 	}
				
				var key='all',mkey;
				var users={};
				var url='<?= $socket_url?>';
				var so=false,n=false,me_id=false,socket=false;
				var lus=A.$('us_online'),lct=A.$('ct');
				n='<?= $username?>';
				me_id='<?= $me_id?>';
				socket='<?= $old_socket?>'; 
				layui.layer.close(window._ajaxLoading);
	    });
	    //Ajax 發生例外時，要做的事情
	    $(document).ajaxError(function () {
        	layui.layer.close(window._ajaxLoading);
	    });



		$('#message_s').click(function() {
			layer.open({
				type:2,
				title:'',
				closeBtn:0,
				area:['1600px','800px'],
				shadeClose:true,
				content:'<?=base_url('mgmt/message/message_show')?>'
			})
		});
		</script>
	</body>
</html>
 