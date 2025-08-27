<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <title>Luna 登入</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <!-- Favicon -->
  <link rel="shortcut icon" href="<?= base_url() ?>luna_1/favicon.ico">

  <!-- Google Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap">

  <!-- Vendor CSS -->
  <link rel="stylesheet" href="<?= base_url() ?>luna_1/assets/vendor/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>luna_1/assets/vendor/icon-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>luna_1/assets/vendor/icon-hs/style.css">
  <link rel="stylesheet" href="<?= base_url() ?>luna_1/assets/vendor/animate.css">
  <link rel="stylesheet" href="<?= base_url() ?>luna_1/assets/vendor/hs-megamenu/src/hs.megamenu.css">
  <link rel="stylesheet" href="<?= base_url() ?>luna_1/assets/vendor/hamburgers/hamburgers.min.css">

  <!-- Unify CSS -->
  <link rel="stylesheet" href="<?= base_url() ?>luna_1/assets/css/unify-core.css">
  <link rel="stylesheet" href="<?= base_url() ?>luna_1/assets/css/unify-components.css">
  <link rel="stylesheet" href="<?= base_url() ?>luna_1/assets/css/unify-globals.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?= base_url() ?>luna_1/assets/css/custom.css">
  <head>
    <?php $this -> load -> view("luna/luna_head")  ?>
  </head>

  <style>
    :root{
      --primary:#2b7cff;
      --primary-600:#1f6cf7;
      --accent:#8c5bff;
      --muted:#6b7280;
      --border:#e5e7eb;
      --glass: rgba(255,255,255,.7);
      --shadow: 0 20px 60px rgba(2,13,40,.15);
    }

    html, body { height:100%; }
    body{
      min-height:100%;
      display:flex; flex-direction:column;
      font-family: Inter, "Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans TC", "PingFang TC", "Microsoft JhengHei", sans-serif;
      background:
        radial-gradient(1200px 600px at 10% -10%, #dbeafe 0%, transparent 60%),
        radial-gradient(900px 600px at 110% -20%, #ede9fe 0%, transparent 60%),
        linear-gradient(180deg, #f8fafc 0%, #eef2ff 100%);
    }
    main{ flex:1 0 auto; display:flex; align-items:center; }

    /* 卡片（玻璃風格） */
    .auth-card{
      backdrop-filter: blur(10px);
      background: var(--glass);
      border: 1px solid rgba(255,255,255,.6);
      border-radius: 16px;
      box-shadow: var(--shadow);
    }

    /* LOGO/標題區 */
    .brand-circle{
      width:56px; height:56px; border-radius:14px;
      display:flex; align-items:center; justify-content:center;
      background: linear-gradient(135deg, var(--primary), var(--accent));
      color:#fff; font-weight:800; letter-spacing: .5px;
      box-shadow: 0 10px 30px rgba(43,124,255,.35);
    }

    /* 浮動標籤表單 */
    .form-float .form-group{
      position:relative; margin-bottom:1.25rem;
    }
    .form-float .form-control{
      height: 52px;
      padding: 1.25rem .9rem .4rem .9rem;
      border:1px solid var(--border);
      border-radius:12px;
      transition: .15s ease;
      background:#fff;
    }
    .form-float .form-control:focus{
      outline:0;
      border-color: rgba(43,124,255,.55);
      box-shadow: 0 0 0 .25rem rgba(43,124,255,.12);
    }
    .form-float label{
      position:absolute; left:.9rem; top:.9rem; margin:0;
      color:var(--muted); font-size:.9rem; transition:.12s ease;
      pointer-events:none; background:#fff; padding:0 .25rem;
      transform-origin:left top;
    }
    .form-float .form-control:focus + label,
    .form-float .form-control:not(:placeholder-shown) + label{
      top:-.55rem; font-size:.75rem; color:var(--primary);
    }

    /* 密碼可視切換按鈕 */
    .field-append{
      position:absolute; right: .35rem; top:50%; transform: translateY(-50%);
      display:flex; align-items:center;
    }
    .btn-eye{
      border:0; background:transparent; color:#64748b; padding:.5rem .6rem; border-radius:10px;
    }
    .btn-eye:hover{ color:#0f172a; background:#f1f5f9; }

    /* 登入按鈕 */
    .btn-primary{
      background:var(--primary);
      border-color:var(--primary);
      font-weight:700; border-radius:12px; height:48px;
      transition:.15s ease;
    }
    .btn-primary:hover{ background:var(--primary-600); border-color:var(--primary-600); }

    .text-muted small{ color:var(--muted)!important; }

    /* footer 置底（不抖動） */
    .site-footer{ flex-shrink:0; }

    /* RWD 微調 */
    @media (max-width: 575.98px){
      .auth-card{ border-radius:14px; }
    }
  </style>
</head>

<body>
  <main>
    <div class="container py-5">
      <div class="row justify-content-center">
        <div class="col-sm-10 col-md-8 col-lg-5">
          <div class="auth-card p-4 p-md-5">
            <div class="text-center mb-4">
              <div class="brand-circle mx-auto mb-3">
                <span>L</span>
              </div>
              <h1 class="h3 mb-1" style="font-weight:800;letter-spacing:.3px;">歡迎回來</h1>
              <div class="text-muted"><small>登入你的 Luna 帳號</small></div>
            </div>

            <!-- Form -->
            <form class="form-float" id="login-form" novalidate>
              <div class="form-group">
                <input class="form-control" required name="account" type="text" placeholder=" " autocomplete="username">
                <label>帳號</label>
              </div>

              <div class="form-group">
                <input class="form-control" required name="password" type="password" placeholder=" " autocomplete="current-password" maxlength="64" id="passwordField">
                <label>密碼</label>
                <div class="field-append">
                  <button type="button" class="btn-eye" id="togglePwd" aria-label="顯示/隱藏密碼">
                    <i class="fa fa-eye-slash"></i>
                  </button>
                </div>
              </div>

              <button class="btn btn-primary w-100 d-inline-flex align-items-center justify-content-center" type="submit" id="btnLogin">
                <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true" id="btnSpinner"></span>
                登入
              </button>

              <div class="text-center text-muted mt-3">
                <small>登入遇到問題？請聯繫管理員</small>
              </div>
            </form>
            <!-- End Form -->
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- footer 放在 main 外，才能穩定貼底 -->
  <div class="site-footer">
    <?php $this->load->view("luna/luna_footer"); ?>
  </div>

  <div class="u-outer-spaces-helper"></div>

  <!-- JS Global Compulsory -->
  <script src="<?= base_url() ?>luna_1/assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?= base_url() ?>luna_1/assets/vendor/jquery-migrate/jquery-migrate.min.js"></script>
  <script src="<?= base_url() ?>luna_1/assets/vendor/popper.js/popper.min.js"></script>
  <script src="<?= base_url() ?>luna_1/assets/vendor/bootstrap/bootstrap.min.js"></script>

  <!-- JS Implementing Plugins -->
  <script src="<?= base_url() ?>luna_1/assets/vendor/hs-megamenu/src/hs.megamenu.js"></script>

  <!-- JS Unify -->
  <script src="<?= base_url() ?>luna_1/assets/js/hs.core.js"></script>
  <script src="<?= base_url() ?>luna_1/assets/js/components/hs.header.js"></script>
  <script src="<?= base_url() ?>luna_1/assets/js/helpers/hs.hamburgers.js"></script>
  <script src="<?= base_url() ?>luna_1/assets/js/components/hs.tabs.js"></script>
  <script src="<?= base_url() ?>luna_1/assets/js/components/hs.go-to.js"></script>

  <!-- Custom -->
  <script src="<?= base_url() ?>luna_1/assets/js/custom.js"></script>
  <script src="<?= base_url() ?>js/plugin/jquery-validate/jquery.validate.min.js"></script>

  <script>
    (function(){
      // 密碼可視/隱藏
      const pwd = document.getElementById('passwordField');
      const tgl = document.getElementById('togglePwd');
      tgl.addEventListener('click', function(){
        const on = pwd.type === 'password';
        pwd.type = on ? 'text' : 'password';
        this.innerHTML = on ? '<i class="fa fa-eye"></i>' : '<i class="fa fa-eye-slash"></i>';
      });

      // jQuery Validate + AJAX
      $("#login-form").validate({
        rules : {
          account : { required : true },
          password : {
            required : true,
            minlength : 1,
            maxlength : 64
          }
        },
        messages : {
          account : { required : '請輸入帳號' },
          password : { required : '請輸入密碼' }
        },
        errorPlacement : function(error, element) {
          // 浮動標籤下方顯示
          error.addClass('text-danger small mt-1');
          error.insertAfter(element.closest('.form-group'));
        },
        submitHandler : function(form) {
          const $btn = $("#btnLogin");
          const $spn = $("#btnSpinner");
          $btn.prop('disabled', true);
          $spn.removeClass('d-none');

          $.ajax({
            type: "POST",
            url: '<?= base_url('luna/login/do_login') ?>',
            dataType: 'json',
            data: $("#login-form").serialize(),
            success: function(data){
              if(data && data.msg){
                alert(data.msg);
                $btn.prop('disabled', false);
                $spn.addClass('d-none');
                return;
              }
              // 預期成功導向
              location.href = "<?= base_url('luna/luna_home') ?>";
            },
            error: function(){
              alert('登入失敗或連線異常，請稍後再試');
              $btn.prop('disabled', false);
              $spn.addClass('d-none');
            }
          });
        }
      });
    })();
  </script>
</body>
</html>
