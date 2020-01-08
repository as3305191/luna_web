<!DOCTYPE html>

<head>
  <!-- Title -->
  <title></title>

  <!-- Required Meta Tags Always Come First -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <!-- Favicon -->
  <link rel="shortcut icon" href="<?= base_url() ?>coach_1/favicon.ico">
  <!-- Google Fonts -->
  <!-- <link rel="stylesheet" href="<?= base_url() ?>https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800"> -->
  <!-- CSS Global Compulsory -->
  <link rel="stylesheet" href="<?= base_url() ?>coach_1/assets/vendor/bootstrap/bootstrap.min.css">
  <!-- CSS Global Icons -->
  <link rel="stylesheet" href="<?= base_url() ?>coach_1/assets/vendor/icon-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>coach_1/assets/vendor/icon-line/css/simple-line-icons.css">
  <link rel="stylesheet" href="<?= base_url() ?>coach_1/assets/vendor/icon-etlinefont/style.css">
  <link rel="stylesheet" href="<?= base_url() ?>coach_1/assets/vendor/icon-line-pro/style.css">
  <link rel="stylesheet" href="<?= base_url() ?>coach_1/assets/vendor/icon-hs/style.css">
  <link rel="stylesheet" href="<?= base_url() ?>coach_1/assets/vendor/animate.css">
  <link rel="stylesheet" href="<?= base_url() ?>coach_1/assets/vendor/malihu-scrollbar/jquery.mCustomScrollbar.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>coach_1/assets/vendor/hs-megamenu/src/hs.megamenu.css">
  <link rel="stylesheet" href="<?= base_url() ?>coach_1/assets/vendor/hamburgers/hamburgers.min.css">

  <!-- CSS Unify -->
  <link rel="stylesheet" href="<?= base_url() ?>coach_1/assets/css/unify-core.css">
  <link rel="stylesheet" href="<?= base_url() ?>coach_1/assets/css/unify-components.css">
  <link rel="stylesheet" href="<?= base_url() ?>coach_1/assets/css/unify-globals.css">

  <!-- CSS Customization -->
  <link rel="stylesheet" href="<?= base_url() ?>coach_1/assets/css/custom.css">
</head>

<body>
  <main>



    <!-- Header -->
    <header id="js-header" class="u-header u-header--static">

    </header>
    <!-- End Header -->

    <!-- Breadcrumb -->
    <section class="g-my-30">

    </section>
    <!-- End Breadcrumb -->

    <section class="g-mb-100">
      <div class="container">
        <div class="row">
          <!-- Profile Sidebar -->
          <div class="col-lg-3 g-mb-50 g-mb-0--lg">
            <input class="form-control" type="hidden" id="coach_id" value="<?=isset($login_user) ? $login_user->id: '' ?>"/>


            <!-- Sidebar Navigation -->
            <div class="list-group list-group-border-0 g-mb-40">
              <div id="logout" class="btn-header transparent pull-right">
                <span> <a href="<?= base_url() ?>coach/login/logout" title="Sign Out" data-action="userLogout" data-logout-msg="You can improve your security further after logging out by closing this opened browser">登出</a> </span>
              </div>
              <a href="<?= base_url() ?>page-profile-main-1.html" class="list-group-item justify-content-between active">
                <span><i class="icon-home g-pos-rel g-top-1 g-mr-8"></i> 主頁</span>
              </a>
              <!-- End Overall -->

              <!-- Profile -->
              <!-- <a href="<?= base_url() ?>page-profile-profile-1.html" class="list-group-item list-group-item-action justify-content-between">
                <span><i class="icon-cursor g-pos-rel g-top-1 g-mr-8"></i> Profile</span>
              </a> -->
              <!-- End Profile -->

              <!-- Users Contacts -->
              <!-- <a href="<?= base_url() ?>page-profile-users-1.html" class="list-group-item list-group-item-action justify-content-between">
                <span><i class="icon-notebook g-pos-rel g-top-1 g-mr-8"></i> Users Contacts</span>
              </a> -->
              <!-- End Users Contacts -->

              <!-- My Projects -->
              <!-- <a href="<?= base_url() ?>page-profile-projects-1.html" class="list-group-item list-group-item-action justify-content-between">
                <span><i class="icon-layers g-pos-rel g-top-1 g-mr-8"></i> My Projects</span>
                <span class="u-label g-font-size-11 g-bg-primary g-rounded-20 g-px-10">9</span>
              </a> -->
              <!-- End My Projects -->

              <!-- Comments -->
              <!-- <a href="<?= base_url() ?>page-profile-comments-1.html" class="list-group-item list-group-item-action justify-content-between">
                <span><i class="icon-bubbles g-pos-rel g-top-1 g-mr-8"></i> Comments</span>
                <span class="u-label g-font-size-11 g-bg-pink g-rounded-20 g-px-8">24</span>
              </a> -->
              <!-- End Comments -->

              <!-- Reviews -->
              <!-- <a href="<?= base_url() ?>page-profile-reviews-1.html" class="list-group-item list-group-item-action justify-content-between">
                <span><i class="icon-heart g-pos-rel g-top-1 g-mr-8"></i> Reviews</span>
              </a> -->
              <!-- End Reviews -->

              <!-- History -->
              <!-- <a href="<?= base_url() ?>page-profile-history-1.html" class="list-group-item list-group-item-action justify-content-between">
                <span><i class="icon-fire g-pos-rel g-top-1 g-mr-8"></i> History</span>
              </a> -->
              <!-- End History -->

              <!-- Settings -->
              <a href="<?= base_url() ?>page-profile-settings-1.html" class="list-group-item list-group-item-action justify-content-between">
                <span><i class="icon-settings g-pos-rel g-top-1 g-mr-8"></i> </span>
                <span class="u-label g-font-size-11 g-bg-cyan g-rounded-20 g-px-8">3</span>
              </a>
              <!-- End Settings -->
            </div>
            <!-- End Sidebar Navigation -->


            <!-- End Project Progress -->
          </div>
          <!-- End Profile Sidebar -->

          <!-- Profile Content -->
          <div class="col-lg-9">
            <!-- Overall Statistics -->
            <div class="row g-mb-40">

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

              <div class="card-block g-pa-0">
                <!-- Product Table -->
                <div class="table-responsive">
                  <table id="dt_list" class="table table-bordered u-table--v2">
                    <thead class="text-uppercase g-letter-spacing-1">
                      <tr>
                        <th class="g-font-weight-300 g-color-black g-min-width-200">學員名字</th>
                        <th class="g-font-weight-300 g-color-black">年齡</th>
                        <th class="g-font-weight-300 g-color-black">身高</th>
                        <th class="g-font-weight-300 g-color-black">性別</th>
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
    </section>

    <a class="js-go-to u-go-to-v1" href="<?= base_url() ?>#" data-type="fixed" data-position='{
     "bottom": 15,
     "right": 15
   }' data-offset-top="400" data-compensation="#js-header" data-show-effect="zoomIn">
      <i class="hs-icon hs-icon-arrow-top"></i>
    </a>
  </main>

  <div class="u-outer-spaces-helper"></div>

