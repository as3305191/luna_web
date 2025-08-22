<style>
@media only screen and (max-width: 750px) {
	.dt_list_th{
	  min-width: 67px !important;
	}
  .dt_list_th_big{
	  min-width: 100px !important;
	}
}
</style>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php $this -> load -> view("luna/luna_head")  ?>
</head>

<body>
  <main>
    <!-- Header -->
    <?php $this -> load -> view("luna/luna_header")  ?>
    <!-- End Header -->

    <section class="g-mb-100">
      <div class="container">
        <div class="row">

          <!-- luna Sidebar -->
          <?php $this -> load -> view("luna/luna_sidebar")  ?>
          <!-- End luna Sidebar -->

          <!-- Profile Content -->
          <div class="col-lg-9">
            <!-- Overall Statistics -->
            <div class="row g-mb-40">
              <div class="col-md-6 g-mb-30 g-mb-0--md">
                <div class="g-bg-cyan g-color-white g-pa-25">
                  <header class="d-flex text-uppercase g-mb-40">
                    <i class="icon-people align-self-center display-4 g-mr-20"></i>

                    <!-- <div class="g-line-height-1">
                      <h4 class="h5">線上商城</h4>
                      <div class="js-counter g-font-size-30" data-comma-separated="true"><?=$count_today?></div>
                    </div> -->
                  </header>

                  <!-- <div class="d-flex justify-content-between text-uppercase g-mb-25">
                    <div class="g-line-height-1">
                      <h5 class="h6 g-font-weight-600">3天未上秤學員</h5>
											<button class="js-counter g-font-size-16" data-comma-separated="true" style="background-color:#00FF00;cursor:pointer" onclick="show_lose_3days(<?= isset($members_lose_3days) ? 1: 0 ?>)"><?=$count_members_lose_3days?></button>
                    </div> -->

                  </div>
                </div>
              </div>

              <!-- <div class="col-md-6 g-mb-30 g-mb-0--md">
                <div class="g-bg-purple g-color-white g-pa-25">
                  <header class="d-flex text-uppercase g-mb-40">
                    <i class="icon-layers align-self-center display-4 g-mr-20"></i>

                    <div class="g-line-height-1">
                      <h4 class="h5">幫助幾人</h4>
                      <div class="js-counter g-font-size-30" data-comma-separated="true"><?=$count_help_people?></div>

                    </div>
                  </header>

                  <div class="d-flex justify-content-between text-uppercase g-mb-25">
                    <div class="g-line-height-1">
                      <h5 class="h6 g-font-weight-600">幾天</h5>
                      <div class="js-counter g-font-size-16" data-comma-separated="true"><?=$days?></div>
                    </div>

                    <div class="text-right g-line-height-1">
                      <h5 class="h6 g-font-weight-600">總共減脂</h5>
                      <div class="g-font-size-16" data-comma-separated="true">
                        <span><?=doubleval($help_fat_rate_change)?></span>
                      </div>
                    </div>
                  </div>
              </div> -->
            </div>


            <!-- Profile Content -->
            <div class="col-lg-12">
              <!-- Overall Statistics -->
              <div class="" >

              <!-- Product Table Panel -->
              <!-- <div class="card border-0">
                <div class="card-header d-flex align-items-center justify-content-between g-bg-gray-light-v5 border-0 g-mb-15">
                  <h3 class="h6 mb-0">
                      <i class="icon-directions g-pos-rel g-top-1 g-mr-5"></i> 所有學員
                    </h3>

                </div>

                <div class="card-block g-pa-0">
                  
                  <div class="table-responsive">
                    <table id="dt_list" class="table table-bordered u-table--v2">
                      <thead class="text-uppercase g-letter-spacing-1">
                        <tr>
                          <th class="g-font-weight-300 g-color-black dt_list_th" style="min-width: 100px">照片</th>
                          <th class="g-font-weight-300 g-color-black dt_list_th" style="min-width: 100px">學員</th>
                          <th class="g-font-weight-300 g-color-black dt_list_th" style="min-width: 100px">年齡</th>
                          <th class="g-font-weight-300 g-color-black dt_list_th" style="min-width: 100px">身高</th>
                          <th class="g-font-weight-300 g-color-black dt_list_th" style="min-width: 100px">性別</th>
                          <th class="g-font-weight-300 g-color-black dt_list_th" style="min-width: 100px">體重</th>
                          <th class="g-font-weight-300 g-color-black dt_list_th_big" style="min-width: 100px">體重變化</th>
                          <th class="g-font-weight-300 g-color-black dt_list_th_big" style="min-width: 100px">脂肪變化</th>
                          <th class="g-font-weight-300 g-color-black dt_list_th_big" style="min-width: 100px">肥胖程度</th>
                        </tr>
                      </thead>
                      <tbody id="dt_list_body">
                      </tbody>
                    </table>
                  </div>

                </div>
                <nav class="text-center" aria-label="Page Navigation">
                  <ul class="list-inline">
                    <?php
                      for ($i=1;$i<=$page;$i++){
                    ?>
                    <?php $j=$i?>

                      <?php if ($i==1): ?>
                        <li class="list-inline-item float-sm-left">
                          <a class="u-pagination-v1__item u-pagination-v1-4 g-rounded-50 g-pa-7-16" onclick="for_table(<?=$j?>)" aria-label="Previous">
                            <span aria-hidden="true">
                              <i class="fa fa-angle-left g-mr-5"></i> 最前頁
                            </span>
                            <span class="sr-only">Previous</span>
                          </a>
                        </li>
                      <?php else: ?>
                      <?php endif; ?>


                      <?php if ($i==1): ?>
                        <li class="list-inline-item g-hidden-sm-down" >
                          <a class="u-pagination-v1__item u-pagination-v1-4 u-pagination-v1-4--active g-rounded-50 g-pa-7-14 s<?=$i?>"  onclick="for_table(<?=$i?>)">
                        <?php echo $i?></a></li>
                      <?php else: ?>
                        <li class="list-inline-item g-hidden-sm-down" >
                          <a class="u-pagination-v1__item u-pagination-v1-4 g-rounded-50 g-pa-7-14 s<?=$i?>"  onclick="for_table(<?=$i?>)">
                        <?php echo $i?></a></li>
                      <?php endif; ?>


                      <?php if ($i==$page): ?>
                        <li class="list-inline-item float-sm-right">
                          <a class="u-pagination-v1__item u-pagination-v1-4 g-rounded-50 g-pa-7-16" onclick="for_table(<?=$j?>)" aria-label="Next">
                            <span aria-hidden="true">
                              最後頁 <i class="fa fa-angle-right g-ml-5"></i>
                            </span>
                            <span class="sr-only">下一頁</span>
                          </a>
                        </li>
                      <?php else: ?>
                      <?php endif; ?>

                        <?php } ?>

                  </ul>
                </nav>
                <div class="card-header d-flex align-items-center justify-content-between g-bg-gray-light-v5 border-0 g-mb-15">
                  <h3 class="h6 mb-0">
                      <i class="icon-directions g-pos-rel g-top-1 g-mr-5"></i> 學員今日體重
                  </h3>
                </div>

                <div class="card-block g-pa-0" style="">
                  <section>
										<label class="label">學員名稱</label>
											<input type="text" id="member_name" style="border-color:#787774;">
                      <button type="button" class="btn btn-danger btn-sm" onclick="search_member()">
                        搜尋
                      </button>
									</section>
                  <div class="table-responsive">
                    <table id="dt_list_for_today_w" class="table table-bordered u-table--v2">
                      <thead class="text-uppercase g-letter-spacing-1">
                        <tr>
                          <th class="g-font-weight-300 g-color-black" style="min-width: 100px">學員名稱</th>
                          <th class="g-font-weight-300 g-color-black" style="min-width: 100px">體重</th>
                          <th class="g-font-weight-300 g-color-black" style="min-width: 100px">體脂率</th>
                          <th class="g-font-weight-300 g-color-black" style="min-width: 200px">時間</th>

                        </tr>
                      </thead>
                      <tbody id="list_for_today_w">
                      </tbody>
                    </table>
                  </div>
                 
                </div>

              </div> -->
              <!-- End Product Table Panel -->
            </div>
            <!-- End Profile Content -->
            </div>
          </div>
          <!-- End Profile Content -->
        </div>
      </div>
    </section>

    <!-- Footer -->
    <?php $this -> load -> view("luna/luna_footer")  ?>
    <!-- End Footer -->
  </main>

