<!DOCTYPE html>
<html lang="zh-Hant-TW">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta charset="UTF-8">
    <title>Kokokara 購物中心</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/ico">
    <link rel="icon" href="favicon.ico" type="image/ico">
    <link rel="icon" href="favicon.svg" type="image/svg+xml">
    <!-- Vender  -->
    <link rel="stylesheet" type="text/css" href="vendor/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/icon-line-pro/style.css">
    <link rel="stylesheet" type="text/css" href="vendor/icon-line/css/simple-line-icons.css">
    <link rel="stylesheet" type="text/css" href="vendor/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/fancybox/jquery.fancybox.css">
    <!-- Koko CSS  -->
    <link rel="stylesheet" type="text/css" href="css/base.css">
    <link rel="stylesheet" type="text/css" href="css/layout.css">
    <link rel="stylesheet" type="text/css" href="css/global.css">
    <link rel="stylesheet" type="text/css" href="css/module.css">
    <link rel="stylesheet" type="text/css" href="css/component.css">
    <link rel="stylesheet" type="text/css" href="css/themes.css">
    <!--[if lte IE 9]>
        <script src="vendor/html5shiv/dist/html5shiv.min.js"></script>
        <script src="vendor/respond/dest/respond.min.js"></script>
        <script src="vendor/Placeholders.js-master/dist/placeholders.jquery.min.js"></script>
    <![endif]-->
</head>