</body>

</html>
<!-- JS Global Compulsory -->
<script src="<?= base_url() ?>coach_1/assets/vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url() ?>coach_1/assets/vendor/jquery-migrate/jquery-migrate.min.js"></script>
<script src="<?= base_url() ?>coach_1/assets/vendor/popper.js/popper.min.js"></script>
<script src="<?= base_url() ?>coach_1/assets/vendor/bootstrap/bootstrap.min.js"></script>


<!-- JS Implementing Plugins -->
<script src="<?= base_url() ?>coach_1/assets/vendor/appear.js"></script>
<script src="<?= base_url() ?>coach_1/assets/vendor/hs-megamenu/src/hs.megamenu.js"></script>
<script src="<?= base_url() ?>coach_1/assets/vendor/malihu-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- JS Unify -->
<script src="<?= base_url() ?>coach_1/assets/js/hs.core.js"></script>
<script src="<?= base_url() ?>coach_1/assets/js/helpers/hs.hamburgers.js"></script>
<script src="<?= base_url() ?>coach_1/assets/js/components/hs.header.js"></script>
<script src="<?= base_url() ?>coach_1/assets/js/components/hs.tabs.js"></script>
<script src="<?= base_url() ?>coach_1/assets/js/components/hs.counter.js"></script>
<script src="<?= base_url() ?>coach_1/assets/js/components/hs.progress-bar.js"></script>
<script src="<?= base_url() ?>coach_1/assets/js/components/hs.rating.js"></script>
<script src="<?= base_url() ?>coach_1/assets/js/components/hs.scrollbar.js"></script>
<script src="<?= base_url() ?>coach_1/assets/js/components/hs.go-to.js"></script>
<script src="<?= base_url('js/plugin/bootstrap-fileinput/js/fileinput.js') ?>"></script>

<!-- JS Customization -->
<script src="<?= base_url() ?>coach_1/assets/js/custom.js"></script>

<!-- JS Plugins Init. -->
<script>
  $(document).on('ready', function () {
      // initialization of go to
      $.HSCore.components.HSGoTo.init('.js-go-to');

      // initialization of tabs
      $.HSCore.components.HSTabs.init('[role="tablist"]');

      // initialization of counters
      var counters = $.HSCore.components.HSCounter.init('[class*="js-counter"]');

      // initialization of rating
      $.HSCore.components.HSRating.init($('.js-rating'), {
        spacing: 2
      });

      // initialization of HSScrollBar component
      $.HSCore.components.HSScrollBar.init( $('.js-scrollbar') );
    });

    $(window).on('load', function () {
      // initialization of header
      $.HSCore.components.HSHeader.init($('#js-header'));
      $.HSCore.helpers.HSHamburgers.init('.hamburger');

      // initialization of HSMegaMenu component
      $('.js-mega-menu').HSMegaMenu({
        event: 'hover',
        pageContainer: $('.container'),
        breakpoint: 991
      });

      // initialization of horizontal progress bars
      setTimeout(function () { // important in this case
        var horizontalProgressBars = $.HSCore.components.HSProgressBar.init('.js-hr-progress-bar', {
          direction: 'horizontal',
          indicatorSelector: '.js-hr-progress-bar-indicator'
        });
      }, 1);
    });

    $(window).on('resize', function () {
      setTimeout(function () {
        $.HSCore.components.HSTabs.init('[role="tablist"]');
      }, 200);
    });
</script>
<script>
var baseUrl = '<?=base_url('')?>';

function for_table(page){
  var url = baseUrl + 'coach/coach_home/get_data';

  $.ajax({
    type : "POST",
    url : url,
    data : {
      id: $('#coach_id').val(),
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
          $('<td>').html(me.height).appendTo($tr);
          if(me.gender==0){
            $('<td>').html('女').appendTo($tr);
          } else{
            if(me.gender==1){
              $('<td>').html('男').appendTo($tr);
            }
          }
        })
      }
      $('.u-pagination-v1__item').removeClass('u-pagination-v1-4--active ');
      $('.s'+page).addClass('u-pagination-v1-4--active');
    }
  });
}

for_table(1);

</script>
