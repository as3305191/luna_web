<!DOCTYPE html>
<html lang="zh-Hant-TW">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>服務條款</title>
  <link rel="stylesheet" href="./style/index.css">
  <link rel="stylesheet" href="./style/event.css">
  <link rel="stylesheet" type="text/css" media="screen" href="<?= base_url('js/plugin/layui/css/layui.css') ?>">
  <link rel="shortcut icon" href="<?= base_url('img/favicon/favicon.ico') ?>" type="image/x-icon">
  <link rel="icon" href="<?= base_url('img/favicon/favicon.ico') ?>" type="image/x-icon">
</head>



<body>
  <!-- .header -->
  <!-- .header end -->
  <style>
    .c_top{
      display:flex;
      align-items:center;
    }
    .c_title{
      overflow:hidden;
      text-overflow:ellipsis;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      word-break: break-all;
    }
  </style>

  <section class="event_hidden">
    <div style="padding:100px 5%;font-size:26px;">
      <?=$list -> desc?>
    </div>
  </section>


  <!-- .promotion end -->


  <!-- template -->
  <script id="act-card-template" type="text/x-handlebars-template">
    <a class="card" href="{{click_target}}" target="_blank">
      <div class="card__photo">
        <img src="{{img_url}}" />
      </div>
      <div class="card__content">
        <h3 class="card__content__title c_top">
          <div class="c_title" style="">{{act_name}}</div>
          <!-- <div style="margin-top:7px;">{{type_name_main}}</div> -->
        </h3>
        <div class="card__content__description">
          <p class="card__content__date"><span>{{start_date}} ({{week_of_days}})</span><span>{{end_date}} ({{end_week_of_days}})</span></p>
          <p class="card__content__country"><span>{{city}}</span></p>
          <p class="card__content__location"><span>{{landmark}}</span></p>
        </div>
      </div>
    </a>
  </script>
  <script id="act-card-more-template" type="text/x-handlebars-template">
    <div class="card card__more">
      <div class="card__photo">
        <img src="./images/cta_banner_bg.svg" />
      </div>
      <div class="card__content">
        <h3 class="card__content__title card__content__title--center">想了解更多如何刊登活動嗎？</h3>
        <div class="card__content__description card__content__description--center">
          <button class="button button__card--callToAction">從這裡開始</button>
        </div>
      </div>
    </div>
  </script>
  <!-- end template -->

  <script>

  </script>
</body>

</html>
