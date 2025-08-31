<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
  // 取 CI 設定的 cookie 名稱（避免與 token name 不同時搞錯）
  $CI =& get_instance();
  $csrf_cookie_name = $CI->config->item('csrf_cookie_name') ?: 'ci_csrf_token';
?>
<style>
  /* Loading overlay：預設隱藏，.is-active 顯示為 flex */
  #checkoutLoading{ display:none; }
  #checkoutLoading.is-active{ display:flex; }
</style>

<section class="g-mb-100">
  <div class="container">
    <div class="row">
      <!-- ※ sidebar 由 luna_layout 負責，這裡只放右側主要內容 -->
      <div class="col-lg-9">
        <div class="card border-0 shadow-soft">
          <div class="card-header d-flex align-items-center justify-content-between g-bg-gray-light-v5 border-0">
            <div class="d-flex align-items-center">
              <h3 class="h5 mb-0"><i class="icon-bag g-mr-8"></i> 商城</h3>
            </div>

            <div class="shop-toolbar d-flex align-items-center flex-wrap">
              <div class="input-group" style="min-width:260px">
                <input id="shop-search" type="text" class="form-control" placeholder="搜尋商品關鍵字">
                <span class="input-group-btn"><button class="btn btn-secondary" type="button"><i class="fa fa-search"></i></button></span>
              </div>

              <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary btn-pill dropdown-toggle" data-toggle="dropdown" data-bs-toggle="dropdown">
                  <i class="fa fa-filter g-mr-5"></i> 排序
                </button>
                <div id="sortMenu" class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" data-sort="name_asc"  href="#">名稱 A→Z</a>
                  <a class="dropdown-item" data-sort="name_desc" href="#">名稱 Z→A</a>
                  <a class="dropdown-item" data-sort="price_asc" href="#">價格低→高</a>
                  <a class="dropdown-item" data-sort="price_desc" href="#">價格高→低</a>
                </div>
              </div>

              <button id="btnCartOpen" class="btn btn-sm btn-primary btn-pill g-ml-5">
                <i class="fa fa-shopping-bag"></i>
                購物車 <span id="cartCount" class="badge badge-light">0</span>
              </button>
              <button id="btnCheckoutTop" class="btn btn-sm btn-success btn-pill g-ml-5" disabled>直接結帳</button>
            </div>
          </div>

          <div class="card-block g-pt-20 g-pb-10 g-px-20">
            <?php if (empty($tabs)): ?>
              <div class="alert alert-info mb-0">Excel 沒資料或路徑未設定！</div>
            <?php else: ?>

              <!-- Tabs -->
              <ul class="nav nav-pills category-tabs g-mb-25" role="tablist">
                <?php $i=0; foreach($tabs as $title): ?>
                  <li class="nav-item g-mr-10 g-mb-10">
                    <a class="nav-link <?= $i===0?'active':'' ?>"
                       href="#tab-<?=$i?>" role="tab"
                       aria-controls="tab-<?=$i?>"
                       aria-selected="<?= $i===0?'true':'false' ?>">
                      <?=htmlspecialchars($title)?>
                    </a>
                  </li>
                <?php $i++; endforeach; ?>
              </ul>

              <div class="tab-content">
                <?php $i=0; foreach($tabs as $title): $list = $itemsMap[$title] ?? []; ?>
                  <div class="tab-pane fade <?= $i===0?'show active':'' ?>" id="tab-<?=$i?>" role="tabpanel">
                    <div class="row product-grid" id="grid-<?=$i?>">
                      <?php if (empty($list)): ?>
                        <div class="col-12"><div class="alert alert-secondary mb-0">此分頁目前沒有商品</div></div>
                      <?php else: foreach ($list as $it): ?>
                        <div class="col-sm-6 col-md-4 col-xl-3 g-mb-20 product-col"
                             data-id="<?=htmlspecialchars($it['id'])?>"
                             data-name="<?=htmlspecialchars($it['name'])?>"
                             data-price="<?= (int)$it['price'] ?>"
                             data-sig="<?=htmlspecialchars($it['sig'])?>"
                             data-match="1">
                          <div class="u-shadow-v18 g-bg-white g-rounded-10 g-pa-15 product-card h-100 d-flex flex-column">
                            <h4 class="name-title" title="<?=htmlspecialchars($it['name'])?>">
                              <span class="scroll-wrap"><span class="scroll-inner"><?=htmlspecialchars($it['name'])?></span></span>
                            </h4>
                            <div class="name-en" title="<?= $it['name_en'] !== '' ? htmlspecialchars($it['name_en']) : '' ?>">
                              <span class="scroll-wrap"><span class="scroll-inner"><?= $it['name_en'] !== '' ? htmlspecialchars($it['name_en']) : '&nbsp;' ?></span></span>
                            </div>

                            <div class="d-flex align-items-center g-mb-10">
                              <div class="qty-wrap">
                                <button class="qty-btn btnMinus" type="button">−</button>
                                <input class="qty-input2" type="number" min="1" max="99" value="1" inputmode="numeric">
                                <button class="qty-btn btnPlus" type="button">＋</button>
                              </div>
                            </div>

                            <div class="mt-auto d-flex align-items-center justify-content-between">
                              <button class="btn btn-sm btn-outline-primary btn-pill add-cart-btn">
                                <i class="fa fa-cart-plus g-mr-5"></i> 加入購物車
                              </button>
                              <span class="price g-color-primary">NT$ <?=number_format((int)$it['price'])?></span>
                            </div>
                          </div>
                        </div>
                      <?php endforeach; endif; ?>
                    </div>

                    <!-- 分頁按鈕（每個 Tab 各自一組） -->
                    <nav class="mt-3 pager-wrap">
                      <ul class="pagination pagination-sm mb-0" data-grid="#grid-<?=$i?>" data-perpage="10" data-page="1"></ul>
                    </nav>
                  </div>
                <?php $i++; endforeach; ?>
              </div>

            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- 右側抽屜：購物車 -->
