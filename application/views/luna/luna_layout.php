<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <?php $this->load->view("luna/luna_head"); ?>
  <meta name="checkout-nonce" content="<?= htmlspecialchars($checkout_nonce ?? '') ?>">
</head>
<body>
  <main>
    <?php $this->load->view("luna/luna_header"); ?>

    <section class="g-mb-100">
      <div class="container">
        <div class="row">
          <?php $this->load->view("luna/luna_sidebar"); ?>

          <!-- 只換這塊 -->
          <main id="pjax-root" class="pjax-root col-lg-9">
            <div class="pjax-content">
              <?php $this->load->view($content_view, $data ?? []); ?>
            </div>
            <div class="zone-loading" aria-hidden="true"><div class="spinner"></div></div>
          </main>
          <!-- /只換這塊 -->
        </div>
      </div>
    </section>
  </main>

  <div class="site-footer"><?php $this->load->view("luna/luna_footer"); ?></div>
  <?php $this->load->view("luna/luna_script"); ?>

  <style>
    .pjax-root{position:relative;min-height:200px}
    .pjax-root .pjax-content{transition:opacity .15s ease}
    .pjax-root.loading .pjax-content{opacity:.35}
    .pjax-root .zone-loading{position:absolute;inset:0;display:none;align-items:center;justify-content:center;background:rgba(255,255,255,.6);backdrop-filter:blur(2px);z-index:5}
    .pjax-root.loading .zone-loading{display:flex}
    .pjax-root .spinner{width:56px;height:56px;border:4px solid #999;border-top-color:transparent;border-radius:50%;animation:spin .8s linear infinite}
    @keyframes spin{to{transform:rotate(360deg)}}
    @media (max-width:1024px){ body{background-attachment:scroll} } /* 手機避免 fixed 背景卡頓 */
  </style>

  <script>
  (function(){
    var root = document.getElementById('pjax-root');
    if(!root) return;
    var contentSel = '#pjax-root .pjax-content';
    function isInternal(url){
      try{ var u=new URL(url, location.href); return u.origin===location.origin && !u.hash; }
      catch(e){ return false; }
    }
    function show(){ root.classList.add('loading'); }
    function hide(){ root.classList.remove('loading'); }

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

    function swapContent(html, url, pjaxTitle){
      var doc = new DOMParser().parseFromString(html, 'text/html');
      var next = doc.querySelector(contentSel);
      if(!next){ location.href = url; return; } // 目標頁沒容器就正常跳轉
      var cur = document.querySelector(contentSel);
      if(!cur) return;

      // 更新 <title>（優先 X-PJAX-Title）
      var title = pjaxTitle || (doc.querySelector('title') && doc.querySelector('title').textContent);
      if (title) document.title = title;

      // 更新 meta（例如 CSRF / nonce）
      var mCsrf = doc.querySelector('meta[name="ci-csrf-hash"]');
      if (mCsrf) {
        var curCsrf = document.querySelector('meta[name="ci-csrf-hash"]');
        if (curCsrf) curCsrf.setAttribute('content', mCsrf.getAttribute('content'));
        window.CSRF = window.CSRF || {}; window.CSRF.hash = mCsrf.getAttribute('content');
      }
      var mNonce = doc.querySelector('meta[name="checkout-nonce"]');
      if (mNonce) {
        var curN = document.querySelector('meta[name="checkout-nonce"]');
        if (curN) curN.setAttribute('content', mNonce.getAttribute('content'));
        window.CHECKOUT_NONCE = mNonce.getAttribute('content');
      }

      var tmp = document.createElement('div');
      tmp.innerHTML = next.innerHTML; // 把頁面中間區塊換掉
      cur.innerHTML = tmp.innerHTML;
      executeScripts(cur); // 讓該區塊內 inline script 生效

      history.pushState({url:url}, '', url);
      document.dispatchEvent(new CustomEvent('page:enter', {detail:{url:url}}));
    }

    function load(url){
      show();
      return fetch(url, {
        credentials: 'include',
        headers: {'X-Requested-With':'XMLHttpRequest','X-PJAX':'1','Accept':'text/html'},
      }).then(function(r){
        if (r.status === 401) { location.href = "<?= site_url('luna/login') ?>"; return Promise.reject(); }
        var title = r.headers.get('X-PJAX-Title');
        return r.text().then(function(html){ swapContent(html, url, title); });
      }).catch(function(){ /* 失敗就用原生跳轉 */ location.href = url; })
        .finally(hide);
    }

    // 攔截站內連結
    document.addEventListener('click', function(e){
      var a = e.target.closest && e.target.closest('a'); if(!a) return;
      if (a.target==='_blank' || a.hasAttribute('download')) return;
      var href = a.getAttribute('href'); if(!href || href.startsWith('#')) return;
      if (!isInternal(href)) return;
      e.preventDefault(); load(href);
    });

    // 返回鍵
    window.addEventListener('popstate', function(){ load(location.href); });
  })();
  </script>
</body>
</html>
