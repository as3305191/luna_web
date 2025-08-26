<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <?php $this->load->view("luna/luna_head"); ?>
  <style>
     
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

    /* 美化：按鈕 & 徽章 */
    .btn-pill{border-radius:999px}
    .badge-dot{display:inline-flex; align-items:center; gap:.35rem; padding:.2rem .6rem; border-radius:999px; background:var(--soft); border:1px solid var(--border)}
    .badge-dot i{width:.45rem; height:.45rem; border-radius:50%; background:var(--primary); display:inline-block}

    /* 右側抽屜購物車 */
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

    /* 小通知（加到購物車） */
    .toast-mini{
      position:fixed; right:18px; bottom:18px; background:#111827; color:#fff; padding:8px 12px;
      border-radius:10px; opacity:0; transform:translateY(10px); transition:.25s ease; z-index:1100; font-size:.92rem;
    }
   .toast-mini.show{opacity:1; transform:translateY(0)}

  </style>
</head>
<body>
<main>
  <?php $this->load->view("luna/luna_header"); ?>

  <section class="g-mb-100">
    <div class="container">
      <div class="row">
        <?php $this->load->view("luna/luna_sidebar"); ?>

        <div class="col-lg-9">
          <div class="card border-0 shadow-soft">
            <div class="card-header d-flex align-items-center justify-content-between g-bg-gray-light-v5 border-0">
              <div class="d-flex align-items-center">
                <h3 class="h5 mb-0"><i class="icon-bag g-mr-8"></i> 商城</h3>
                <span class="badge-dot g-ml-15">
                  <i></i> 剩餘點數：
                  <span id="mallPoint" class="mono">--</span>
                </span>
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
                      <div class="row" id="grid-<?=$i?>">
                        <?php if (empty($list)): ?>
                          <div class="col-12"><div class="alert alert-secondary mb-0">此分頁目前沒有商品</div></div>
                        <?php else: foreach ($list as $it): ?>
                          <div class="col-sm-6 col-md-4 col-xl-3 g-mb-20 product-col"
                               data-id="<?=htmlspecialchars($it['id'])?>"
                               data-name="<?=htmlspecialchars($it['name'])?>"
                               data-price="<?= (int)$it['price'] ?>"
                               data-sig="<?=htmlspecialchars($it['sig'])?>">
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
                                  <input class="qty-input2" type="number" min="1" max="9999" value="1">
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
                    </div>
                  <?php $i++; endforeach; ?>
                </div>

              <?php endif; ?>

              <hr class="g-my-20">
              <nav class="text-center" aria-label="Page Navigation">
                <ul class="list-inline mb-0">
                  <li class="list-inline-item"><span class="u-pagination-v1__item u-pagination-v1-4 g-rounded-50 g-pa-7-16 disabled">已載入全部</span></li>
                </ul>
              </nav>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <?php $this->load->view("luna/luna_footer"); ?>
</main>

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
<form id="checkoutForm" class="d-none" method="post" action="<?=site_url('luna/Luna_mall/checkout')?>">
  <?php if (!empty($csrf_name)): ?>
    <input type="hidden" name="<?=$csrf_name?>" value="<?=$csrf_hash?>">
  <?php endif; ?>
  <input type="hidden" name="cart">
</form>

<!-- 小通知 -->
<div id="toastMini" class="toast-mini">已加入購物車</div>