<div class="u-outer-spaces-helper"></div>

</body>
</html>
<!-- Product Serach Modal -->
<div class="modal fade" id="graduate" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
        <h3 id="deleteModalLabel">確認畢業</h3>
			</div>
      <fieldset>
          <div class="form-group">
            <label class="col-md-3 control-label">學員</label>
            <div class="col-md-9">
              <div class="col-md-9">
                <input type="hidden" class="form-control"  id="m_id" />
                <input type="text" class="form-control" style = "border-style:none none none none;" id="m_name" readonly/>
              </div>
            </div>
          </div>
        </fieldset>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-sm" onclick="save_graduate()">
					<i class="fa fa-save"></i> 確認
				</button>
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
					<i class="fa fa-close"></i> 關閉
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="lose_3day" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
        <h3 id="lose_3day_Label">3天未上線人員</h3>
			</div>
      <div class="js-scrollbar card-block  u-info-v1-1 g-bg-white-gradient-v1--after g-height-400 g-pa-0">
          <?php foreach ($members_lose_3days as $each): ?>
            <?php if ($each->last_weight): ?>
            <ul class="list-unstyled">
              <li class="d-flex justify-content-start g-brd-around g-brd-gray-light-v4 g-pa-20 g-mb-10">
                <div class="g-mt-2">
                  <img class="g-width-50 g-height-50 rounded-circle" src="<?=base_url('')?>mgmt/images/get/<?=$each->image_id?>/thumb" alt="Image Description">
                </div>
                <div class="align-self-center g-px-10">
                  <h5 class="h6 g-font-weight-600 g-color-black g-mb-3">
                      <span class="g-mr-5"><?=$each->user_name?></span>
                      <!-- <small class="g-font-size-12 g-color-blue">8k+ earned</small> -->
                    </h5>
                  <!-- <p class="m-0">Nulla ipsum dolor sit amet adipiscing</p> -->
                </div>
              </li>
            </ul>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
					<i class="fa fa-close"></i> 關閉
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php $this -> load -> view("luna/luna_script")  ?>
<!-- End JS -->

