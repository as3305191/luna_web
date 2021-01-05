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
						<header>
							<div class="widget-toolbar pull-left">
								<div class="btn-group">
									<button onclick="currentApp.doEdit(0)" class="btn dropdown-toggle btn-xs btn-success" data-toggle="dropdown">
										<i class="fa fa-plus"></i>新增
									</button>
								</div>
							</div>
							<div class="widget-toolbar pull-left">
								<label>公司：</label>
							</div>
							<div class="widget-toolbar pull-left">
								<label>顯示有評分的項目<input id="s_multiple" type="checkbox" class="" value="" /></label>
							</div>
						
							<!-- <div class="widget-toolbar pull-right" >
								<a href="<?=base_url('files/test_menu_2.xlsx')?>" download class="btn btn-info" id="download_btn" >下載菜單範本</a>
							</div> -->
							<!-- <div class="widget-toolbar pull-right" >
								<form method="post" id="import_form" enctype="multipart/form-data">
									<label for="file" id="w_file" class="btn btn-outline-warning btn-xs" style="background-color:orange;">匯入菜單</label>
									<input type="file" name="file" class="btn btn-outline-warning" style="display:none" id="file" accept=".xls, .xlsx" />
								</form>
							</div> -->
						</header>

						<!-- widget div-->
						<div>

							<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->
							</div>
							<!-- end widget edit box -->
							<!-- <input type="hidden" class="form-control"  name="user_id" value="<?= isset($login_user) ? $login_user->corp_id : '' ?>"  /> -->
							<input type="hidden" class="form-control" id="user_id" name="user_id" value="<?= isset($login_user) ? $login_user->id : '' ?>"  />
							<input type="hidden"  id="role_id"  value="<?= isset($login_user) ? $login_user-> role_id : '' ?>"/>

							<!-- widget content -->
							<div class="widget-body no-padding">

								<table id="dt_list" class="table table-striped table-bordered table-hover" width="100%">
									<thead>
										<tr>
											<th class="min25"></th>
											<th class="min100">編號</th>
											<th class="min100">刪除碼</th>
											<th class="min100">名稱</th>
											<th class="min100">餐別名</th>
											<th class="min100">菜色類別</th>
										</tr>
										<tr class="search_box">
											<th></th>
											<th></th>
											<th><input class="form-control input-xs min100" type="text" /></th>
											<th><input class="form-control input-xs min100" type="text" /></th>
											<th><input class="form-control input-xs min100" type="text" /></th>
											<th><input class="form-control input-xs min100" type="text" /></th>
								   		 </tr>
									</thead>
									<tbody>
										
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
<div class="modal fade" id="update_type" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
				</div>
				<div class="modal-body" id="">
					<form id="" class="">


						<fieldset>
							<div class="form-group">
								<label class="col-md-3 control-label">刪除碼</label>
								<div class="col-md-9">
									<div class="col-md-9">
										<input type="text" class="form-control required" id="delete_num" value=""  />
									</div>
								</div>
							</div>
						</fieldset>

					<div class="modal-footer">
						<button type="button" class="btn btn-danger btn-sm" onclick="do_delete_action()">
							<i class="fa fa-save"></i> 存檔
						</button>
						<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
							<i class="fa fa-close"></i> 關閉
						</button>
					</div>
					</form>
				</div>

			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>
<script type="text/javascript">

	loadScript(baseUrl + "js/class/BaseAppClass.js", function(){
		loadScript(baseUrl + "js/app/menu/list.js", function(){
			currentApp = new MenuAppClass(new BaseAppClass({}));
		});
	});

// 	$('#file').on('click', function(){
//     console.log('123');
// 		var corp_id = $('#corp_id').val();
// 		var role_id = $('#role_id').val();
// 		if(role_id==107 && corp_id=='-1' ){
// 			$('#waring').show();
// 			return false;
// 		} else{
// 			$('#file').on('change', function(){
// 				$('#import_form').submit();
// 			})
// 		}
//   })

// 	$('#import_form').on('submit', function(event){
//     var url = '<?=base_url()?>';
// 		var user_id = $('#user_id').val();
// 		var corp_id = $('#corp_id').val();
// 	  event.preventDefault();
//   $.ajax({
//    url: url + 'mgmt/menu/import?user_id=' + user_id + '&corp_id=' + corp_id,
//    method:"POST",
//    data:new FormData(this),
//    contentType:false,
//    cache:false,
//    processData:false,
//    success:function(data){
//      if(data.success){
//        $('#file').val('');
//        layer.msg('菜單已上傳');
// 			 currentApp.tableReload();
//      }else if(data.err){
//        var err = data.err.toString();
//        layer.alert(err,{
//          btn:['確定'],
//          title:'錯誤!',
//          closeBtn:0
//        },function(index) {
//          layer.close(index);
//        })
//      }

//    }
//   })
//  });

//  function do_update_type_delete() {
//  	 // $('#or1').val(id);
//  	 $('#update_type').modal('show');
//   }

//   function do_delete_action() {
//  	 var url = '<?= base_url() ?>' + 'mgmt/menu/do_update_type_delete';
//  	 $.ajax({
//  		 url : url,
//  		 type: 'POST',
//  		 data: {
//  			 delete_num: $('#delete_num').val(),
//  		 },
//  		 dataType: 'json',
//  		 success: function(d) {
//  			 // Vaildation();
//  			 if(d.success){
//  				 $('#update_type').modal('hide');
// 				 currentApp.tableReload();

//  			 }

//  		 },

//  		 failure:function(){
//  			 alert('faialure');
//  		 }
//  	 });
//   }

</script>