<?php $this->load->view("luna/luna_script"); ?>
<script>
(function(){
  // --- Loading Overlay helpers（同檔可用 + 對外相容） ---
  var loadingBox = document.getElementById('checkoutLoading');
  var stepText   = document.getElementById('checkoutStep');

  function showLoading(msg){
    if (!loadingBox) return;
    if (stepText) stepText.textContent = msg || '處理中...';
    loadingBox.classList.add('is-active');   // 用 class 控制顯示
  }
  function updateStep(step){
    if (!stepText) return;
    if (step==='verify') stepText.textContent = '驗證商品中...';
    if (step==='point')  stepText.textContent = '扣除點數中...';
    if (step==='item')   stepText.textContent = '發送物品中...';
    if (step==='done')   stepText.textContent = '完成！';
  }
  function hideLoading(){
    if (!loadingBox) return;
    loadingBox.classList.remove('is-active');
  }

  // 讓其他檔案也能呼叫（避免別的地方又報 undefined）
  window.showLoading = showLoading;
  window.updateStep  = updateStep;
  window.hideLoading = hideLoading;

  // 進頁面保險：如果上次殘留，先關掉
  try { hideLoading(); } catch(e) {}

  /* ---------- Utils ---------- */
  function nf(n){ try{ return new Intl.NumberFormat('zh-Hant-TW').format(n); }catch(e){ return n; } }
  function showToast(msg){
    var el = document.getElementById('toastMini'); if(!el) return;
    el.textContent = msg || '完成'; el.classList.add('show');
    clearTimeout(showToast._t); showToast._t = setTimeout(()=>el.classList.remove('show'), 1400);
  }

  /* ---------- 點數自動更新（10s） ---------- */
  const ENDPOINT_BAL = '<?= site_url("luna/luna_gm_product_set/balance") ?>';
  const mpEl = document.getElementById('mallPoint');
  function refreshPoint(){
    if(!mpEl) return;
    fetch(ENDPOINT_BAL, {method:'POST', headers:{'X-Requested-With':'XMLHttpRequest'}})
      .then(r => r.ok ? r.json() : null)
      .then(j => { if(j && j.ok && typeof j.mall_point!=="undefined"){ mpEl.textContent = nf(j.mall_point); } })
      .catch(()=>{});
  }
  refreshPoint(); setInterval(refreshPoint, 10000);

  /* ---------- Tabs（純原生） ---------- */
  var tabLinks = document.querySelectorAll('.category-tabs a.nav-link');
  var shopSearch = document.getElementById('shop-search');
  tabLinks.forEach(function(a){
    a.addEventListener('click', function(e){
      e.preventDefault();
      tabLinks.forEach(x=>{ x.classList.remove('active'); x.setAttribute('aria-selected','false'); });
      this.classList.add('active'); this.setAttribute('aria-selected','true');
      document.querySelectorAll('.tab-content .tab-pane').forEach(p=>p.classList.remove('show','active'));
      var pane = document.querySelector(this.getAttribute('href')); if (pane) pane.classList.add('show','active');
      if (shopSearch) shopSearch.value = '';
      if (pane) pane.querySelectorAll('.product-col').forEach(el=>el.style.display='');
    });
  });

  /* ---------- 搜尋 ---------- */
  function filterBySearch(){
    var q = (shopSearch.value||'').toLowerCase().trim();
    var pane = document.querySelector('.tab-pane.active'); if(!pane) return;
    pane.querySelectorAll('.product-col').forEach(function(el){
      var name = (el.getAttribute('data-name')||'').toLowerCase();
      el.style.display = name.indexOf(q) !== -1 ? '' : 'none';
    });
  }
  if (shopSearch) shopSearch.addEventListener('input', filterBySearch);

  /* ---------- 排序 ---------- */
  var sortMenu = document.getElementById('sortMenu');
  if (sortMenu){
    sortMenu.addEventListener('click', function(e){
      var t = e.target.closest('[data-sort]'); if(!t) return; e.preventDefault();
      var mode = t.getAttribute('data-sort');
      var pane = document.querySelector('.tab-pane.active'); if(!pane) return;
      var grid = pane.querySelector('.row'); if(!grid) return;
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
    });
  }

  /* ---------- 跑馬燈（滑入才跑） ---------- */
  function setupMarquee(){
    document.querySelectorAll('.scroll-wrap').forEach(function(wrap){
      var inner = wrap.querySelector('.scroll-inner'); if(!inner) return;
      function start(){
        var diff = Math.ceil(inner.scrollWidth - wrap.clientWidth);
        if (diff>0){ wrap.style.setProperty('--slide-px', diff+'px'); wrap.style.setProperty('--slide-sec', Math.max(2, diff/40)+'s'); wrap.classList.add('marquee'); }
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
      v = isNaN(v)?1:v; v = minus ? Math.max(1, v-1) : Math.min(9999, v+1);
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

  function openCart(){
    cartMask.classList.add('show');
    cartDrawer.classList.add('open');
    cartDrawer.setAttribute('aria-hidden','false');
    document.body.style.overflow='hidden';
  }
  function closeCart(){
    cartMask.classList.remove('show');
    cartDrawer.classList.remove('open');
    cartDrawer.setAttribute('aria-hidden','true');
    document.body.style.overflow='';
  }
  if (btnOpen)  btnOpen.addEventListener('click', openCart);
  if (btnClose) btnClose.addEventListener('click', closeCart);
  if (cartMask) cartMask.addEventListener('click', closeCart);
  window.addEventListener('keydown', function(e){ if(e.key==='Escape') closeCart(); });

  function redrawCart(){
    cartBody.innerHTML = '';
    let total = 0;
    if (!CART.length){
      cartBody.innerHTML = '<div class="text-center text-muted g-my-20">購物車是空的，去逛逛吧～</div>';
    }else{
      CART.forEach(function(it, idx){
        const sub = (it.price||0) * (it.qty||0); total += sub;
        const row = document.createElement('div'); row.className='cart-item';
        row.innerHTML = `
          <div>
            <div class="title" title="${it.name}">${it.name}</div>
            <div class="small text-muted">NT$ ${nf(it.price)} / 件</div>
          </div>
          <div class="text-right">
            <button class="btn btn-sm btn-link text-danger del" data-idx="${idx}" title="移除"><i class="fa fa-times"></i></button>
          </div>
          <div>
            <div class="qty-wrap">
              <button class="qty-btn btnMinus2" data-idx="${idx}" type="button">−</button>
              <input class="qty-input2 qtyEdit" data-idx="${idx}" type="number" min="1" max="9999" value="${it.qty||1}">
              <button class="qty-btn btnPlus2" data-idx="${idx}" type="button">＋</button>
            </div>
          </div>
          <div class="text-right price">NT$ ${nf(sub)}</div>
        `;
        cartBody.appendChild(row);
      });
    }
    cartTotal.textContent = 'NT$ ' + nf(total);
    cartCount.textContent = CART.length;
    cartCount2.textContent = CART.length;
    btnCheckout.disabled = CART.length===0;
    btnCheckoutTop.disabled = CART.length===0;
  }

  function addToCart(id,name,price,sig,qty){
    qty = Math.max(1, parseInt(qty||1,10));
    var i = CART.findIndex(x => String(x.id)===String(id) && x.sig===sig);
    if (i>=0) CART[i].qty = Math.min(9999, (CART[i].qty||0) + qty);
    else CART.push({id:String(id), name:String(name), qty:qty, price:parseInt(price,10)||0, sig:String(sig)});
    redrawCart(); showToast('已加入購物車');
  }

  // 商品卡 -> 加入購物車
  document.addEventListener('click', function(e){
    var btn = e.target.closest('.add-cart-btn'); if(!btn) return;
    var col = btn.closest('.product-col'); if(!col) return;
    var id    = (col.getAttribute('data-id')||'')+'';
    var name  = (col.getAttribute('data-name')||'')+'';
    var price = parseInt(col.getAttribute('data-price')||'0',10);
    var sig   = (col.getAttribute('data-sig')||'')+'';
    var qtyEl = col.querySelector('.qty-input2');
    var qty   = qtyEl ? parseInt(qtyEl.value||'1',10) : 1;
    if (!id || !sig || qty<=0) return;
    addToCart(id,name,price,sig,qty);
  });

  // 抽屜內：調整數量 / 刪除
  if (cartBody){
    cartBody.addEventListener('click', function(e){
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
        CART[idx].qty = minus ? Math.max(1, v-1) : Math.min(9999, v+1);
        redrawCart();
      }
    });
    cartBody.addEventListener('change', function(e){
      var inp = e.target.closest('.qtyEdit'); if (!inp) return;
      var idx = parseInt(inp.getAttribute('data-idx'),10);
      var v = Math.max(1, Math.min(9999, parseInt(inp.value||'1',10)));
      if (!isNaN(idx) && CART[idx]){ CART[idx].qty = v; redrawCart(); }
    });
  }

  // 開抽屜 / 頂部結帳也會開抽屜
  document.getElementById('btnCheckoutTop').addEventListener('click', function(){ if(CART.length) openCart(); });

  /* ---------- 結帳：送 {id,qty,sig}，後端驗章/重算/扣點 ---------- */
  var checkoutForm = document.getElementById('checkoutForm');
  function doCheckout(){
  if (!CART.length) return;

  var safeCart = CART.map(it => ({ id: it.id, qty: it.qty, sig: it.sig }));
  var input = checkoutForm.querySelector('input[name="cart"]');
  input.value = JSON.stringify(safeCart);

  var fd = new FormData(checkoutForm);
  showLoading('開始交易...');

  // 20 秒防呆，避免 overlay 卡死
  var bailout = setTimeout(hideLoading, 20000);

  fetch(checkoutForm.getAttribute('action'), { method:'POST', body:fd })
    .then(r => r.json())
    .then(res => {
      // 更新 CSRF（如果後端有給）
      if (res && res.csrf_name && res.csrf_hash){
        var csrf = checkoutForm.querySelector('input[type="hidden"]');
        if (csrf){ csrf.setAttribute('name', res.csrf_name); csrf.value = res.csrf_hash; }
      }

      if (res && Array.isArray(res.progress)) res.progress.forEach(updateStep);

      if (!res || !res.ok){
        alert(res && res.msg ? res.msg : '結帳失敗');
        hideLoading(); clearTimeout(bailout);
        return;
      }

      if (typeof res.after !== 'undefined' && res.after < 0){
        alert('點數不足，請先儲值再試！');
        hideLoading(); clearTimeout(bailout);
        return;
      }

      alert('購買成功！扣點 NT$ ' + nf(res.total) + '，剩餘點數 ' + nf(res.after));
      CART = []; redrawCart(); closeCart();
      if (mpEl && typeof res.after !== 'undefined') mpEl.textContent = nf(res.after);

      hideLoading(); clearTimeout(bailout);
    })
    .catch(()=>{
      alert('網路異常，請稍後再試');
      hideLoading(); clearTimeout(bailout);
    });
}

  if (btnCheckout) btnCheckout.addEventListener('click', doCheckout);

})();
</script>
</body>
</html>