<!-- Page Javascript -->
<script>
  var baseUrl = '<?=base_url('')?>';

  function for_table(page){
    var url = baseUrl + 'luna/luna_home/get_data';

    $.ajax({
      type : "POST",
      url : url,
      data : {
        id: $('#luna_id').val(),
        page: page
      },
      success : function(data) {
        var $body = $('#dt_list_body').empty();
        if(data.id!==''){
          $.each(data.items, function(){
            var me = this;
            var $tr = $('<tr class="pointer " user_name="'+me.user_name+'" user_id="'+me.id+'">').click(function(){
              // $('#graduate').modal('show');//畢業功能
              // $('#m_name').val($(this).attr('user_name'));
              // $('#m_id').val($(this).attr('user_id'));

            }).appendTo($body);
            if(me.image_id>0){
              $('<td>').html('<img class="g-width-100 g-height-100 rounded-circle g-mb-20" src="'+baseUrl+'mgmt/images/get/' +me.image_id+'/thumb" style="height:100px; width:100px;" />').appendTo($tr);
            } else{
              $('<td>').html('未上傳').appendTo($tr);
            }
            $('<td>').html(me.user_name).appendTo($tr);
            $('<td>').html(me.age).appendTo($tr);
            $('<td>').html(me.height).appendTo($tr);
            if(me.gender==0){
              $('<td>').html('女').appendTo($tr);
            } else{
              if(me.gender==1){
                $('<td>').html('男').appendTo($tr);
              }
            }
            $('<td>').html(parseFloat(me.the_new_weight/ 1000).toFixed(2)).appendTo($tr);
            $('<td>').html(parseFloat(me.the_weight_change/ 1000).toFixed(2)).appendTo($tr);
            $('<td>').html(parseFloat(me.the_fat_rate_change).toFixed(2)).appendTo($tr);
            $('<td>').html(me.the_fat_info).appendTo($tr);

          })
        }
        $('.u-pagination-v1__item').removeClass('u-pagination-v1-4--active ');
        $('.s'+page).addClass('u-pagination-v1-4--active');
      }
    });
  }

  // for_table(1);

  function search_member(){
    var url = baseUrl + 'luna/luna_home/find_today_weight';

    $.ajax({
      type : "POST",
      url : url,
      data : {
        name: $('#member_name').val(),
      },
      success : function(data) {
        var $body = $('#list_for_today_w').empty();
        if(data.id!==''){
          $.each(data.member_weihght, function(){
            var me = this;
            var $tr = $('<tr class="pointer">').click(function(){
            }).appendTo($body);
            if(me!=='沒有結果'){
              $('<td>').html(me.user_name).appendTo($tr);
              $('<td>').html(parseFloat(me.weight/ 1000).toFixed(2)).appendTo($tr);
              $('<td>').html(me.body_fat_rate).appendTo($tr);
              $('<td>').html(me.create_time).appendTo($tr);
            } else{
              $body;
            }

          })
        }
        // $('.u-pagination-v1__item').removeClass('u-pagination-v1-4--active ');
      }
    });
		}

    function save_graduate() {
      var url = baseUrl + 'luna/luna_home/update_graduate';
  		$.ajax({
  			url : url,
  			type: 'POST',
  			data: {
  				user_id: $('#m_id').val(),
  			},
  			dataType: 'json',
  			success: function(d) {
  				if(d.success=="true"){
  					$('#graduate').modal('hide');
            location.reload();
  				}

  			},

  			failure:function(){
  				alert('faialure');
  			}
  		});
  	}

    function show_lose_3days($id_array) {
      if($id_array>0){//人數大於1才顯示
        $('#lose_3day').modal('show');//3先沒上線人員顯示
      }
    }


// search_member();
</script>
<!-- End Page Javascript -->