<div id="cartMask" class="cart-mask"></div>
<aside id="cartDrawer" class="cart-drawer" aria-hidden="true" aria-label="購物車">
  <div class="cart-header">
    <div class="d-flex align-items-center">
      <i class="fa fa-shopping-cart g-mr-8"></i><strong>我的購物車</strong>
      <span class="badge badge-light g-ml-10" id="cartCount2">0</span>
    </div>
    <button id="btnCartClose" class="btn btn-sm btn-light btn-pill">關閉</button>
  </div>
  <div class="cart-body" id="cartBody"></div>
  <div class="cart-footer">
    <div class="d-flex align-items-center justify-content-between g-mb-10">
      <div class="text-muted">總計</div>
      <div id="cartTotal" class="h5 mb-0">NT$ 0</div>
    </div>
    <button id="btnCheckout" class="btn btn-success btn-block btn-pill" disabled>
      <i class="fa fa-credit-card-alt g-mr-5"></i> 結帳
    </button>
  </div>
</aside>

<!-- Loading overlay -->
<div id="checkoutLoading"
     style="position:fixed; inset:0; z-index:2000;
     background:rgba(15,23,42,.7); color:#fff;
     align-items:center; justify-content:center;
     font-size:1.2rem; text-align:center;">
  <div>
    <div id="checkoutStep">交易準備中...</div>
    <div class="spinner-border text-light mt-3" role="status" style="width:2.5rem;height:2.5rem;">
      <span class="sr-only">Loading...</span>
    </div>
  </div>
</div>

<!-- 隱藏表單（結帳） -->
<form id="checkoutForm" class="d-none" method="post" action="<?=site_url('luna/luna_mall/checkout')?>">
  <?php if (!empty($csrf_name)): ?>
    <input type="hidden" name="<?=$csrf_name?>" value="<?=$csrf_hash?>">
  <?php endif; ?>
  <input type="hidden" name="nonce" value="<?= htmlspecialchars($checkout_nonce ?? '') ?>">
  <input type="hidden" name="cart">
