<!-- Title -->
<title>LUNA3</title>

<!-- Required Meta Tags Always Come First -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="x-ua-compatible" content="ie=edge">

<link rel="shortcut icon" href="<?= base_url() ?>luna_1/favicon.ico">
<!-- Google Fonts -->
<!-- <link rel="stylesheet" href="<?= base_url() ?>https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800"> -->
<!-- CSS Global Compulsory -->
<link rel="stylesheet" href="<?= base_url() ?>luna_1/assets/vendor/bootstrap/bootstrap.min.css">
<!-- CSS Global Icons -->
<link rel="stylesheet" href="<?= base_url() ?>luna_1/assets/vendor/icon-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="<?= base_url() ?>luna_1/assets/vendor/icon-line/css/simple-line-icons.css">
<link rel="stylesheet" href="<?= base_url() ?>luna_1/assets/vendor/icon-etlinefont/style.css">
<link rel="stylesheet" href="<?= base_url() ?>luna_1/assets/vendor/icon-line-pro/style.css">
<link rel="stylesheet" href="<?= base_url() ?>luna_1/assets/vendor/icon-hs/style.css">
<link rel="stylesheet" href="<?= base_url() ?>luna_1/assets/vendor/animate.css">
<link rel="stylesheet" href="<?= base_url() ?>luna_1/assets/vendor/malihu-scrollbar/jquery.mCustomScrollbar.min.css">
<link rel="stylesheet" href="<?= base_url() ?>luna_1/assets/vendor/hs-megamenu/src/hs.megamenu.css">
<link rel="stylesheet" href="<?= base_url() ?>luna_1/assets/vendor/hamburgers/hamburgers.min.css">

<!-- CSS Unify -->
<link rel="stylesheet" href="<?= base_url() ?>luna_1/assets/css/unify-core.css">
<link rel="stylesheet" href="<?= base_url() ?>luna_1/assets/css/unify-components.css">
<link rel="stylesheet" href="<?= base_url() ?>luna_1/assets/css/unify-globals.css">

<!-- CSS Customization -->
<link rel="stylesheet" href="<?= base_url() ?>luna_1/assets/css/custom.css">
<style>

  body {
    background-image: url('<?= base_url('img/luna/back.png') ?>'); /* 這裡是背景圖片的路徑 */
    background-size: cover;           /* 自動縮放圖片以填滿整個畫面 */
    background-repeat: no-repeat;     /* 不重複圖片 */
    background-position: center;      /* 圖片置中 */
    background-attachment: fixed;     /* 滾動時背景固定 */
  }
    html, body {
    height: 100%;
    margin: 0;
  }

  body {
    display: flex;
    flex-direction: column;
  }

  main {
    flex: 1;
  }

  footer {
    /* 確保 footer 不會被壓縮，並正常顯示 */
    flex-shrink: 0;
  }