<body>
    <main>
        <section class="koko-top-banner">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <span class="align-middle">RUSH SALE 01.06 23:59 (日本時間) 截止！</span>
                        <a class="btn btn--tertiary btn--xs" href="javascript:;">SALE商品請點這裡</a>
                    </div>
                </div>
            </div>
        </section>
        <header id="header">
            <!-- Top Nav Start -->
            <nav class="koko-top-nav">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="push-left hidden-sm">
                                <i class="icon-clock align-middle" aria-hidden="true"></i>
                                <font class="align-middle">Mon - Sun: 8:00 am to 5:00 pm</font>
                            </div>
                            <div class="push-right">
                                <select id="language">
                                    <option value="1">中文 (繁體)</option>
                                    <option value="2">中文 (簡體)</option>
                                </select>
                                <font>參和考幣別:</font>
                                <select id="cost">
                                    <option value="1">JPY</option>
                                    <option value="2">TWD</option>
                                </select>
                                <font>收貨地:</font>
                                <select id="area">
                                    <option value="1">台灣</option>
                                    <option value="2">大陸</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Top Nav End -->
            <!-- Header Start -->
            <section id="koko-header" class="koko-header">
                <div class="container">
                    <div class="koko-brand">
                        <a href="index.html">
                            <i class="koko-icon-img-logo">
                                <font class="path1"></font>
                                <font class="path2"></font>
                                <font class="path3"></font>
                                <font class="path4"></font>
                                <font class="path5"></font>
                                <font class="path6"></font>
                                <font class="path7"></font>
                                <font class="path8"></font>
                                <font class="path9"></font>
                            </i>
                        </a>
                    </div>
                    <a class="search-icon" href="javascript:;" id="searchInputIcon">
                        <i class="icon-magnifier"></i>
                    </a>
                    <form class="site-search" method="get">
                        <input class="search-input" type="text" placeholder="Search" autocomplete="off" id="searchInputBox1">
                        <i class="icon-close" id="searchClose"></i>
                    </form>
                    <form class="site-search" method="get">
                        <input class="search-input" type="text" placeholder="Search" autocomplete="off" id="searchInputBox1">
                        <i class="icon-close" id="searchClose"></i>
                    </form>
                    <div class="koko-search">
                        <div class="search-input-block" id="searchInput">
                            <select class="selectWhite" id="categories">
                                <option value="hide">商品分類</option>
                                <option value="1">Categories</option>
                            </select>
                            <div class="search-input-cnt">
                                <input class="search-input" type="text" placeholder="Search" autocomplete="off" id="searchInputBox">
                                <ul class="search-log" id="searchLog">
                                    <li><a href="javascript:;">富山123</a></li>
                                    <li><a href="javascript:;">富山123</a></li>
                                    <li><a href="javascript:;">富山123</a></li>
                                </ul>
                            </div>
                            <button class="btn btn--primary" type="button">
                                <i class="icon-magnifier align-middle mr-4"></i>
                                <span class="align-middle">SEARCH</span>
                            </button>
                        </div>
                    </div>
                    <div class="koko-member">
                        <ul class="member-main">
                            <li>
                                <a href="membercenter_contactUs.html">
                                    <i class="icon-speech" aria-hidden="true"></i>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;" id="basketShop">
                                    <i class="icon-basket" aria-hidden="true"></i>
                                </a>
                                <span class="counter badge member-main-badge" id="countCart">0</span>
                            </li>
                            <div id="basketIn" class="shopping-cart-basket">
                                <div class="shopping-cart-header">
                                    <h4>我的購物車</h4>
                                    <div class="shopping-cart-total">
                                        <span class="text--black">總共：</span>
                                        <span class="text--secondary tw">0</span>
                                    </div>
                                    <div class="clear-fix"></div>
                                </div>
                                <div class="shopping-cart-items" id="rtCard">
                                    <span id="rtempty" class="empty">還沒有購買商品喔！</span>
                                </div>
                                <a id="rtCheckBtn" href="cart_1_check.html" class="btn btn--block">立 即 結 帳</a>
                            </div>
                            <li>
                                <a href="membercenter.html">
                                    <i class="icon-people" aria-hidden="true"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
            <!-- Header End -->
            <!-- Main Nav Start-->
            <nav class="koko-navbar">
                <div class="container">
                    <div class="row" style="">
                        <div class="col-lg-12">
                            <!-- Product menu -->
                            <div class="cd-dropdown-wrapper">
                                <a class="cd-dropdown-trigger" href="javascript:;">
                                    <ul>
                                        <li></li>
                                        <li></li>
                                        <li></li>
                                    </ul>
                                    <span>商品目錄</span>
                                </a>
                                <nav class="cd-dropdown">
                                    <h2>
                                        <a href="javascript:;" class="logo">
                                            <img src="img/img-logo-white.svg" alt="kokokara">
                                        </a>
                                        <a href="signInUp.html" class="login-link text--underline">登入 / 註冊</a>
                                    </h2>
                                    <a href="javascript:;" class="cd-close">Close</a>
                                    <ul class="cd-dropdown-content">
                                        <li class="hidden-sm-up">
                                            <a href="javascript:;">
                                                <i class="icon-real-estate-043"></i>
                                                <span>首頁</span>
                                            </a>
                                        </li>
                                        <li class="cd-divider hidden-sm-up">商品分類</li>
                                        <li class="has-children">
                                            <a href="">
                                                <i class="icon-hotel-restaurant-106"></i>
                                                <span>美容</span>
                                            </a>
                                            <ul class="cd-secondary-dropdown is-hidden">
                                                <li class="go-back"><a href="javascript:;">Menu</a></li>
                                                <li class="has-children">
                                                    <a href="javascript:;">卸妝</a>
                                                    <ul class="is-hidden">
                                                        <li class="go-back"><a href="javascript:;">Clothing</a></li>
                                                        <li class="see-all"><a href="javascript:;">所有卸妝分類</a></li>
                                                        <li><a href="javascript:;">卸妝油</a></li>
                                                        <li><a href="javascript:;">卸妝凝</a></li>
                                                        <li><a href="javascript:;">卸妝霜</a></li>
                                                        <li><a href="javascript:;">卸妝乳</a></li>
                                                        <li><a href="javascript:;">卸妝棉</a></li>
                                                        <li><a href="javascript:;">卸妝水</a></li>
                                                    </ul>
                                                </li>
                                                <li class="has-children">
                                                    <a href="javascript:;">美髮/造型</a>
                                                    <ul class="is-hidden">
                                                        <li class="go-back"><a href="javascript:;">Clothing</a></li>
                                                        <li class="see-all"><a href="javascript:;">所有美髮/造型分類</a></li>
                                                        <li><a href="javascript:;">免沖洗護髮</a></li>
                                                        <li><a href="javascript:;">洗髮精</a></li>
                                                        <li><a href="javascript:;">頭皮護理</a></li>
                                                        <li><a href="javascript:;">頭髮造型</a></li>
                                                        <li><a href="javascript:;">護髮</a></li>
                                                        <li><a href="javascript:;">潤髮</a></li>
                                                    </ul>
                                                </li>
                                                <div class="clear-fix"></div>
                                                <li class="has-children">
                                                    <a href="javascript:;">美髮/造型</a>
                                                    <ul class="is-hidden">
                                                        <li class="go-back"><a href="javascript:;">Clothing</a></li>
                                                        <li class="see-all"><a href="javascript:;">所有美髮/造型分類</a></li>
                                                        <li><a href="javascript:;">免沖洗護髮</a></li>
                                                        <li><a href="javascript:;">洗髮精</a></li>
                                                        <li><a href="javascript:;">頭皮護理</a></li>
                                                        <li><a href="javascript:;">頭髮造型</a></li>
                                                        <li><a href="javascript:;">護髮</a></li>
                                                        <li><a href="javascript:;">潤髮</a></li>
                                                    </ul>
                                                </li>
                                                <li class="has-children">
                                                    <a href="javascript:;">卸妝</a>
                                                    <ul class="is-hidden">
                                                        <li class="go-back"><a href="javascript:;">Clothing</a></li>
                                                        <li class="see-all"><a href="javascript:;">所有卸妝分類</a></li>
                                                        <li><a href="javascript:;">卸妝油</a></li>
                                                        <li><a href="javascript:;">卸妝凝</a></li>
                                                        <li><a href="javascript:;">卸妝霜</a></li>
                                                        <li><a href="javascript:;">卸妝乳</a></li>
                                                        <li><a href="javascript:;">卸妝棉</a></li>
                                                        <li><a href="javascript:;">卸妝水</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="has-children">
                                            <a href="">
                                                <i class="icon-science-085"></i>
                                                <span>彩妝</span>
                                            </a>
                                            <ul class="cd-secondary-dropdown is-hidden">
                                                <li class="go-back"><a href="javascript:;">回第一層</a></li>
                                                <li class="has-children">
                                                    <a href="javascript:;">卸妝</a>
                                                    <ul class="is-hidden">
                                                        <li class="go-back"><a href="javascript:;">返回卸妝</a></li>
                                                        <li class="see-all"><a href="javascript:;">所有卸妝分類</a></li>
                                                        <li><a href="javascript:;">卸妝油</a></li>
                                                        <li><a href="javascript:;">卸妝凝</a></li>
                                                        <li><a href="javascript:;">卸妝霜</a></li>
                                                        <li><a href="javascript:;">卸妝乳</a></li>
                                                        <li><a href="javascript:;">卸妝棉</a></li>
                                                        <li><a href="javascript:;">卸妝水</a></li>
                                                    </ul>
                                                </li>
                                                <li class="has-children">
                                                    <a href="javascript:;">美髮/造型</a>
                                                    <ul class="is-hidden">
                                                        <li class="go-back"><a href="javascript:;">回第一層</a></li>
                                                        <li class="see-all"><a href="javascript:;">所有美髮/造型分類</a></li>
                                                        <li><a href="javascript:;">免沖洗護髮</a></li>
                                                        <li><a href="javascript:;">洗髮精</a></li>
                                                        <li><a href="javascript:;">頭皮護理</a></li>
                                                        <li><a href="javascript:;">頭髮造型</a></li>
                                                        <li><a href="javascript:;">護髮</a></li>
                                                        <li><a href="javascript:;">潤髮</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="has-children">
                                            <a href="">
                                                <i class="icon-medical-002"></i>
                                                <span>生活保健</span>
                                            </a>
                                            <ul class="cd-secondary-dropdown is-hidden">
                                                <li class="go-back"><a href="javascript:;">Menu</a></li>
                                                <li class="has-children">
                                                    <a href="javascript:;">卸妝</a>
                                                    <ul class="is-hidden">
                                                        <li class="go-back"><a href="javascript:;">Clothing</a></li>
                                                        <li class="see-all"><a href="javascript:;">所有卸妝分類</a></li>
                                                        <li><a href="javascript:;">卸妝油</a></li>
                                                        <li><a href="javascript:;">卸妝凝</a></li>
                                                        <li><a href="javascript:;">卸妝霜</a></li>
                                                        <li><a href="javascript:;">卸妝乳</a></li>
                                                        <li><a href="javascript:;">卸妝棉</a></li>
                                                        <li><a href="javascript:;">卸妝水</a></li>
                                                    </ul>
                                                </li>
                                                <li class="has-children">
                                                    <a href="javascript:;">美髮/造型</a>
                                                    <ul class="is-hidden">
                                                        <li class="go-back"><a href="javascript:;">Clothing</a></li>
                                                        <li class="see-all"><a href="javascript:;">所有美髮/造型分類</a></li>
                                                        <li><a href="javascript:;">免沖洗護髮</a></li>
                                                        <li><a href="javascript:;">洗髮精</a></li>
                                                        <li><a href="javascript:;">頭皮護理</a></li>
                                                        <li><a href="javascript:;">頭髮造型</a></li>
                                                        <li><a href="javascript:;">護髮</a></li>
                                                        <li><a href="javascript:;">潤髮</a></li>
                                                    </ul>
                                                </li>
                                                <div class="clear-fix"></div>
                                                <li class="has-children">
                                                    <a href="javascript:;">美髮/造型</a>
                                                    <ul class="is-hidden">
                                                        <li class="go-back"><a href="javascript:;">Clothing</a></li>
                                                        <li class="see-all"><a href="javascript:;">所有美髮/造型分類</a></li>
                                                        <li><a href="javascript:;">免沖洗護髮</a></li>
                                                        <li><a href="javascript:;">洗髮精</a></li>
                                                        <li><a href="javascript:;">頭皮護理</a></li>
                                                        <li><a href="javascript:;">頭髮造型</a></li>
                                                        <li><a href="javascript:;">護髮</a></li>
                                                        <li><a href="javascript:;">潤髮</a></li>
                                                    </ul>
                                                </li>
                                                <li class="has-children">
                                                    <a href="javascript:;">卸妝</a>
                                                    <ul class="is-hidden">
                                                        <li class="go-back"><a href="javascript:;">Clothing</a></li>
                                                        <li class="see-all"><a href="javascript:;">所有卸妝分類</a></li>
                                                        <li><a href="javascript:;">卸妝油</a></li>
                                                        <li><a href="javascript:;">卸妝凝</a></li>
                                                        <li><a href="javascript:;">卸妝霜</a></li>
                                                        <li><a href="javascript:;">卸妝乳</a></li>
                                                        <li><a href="javascript:;">卸妝棉</a></li>
                                                        <li><a href="javascript:;">卸妝水</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="has-children">
                                            <a href="">
                                                <i class="icon-medical-001"></i>
                                                <span>醫藥品</span>
                                            </a>
                                            <ul class="cd-secondary-dropdown is-hidden">
                                                <li class="go-back"><a href="javascript:;">回第一層</a></li>
                                                <li class="has-children">
                                                    <a href="javascript:;">卸妝</a>
                                                    <ul class="is-hidden">
                                                        <li class="go-back"><a href="javascript:;">返回卸妝</a></li>
                                                        <li class="see-all"><a href="javascript:;">所有卸妝分類</a></li>
                                                        <li><a href="javascript:;">卸妝油</a></li>
                                                        <li><a href="javascript:;">卸妝凝</a></li>
                                                        <li><a href="javascript:;">卸妝霜</a></li>
                                                        <li><a href="javascript:;">卸妝乳</a></li>
                                                        <li><a href="javascript:;">卸妝棉</a></li>
                                                        <li><a href="javascript:;">卸妝水</a></li>
                                                    </ul>
                                                </li>
                                                <li class="has-children">
                                                    <a href="javascript:;">美髮/造型</a>
                                                    <ul class="is-hidden">
                                                        <li class="go-back"><a href="javascript:;">回第一層</a></li>
                                                        <li class="see-all"><a href="javascript:;">所有美髮/造型分類</a></li>
                                                        <li><a href="javascript:;">免沖洗護髮</a></li>
                                                        <li><a href="javascript:;">洗髮精</a></li>
                                                        <li><a href="javascript:;">頭皮護理</a></li>
                                                        <li><a href="javascript:;">頭髮造型</a></li>
                                                        <li><a href="javascript:;">護髮</a></li>
                                                        <li><a href="javascript:;">潤髮</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="has-children">
                                            <a href="">
                                                <i class="icon-science-134"></i>
                                                <span>孕嬰用品</span>
                                            </a>
                                            <ul class="cd-secondary-dropdown is-hidden">
                                                <li class="go-back"><a href="javascript:;">回第一層</a></li>
                                                <li class="has-children">
                                                    <a href="javascript:;">卸妝</a>
                                                    <ul class="is-hidden">
                                                        <li class="go-back"><a href="javascript:;">返回卸妝</a></li>
                                                        <li class="see-all"><a href="javascript:;">所有卸妝分類</a></li>
                                                        <li><a href="javascript:;">卸妝油</a></li>
                                                        <li><a href="javascript:;">卸妝凝</a></li>
                                                        <li><a href="javascript:;">卸妝霜</a></li>
                                                        <li><a href="javascript:;">卸妝乳</a></li>
                                                        <li><a href="javascript:;">卸妝棉</a></li>
                                                        <li><a href="javascript:;">卸妝水</a></li>
                                                    </ul>
                                                </li>
                                                <li class="has-children">
                                                    <a href="javascript:;">美髮/造型</a>
                                                    <ul class="is-hidden">
                                                        <li class="go-back"><a href="javascript:;">回第一層</a></li>
                                                        <li class="see-all"><a href="javascript:;">所有美髮/造型分類</a></li>
                                                        <li><a href="javascript:;">免沖洗護髮</a></li>
                                                        <li><a href="javascript:;">洗髮精</a></li>
                                                        <li><a href="javascript:;">頭皮護理</a></li>
                                                        <li><a href="javascript:;">頭髮造型</a></li>
                                                        <li><a href="javascript:;">護髮</a></li>
                                                        <li><a href="javascript:;">潤髮</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li><a href="javascript:;">所有商品分類頁面</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Main Nav End -->
        </header>
        <article class="owl-carousel carousel-theme-full" id="koko-hero">
            <section class="koko-hero">
                <div class="mask mask_dark"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="content-text">
                                <h2>TOP CLASSIC WATCH</h2>
                                <p>Lorem ipsum is some dummy text generator</p>
                                <a href="#!" class="btn btn--lg">Subscribe</a>
                            </div>
                            <div class="content-box push-right">
                                <h3>Professional Power Tools</h3>
                                <p>
                                    Over the years, we’ve create power tools with professional equipments that complement your construction and building process.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="koko-hero" style="background-image: url('img/adv--header--2.jpg');">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="content-text">
                                <span class="text--secondary">BEAUTY COSMETICS</span>
                                <h2>NATURAL SKIN CARE</h2>
                                <p>Lorem ipsum is some dummy text generator</p>
                                <a href="#!" class="btn btn--border">SHOP COLLECTION</a>
                            </div>
                            <div class="content-box push-right">
                                <h3>Professional Power Tools</h3>
                                <p>
                                    Over the years, we’ve create power tools with professional equipments that complement your construction and building process.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </article>
        <section class="koko-activity bg--white">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-sm-12">
                        <a href="javascript:;">
                            <img src="img/adv--1.jpg" alt="">
                        </a>
                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <a href="javascript:;">
                            <img src="img/adv--2.jpg" alt="">
                        </a>
                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <a href="javascript:;">
                            <img src="img/adv--3.jpg" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <section class="koko-hot-product">
            <div class="row">
                <div class="col-lg-12">
                    <h3>人氣商品排行榜</h3>
                    <p class="mt-8 mb-24">After using various platforms, I changed!</p>
                </div>
            </div>
            <div class="owl-carousel owl-theme" id="koko-hot-product">
                <figure class="koko-card">
                    <a href="javascript:;" class="btn-favorite"></a>
                    <label class="badge-product--new">
                        <span>NEW</span>
                    </label>
                    <div class="box-up">
                        <div class="img-container">
                            <img class="img owl-lazy" data-src="img/img-product.svg" alt="productnames">
                            <div class="p-price">1,999</div>
                        </div>
                        <div class="info-inner">
                            <p class="p-name">體育帶黑/黑85厘米</p>
                            <p class="p-company text--ellipsis">Phiten</p>
                        </div>
                    </div>
                    <figcaption class="box-down">
                        <a class="cart-bg" href="javascript:;">
                            <div class="cart-bg-inner">
                                <span class="buy-btn">立即購買</span>
                            </div>
                        </a>
                        <a class="cart-btn addToCart" href="javascript:;">
                            <span class="add-to-cart">
                                <i class="icon-basket"></i>
                            </span>
                        </a>
                    </figcaption>
                </figure>
                <figure class="koko-card">
                    <a href="javascript:;" class="btn-favorite"></a>
                    <label class="badge-product--new">
                        <span>NEW</span>
                    </label>
                    <div class="box-up">
                        <div class="img-container">
                            <img class="img owl-lazy" data-src="img/img-product.svg" alt="productnames">
                            <div class="p-price">1999</div>
                        </div>
                        <div class="info-inner">
                            <p class="p-name">體育帶黑/黑85厘米</p>
                            <p class="p-company text--ellipsis">Phiten</p>
                        </div>
                    </div>
                    <figcaption class="box-down">
                        <a class="cart-bg" href="javascript:;">
                            <div class="cart-bg-inner">
                                <span class="buy-btn">立即購買</span>
                            </div>
                        </a>
                        <a class="cart-btn addToCart" href="javascript:;">
                            <span class="add-to-cart">
                                <i class="icon-basket"></i>
                            </span>
                        </a>
                    </figcaption>
                </figure>
                <figure class="koko-card">
                    <a href="javascript:;" class="btn-favorite"></a>
                    <label class="badge-product--new">
                        <span>NEW</span>
                    </label>
                    <div class="box-up">
                        <div class="img-container">
                            <img class="img owl-lazy" data-src="img/img-product.svg" alt="productnames">
                            <div class="p-price">1,999</div>
                        </div>
                        <div class="info-inner">
                            <p class="p-name">體育帶黑/黑85厘米</p>
                            <p class="p-company text--ellipsis">Phiten</p>
                        </div>
                    </div>
                    <figcaption class="box-down">
                        <a class="cart-bg" href="javascript:;">
                            <div class="cart-bg-inner">
                                <span class="buy-btn">立即購買</span>
                            </div>
                        </a>
                        <a class="cart-btn addToCart" href="javascript:;">
                            <span class="add-to-cart">
                                <i class="icon-basket"></i>
                            </span>
                        </a>
                    </figcaption>
                </figure>
                <figure class="koko-card">
                    <a href="javascript:;" class="btn-favorite"></a>
                    <label class="badge-product--new">
                        <span>NEW</span>
                    </label>
                    <div class="box-up">
                        <div class="img-container">
                            <img class="img owl-lazy" data-src="img/img-product.svg" alt="productnames">
                            <div class="p-price">1,999</div>
                        </div>
                        <div class="info-inner">
                            <p class="p-name">體育帶黑/黑85厘米</p>
                            <p class="p-company text--ellipsis">Phiten</p>
                        </div>
                    </div>
                    <figcaption class="box-down">
                        <a class="cart-bg" href="javascript:;">
                            <div class="cart-bg-inner">
                                <span class="buy-btn">立即購買</span>
                            </div>
                        </a>
                        <a class="cart-btn addToCart" href="javascript:;">
                            <span class="add-to-cart">
                                <i class="icon-basket"></i>
                            </span>
                        </a>
                    </figcaption>
                </figure>
                <figure class="koko-card">
                    <a href="javascript:;" class="btn-favorite"></a>
                    <label class="badge-product--new">
                        <span>NEW</span>
                    </label>
                    <div class="box-up">
                        <div class="img-container">
                            <img class="img owl-lazy" data-src="img/img-product.svg" alt="productnames">
                            <div class="p-price">1,999</div>
                        </div>
                        <div class="info-inner">
                            <p class="p-name">體育帶黑/黑85厘米</p>
                            <p class="p-company text--ellipsis">Phiten</p>
                        </div>
                    </div>
                    <figcaption class="box-down">
                        <a class="cart-bg" href="javascript:;">
                            <div class="cart-bg-inner">
                                <span class="buy-btn">立即購買</span>
                            </div>
                        </a>
                        <a class="cart-btn addToCart" href="javascript:;">
                            <span class="add-to-cart">
                                <i class="icon-basket"></i>
                            </span>
                        </a>
                    </figcaption>
                </figure>
                <figure class="koko-card">
                    <a href="javascript:;" class="btn-favorite"></a>
                    <label class="badge-product--new">
                        <span>NEW</span>
                    </label>
                    <div class="box-up">
                        <div class="img-container">
                            <img class="img owl-lazy" data-src="img/img-product.svg" alt="productnames">
                            <div class="p-price">1,999</div>
                        </div>
                        <div class="info-inner">
                            <p class="p-name">體育帶黑/黑85厘米</p>
                            <p class="p-company text--ellipsis">Phiten</p>
                        </div>
                    </div>
                    <figcaption class="box-down">
                        <a class="cart-bg" href="javascript:;">
                            <div class="cart-bg-inner">
                                <span class="buy-btn">立即購買</span>
                            </div>
                        </a>
                        <a class="cart-btn addToCart" href="javascript:;">
                            <span class="add-to-cart">
                                <i class="icon-basket"></i>
                            </span>
                        </a>
                    </figcaption>
                </figure>
                <figure class="koko-card">
                    <a href="javascript:;" class="btn-favorite"></a>
                    <label class="badge-product--new">
                        <span>NEW</span>
                    </label>
                    <div class="box-up">
                        <div class="img-container">
                            <img class="img owl-lazy" data-src="img/img-product.svg" alt="productnames">
                            <div class="p-price">1,999</div>
                        </div>
                        <div class="info-inner">
                            <p class="p-name">體育帶黑/黑85厘米</p>
                            <p class="p-company text--ellipsis">Phiten</p>
                        </div>
                    </div>
                    <figcaption class="box-down">
                        <a class="cart-bg" href="javascript:;">
                            <div class="cart-bg-inner">
                                <span class="buy-btn">立即購買</span>
                            </div>
                        </a>
                        <a class="cart-btn addToCart" href="javascript:;">
                            <span class="add-to-cart">
                                <i class="icon-basket"></i>
                            </span>
                        </a>
                    </figcaption>
                </figure>
                <figure class="koko-card">
                    <a href="javascript:;" class="btn-favorite"></a>
                    <label class="badge-product--new">
                        <span>NEW</span>
                    </label>
                    <div class="box-up">
                        <div class="img-container">
                            <img class="img owl-lazy" data-src="img/img-product.svg" alt="productnames">
                            <div class="p-price">1,999</div>
                        </div>
                        <div class="info-inner">
                            <p class="p-name">體育帶黑/黑85厘米</p>
                            <p class="p-company text--ellipsis">Phiten</p>
                        </div>
                    </div>
                    <figcaption class="box-down">
                        <a class="cart-bg" href="javascript:;">
                            <div class="cart-bg-inner">
                                <span class="buy-btn">立即購買</span>
                            </div>
                        </a>
                        <a class="cart-btn addToCart" href="javascript:;">
                            <span class="add-to-cart">
                                <i class="icon-basket"></i>
                            </span>
                        </a>
                    </figcaption>
                </figure>
            </div>
        </section>
        <section class="koko-record bg--white">
            <div class="row">
                <div class="col-lg-12">
                    <h3>最近瀏覽過的商品</h3>
                    <p class="mt-8 mb-24">After using various platforms, I changed!</p>
                </div>
            </div>
            <div class="owl-carousel owl-theme" id="koko-record-list">
                <a href="#!"><img class="img owl-lazy" data-src="img/img-product.svg" alt=""></a>
                <a href="#!"><img class="img owl-lazy" data-src="img/img-product.svg" alt=""></a>
                <a href="#!"><img class="img owl-lazy" data-src="img/img-product.svg" alt=""></a>
                <a href="#!"><img class="img owl-lazy" data-src="img/img-product.svg" alt=""></a>
                <a href="#!"><img class="img owl-lazy" data-src="img/img-product.svg" alt=""></a>
                <a href="#!"><img class="img owl-lazy" data-src="img/img-product.svg" alt=""></a>
                <a href="#!"><img class="img owl-lazy" data-src="img/img-product.svg" alt=""></a>
                <a href="#!"><img class="img owl-lazy" data-src="img/img-product.svg" alt=""></a>
                <a href="#!"><img class="img owl-lazy" data-src="img/img-product.svg" alt=""></a>
            </div>
        </section>
        <section class="koko-push-product bg--lightorange--1">
            <div class="row">
                <div class="col-lg-12">
                    <h3>最新熱門推薦商品</h3>
                    <p class="mt-8 mb-24">After using various platforms, I changed!</p>
                </div>
            </div>
            <div class="owl-carousel owl-theme" id="koko-push-product">
                <figure class="koko-card">
                    <a href="javascript:;" class="btn-favorite"></a>
                    <div class="box-up">
                        <div class="img-container">
                            <img class="img owl-lazy" data-src="img/img-product.svg" alt="productnames">
                            <div class="p-price">1,999</div>
                        </div>
                        <div class="info-inner">
                            <p class="p-name">體育帶黑/黑85厘米</p>
                            <p class="p-company text--ellipsis">Phiten</p>
                        </div>
                    </div>
                    <figcaption class="box-down">
                        <a class="cart-bg" href="javascript:;">
                            <div class="cart-bg-inner">
                                <span class="buy-btn">立即購買</span>
                            </div>
                        </a>
                        <a class="cart-btn addToCart" href="javascript:;">
                            <span class="add-to-cart">
                                <i class="icon-basket"></i>
                            </span>
                        </a>
                    </figcaption>
                </figure>
                <figure class="koko-card">
                    <a href="javascript:;" class="btn-favorite"></a>
                    <div class="box-up">
                        <div class="img-container">
                            <img class="img owl-lazy" data-src="img/img-product.svg" alt="productnames">
                            <div class="p-price">1,999</div>
                        </div>
                        <div class="info-inner">
                            <p class="p-name">體育帶黑/黑85厘米</p>
                            <p class="p-company text--ellipsis">Phiten</p>
                        </div>
                    </div>
                    <figcaption class="box-down">
                        <a class="cart-bg" href="javascript:;">
                            <div class="cart-bg-inner">
                                <span class="buy-btn">立即購買</span>
                            </div>
                        </a>
                        <a class="cart-btn addToCart" href="javascript:;">
                            <span class="add-to-cart">
                                <i class="icon-basket"></i>
                            </span>
                        </a>
                    </figcaption>
                </figure>
                <figure class="koko-card">
                    <a href="javascript:;" class="btn-favorite"></a>
                    <div class="box-up">
                        <div class="img-container">
                            <img class="img owl-lazy" data-src="img/img-product.svg" alt="productnames">
                            <div class="p-price">1,999</div>
                        </div>
                        <div class="info-inner">
                            <p class="p-name">體育帶黑/黑85厘米</p>
                            <p class="p-company text--ellipsis">Phiten</p>
                        </div>
                    </div>
                    <figcaption class="box-down">
                        <a class="cart-bg" href="javascript:;">
                            <div class="cart-bg-inner">
                                <span class="buy-btn">立即購買</span>
                            </div>
                        </a>
                        <a class="cart-btn addToCart" href="javascript:;">
                            <span class="add-to-cart">
                                <i class="icon-basket"></i>
                            </span>
                        </a>
                    </figcaption>
                </figure>
                <figure class="koko-card">
                    <a href="javascript:;" class="btn-favorite"></a>
                    <div class="box-up">
                        <div class="img-container">
                            <img class="img owl-lazy" data-src="img/img-product.svg" alt="productnames">
                            <div class="p-price">1,999</div>
                        </div>
                        <div class="info-inner">
                            <p class="p-name">體育帶黑/黑85厘米</p>
                            <p class="p-company text--ellipsis">Phiten</p>
                        </div>
                    </div>
                    <figcaption class="box-down">
                        <a class="cart-bg" href="javascript:;">
                            <div class="cart-bg-inner">
                                <span class="buy-btn">立即購買</span>
                            </div>
                        </a>
                        <a class="cart-btn addToCart" href="javascript:;">
                            <span class="add-to-cart">
                                <i class="icon-basket"></i>
                            </span>
                        </a>
                    </figcaption>
                </figure>
                <figure class="koko-card">
                    <a href="javascript:;" class="btn-favorite"></a>
                    <div class="box-up">
                        <div class="img-container">
                            <img class="img owl-lazy" data-src="img/img-product.svg" alt="productnames">
                            <div class="p-price">1,999</div>
                        </div>
                        <div class="info-inner">
                            <p class="p-name">體育帶黑/黑85厘米</p>
                            <p class="p-company text--ellipsis">Phiten</p>
                        </div>
                    </div>
                    <figcaption class="box-down">
                        <a class="cart-bg" href="javascript:;">
                            <div class="cart-bg-inner">
                                <span class="buy-btn">立即購買</span>
                            </div>
                        </a>
                        <a class="cart-btn addToCart" href="javascript:;">
                            <span class="add-to-cart">
                                <i class="icon-basket"></i>
                            </span>
                        </a>
                    </figcaption>
                </figure>
                <figure class="koko-card">
                    <a href="javascript:;" class="btn-favorite"></a>
                    <div class="box-up">
                        <div class="img-container">
                            <img class="img owl-lazy" data-src="img/img-product.svg" alt="productnames">
                            <div class="p-price">1,999</div>
                        </div>
                        <div class="info-inner">
                            <p class="p-name">體育帶黑/黑85厘米</p>
                            <p class="p-company text--ellipsis">Phiten</p>
                        </div>
                    </div>
                    <figcaption class="box-down">
                        <a class="cart-bg" href="javascript:;">
                            <div class="cart-bg-inner">
                                <span class="buy-btn">立即購買</span>
                            </div>
                        </a>
                        <a class="cart-btn addToCart" href="javascript:;">
                            <span class="add-to-cart">
                                <i class="icon-basket"></i>
                            </span>
                        </a>
                    </figcaption>
                </figure>
                <figure class="koko-card">
                    <a href="javascript:;" class="btn-favorite"></a>
                    <div class="box-up">
                        <div class="img-container">
                            <img class="img owl-lazy" data-src="img/img-product.svg" alt="productnames">
                            <div class="p-price">1,999</div>
                        </div>
                        <div class="info-inner">
                            <p class="p-name">體育帶黑/黑85厘米</p>
                            <p class="p-company text--ellipsis">Phiten</p>
                        </div>
                    </div>
                    <figcaption class="box-down">
                        <a class="cart-bg" href="javascript:;">
                            <div class="cart-bg-inner">
                                <span class="buy-btn">立即購買</span>
                            </div>
                        </a>
                        <a class="cart-btn addToCart" href="javascript:;">
                            <span class="add-to-cart">
                                <i class="icon-basket"></i>
                            </span>
                        </a>
                    </figcaption>
                </figure>
                <figure class="koko-card">
                    <a href="javascript:;" class="btn-favorite"></a>
                    <div class="box-up">
                        <div class="img-container">
                            <img class="img owl-lazy" data-src="img/img-product.svg" alt="productnames">
                            <div class="p-price">1,999</div>
                        </div>
                        <div class="info-inner">
                            <p class="p-name">體育帶黑/黑85厘米</p>
                            <p class="p-company text--ellipsis">Phiten</p>
                        </div>
                    </div>
                    <figcaption class="box-down">
                        <a class="cart-bg" href="javascript:;">
                            <div class="cart-bg-inner">
                                <span class="buy-btn">立即購買</span>
                            </div>
                        </a>
                        <a class="cart-btn addToCart" href="javascript:;">
                            <span class="add-to-cart">
                                <i class="icon-basket"></i>
                            </span>
                        </a>
                    </figcaption>
                </figure>
            </div>
        </section>
        <section class="koko-sale-product bg--white">
            <div class="row">
                <div class="col-lg-12">
                    <h3>打折商品</h3>
                    <p class="mt-8 mb-24">After using various platforms, I changed!</p>
                </div>
            </div>
            <div class="owl-carousel owl-theme" id="koko-sale-product">
                <figure class="koko-card">
                    <a href="javascript:;" class="btn-favorite"></a>
                    <label class="badge-product--sale">
                        <span>SALE</span>
                    </label>
                    <div class="box-up">
                        <div class="img-container">
                            <img class="img owl-lazy" data-src="img/img-product.svg" alt="productnames">
                            <div class="p-price">1,999</div>
                        </div>
                        <div class="info-inner">
                            <p class="p-name">體育帶黑/黑85厘米</p>
                            <p class="p-company text--ellipsis">Phiten</p>
                        </div>
                    </div>
                    <figcaption class="box-down">
                        <a class="cart-bg" href="javascript:;">
                            <div class="cart-bg-inner">
                                <span class="buy-btn">立即購買</span>
                            </div>
                        </a>
                        <a class="cart-btn addToCart" href="javascript:;">
                            <span class="add-to-cart">
                                <i class="icon-basket"></i>
                            </span>
                        </a>
                    </figcaption>
                </figure>
                <figure class="koko-card">
                    <a href="javascript:;" class="btn-favorite"></a>
                    <label class="badge-product--sale">
                        <span>SALE</span>
                    </label>
                    <div class="box-up">
                        <div class="img-container">
                            <img class="img owl-lazy" data-src="img/img-product.svg" alt="productnames">
                            <div class="p-price">1,999</div>
                        </div>
                        <div class="info-inner">
                            <p class="p-name">體育帶黑/黑85厘米</p>
                            <p class="p-company text--ellipsis">Phiten</p>
                        </div>
                    </div>
                    <figcaption class="box-down">
                        <a class="cart-bg" href="javascript:;">
                            <div class="cart-bg-inner">
                                <span class="buy-btn">立即購買</span>
                            </div>
                        </a>
                        <a class="cart-btn addToCart" href="javascript:;">
                            <span class="add-to-cart">
                                <i class="icon-basket"></i>
                            </span>
                        </a>
                    </figcaption>
                </figure>
                <figure class="koko-card">
                    <a href="javascript:;" class="btn-favorite"></a>
                    <label class="badge-product--sale">
                        <span>SALE</span>
                    </label>
                    <div class="box-up">
                        <div class="img-container">
                            <img class="img owl-lazy" data-src="img/img-product.svg" alt="productnames">
                            <div class="p-price">1,999</div>
                        </div>
                        <div class="info-inner">
                            <p class="p-name">體育帶黑/黑85厘米</p>
                            <p class="p-company text--ellipsis">Phiten</p>
                        </div>
                    </div>
                    <figcaption class="box-down">
                        <a class="cart-bg" href="javascript:;">
                            <div class="cart-bg-inner">
                                <span class="buy-btn">立即購買</span>
                            </div>
                        </a>
                        <a class="cart-btn addToCart" href="javascript:;">
                            <span class="add-to-cart">
                                <i class="icon-basket"></i>
                            </span>
                        </a>
                    </figcaption>
                </figure>
                <figure class="koko-card">
                    <a href="javascript:;" class="btn-favorite"></a>
                    <label class="badge-product--sale">
                        <span>SALE</span>
                    </label>
                    <div class="box-up">
                        <div class="img-container">
                            <img class="img owl-lazy" data-src="img/img-product.svg" alt="productnames">
                            <div class="p-price">1,999</div>
                        </div>
                        <div class="info-inner">
                            <p class="p-name">體育帶黑/黑85厘米</p>
                            <p class="p-company text--ellipsis">Phiten</p>
                        </div>
                    </div>
                    <figcaption class="box-down">
                        <a class="cart-bg" href="javascript:;">
                            <div class="cart-bg-inner">
                                <span class="buy-btn">立即購買</span>
                            </div>
                        </a>
                        <a class="cart-btn addToCart" href="javascript:;">
                            <span class="add-to-cart">
                                <i class="icon-basket"></i>
                            </span>
                        </a>
                    </figcaption>
                </figure>
                <figure class="koko-card">
                    <a href="javascript:;" class="btn-favorite"></a>
                    <label class="badge-product--sale">
                        <span>SALE</span>
                    </label>
                    <div class="box-up">
                        <div class="img-container">
                            <img class="img owl-lazy" data-src="img/img-product.svg" alt="productnames">
                            <div class="p-price">1,999</div>
                        </div>
                        <div class="info-inner">
                            <p class="p-name">體育帶黑/黑85厘米</p>
                            <p class="p-company text--ellipsis">Phiten</p>
                        </div>
                    </div>
                    <figcaption class="box-down">
                        <a class="cart-bg" href="javascript:;">
                            <div class="cart-bg-inner">
                                <span class="buy-btn">立即購買</span>
                            </div>
                        </a>
                        <a class="cart-btn addToCart" href="javascript:;">
                            <span class="add-to-cart">
                                <i class="icon-basket"></i>
                            </span>
                        </a>
                    </figcaption>
                </figure>
                <figure class="koko-card">
                    <a href="javascript:;" class="btn-favorite"></a>
                    <label class="badge-product--sale">
                        <span>SALE</span>
                    </label>
                    <div class="box-up">
                        <div class="img-container">
                            <img class="img owl-lazy" data-src="img/img-product.svg" alt="productnames">
                            <div class="p-price">1,999</div>
                        </div>
                        <div class="info-inner">
                            <p class="p-name">體育帶黑/黑85厘米</p>
                            <p class="p-company text--ellipsis">Phiten</p>
                        </div>
                    </div>
                    <figcaption class="box-down">
                        <a class="cart-bg" href="javascript:;">
                            <div class="cart-bg-inner">
                                <span class="buy-btn">立即購買</span>
                            </div>
                        </a>
                        <a class="cart-btn addToCart" href="javascript:;">
                            <span class="add-to-cart">
                                <i class="icon-basket"></i>
                            </span>
                        </a>
                    </figcaption>
                </figure>
                <figure class="koko-card">
                    <a href="javascript:;" class="btn-favorite"></a>
                    <label class="badge-product--sale">
                        <span>SALE</span>
                    </label>
                    <div class="box-up">
                        <div class="img-container">
                            <img class="img owl-lazy" data-src="img/img-product.svg" alt="productnames">
                            <div class="p-price">1,999</div>
                        </div>
                        <div class="info-inner">
                            <p class="p-name">體育帶黑/黑85厘米</p>
                            <p class="p-company text--ellipsis">Phiten</p>
                        </div>
                    </div>
                    <figcaption class="box-down">
                        <a class="cart-bg" href="javascript:;">
                            <div class="cart-bg-inner">
                                <span class="buy-btn">立即購買</span>
                            </div>
                        </a>
                        <a class="cart-btn addToCart" href="javascript:;">
                            <span class="add-to-cart">
                                <i class="icon-basket"></i>
                            </span>
                        </a>
                    </figcaption>
                </figure>
                <figure class="koko-card disabled">
                    <a href="javascript:;" class="mask mask_sale">
                        <span class="btn">更 多 商 品</span>
                    </a>
                    <a href="javascript:;" class="btn-favorite disabled"></a>
                    <label class="badge-product--sale">
                        <span>SALE</span>
                    </label>
                    <div class="box-up">
                        <div class="img-container">
                            <img class="img owl-lazy" data-src="img/img-product.svg" alt="productnames">
                            <div class="p-price">1,999</div>
                        </div>
                        <div class="info-inner">
                            <p class="p-name">體育帶黑/黑85厘米</p>
                            <p class="p-company text--ellipsis">Phiten</p>
                        </div>
                    </div>
                    <figcaption class="box-down">
                        <a class="cart-bg" href="javascript:;">
                            <div class="cart-bg-inner">
                                <span class="buy-btn">立即購買</span>
                            </div>
                        </a>
                        <a class="cart-btn addToCart" href="javascript:;">
                            <span class="add-to-cart">
                                <i class="icon-basket"></i>
                            </span>
                        </a>
                    </figcaption>
                </figure>
            </div>
        </section>
        <section class="koko-daily-special bg--lightyellow">
            <div class="row">
                <div class="col-lg-12">
                    <h3>每日超值精選</h3>
                    <p class="mt-8 mb-24">After using various platforms, I changed!</p>
                </div>
            </div>
            <div class="owl-carousel owl-theme" id="koko-daily-special">
                <figure class="daily-card">
                    <label class="sale-tag">
                        <span>SALE</span>
                    </label>
                    <div class="photo">
                        <img src="img/img-product.svg">
                    </div>
                    <figcaption class="description">
                        <p class="de-price">6,200 日圓</p>
                        <h1>5,900 日圓</h1>
                        <h2 class="text--ellipsis">合利他命強效錠EX PLUS</h2>
                        <h4 class="text--ellipsis">合利他命強效錠EX PLUS</h4>
                        <p>Classic Peace Lily is a spathiphyllum floor plant arranged in a bamboo planter with a blue &amp; red ribbom and butterfly pick.</p>
                        <button class="btn btn--primary btn--sm">立 即 購 買</button>
                    </figcaption>
                </figure>
                <figure class="daily-card">
                    <label class="sale-tag">
                        <span>SALE</span>
                    </label>
                    <div class="photo">
                        <img src="img/img-product.svg">
                    </div>
                    <figcaption class="description">
                        <p class="de-price">6,200 日圓</p>
                        <h1>5,900 日圓</h1>
                        <h2 class="text--ellipsis">合利他命強效錠EX PLUS</h2>
                        <h4 class="text--ellipsis">合利他命強效錠EX PLUS</h4>
                        <p>Classic Peace Lily is a spathiphyllum floor plant arranged in a bamboo planter with a blue &amp; red ribbom and butterfly pick.</p>
                        <button class="btn btn--primary btn--sm">立 即 購 買</button>
                    </figcaption>
                </figure>
                <figure class="daily-card">
                    <label class="sale-tag">
                        <span>SALE</span>
                    </label>
                    <div class="photo">
                        <img src="img/img-product.svg">
                    </div>
                    <figcaption class="description">
                        <p class="de-price">6,200 日圓</p>
                        <h1>5,900 日圓</h1>
                        <h2 class="text--ellipsis">合利他命強效錠EX PLUS</h2>
                        <h4 class="text--ellipsis">合利他命強效錠EX PLUS</h4>
                        <p>Classic Peace Lily is a spathiphyllum floor plant arranged in a bamboo planter with a blue &amp; red ribbom and butterfly pick.</p>
                        <button class="btn btn--primary btn--sm">立 即 購 買</button>
                    </figcaption>
                </figure>
                <figure class="daily-card">
                    <label class="sale-tag">
                        <span>SALE</span>
                    </label>
                    <div class="photo">
                        <img src="img/img-product.svg">
                    </div>
                    <figcaption class="description">
                        <p class="de-price">6,200 日圓</p>
                        <h1>5,900 日圓</h1>
                        <h2 class="text--ellipsis">合利他命強效錠EX PLUS</h2>
                        <h4 class="text--ellipsis">合利他命強效錠EX PLUS</h4>
                        <p>Classic Peace Lily is a spathiphyllum floor plant arranged in a bamboo planter with a blue &amp; red ribbom and butterfly pick.</p>
                        <button class="btn btn--primary btn--sm">立 即 購 買</button>
                    </figcaption>
                </figure>
            </div>
        </section>
        <section class="koko-categories">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="koko-title--2">
                            <h3>
                                <i class="icon-medical-002"></i>
                                <font>生活保健</font>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-sm-12">
                        <div class="product-category-cnt cf">
                            <ul class="product-category-list">
                                <li><a href="javascript:;">隱形眼鏡/眼部</a></li>
                                <li><a href="javascript:;">護理用品</a></li>
                                <li><a href="javascript:;">營養補充品</a></li>
                                <li><a href="javascript:;">窈窕瘦身</a></li>
                                <li><a href="javascript:;">按摩 / 放鬆</a></li>
                                <li><a href="javascript:;">口腔清潔</a></li>
                                <li><a href="javascript:;">衛生用品</a></li>
                                <li><a href="javascript:;">成人照護用品</a></li>
                                <li><a href="javascript:;">健康食品</a></li>
                                <li><a href="javascript:;">隱形眼鏡 / 眼部</a></li>
                                <li><a href="javascript:;">護理用品</a></li>
                                <li><a href="javascript:;">營養補充品</a></li>
                                <li><a href="javascript:;">窈窕瘦身</a></li>
                                <li><a href="javascript:;">按摩 / 放鬆</a></li>
                                <li><a href="javascript:;">More …</a></li>
                            </ul>
                            <div class="product-category-adv">
                                <img src="img/img-adv-category.svg" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-sm-12">
                        <div class="owl-carousel owl-theme koko-index-category">
                            <div class="row">
                                <div class="col-lg-12">
                                    <figure class="koko-card">
                                        <a href="javascript:;" class="btn-favorite"></a>
                                        <div class="box-up">
                                            <div class="img-container">
                                                <img class="img owl-lazy" data-src="img/img-product.svg" alt="productnames">
                                                <div class="p-price">1,999</div>
                                            </div>
                                            <div class="info-inner">
                                                <p class="p-name">體育帶黑/黑85厘米</p>
                                                <p class="p-company text--ellipsis">Phiten</p>
                                            </div>
                                        </div>
                                        <figcaption class="box-down">
                                            <a class="cart-bg" href="javascript:;">
                                                <div class="cart-bg-inner">
                                                    <span class="buy-btn">立即購買</span>
                                                </div>
                                            </a>
                                            <a class="cart-btn addToCart" href="javascript:;">
                                                <span class="add-to-cart">
                                                    <i class="icon-basket"></i>
                                                </span>
                                            </a>
                                        </figcaption>
                                    </figure>
                                    <figure class="koko-card">
                                        <a href="javascript:;" class="btn-favorite"></a>
                                        <div class="box-up">
                                            <div class="img-container">
                                                <img class="img owl-lazy" data-src="img/img-product.svg" alt="productnames">
                                                <div class="p-price">1,999</div>
                                            </div>
                                            <div class="info-inner">
                                                <p class="p-name">體育帶黑/黑85厘米</p>
                                                <p class="p-company text--ellipsis">Phiten</p>
                                            </div>
                                        </div>
                                        <figcaption class="box-down">
                                            <a class="cart-bg" href="javascript:;">
                                                <div class="cart-bg-inner">
                                                    <span class="buy-btn">立即購買</span>
                                                </div>
                                            </a>
                                            <a class="cart-btn addToCart" href="javascript:;">
                                                <span class="add-to-cart">
                                                    <i class="icon-basket"></i>
                                                </span>
                                            </a>
                                        </figcaption>
                                    </figure>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <figure class="koko-card">
                                        <a href="javascript:;" class="btn-favorite"></a>
                                        <div class="box-up">
                                            <div class="img-container">
                                                <img class="img owl-lazy" data-src="img/img-product.svg" alt="productnames">
                                                <div class="p-price">1,999</div>
                                            </div>
                                            <div class="info-inner">
                                                <p class="p-name">體育帶黑/黑85厘米</p>
                                                <p class="p-company text--ellipsis">Phiten</p>
                                            </div>
                                        </div>
                                        <figcaption class="box-down">
                                            <a class="cart-bg" href="javascript:;">
                                                <div class="cart-bg-inner">
                                                    <span class="buy-btn">立即購買</span>
                                                </div>
                                            </a>
                                            <a class="cart-btn addToCart" href="javascript:;">
                                                <span class="add-to-cart">
                                                    <i class="icon-basket"></i>
                                                </span>
                                            </a>
                                        </figcaption>
                                    </figure>
                                    <figure class="koko-card">
                                        <a href="javascript:;" class="btn-favorite"></a>
                                        <div class="box-up">
                                            <div class="img-container">
                                                <img class="img owl-lazy" data-src="img/img-product.svg" alt="productnames">
                                                <div class="p-price">1,999</div>
                                            </div>
                                            <div class="info-inner">
                                                <p class="p-name">體育帶黑/黑85厘米</p>
                                                <p class="p-company text--ellipsis">Phiten</p>
                                            </div>
                                        </div>
                                        <figcaption class="box-down">
                                            <a class="cart-bg" href="javascript:;">
                                                <div class="cart-bg-inner">
                                                    <span class="buy-btn">立即購買</span>
                                                </div>
                                            </a>
                                            <a class="cart-btn addToCart" href="javascript:;">
                                                <span class="add-to-cart">
                                                    <i class="icon-basket"></i>
                                                </span>
                                            </a>
                                        </figcaption>
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="koko-categories">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="koko-title--2">
                            <h3>
                                <i class="icon-medical-002"></i>
                                <font>生活保健</font>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-sm-12">
                        <div class="product-category-cnt cf">
                            <ul class="product-category-list">
                                <li><a href="javascript:;">隱形眼鏡/眼部</a></li>
                                <li><a href="javascript:;">護理用品</a></li>
                                <li><a href="javascript:;">營養補充品</a></li>
                                <li><a href="javascript:;">窈窕瘦身</a></li>
                                <li><a href="javascript:;">按摩 / 放鬆</a></li>
                                <li><a href="javascript:;">口腔清潔</a></li>
                                <li><a href="javascript:;">衛生用品</a></li>
                                <li><a href="javascript:;">成人照護用品</a></li>
                                <li><a href="javascript:;">健康食品</a></li>
                                <li><a href="javascript:;">隱形眼鏡 / 眼部</a></li>
                                <li><a href="javascript:;">護理用品</a></li>
                                <li><a href="javascript:;">營養補充品</a></li>
                                <li><a href="javascript:;">窈窕瘦身</a></li>
                                <li><a href="javascript:;">按摩 / 放鬆</a></li>
                                <li><a href="javascript:;">More …</a></li>
                            </ul>
                            <div class="product-category-adv">
                                <img src="img/img-adv-category.svg" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-sm-12">
                        <div class="owl-carousel owl-theme koko-index-category">
                            <div class="row">
                                <div class="col-lg-12">
                                    <figure class="koko-card">
                                        <a href="javascript:;" class="btn-favorite"></a>
                                        <div class="box-up">
                                            <div class="img-container">
                                                <img class="img owl-lazy" data-src="img/img-product.svg" alt="productnames">
                                                <div class="p-price">1,999</div>
                                            </div>
                                            <div class="info-inner">
                                                <p class="p-name">體育帶黑/黑85厘米</p>
                                                <p class="p-company text--ellipsis">Phiten</p>
                                            </div>
                                        </div>
                                        <figcaption class="box-down">
                                            <a class="cart-bg" href="javascript:;">
                                                <div class="cart-bg-inner">
                                                    <span class="buy-btn">立即購買</span>
                                                </div>
                                            </a>
                                            <a class="cart-btn addToCart" href="javascript:;">
                                                <span class="add-to-cart">
                                                    <i class="icon-basket"></i>
                                                </span>
                                            </a>
                                        </figcaption>
                                    </figure>
                                    <figure class="koko-card">
                                        <a href="javascript:;" class="btn-favorite"></a>
                                        <div class="box-up">
                                            <div class="img-container">
                                                <img class="img owl-lazy" data-src="img/img-product.svg" alt="productnames">
                                                <div class="p-price">1,999</div>
                                            </div>
                                            <div class="info-inner">
                                                <p class="p-name">體育帶黑/黑85厘米</p>
                                                <p class="p-company text--ellipsis">Phiten</p>
                                            </div>
                                        </div>
                                        <figcaption class="box-down">
                                            <a class="cart-bg" href="javascript:;">
                                                <div class="cart-bg-inner">
                                                    <span class="buy-btn">立即購買</span>
                                                </div>
                                            </a>
                                            <a class="cart-btn addToCart" href="javascript:;">
                                                <span class="add-to-cart">
                                                    <i class="icon-basket"></i>
                                                </span>
                                            </a>
                                        </figcaption>
                                    </figure>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <figure class="koko-card">
                                        <a href="javascript:;" class="btn-favorite"></a>
                                        <div class="box-up">
                                            <div class="img-container">
                                                <img class="img owl-lazy" data-src="img/img-product.svg" alt="productnames">
                                                <div class="p-price">1,999</div>
                                            </div>
                                            <div class="info-inner">
                                                <p class="p-name">體育帶黑/黑85厘米</p>
                                                <p class="p-company text--ellipsis">Phiten</p>
                                            </div>
                                        </div>
                                        <figcaption class="box-down">
                                            <a class="cart-bg" href="javascript:;">
                                                <div class="cart-bg-inner">
                                                    <span class="buy-btn">立即購買</span>
                                                </div>
                                            </a>
                                            <a class="cart-btn addToCart" href="javascript:;">
                                                <span class="add-to-cart">
                                                    <i class="icon-basket"></i>
                                                </span>
                                            </a>
                                        </figcaption>
                                    </figure>
                                    <figure class="koko-card">
                                        <a href="javascript:;" class="btn-favorite"></a>
                                        <div class="box-up">
                                            <div class="img-container">
                                                <img class="img owl-lazy" data-src="img/img-product.svg" alt="productnames">
                                                <div class="p-price">1,999</div>
                                            </div>
                                            <div class="info-inner">
                                                <p class="p-name">體育帶黑/黑85厘米</p>
                                                <p class="p-company text--ellipsis">Phiten</p>
                                            </div>
                                        </div>
                                        <figcaption class="box-down">
                                            <a class="cart-bg" href="javascript:;">
                                                <div class="cart-bg-inner">
                                                    <span class="buy-btn">立即購買</span>
                                                </div>
                                            </a>
                                            <a class="cart-btn addToCart" href="javascript:;">
                                                <span class="add-to-cart">
                                                    <i class="icon-basket"></i>
                                                </span>
                                            </a>
                                        </figcaption>
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <footer class="koko-footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <h2>
                            <i class="icon-education-045"></i>
                            <span>找商品</span>
                        </h2>
                        <div class="row">
                            <div class="col-lg-12">
                                <ul class="ft-list">
                                    <li class="">
                                        <a class="" href="javascript:;">分類搜尋</a>
                                    </li>
                                    <li class="">
                                        <a class="" href="javascript:;">品牌搜尋</a>
                                    </li>
                                    <li class="">
                                        <a class="js/" href="javascript:;">製造商搜尋</a>
                                    </li>
                                    <li class="">
                                        <a class="" href="javascript:;">最新熱門商品</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <h2>
                            <i class="icon-education-043"></i>
                            <span>客戶服務中心</span>
                        </h2>
                        <div class="row">
                            <div class="col-lg-12">
                                <ul class="ft-list">
                                    <li class="">
                                        <a class="" href="javascript:;">使用導覽</a>
                                    </li>
                                    <li class="">
                                        <a class="" href="javascript:;">常見問題</a>
                                    </li>
                                    <li class="">
                                        <a class="" href="javascript:;">聯絡我們</a>
                                    </li>
                                    <li class="">
                                        <a class="" href="javascript:;">未註冊會員訂單查詢</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <h2>
                            <i class="icon-real-estate-013"></i>
                            <span>關於 KOKOKARA</span>
                        </h2>
                        <div class="row">
                            <div class="col-lg-12">
                                <ul class="ft-list">
                                    <li class="">
                                        <a class="" href="javascript:;">關於我們</a>
                                    </li>
                                    <li class="">
                                        <a class="" href="javascript:;">服務條款</a>
                                    </li>
                                    <li class="">
                                        <a class="" href="javascript:;">點數規範</a>
                                    </li>
                                    <li class="">
                                        <a class="" href="javascript:;">折價卷使用條款</a>
                                    </li>
                                    <li class="">
                                        <a class="" href="javascript:;">個人資料保護方針</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <img src="img/img-logo-white.svg" alt="kokokara">
                        <ul class="social-icons">
                            <li>
                                <a href="javascript:;" data-tooltip="Instagram">
                                    <i class="fa fa-instagram"></i>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;" data-tooltip="Facebook">
                                    <i class="fa fa-facebook"></i>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;" data-tooltip="微博">
                                    <i class="fa fa-weibo"></i>
                                </a>
                            </li>
                        </ul>
                        <div class="ft-txt-block">
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.</p>
                            <p class="copyright">2019 © Kokokara. All Rights Reserved.</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="payment-icons">
                            <li>
                                <a href="javascript:;" data-tooltip="Visa" class="block">
                                    <i class="fa fa-cc-visa"></i>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;" data-tooltip="Paypal" class="block">
                                    <i class="fa fa-cc-paypal"></i>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;" data-tooltip="Mastercard" class="block">
                                    <i class="fa fa-cc-mastercard"></i>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;" data-tooltip="Discover" class="block">
                                    <i class="fa fa-cc-discover"></i>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;" data-tooltip="Jcb" class="block">
                                    <i class="fa fa-cc-jcb"></i>
                                </a>s
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
        <button class="js-go-to go-to-top" href="#" data-type="fixed" data-position='{"bottom": 16,"right": 16}' data-offset-top="400" data-compensation="#header" data-show-effect="zoomIn">
            <i class="icon-arrow-up"></i>
        </button>
        <button class="js-go-to go-to-top" href="#" data-type="fixed" data-position='{"bottom": 16,"right": 16}' data-offset-top="400" data-compensation="#header" data-show-effect="zoomIn">
            <i class="icon-arrow-up"></i>
        </button>
    </main>
    <!-- JQuery -->
    <script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
    <!-- Scroll -->
    <script src="vendor/ScrollToFixed-master/jquery-scrolltofixed.js"></script>
    <!-- OwlCarousel -->
    <script src="vendor/OwlCarousel2-2.3.4/dist/owl.carousel.min.js"></script>
    <!-- Mega Menu -->
    <script src="vendor/mega-dropdown-master/js/jquery.menu-aim.js"></script>
    <script src="vendor/mega-dropdown-master/js/mega-dropdown.js"></script>
    <!-- FancyBox -->
    <script src="vendor/fancybox/jquery.fancybox.min.js"></script>
    <!-- Go Top -->
    <script src="js/go-to-top.js"></script>
    <!-- Go Top -->
    <script src="js/go-to-top.js"></script>
    <!-- Main -->
    <script src="js/main.min.js"></script>
    <script>
    $(function() {
        kokokaraMain.fancyboxModule('firtSet');
    });
    </script>
</body>

</html>