</form>

<!-- 小通知 -->
<div id="toastMini" class="toast-mini">已加入購物車</div>

<script>
(function(){
  /* ---------- Loading helpers ---------- */
  var loadingBox = document.getElementById('checkoutLoading');
  var stepText   = document.getElementById('checkoutStep');
  function showLoading(msg){ if(!loadingBox) return; if(stepText) stepText.textContent = msg || '處理中...'; loadingBox.classList.add('is-active'); }
  function updateStep(step){ if(!stepText) return;
    if (step==='verify') stepText.textContent = '驗證商品中...';
    if (step==='point')  stepText.textContent = '扣除點數中...';
    if (step==='item')   stepText.textContent = '發送物品中...';
    if (step==='done')   stepText.textContent = '完成！';
  }
  function hideLoading(){ if(!loadingBox) return; loadingBox.classList.remove('is-active'); }
  try{ hideLoading(); }catch(e){}

  /* ---------- CSRF / Nonce helpers ---------- */
  // ★ 把 server 給的 token 同步到 hidden + Cookie（兩者要一致才不會 403）
  const CSRF_COOKIE_NAME = <?= json_encode($csrf_cookie_name) ?>;

  function setCsrfCookie(name, value){
    if (!name || typeof value!=='string') return;
    // 統一與 CI 設定相同的 path / SameSite；HTTPS 則加 secure
    var parts = [''+encodeURIComponent(name)+'='+encodeURIComponent(value), 'path=/','SameSite=Lax'];
    if (location.protocol==='https:') parts.push('secure');
    document.cookie = parts.join('; ');
  }

  function getCsrfPair(){
    const form = document.getElementById('checkoutForm');
    if(!form) return {name:null, value:null};
    const input = form.querySelector('input[type="hidden"]:not([name="nonce"]):not([name="cart"])');
    return input ? {name: input.name, value: input.value} : {name:null, value:null};
  }
  function setCsrfPair(name, value){
    const form = document.getElementById('checkoutForm'); if(!form) return;
    Array.from(form.querySelectorAll('input[type="hidden"]'))
      .filter(x => x.name !== 'nonce' && x.name !== 'cart')
      .forEach(x => x.remove());
    let input = document.createElement('input');
    input.type = 'hidden'; input.name = name; input.value = value;
    form.appendChild(input);
  }
  function syncCsrfFromServer(name, hash){
    if (!name || !hash) return;
    setCsrfPair(name, hash);           // 更新 hidden
    setCsrfCookie(CSRF_COOKIE_NAME, hash); // ★ 同步更新 Cookie
    // 也備份到全域，讓其他 AJAX 可用
    window.CSRF = { name: name, hash: hash };
  }
  function getNonce(){
    const form = document.getElementById('checkoutForm'); if(!form) return '';
    const input = form.querySelector('input[name="nonce"]'); return input ? input.value : '';
  }
  function setNonce(nonce){
    const form = document.getElementById('checkoutForm'); if(!form) return;
    let input = form.querySelector('input[name="nonce"]');
    if(!input){ input = document.createElement('input'); input.type='hidden'; input.name='nonce'; form.appendChild(input); }
    input.value = nonce || '';
  }

  /* ---------- Utils ---------- */
  function nf(n){ try{ return new Intl.NumberFormat('zh-Hant-TW').format(n); }catch(e){ return n; } }
  function showToast(msg){
    var el = document.getElementById('toastMini'); if(!el) return;
    el.textContent = msg || '完成'; el.classList.add('show');
    clearTimeout(showToast._t); showToast._t = setTimeout(()=>el.classList.remove('show'), 1600);
  }

  window.APP = {
    balanceUrl: "<?= site_url('luna/luna_gm_product_set/balance') ?>",
    checkoutUrl: "<?= site_url('luna/luna_mall/checkout') ?>",
  };

  function refreshPoint() {
    $.ajax({
      url: window.APP.balanceUrl,
      method: 'GET',
      dataType: 'json',
      xhrFields: { withCredentials: true }
    }).done(function(resp){
      if (resp && resp.ok) $('#mallPoint').text(resp.mall_point);
      if (resp && resp.csrf_name && resp.csrf_hash) {
        // ★ 不只更新 hidden，也把 Cookie 一起同步
        syncCsrfFromServer(resp.csrf_name, resp.csrf_hash);
      }
    });
  }

  refreshPoint();
  let refreshTimer = setInterval(refreshPoint, 10000);
  function pauseRefresh(){ if (refreshTimer) { clearInterval(refreshTimer); refreshTimer = null; } }
  function resumeRefresh(){ if (!refreshTimer) { refreshPoint(); refreshTimer = setInterval(refreshPoint, 10000); } }

  /* ===========================================================
     分頁核心（依 data-match 分頁）
     =========================================================== */
  function getActiveContext(){
    const pane  = document.querySelector('.tab-pane.active'); if(!pane) return null;
    const pager = pane.querySelector('.pagination'); if(!pager) return null;
    const grid  = pane.querySelector(pager.dataset.grid); if(!grid) return null;
    const per   = Math.max(1, parseInt(pager.dataset.perpage||'12', 10));
    const page  = Math.max(1, parseInt(pager.dataset.page||'1', 10));
    return {pane, pager, grid, per, page};
  }
  function computeMatched(grid){
    const all = Array.prototype.slice.call(grid.querySelectorAll('.product-col'));
    return all.filter(el => String(el.dataset.match) !== '0');
  }
  function renderPager(pager, totalPages, current, onGoto){
    pager.innerHTML = '';
    function add(txt, target, disabled, active){
      const li = document.createElement('li');
      li.className = 'page-item' + (disabled?' disabled':'') + (active?' active':'');
      const a = document.createElement('a');
      a.className = 'page-link'; a.href = '#'; a.textContent = txt;
      if(!disabled && !active){ a.addEventListener('click', function(e){ e.preventDefault(); onGoto(target); }); }
      li.appendChild(a); pager.appendChild(li);
    }
    add('«', 1, current===1, false);
    add('‹', current-1, current===1, false);
    const windowSize = 7;
    let from = Math.max(1, current - Math.floor(windowSize/2));
    let to   = Math.min(totalPages, from + windowSize - 1);
    from = Math.max(1, to - windowSize + 1);
    for (let p=from; p<=to; p++){ add(String(p), p, false, p===current); }
    add('›', current+1, current===totalPages, false);
    add('»', totalPages, current===totalPages, false);
  }
  function applyPagination(){
    const ctx = getActiveContext(); if(!ctx) return;
    const {pager, grid, per} = ctx;
    const matched = computeMatched(grid);
    const totalPages = Math.max(1, Math.ceil(matched.length / per));
    let current = Math.min(Math.max(1, parseInt(pager.dataset.page||'1', 10)), totalPages);
    pager.dataset.page = current;

    const all = Array.prototype.slice.call(grid.querySelectorAll('.product-col'));
    all.forEach(el => el.style.display = 'none');

    const start = (current-1)*per, end = current*per;
    matched.forEach((el, i) => { if(i>=start && i<end) el.style.display = ''; });

    let empty = grid.querySelector('.__empty_placeholder');
    if (matched.length === 0) {
      if (!empty){
        empty = document.createElement('div');
        empty.className = '__empty_placeholder col-12';
        empty.innerHTML = '<div class="alert alert-secondary mb-0 text-center">沒有符合條件的商品</div>';
        grid.appendChild(empty);
      }
    } else if (empty) {
      empty.parentNode.removeChild(empty);
    }

    renderPager(pager, totalPages, current, function(go){
      pager.dataset.page = go;
      applyPagination();
      grid.scrollIntoView({behavior:'smooth', block:'start'});
    });
  }

  /* ---------- Tabs ---------- */
  var tabLinks  = document.querySelectorAll('.category-tabs a.nav-link');
  var shopSearch= document.getElementById('shop-search');
  tabLinks.forEach(function(a){
    a.addEventListener('click', function(e){
      e.preventDefault();
      tabLinks.forEach(x=>{ x.classList.remove('active'); x.setAttribute('aria-selected','false'); });
      this.classList.add('active'); this.setAttribute('aria-selected','true');
      document.querySelectorAll('.tab-content .tab-pane').forEach(p=>p.classList.remove('show','active'));
      var pane = document.querySelector(this.getAttribute('href')); if (pane) pane.classList.add('show','active');

      if (shopSearch) shopSearch.value = '';
      if (pane){
        pane.querySelectorAll('.product-col').forEach(el=>{
          el.dataset.match = '1';
          el.style.display = '';
        });
        const pager = pane.querySelector('.pagination');
        if (pager){ pager.dataset.page = 1; }
      }
      applyPagination();
    });
  });

  /* ---------- 搜尋 ---------- */
  function filterBySearch(){
    var q = (shopSearch.value||'').toLowerCase().trim();
    const ctx = getActiveContext(); if(!ctx) return;
    const {pane} = ctx;
    const grid = pane.querySelector('.product-grid'); if (!grid) return;

    grid.querySelectorAll('.product-col').forEach(function(el){
      var name = (el.getAttribute('data-name')||'').toLowerCase();
      el.dataset.match = (q==='' || name.indexOf(q)!==-1) ? '1' : '0';
    });
    const pager = pane.querySelector('.pagination');
    if (pager){ pager.dataset.page = 1; }
    applyPagination();
  }
  if (shopSearch) shopSearch.addEventListener('input', filterBySearch);

  /* ---------- 排序 ---------- */
  var sortMenu = document.getElementById('sortMenu');
  if (sortMenu){
    sortMenu.addEventListener('click', function(e){
      var t = e.target.closest('[data-sort]'); if(!t) return; e.preventDefault();
      var mode = t.getAttribute('data-sort');
      const ctx = getActiveContext(); if(!ctx) return;
      const {pane} = ctx;
      var grid = pane.querySelector('.product-grid'); if(!grid) return;

      var items = Array.prototype.slice.call(grid.querySelectorAll('.product-col'));
      items.sort(function(a,b){
        var an=(a.getAttribute('data-name')||'').toLowerCase();
        var bn=(b.getAttribute('data-name')||'').toLowerCase();
        var ap=parseInt(a.getAttribute('data-price')||'0',10);
        var bp=parseInt(b.getAttribute('data-price')||'0',10);
        if(mode==='name_asc')  return an>bn?1:(an<bn?-1:0);
        if(mode==='name_desc') return an<bn?1:(an>bn?-1:0);
        if(mode==='price_asc') return ap-bp;
        if(mode==='price_desc')return bp-ap;
        return 0;
      });
      items.forEach(el=>grid.appendChild(el));

      const pager = pane.querySelector('.pagination');
      if (pager){ pager.dataset.page = 1; }
      applyPagination();
    });
  }

  /* ---------- 跑馬燈 ---------- */
  function setupMarquee(){
    document.querySelectorAll('.scroll-wrap').forEach(function(wrap){
      var inner = wrap.querySelector('.scroll-inner'); if(!inner) return;
      function start(){
        var diff = Math.ceil(inner.scrollWidth - wrap.clientWidth);
        if (diff>0){
          wrap.style.setProperty('--slide-px', diff+'px');
          wrap.style.setProperty('--slide-sec', Math.max(2, diff/40)+'s');
          wrap.classList.add('marquee');
        }
      }
      function stop(){ wrap.classList.remove('marquee'); }
      wrap.addEventListener('mouseenter', start);
      wrap.addEventListener('mouseleave', stop);
      inner.addEventListener('animationend', stop);
    });
  }
  setupMarquee();

  /* ---------- 數量 stepper（卡片內） ---------- */
  document.addEventListener('click', function(e){
    var minus = e.target.closest('.btnMinus'); var plus = e.target.closest('.btnPlus');
    if (minus || plus){
      var card = e.target.closest('.product-col'); if(!card) return;
      var inp = card.querySelector('.qty-input2'); if(!inp) return;
      var v = parseInt(inp.value||'1',10);
      v = isNaN(v)?1:v; v = minus ? Math.max(1, v-1) : Math.min(99, v+1);
      inp.value = v;
    }
  });

  /* ---------- Cart（右側抽屜） ---------- */
  var CART = []; // {id,name,qty,price,sig}
  var cartMask   = document.getElementById('cartMask');
  var cartDrawer = document.getElementById('cartDrawer');
  var btnOpen    = document.getElementById('btnCartOpen');
  var btnClose   = document.getElementById('btnCartClose');
  var btnCheckout= document.getElementById('btnCheckout');
  var btnCheckoutTop = document.getElementById('btnCheckoutTop');
  var cartBody   = document.getElementById('cartBody');
  var cartTotal  = document.getElementById('cartTotal');
  var cartCount  = document.getElementById('cartCount');
  var cartCount2 = document.getElementById('cartCount2');

  function openCart(){ cartMask.classList.add('show'); cartDrawer.classList.add('open'); cartDrawer.setAttribute('aria-hidden','false'); document.body.style.overflow='hidden'; }
  function closeCart(){ cartMask.classList.remove('show'); cartDrawer.classList.remove('open'); cartDrawer.setAttribute('aria-hidden','true'); document.body.style.overflow=''; }
  if (btnOpen)  btnOpen.addEventListener('click', openCart);
  if (btnClose) btnClose.addEventListener('click', closeCart);
  if (cartMask) cartMask.addEventListener('click', closeCart);
  window.addEventListener('keydown', function(e){ if(e.key==='Escape') closeCart(); });

  function el(tag, attrs, text){
    var node = document.createElement(tag);
    if (attrs) for (var k in attrs){
      if (k==='class') node.className = attrs[k];
      else if (k==='dataset'){ var ds = attrs[k]; for (var dk in ds){ node.dataset[dk] = ds[dk]; } }
      else if (k==='html'){ node.innerHTML = attrs[k]; }
      else node.setAttribute(k, attrs[k]);
    }
    if (typeof text==='string') node.textContent = text;
    return node;
  }

  let submitting = false;
  function redrawCart(){
    cartBody.innerHTML = '';
    let total = 0;
    if (!CART.length){
      cartBody.appendChild(el('div', {class:'text-center text-muted g-my-20'}, '購物車是空的，去逛逛吧～'));
    }else{
      CART.forEach(function(it, idx){
        const sub = (it.price||0) * (it.qty||0); total += sub;

        const row = el('div', {class:'cart-item'});
        const left = el('div');
        left.appendChild(el('div', {class:'title', title: it.name}, it.name));
        left.appendChild(el('div', {class:'small text-muted'}, 'NT$ '+ nf(it.price) + ' / 件'));

        const right = el('div', {class:'text-right'});
        right.appendChild(el('button', {class:'btn btn-sm btn-link text-danger del', type:'button', 'data-idx':idx, html:'<i class="fa fa-times"></i>'}));

        const qtyCell = el('div');
        const qtyWrap = el('div', {class:'qty-wrap'});
        qtyWrap.appendChild(el('button', {class:'qty-btn btnMinus2', type:'button', 'data-idx':idx}, '−'));
        qtyWrap.appendChild(el('input', {class:'qty-input2 qtyEdit', type:'number', min:'1', max:'99', value:String(it.qty||1), 'data-idx':idx}));
        qtyWrap.appendChild(el('button', {class:'qty-btn btnPlus2', type:'button', 'data-idx':idx}, '＋'));
        qtyCell.appendChild(qtyWrap);

        row.appendChild(left);
        row.appendChild(right);
        row.appendChild(qtyCell);
        row.appendChild(el('div', {class:'text-right price'}, 'NT$ ' + nf(sub)));

        cartBody.appendChild(row);
      });
    }
    cartTotal.textContent = 'NT$ ' + nf(total);
    cartCount.textContent = CART.length;
    cartCount2.textContent = CART.length;
    btnCheckout.disabled = CART.length===0 || submitting;
    btnCheckoutTop.disabled = CART.length===0 || submitting;
  }

  function addToCart(id,name,price,sig,qty){
    qty = Math.max(1, parseInt(qty||1,10));
    var i = CART.findIndex(x => String(x.id)===String(id) && x.sig===sig);
    if (i>=0) CART[i].qty = Math.min(99, (CART[i].qty||0) + qty);
    else CART.push({id:String(id), name:String(name), qty:qty, price:parseInt(price,10)||0, sig:String(sig)});
    redrawCart(); showToast('已加入購物車');
  }

  document.addEventListener('click', function(e){
    var btn = e.target.closest('.add-cart-btn'); if(!btn) return;
    if (submitting) return;
    var col = btn.closest('.product-col'); if(!col) return;
    var id    = (col.getAttribute('data-id')||'')+'';
    var name  = (col.getAttribute('data-name')||'')+'';
    var price = parseInt(col.getAttribute('data-price')||'0',10);
    var sig   = (col.getAttribute('data-sig')||'')+'';
    var qtyEl = col.querySelector('.qty-input2');
    var qtyRaw = qtyEl ? parseInt(qtyEl.value||'1',10) : 1;
    var qty    = Math.max(1, Math.min(99, qtyRaw));
    if (!id || !sig || qty<=0) return;
    addToCart(id,name,price,sig,qty);
  });

  if (cartBody){
    cartBody.addEventListener('click', function(e){
      if (submitting) return;
      var del = e.target.closest('.del'); if (del){
        var idx = parseInt(del.getAttribute('data-idx'),10);
        if (!isNaN(idx)){ CART.splice(idx,1); redrawCart(); }
        return;
      }
      var minus = e.target.closest('.btnMinus2');
      var plus  = e.target.closest('.btnPlus2');
      if (minus || plus){
        var idx = parseInt((minus||plus).getAttribute('data-idx'),10);
        if (isNaN(idx) || !CART[idx]) return;
        var v = CART[idx].qty||1;
        CART[idx].qty = minus ? Math.max(1, v-1) : Math.min(99, v+1);
        redrawCart();
      }
    });
    cartBody.addEventListener('change', function(e){
      if (submitting) return;
      var inp = e.target.closest('.qtyEdit'); if (!inp) return;
      var idx = parseInt(inp.getAttribute('data-idx'),10);
      var v = Math.max(1, Math.min(99, parseInt(inp.value||'1',10)));
      if (!isNaN(idx) && CART[idx]){ CART[idx].qty = v; redrawCart(); }
    });
  }

  if (document.getElementById('btnCheckoutTop')) {
    document.getElementById('btnCheckoutTop').addEventListener('click', function(){ if(CART.length) openCart(); });
  }

  /* ---------- 結帳（自動重試一次 + CSRF Cookie 同步） ---------- */
  var checkoutForm = document.getElementById('checkoutForm');
  function lockCartUI(on){
    submitting = !!on;
    btnCheckout.classList.toggle('is-disabled', on);
    btnCheckoutTop.classList.toggle('is-disabled', on);
    cartDrawer.classList.toggle('is-disabled', on);
    btnCheckout.disabled = on || CART.length===0;
    btnCheckoutTop.disabled = on || CART.length===0;
  }

  function ensureCsrfInForm(){
    const cur = getCsrfPair();
    if ((!cur.name || !cur.value) && window.CSRF && window.CSRF.name && window.CSRF.hash) {
      setCsrfPair(window.CSRF.name, window.CSRF.hash);
      setCsrfCookie(CSRF_COOKIE_NAME, window.CSRF.hash); // ★ 也補 Cookie
    }
  }

  function postCheckoutOnce(){
    const formEl = checkoutForm;
    const fd = new FormData();

    // 1) CSRF（hidden + header 用同一組）
    ensureCsrfInForm();
    const pair = getCsrfPair();
    if (pair.name && pair.value) fd.append(pair.name, pair.value);

    // 2) Nonce + cart
    const nonceNow = getNonce();
    fd.append('nonce', nonceNow);
    fd.append('cart', JSON.stringify(CART.map(it => ({
      id:String(it.id),
      qty:Math.max(1, Math.min(99, parseInt(it.qty,10)||1)),
      sig:String(it.sig)
    }))));

    // 3) Headers：同一組 CSRF，並補 X-Checkout-Nonce（和 body 一致）
    const headers = {
      'X-Requested-With':'XMLHttpRequest',
      'Accept':'application/json',
      'X-CSRF-Token': pair && pair.value ? pair.value : '',
      'X-Checkout-Nonce': nonceNow
    };

    return fetch(formEl.getAttribute('action'), {
      method:'POST', body:fd, headers, credentials:'include'
    }).then(async r => {
      const txt = await r.text(); let j=null; try{ j=JSON.parse(txt);}catch(_){}
      // ★ 同步 server 回傳的 token 到 hidden + Cookie
      if (j && j.csrf_name && j.csrf_hash) syncCsrfFromServer(j.csrf_name, j.csrf_hash);
      if (j && j.checkout_nonce) setNonce(j.checkout_nonce);
      return { ok: r.ok, status: r.status, payload: j };
    });
  }

  function doCheckout(){
    if (!CART.length || submitting) return;
    pauseRefresh();
    lockCartUI(true);
    showLoading('開始交易...'); updateStep('verify');

    let triedRetry = false;  // 只重試一次
    const bailout = setTimeout(hideLoading, 20000);

    const fail = (msg) => {
      showToast(msg || '結帳失敗');
      hideLoading(); clearTimeout(bailout);
      lockCartUI(false); resumeRefresh();
    };

    const done = (j) => {
      if (Array.isArray(j.progress)) j.progress.forEach(updateStep);
      alert(j.order_no ? `購買成功（訂單：${j.order_no}）！扣點 NT$ ${nf(j.total)}，剩餘點數 ${nf(j.after)}`
                       : '購買成功！扣點 NT$ ' + nf(j.total) + '，剩餘點數 ' + nf(j.after));
      CART=[]; redrawCart(); closeCart();
      const mp=document.getElementById('mallPoint'); if (mp && typeof j.after!=='undefined') mp.textContent = nf(j.after);
      updateStep('done');
      hideLoading(); clearTimeout(bailout);
      lockCartUI(false); resumeRefresh();
    };

    postCheckoutOnce()
      .then(res => {
        const j = res.payload || {};
        // 401：未登入 → 直接導去登入
        if (res.status === 401) { window.location.href = "<?= site_url('luna/login') ?>"; return null; }

        // 首次 CSRF 失敗 → 同步完 token+Cookie 後再重送一次
        if ((!res.ok || j.ok === false) &&
            (res.status === 403 || /csrf/i.test(String(j.msg||''))) &&
            !triedRetry) {
          triedRetry = true;
          return postCheckoutOnce();
        }
        return res;
      })
      .then(res2 => {
        if (!res2) return; // 已導向登入
        const j2 = res2.payload || {};
        if (!res2.ok || j2.ok === false) return fail(j2.msg);
        return done(j2);
      })
      .catch(() => fail('網路或驗證異常，請再試一次'));
  }

  var btnCheckout = document.getElementById('btnCheckout');
  if (btnCheckout) btnCheckout.addEventListener('click', doCheckout);

  /* ---------- 初始化：建第一個分頁 ---------- */
  applyPagination();
})();
</script>