</style>
<style>
    /* -------- 版面與固定頁腳（不使用 position:fixed，避免覆蓋內容） -------- */
    html, body { height:100%; }
    body{ min-height:100%; display:flex; flex-direction:column; }
    main{ flex:1 0 auto; }          /* 主內容撐滿 */
    .site-footer{ flex-shrink:0; }   /* 頁腳固定在最底，不抖動 */

    /* -------- 原有樣式 -------- */
    #checkoutLoading { display: none; }
    #checkoutLoading.is-active { display: flex; }
    :root{
      --primary:#2b7cff;
      --muted:#6c757d;
      --soft:#f7f9fc;
      --border:#e9edf2;
      --shadow:0 10px 30px rgba(18,38,63,.08);
    }
    .mono{font-family:ui-monospace, SFMono-Regular, Menlo, Consolas, "Liberation Mono", monospace}
    .shop-toolbar{gap:.5rem}
    .product-card{transition:transform .15s ease, box-shadow .15s ease; border:1px solid var(--border)}
    .product-card:hover{transform:translateY(-2px); box-shadow:var(--shadow)}
    .price{font-weight:700}
    .qty-input{max-width:96px}
    .name-title{margin-bottom:.375rem; font-size:1rem}
    .name-en{color:var(--muted); font-size:.85rem; line-height:1.2; min-height:1.2em; margin-bottom:.625rem}
    .scroll-wrap{display:block; overflow:hidden; white-space:nowrap; text-overflow:ellipsis}
    .scroll-inner{display:inline-block; white-space:nowrap; will-change:transform; padding-right:1rem}
    .scroll-wrap.marquee{ text-overflow:clip }
    .scroll-wrap.marquee .scroll-inner{ animation: name-slide var(--slide-sec, 5s) linear 1 }
    @keyframes name-slide{ from{transform:translateX(0)} to{transform:translateX(calc(-1 * var(--slide-px,0px)))} }

    .btn-pill{border-radius:999px}
    .badge-dot{display:inline-flex; align-items:center; gap:.35rem; padding:.2rem .6rem; border-radius:999px; background:var(--soft); border:1px solid var(--border)}
    .badge-dot i{width:.45rem; height:.45rem; border-radius:50%; background:var(--primary); display:inline-block}

    .cart-mask{
      position:fixed; inset:0; background:rgba(15,23,42,.45);
      opacity:0; visibility:hidden; transition:.25s ease; z-index:1040;
    }
    .cart-mask.show{opacity:1; visibility:visible}
    .cart-drawer{
      position:fixed; top:0; right:0; height:100vh; width:min(420px,100%);
      background:#fff; box-shadow:var(--shadow); border-left:1px solid var(--border);
      transform:translateX(100%); transition:transform .3s ease; z-index:1050;
      display:flex; flex-direction:column;
    }
    .cart-drawer.open{ transform:translateX(0) }
    .cart-header{
      position:sticky; top:0; background:#fff; border-bottom:1px solid var(--border);
      padding:14px 16px; display:flex; align-items:center; justify-content:space-between;
    }
    .cart-body{ padding:10px 12px; overflow:auto; flex:1 }
    .cart-footer{
      position:sticky; bottom:0; background:#fff; border-top:1px solid var(--border);
      padding:14px 16px;
    }
    .cart-item{
      display:grid; grid-template-columns:1fr auto; gap:6px 10px;
      border:1px solid var(--border); border-radius:12px; padding:10px 12px; margin-bottom:10px;
    }
    .cart-item .title{font-weight:600}
    .cart-item .price{color:#0b5; font-weight:700}
    .qty-wrap{display:inline-flex; align-items:center; border:1px solid var(--border); border-radius:10px; overflow:hidden}
    .qty-btn{width:32px; height:32px; border:0; background:#f2f5fb; font-weight:700}
    .qty-input2{width:56px; height:32px; border:0; text-align:center; outline:0}
    .btn-primary{background:var(--primary); border-color:var(--primary)}
    .btn-outline-primary{border-color:var(--primary); color:var(--primary)}
    .btn-outline-primary:hover{background:var(--primary); color:#fff}
    .shadow-soft{box-shadow:var(--shadow)}

    .toast-mini{
      position:fixed; right:18px; bottom:18px; background:#111827; color:#fff; padding:8px 12px;
      border-radius:10px; opacity:0; transform:translateY(10px); transition:.25s ease; z-index:1100; font-size:.92rem;
    }
    .toast-mini.show{opacity:1; transform:translateY(0)}
    .is-disabled { pointer-events:none; opacity:.7 }

    /* -------- 分頁視覺 -------- */
    .pager-wrap{ display:flex; justify-content:center; }
    .pagination .page-link{ color:#2b7cff; }
    .pagination .page-item.active .page-link{
      background:#2b7cff; border-color:#2b7cff; color:#fff;
    }
    .pagination .page-item.disabled .page-link{ color:#999; pointer-events:none; }
  </style>
</style>