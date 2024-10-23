<!DOCTYPE html>
<html lang="en">

<head>
  <?php $this -> load -> view("old_system_view/old_system_view_head")  ?>
</head>

<body>
  <main>
    <!-- Header -->
    <?php $this -> load -> view("old_system_view/old_system_view_header")  ?>
    <!-- End Header -->

    <section class="g-mb-100">
      <div class="container">
        <div class="row">

          <!-- Coach Sidebar -->
          <?php $this -> load -> view("old_system_view/old_system_view_sidebar")  ?>
          <!-- End Coach Sidebar -->

          <!-- Profile Content -->
          <div class="col-lg-9">
            <!-- Overall Statistics -->
            <div class="row g-mb-40">


            <!-- Profile Content -->
            <div class="col-lg-12">
              <!-- Overall Statistics -->
              <div class="" >

              <!-- Product Table Panel -->
              <div class="card border-0">
                <div class="card-header d-flex align-items-center justify-content-between g-bg-gray-light-v5 border-0 g-mb-15">
                  <h3 class="h6 mb-0">
                      <i class="icon-directions g-pos-rel g-top-1 g-mr-5"></i> 所有學員
                    </h3>
                  <div class="dropdown g-mb-10 g-mb-0--md">
                    <div class="dropdown-menu dropdown-menu-right rounded-0 g-mt-10">
                      <a class="dropdown-item g-px-10" href="<?= base_url() ?>#">
                        <i class="icon-layers g-font-size-12 g-color-gray-dark-v5 g-mr-5"></i> Projects
                      </a>
                      <a class="dropdown-item g-px-10" href="<?= base_url() ?>#">
                        <i class="icon-wallet g-font-size-12 g-color-gray-dark-v5 g-mr-5"></i> Wallets
                      </a>
                      <a class="dropdown-item g-px-10" href="<?= base_url() ?>#">
                        <i class="icon-fire g-font-size-12 g-color-gray-dark-v5 g-mr-5"></i> Reports
                      </a>
                      <a class="dropdown-item g-px-10" href="<?= base_url() ?>#">
                        <i class="icon-settings g-font-size-12 g-color-gray-dark-v5 g-mr-5"></i> Users Setting
                      </a>

                      <div class="dropdown-divider"></div>

                      <a class="dropdown-item g-px-10" href="<?= base_url() ?>#">
                        <i class="icon-plus g-font-size-12 g-color-gray-dark-v5 g-mr-5"></i> View More
                      </a>
                    </div>
                  </div>
                </div>

                <div class="card-block g-pa-0" style="">
                  <!-- Product Table -->
                  <div class="table-responsive">
                    <table id="dt_list" class="table table-bordered u-table--v2">
                      <thead class="text-uppercase g-letter-spacing-1">
                        <tr>
                          <th class="g-font-weight-300 g-color-black g-min-width-200">學員名字</th>
                          <th class="g-font-weight-300 g-color-black">體重</th>

                        </tr>
                      </thead>
                      <tbody id="dt_list_body">
                      </tbody>
                    </table>
                  </div>
                  <!-- End Product Table -->
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
              </div>
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
    <?php $this -> load -> view("old_system_view/old_system_view_footer")  ?>
    <!-- End Footer -->
  </main>

<div class="u-outer-spaces-helper"></div>

</body>
</html>

<!-- JS -->
<?php $this -> load -> view("old_system_view/old_system_view_script")  ?>
<!-- End JS -->

<!-- Page Javascript -->
<script>
  var baseUrl = '<?=base_url('')?>';
  function for_table(page){
    var url = baseUrl + 'old_system_view/member_weight_today/get_data';

    $.ajax({
      type : "POST",
      url : url,
      data : {
        id: $('#old_system_view_id').val(),
        page: page
      },
      success : function(data) {
        var $body = $('#dt_list_body').empty();
        if(data.id!==''){
          $.each(data.items, function(){
            var me = this;
            var $tr = $('<tr class="pointer">').click(function(){
              // $('.job_id_1').val(me.id);
              // $('.job_name').val(me.temp_title);
            }).appendTo($body);
            $('<td>').html(me.user_name).appendTo($tr);
            $('<td>').html(me.age).appendTo($tr);
          })
        }
        $('.u-pagination-v1__item').removeClass('u-pagination-v1-4--active ');
        $('.s'+page).addClass('u-pagination-v1-4--active');
      }
    });
  }

  for_table(1);


</script>
<!-- End Page Javascript -->
