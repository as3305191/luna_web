<!DOCTYPE html>
<html lang="en">

<head>
  <?php $this -> load -> view("luna/luna_head")  ?>
</head>
    <!-- End Header -->

    <!-- Header -->
    <?php $this -> load -> view("luna/luna_header")  ?>
    <!-- End Header -->
    <section class="g-mb-100">
      <div class="container">
        <div class="row">
          <!-- luna Sidebar -->
          <?php $this -> load -> view("luna/luna_sidebar")  ?>
          <!-- End luna Sidebar -->

          <!-- Profle Content -->
          <div class="col-lg-9">
            <!-- Nav tabs -->
            <ul class="nav nav-justified u-nav-v1-1 u-nav-primary g-brd-bottom--md g-brd-bottom-2 g-brd-primary g-mb-10" role="tablist" data-target="nav-1-1-default-hor-left-underline" data-tabs-mobile-type="slide-up-down" data-btn-classes="btn btn-md btn-block rounded-0 u-btn-outline-primary g-mb-20">
              <li class="nav-item">
                <a class="nav-link g-py-10 active" data-toggle="tab" href="#nav-1-1-default-hor-left-underline--1" role="tab">教練基本資料設定</a>
              </li>

              <!-- <li class="nav-item">
                <a class="nav-link g-py-10" data-toggle="tab" href="#nav-1-1-default-hor-left-underline--3" role="tab">其他功能</a>
              </li>
              <li class="nav-item">
                <a class="nav-link g-py-10" data-toggle="tab" href="#nav-1-1-default-hor-left-underline--4" role="tab">其他功能</a>
              </li> -->
            </ul>
            <!-- End Nav tabs -->

            <!-- Tab panes -->
            <div id="nav-1-1-default-hor-left-underline" class="tab-content">
              <!-- Edit Profile -->
              <div class="tab-pane fade show active" id="nav-1-1-default-hor-left-underline--1" role="tabpanel" data-parent="#nav-1-1-default-hor-left-underline">
                <form>
                  <!-- Current Password -->
                  <div class="form-group row g-mb-25">
                    <label class="col-sm-3 col-form-label g-color-gray-dark-v2 g-font-weight-700 text-sm-right g-mb-10">帳號</label>
                    <div class="col-sm-9">
                      <div class="input-group g-brd-primary--focus">
                        <input class="form-control form-control-md border-right-0 rounded-0 g-py-13 pr-0" type="text" id="account" placeholder="請輸入帳號" value="<?= isset($login_user) ? $login_user -> account : '' ?>">
                        <div class="input-group-append">
                          <span class="input-group-text g-bg-white g-color-gray-light-v1 rounded-0"><i class="icon-lock"></i></span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- End Current Password -->
                  <div class="form-group row g-mb-25">
                    <label class="col-sm-3 col-form-label g-color-gray-dark-v2 g-font-weight-700 text-sm-right g-mb-10">密碼</label>
                    <div class="col-sm-9">
                      <div class="input-group g-brd-primary--focus">
                        <input class="form-control form-control-md border-right-0 rounded-0 g-py-13 pr-0" type="text" id="password" placeholder="請輸入密碼" value="<?= isset($login_user) ? $login_user -> password : '' ?>">
                        <div class="input-group-append">
                          <span class="input-group-text g-bg-white g-color-gray-light-v1 rounded-0"><i class="icon-lock"></i></span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row g-mb-25">
                    <label class="col-sm-3 col-form-label g-color-gray-dark-v2 g-font-weight-700 text-sm-right g-mb-10">信箱</label>
                    <div class="col-sm-9">
                      <div class="input-group g-brd-primary--focus">
                        <input class="form-control form-control-md border-right-0 rounded-0 g-py-13 pr-0" type="text" id="email" placeholder="請輸入信箱" value="<?= isset($login_user) ? $login_user -> email : '' ?>">
                        <div class="input-group-append">
                          <span class="input-group-text g-bg-white g-color-gray-light-v1 rounded-0"><i class="icon-lock"></i></span>
                        </div>
                      </div>
                    </div>
                  </div>


                  <hr class="g-brd-gray-light-v4 g-my-25">

                  <div class="text-sm-right">
                    <!-- <a class="btn u-btn-darkgray rounded-0 g-py-12 g-px-25 g-mr-10" href="#">取消</a> -->
                    <a class="btn u-btn-primary rounded-0 g-py-12 g-px-25" onclick="do_save_luna()">儲存</a>
                  </div>
                </form>

              </div>
              <!-- End Edit Profile -->


              <!-- Payment Options -->
              <div class="tab-pane fade" id="nav-1-1-default-hor-left-underline--3" role="tabpanel" data-parent="#nav-1-1-default-hor-left-underline">
                <h2 class="h4 g-font-weight-300">敬請期待</h2>


              </div>
              <!-- End Payment Options -->

              <!-- Notification Settings -->
              <div class="tab-pane fade" id="nav-1-1-default-hor-left-underline--4" role="tabpanel" data-parent="#nav-1-1-default-hor-left-underline">
                <h2 class="h4 g-font-weight-300">敬請期待</h2>

              </div>
              <!-- End Notification Settings -->
            </div>
            <!-- End Tab panes -->
          </div>
          <!-- End Profle Content -->
        </div>
      </div>
    </section>


    <!-- Copyright Footer -->
    <?php $this -> load -> view("luna/luna_footer")  ?>
    <!-- End Copyright Footer -->


  </main>

  <div class="u-outer-spaces-helper"></div>




</body>

</html>
<!-- JS -->
<?php $this -> load -> view("luna/luna_script")  ?>
<!-- End JS -->

  <script>
  var baseUrl = '<?=base_url('')?>';
  function do_save_luna() {
  		var url = '<?= base_url() ?>' + 'luna/luna_setting/insert';
  		$.ajax({
  			url : url,
  			type: 'POST',
  			data: {
          id: $('#luna_id').val(),
          account: $('#account').val(),
          password: $('#password').val(),
          email: $('#email').val(),

  			},
  			dataType: 'json',
  			success: function(d) {
  			alert('儲存成功');

  			},
  			failure:function(){
  				alert('faialure');
  			}
  		});
  	}
  </script>
