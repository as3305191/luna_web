<header class="header">
  <div>
    <div class="header__logo">
      <a href="<?= base_url("") ?>">
        <img src="./images/logo_3x.png" alt="AHDA Logo" title="AHDA Logo" class="header__logo__platform" />
        <img src="./images/ahda-logo@3x.png" alt="AHDA Logo" title="AHDA Logo" class="header__logo__AHDA" />
      </a>
    </div>

    <?php if (isset($can_search)): ?>
      <div class="header__search"><span><input type="text" style="border:0px;" name="" id="s_keyword" placeholder="關鍵字..."><button
            type="submit" id="searchBtn"><img src="./images/icons/search.svg" alt=""></button></span></div>
    <?php endif; ?>


    <nav class="header__navbar">
      <label class="header__navbar__mobile" for="menu"><img src="./images/icons/bar.svg" alt="Menu" title="Menu"></label>
      <input type="checkbox" class="hiddenButton"id="menu"></input>
      <ul class="header__navbar__pc">
        <li>

          <?php if(!empty($l_member)): ?>
            <a href="<?= base_url("appF/#front/MyActivitys/personal_info") ?>">刊登活動</a>
          <?php else: ?>
            <a href="javascript:void(0)" onclick="alert('請先登入')">刊登活動</a>
          <?php endif ?>
        </li>
        <li>
          <?php if(!empty($l_member)): ?>
            <a href="javascript:void(0)" onclick="doLogout()">登出</a>
          <?php else: ?>
            <a href="<?= base_url("loginFrontLogin") ?>">登入</a>
          <?php endif ?>
        </li>
      </ul>
    </nav>
  </div>
</header>
