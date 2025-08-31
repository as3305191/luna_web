<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <?php $this->load->view('luna/luna_head'); ?>
  <style>
    /* 你的 CSS（保留） */
    @media only screen and (max-width: 750px){ .dt_list_th{min-width:67px!important} .dt_list_th_big{min-width:100px!important} }
    .pjax-root{ position:relative; min-height:240px; }
    .pjax-root .pjax-content{ transition: opacity .15s ease; }
    .pjax-root.loading .pjax-content{ opacity:.35; }
    .pjax-root .zone-loading{ position:absolute; inset:0; display:none; align-items:center; justify-content:center; background:rgba(255,255,255,.6); backdrop-filter:blur(2px); z-index:5; }
    .pjax-root.loading .zone-loading{ display:flex; }
    .pjax-root .zone-loading .spinner{ width:56px; height:56px; border:4px solid #999; border-top-color:transparent; border-radius:50%; animation:spin .8s linear infinite; }
    @keyframes spin{ to{ transform:rotate(360deg) } }
    @media (max-width:1024px){ body{ background-attachment:scroll } }
  </style>
</head>

<body>
  <main> <!-- 這是整頁唯一的 <main> -->
    <!-- Header -->
    <?php $this->load->view('luna/luna_header'); ?>
    <!-- End Header -->

    <section class="g-mb-100">
      <div class="container">
        <div class="row">
          <!-- Sidebar（固定左欄） -->
          <?php $this->load->view('luna/luna_sidebar'); ?>

          <!-- 右欄內容：只在這裡 PJAX -->
          <div class="col-lg-9"> <!-- 依你的版面調整 col 寬度 -->
            <div id="pjax-root" class="pjax-root">
              <div class="pjax-content">
                <?php
                  // 這一行不能註解，塞入目前頁面的主要內容檔
                  if (isset($content_view)) { $this->load->view($content_view, isset($data)?$data:[]); }
                  else { /* 當前頁直接寫內容也可以 */ }
                ?>
              </div>
              <div class="zone-loading" aria-hidden="true"><div class="spinner"></div></div>
            </div>
          </div>
          <!-- /右欄 -->
        </div>
      </div>
    </section>
  </main>

  <!-- footer 放在 main 外，才能穩定貼底 -->
  <div class="site-footer">
    <?php $this->load->view('luna/luna_footer'); ?>
  </div>
  <div class="u-outer-spaces-helper"></div>

  <?php $this->load->view('luna/luna_script'); ?> <!-- ← 移到這裡，結束 body 前 -->
  <script>
  (function(){
    var root = document.getElementById('pjax-root');
    if (!root) return;
    var contentSel = '#pjax-root .pjax-content';

    function isInternal(url){
      try{
        var u = new URL(url, location.href);
        if (u.origin !== location.origin) return false;
        if (u.hash && u.pathname === location.pathname && u.search === location.search) return false;
        return true;
      }catch(e){ return false; }
    }
    function show(){ root.classList.add('loading'); }
    function hide(){ root.classList.remove('loading'); }

    function updateHeadFrom(doc){
      var t = doc.querySelector('title'); if (t) document.title = t.textContent;
      var mCsrf = doc.querySelector('meta[name="ci-csrf-hash"]');
      if (mCsrf){
        var cur = document.querySelector('meta[name="ci-csrf-hash"]');
        if (cur) cur.setAttribute('content', mCsrf.getAttribute('content'));
        window.CSRF = window.CSRF || {}; window.CSRF.hash = mCsrf.getAttribute('content');
      }
      var mNonce = doc.querySelector('meta[name="checkout-nonce"]');
      if (mNonce){
        var curN = document.querySelector('meta[name="checkout-nonce"]');
        if (curN) curN.setAttribute('content', mNonce.getAttribute('content'));
        window.CHECKOUT_NONCE = mNonce.getAttribute('content');
      }
    }
    function executeScripts(scope){
      var scripts = scope.querySelectorAll('script');
      scripts.forEach(function(s){
        var ns = document.createElement('script');
        if (s.src) ns.src = s.src;
        if (s.type) ns.type = s.type;
        if (s.noModule) ns.noModule = true;
        if (s.defer) ns.defer = true;
        if (s.async) ns.async = true;
        ns.text = s.textContent;
        document.body.appendChild(ns);
        setTimeout(function(){ ns.parentNode && ns.parentNode.removeChild(ns); }, 0);
      });
    }
    function swapContentFrom(doc, push){
      var next = doc.querySelector(contentSel);
      if (!next){ location.href = doc.URL || location.href; return; }
      var cur = document.querySelector(contentSel); if (!cur) return;
      var tmp = document.createElement('div'); tmp.innerHTML = next.innerHTML;
      cur.innerHTML = tmp.innerHTML;
      executeScripts(cur);
      if (push) history.pushState({url: doc.URL}, '', doc.URL);
      document.dispatchEvent(new CustomEvent('page:enter', {detail:{url: doc.URL}}));
    }
    function load(url, push){
      show();
      return fetch(url, { credentials: 'same-origin' })
        .then(function(r){ return r.text(); })
        .then(function(html){
          var doc = new DOMParser().parseFromString(html, 'text/html');
          updateHeadFrom(doc);
          swapContentFrom(doc, push);
        })
        .catch(function(){ location.href = url; })
        .finally(hide);
    }

    document.addEventListener('click', function(e){
      var a = e.target.closest && e.target.closest('a'); if (!a) return;
      if (a.target === '_blank' || a.hasAttribute('download') || a.hasAttribute('data-no-pjax')) return;
      var url = a.getAttribute('href'); if (!url || url.startsWith('#')) return;
      if (!isInternal(url)) return;
      e.preventDefault(); load(url, true);
    });

    window.addEventListener('popstate', function(){ load(location.href, false); });

    // hover 預抓（可留可拿掉）
    var prefetchTimer=null;
    document.addEventListener('mouseover', function(e){
      var a = e.target.closest && e.target.closest('a'); if (!a) return;
      var url = a.getAttribute('href'); if (!url || !isInternal(url)) return;
      if (a.hasAttribute('data-no-pjax')) return;
      clearTimeout(prefetchTimer);
      prefetchTimer = setTimeout(function(){
        var link = document.createElement('link'); link.rel='prefetch'; link.href=url; document.head.appendChild(link);
      }, 120);
    });
  })();
  </script>
</body>
</html>
