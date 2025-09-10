<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
  td.text-right { text-align:right; }
  .pagination-wrap { display:flex; justify-content:center; gap:6px; flex-wrap:wrap; }
  .page-ctrl { cursor:pointer; user-select:none; }
  .page-ellipsis { padding:6px 10px; color:#999; }
  .badge { display:inline-block; padding:.25em .5em; border-radius:.25rem; font-size:12px; }
  .badge.gray { background:#e9ecef; color:#495057; }
  .badge.orange { background:#fff3cd; color:#856404; }
  .btn-xs { padding:2px 6px; font-size:12px; line-height:1.3; }
  .table thead th { white-space:nowrap; }
  .muted { color:#6c757d; }
  .w-120 { width:120px; }
  .w-140 { width:140px; }
  .w-80 { width:80px; }
  .nowrap { white-space:nowrap; }
  .loading { opacity:.6; pointer-events:none; }
  .small { font-size:12px; }
  .mono { font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, "Liberation Mono", monospace; }
</style>

<div class="col-lg-9">
  <div class="row g-mb-40">
    <div class="col-lg-12">

      <!-- 新增玩家帳號 -->
      <div class="card border-0 g-mb-20">
        <div class="card-header g-bg-gray-light-v5 border-0">
          <h3 class="h6 mb-0"><i class="icon-user g-mr-5"></i> 新增玩家帳號</h3>
        </div>
        <div class="card-block">
          <div class="row g-mb-10">
            <div class="col-md-4">
              <label>帳號（英數 ≥6）</label>
              <input id="new_login" class="form-control" maxlength="50" placeholder="例如: Player123">
            </div>
            <div class="col-md-4">
              <label>密碼（英數 ≥6）</label>
              <input id="new_password" class="form-control" maxlength="100" placeholder="例如: Pass123">
            </div>
            <div class="col-md-4">
              <label>權限</label>
              <select id="new_userLevel" class="form-control">
                <option value="6" selected>一般玩家 (6)</option>
                <option value="2">GM (2)</option>
              </select>
            </div>
          </div>
          <button id="btnCreateUser" class="btn btn-primary">建立帳號</button>
          <span id="cu_msg" class="g-ml-10"></span>
        </div>
      </div>

      <!-- 帳號管理 -->
      <div class="card border-0 g-mb-20">
        <div class="card-header g-bg-gray-light-v5 border-0">
          <h3 class="h6 mb-0"><i class="icon-lock g-mr-5"></i> 帳號管理</h3>
        </div>
        <div class="card-block">
          <div class="row g-mb-10">
            <div class="col-md-6">
              <label>帳號 (id_loginid) 或 USER_IDX</label>
              <input id="acct_query" class="form-control" placeholder="輸入帳號或 USER_IDX">
            </div>
            <div class="col-md-6 d-flex align-items-end">
              <button id="btnAcctSearch" class="btn btn-info">查詢</button>
            </div>
          </div>
          <div id="acct_info" class="g-mt-10 small"></div>
          <div id="acct_actions" class="g-mt-10" style="display:none;">
            <button class="btn btn-danger btn-sm" id="btnBan">封鎖 (UserLevel=4)</button>
            <button class="btn btn-success btn-sm" id="btnUnban">解鎖成一般玩家 (UserLevel=6)</button>
            <button class="btn btn-warning btn-sm" id="btnMakeGM">升 GM (UserLevel=2)</button>
          </div>
        </div>
      </div>

      <!-- 發點數 -->
      <div class="card border-0 g-mb-20">
        <div class="card-header d-flex align-items-center justify-content-between g-bg-gray-light-v5 border-0">
          <h3 class="h6 mb-0"><i class="icon-wallet g-pos-rel g-top-1 g-mr-5"></i> 發送點數（依帳號）</h3>
        </div>
        <div class="card-block g-pt-15 g-pb-10">
          <div class="row g-mb-10">
            <div class="col-md-6">
              <label>帳號 <mark>id_loginid</mark>（可多個，用逗號或換行分隔）</label>
              <textarea id="mp_user_list" class="form-control mono" rows="4" placeholder="輸入帳號"></textarea>
            </div>
            <div class="col-md-3">
              <label>發送點數（可正可負；正數＝加點，負數＝扣點）</label>
              <input id="mp_amount" type="number" class="form-control" step="1" value="100">
            </div>
            <div class="col-md-3">
              <label>備註（選填）</label>
              <input id="mp_memo" type="text" class="form-control" maxlength="200">
            </div>
          </div>
          <div class="d-flex align-items-center">
            <button id="btnGrantPoint" class="btn btn-success">發送點數</button>
            <span id="mp_msg" class="g-ml-15" style="color:#28a745;"></span>
          </div>
          <div id="mp_result" class="g-mt-10"></div>
        </div>
      </div>

      <!-- 發送商品到商城包包（多人） -->
      <div class="card border-0 g-mb-20">
        <div class="card-header g-bg-gray-light-v5 border-0">
          <h3 class="h6 mb-0">
            <i class="icon-bag g-mr-5"></i> 發送商品到商城包包
            <small class="muted">（ITEM_POSITION 固定 320，封印/疊加由後端自動判斷）</small>
          </h3>
        </div>
        <div class="card-block">
          <div class="row g-mb-10">
            <div class="col-md-6">
              <label>帳號清單（id_loginid；可多個，用逗號或換行分隔）</label>
              <textarea id="shop_user_ids" class="form-control mono" rows="3"
                        placeholder="例如：Player001,PlayerABC&#10;Test999"></textarea>
              <div class="small muted g-mt-5">只接受英數字（A-Z, a-z, 0-9）。無效的會被自動忽略。</div>
            </div>
            <div class="col-md-2">
              <label>數量（qty）</label>
              <input id="shop_qty" type="number" class="form-control" min="1" step="1" value="1">
            </div>
            <div class="col-md-4">
              <label>商品編號（可多個，以逗號或換行分隔）</label>
              <textarea id="shop_item_codes" class="form-control mono" rows="3"
                        placeholder="例如：21001685,21000001"></textarea>
              <div class="small muted g-mt-5">可直接在下方「商品清單」點 <b>加入待發送</b> 快速填入。</div>
            </div>
          </div>

          <div class="d-flex align-items-center">
            <button id="btnSendShopBagMulti" class="btn btn-primary">送至商城包包（多人）</button>
            <span id="shop_msg" class="g-ml-15"></span>
          </div>
          <div id="shop_result" class="g-mt-10 small"></div>
        </div>
      </div>

      <!-- 商品清單 -->
      <div class="card border-0">
        <div class="card-header d-flex align-items-center justify-content-between g-bg-gray-light-v5 border-0">
          <h3 class="h6 mb-0"><i class="icon-directions g-pos-rel g-top-1 g-mr-5"></i> 商品清單</h3>
          <div class="d-flex align-items-center">
            <input id="q" type="text" class="form-control form-control-sm" 
                  placeholder="搜尋：編號 / 名稱" style="width:260px;">
          </div>
        </div>
        <div class="card-block g-pa-0">
          <div class="table-responsive">
            <table class="table table-bordered u-table--v2">
              <thead class="text-uppercase g-letter-spacing-1">
                <tr>
                  <th class="w-140">商品編號</th>
                  <th>名稱</th>
                  <th class="w-120">限時</th>
                  <th class="w-140">分類</th>
                  <th class="w-120">操作</th>
                </tr>
              </thead>
              <tbody id="dt_list_body"></tbody>
            </table>
          </div>
          <div id="msg" class="text-center g-mb-10" style="color:#d9534f;"></div>
          <nav class="text-center" aria-label="Page Navigation">
            <ul class="list-inline pagination-wrap" id="pagination"></ul>
          </nav>
        </div>
      </div>

    </div>
  </div>
</div>

<script>
(function(){
  // ===== API 路徑 =====
  const API_GET                 = '<?= site_url('luna/luna_gm_product_set/get_data') ?>';
  const API_GRANT_POINTS        = '<?= site_url("luna/luna_gm_product_set/grant_points") ?>';
  const API_CREATE_USER         = '<?= site_url("luna/luna_gm_product_set/create_user") ?>';
  const API_ACCT_SEARCH         = '<?= site_url("luna/luna_gm_product_set/account_search") ?>';
  const API_ACCT_UPDATE         = '<?= site_url("luna/luna_gm_product_set/account_update") ?>';
  const API_SEND_SHOP_BAG_MULTI = '<?= site_url("luna/luna_gm_product_set/send_shop_bag_multi") ?>';

  // ===== 小工具 =====
  const qs  = (s, root=document) => root.querySelector(s);
  const qsa = (s, root=document) => Array.prototype.slice.call(root.querySelectorAll(s));
  const on  = (el, ev, fn) => el && el.addEventListener(ev, fn);
  const val = (sel) => (qs(sel)?.value ?? '').trim();

  function setLoading(on){
    const t = qs('.table');
    if (t) t.classList.toggle('loading', !!on);
  }
  function debounce(fn, ms){ let t=null; return (...args)=>{ clearTimeout(t); t=setTimeout(()=>fn(...args), ms); }; }
  function humanizeSeconds(sec){
    const n = parseInt(sec,10); if(!n || n<=0) return '永久';
    const d=Math.floor(n/86400), h=Math.floor((n%86400)/3600), m=Math.floor((n%3600)/60);
    if(d>=1 && h===0) return `${d}天`;
    if(d>=1) return `${d}天${h}小時`;
    if(h>=1) return `${h}小時${m}分`;
    return `${m}分`;
  }

  // ===== CSRF Helper（與後端同步）=====
  function addCsrf(obj){
    obj = obj || {};
    const name = (window.CSRF && window.CSRF.name) || '<?= $this->security->get_csrf_token_name(); ?>';
    const hash = (window.CSRF && window.CSRF.hash) || '<?= $this->security->get_csrf_hash(); ?>';
    if (name && hash) obj[name] = hash;
    return obj;
  }
  function updateCsrfFrom(res){
    if (res && res.csrf_name && res.csrf_hash){
      window.CSRF = { name:res.csrf_name, hash:res.csrf_hash };
    }
  }
  function formPost(url, dataObj){
    const data = addCsrf(dataObj || {});
    const fd = new FormData(); Object.keys(data).forEach(k=>fd.append(k,data[k]));
    const headers = {'X-Requested-With':'XMLHttpRequest','Accept':'application/json'};
    if (window.CSRF && window.CSRF.hash) headers['X-CSRF-Token'] = window.CSRF.hash;
    return fetch(url, { method:'POST', body:fd, headers, credentials:'include' })
      .then(async r => { const txt=await r.text(); let j=null; try{ j=JSON.parse(txt);}catch(_){}
        return { ok:r.ok, status:r.status, json:j };
      });
  }

  // ====== 商品清單（分頁 + 搜尋）======
  let currentPage = 1;
  let currentQ = '';

  function renderRows(items){
    const body = qs('#dt_list_body');
    body.innerHTML = '';
    if (!items || !items.length){
      body.innerHTML = '<tr><td colspan="5" class="text-center">查無資料</td></tr>';
      return;
    }
    items.forEach(me=>{
      const tr = document.createElement('tr');

      const td1 = document.createElement('td'); td1.className='mono'; td1.textContent=me.product_code || '';
      const td2 = document.createElement('td'); td2.textContent = me.name || '';
      const td3 = document.createElement('td'); td3.textContent = me.endtime ? humanizeSeconds(me.endtime) : '永久';
      const td4 = document.createElement('td'); td4.textContent = `大類:${me.category_code} / 細類:${me.category_detail}`;
      const td5 = document.createElement('td'); td5.className = 'nowrap';
      const btn = document.createElement('button'); btn.className='btn btn-primary btn-xs'; btn.textContent='加入待發送';
      btn.addEventListener('click', ()=>{
        const toAdd = String(me.product_code || '').trim(); if (!toAdd) return;
        const el = qs('#shop_item_codes'); const cur = (el.value || '').trim();
        el.value = cur ? (cur.endsWith(',') ? cur + toAdd : cur + ',' + toAdd) : toAdd;
      });
      td5.appendChild(btn);

      tr.append(td1,td2,td3,td4,td5);
      body.appendChild(tr);
    });
  }

  function renderPagination(page, totalPage){
    const wrap = qs('#pagination'); wrap.innerHTML='';
    const windowSize = 8; totalPage = Math.max(1, parseInt(totalPage||1,10));

    function addBtn(label, targetPage, disabled=false, active=false){
      const li=document.createElement('li'); li.className='list-inline-item';
      const a=document.createElement('a');
      a.className='u-pagination-v1__item u-pagination-v1-4 g-rounded-50 g-pa-7-14 page-ctrl';
      if (active) a.classList.add('u-pagination-v1-4--active');
      if (disabled) a.classList.add('disabled');
      a.href='javascript:void(0)'; a.textContent=label;
      if (!disabled && !active) a.addEventListener('click', ()=>fetch_page(targetPage));
      li.appendChild(a); wrap.appendChild(li);
    }
    function addEllipsis(){ const li=document.createElement('li'); li.className='list-inline-item page-ellipsis'; li.textContent='…'; wrap.appendChild(li); }

    addBtn('«', Math.max(1, page-1), page<=1);
    let start = Math.floor((page-1)/windowSize)*windowSize + 1;
    let end   = Math.min(start + windowSize - 1, totalPage);
    if (start > 1){ addBtn('1',1,false,page===1); addEllipsis(); }
    for (let i=start; i<=end; i++) addBtn(String(i), i, false, i===page);
    if (end < totalPage){ addEllipsis(); addBtn(String(totalPage), totalPage, false, page===totalPage); }
    addBtn('»', Math.min(totalPage, page+1), page>=totalPage);
  }

  function fetch_page(page){
    setLoading(true);
    formPost(API_GET, { page, q: currentQ })
      .then(({ok, status, json})=>{
        updateCsrfFrom(json);
        const msg = qs('#msg'); msg.textContent='';
        if (!ok){ msg.textContent = '資料載入失敗：'+status; return; }
        if (json.error) msg.textContent = json.error;
        renderRows(json.items || []);
        currentPage = json.page || 1;
        renderPagination(currentPage, json.total_page || 1);
      })
      .catch(()=>{ qs('#msg').textContent='資料載入失敗'; })
      .finally(()=> setLoading(false));
  }

  // 初次渲染 + PJAX 進場
  fetch_page(1);
  document.addEventListener('page:enter', (e)=>{
    const url = (e.detail && e.detail.url) || location.href;
    if (url.indexOf('luna_gm_product_set') >= 0) fetch_page(1);
  });

  // 搜尋（防抖）
  const qInput = qs('#q');
  on(qInput, 'input', debounce(()=>{ currentQ = val('#q'); fetch_page(1); }, 300));

  // ===== 建立帳號 =====
  const btnCreateUser = qs('#btnCreateUser');
  on(btnCreateUser, 'click', ()=>{
    const login = val('#new_login');
    const pwd   = val('#new_password');
    const lvl   = parseInt(val('#new_userLevel') || '6',10) || 6;
    if(!/^[A-Za-z0-9]{6,}$/.test(login)){ alert('帳號需為英數且至少 6 碼'); return; }
    if(!/^[A-Za-z0-9]{6,}$/.test(pwd)){ alert('密碼需為英數且至少 6 碼'); return; }

    const uiMsg = qs('#cu_msg');
    btnCreateUser.disabled = true; btnCreateUser.textContent='建立中…'; uiMsg.textContent='';

    formPost(API_CREATE_USER, { login, password:pwd, userLevel:lvl })
      .then(({json})=>{
        updateCsrfFrom(json);
        if (json && json.ok){
          uiMsg.style.color='#28a745'; uiMsg.textContent='建立成功，id_idx='+json.id_idx;
          qs('#new_login').value=''; qs('#new_password').value=''; qs('#new_userLevel').value='6';
        }else{
          uiMsg.style.color='#d9534f'; uiMsg.textContent=(json && json.msg) ? json.msg : '建立失敗';
        }
      })
      .catch(()=>{ uiMsg.style.color='#d9534f'; uiMsg.textContent='建立失敗（網路或伺服器錯誤）'; })
      .finally(()=>{ btnCreateUser.disabled=false; btnCreateUser.textContent='建立帳號'; });
  });

  // ===== 帳號查詢/封鎖/解鎖/升級 =====
  const btnAcctSearch = qs('#btnAcctSearch');
  function acctUpdate(level){
    const actions = qs('#acct_actions');
    const acct = actions.dataset.acct ? JSON.parse(actions.dataset.acct) : null;
    if (!acct) return;
    formPost(API_ACCT_UPDATE, { id_idx: acct.id_idx, level })
      .then(({json})=>{
        updateCsrfFrom(json);
        if (json && json.ok){ alert('更新成功'); btnAcctSearch.click(); }
        else { alert('更新失敗：' + (json && json.msg ? json.msg : '')); }
      });
  }
  on(btnAcctSearch, 'click', ()=>{
    const key = val('#acct_query'); if(!key){ alert('請輸入帳號或 USER_IDX'); return; }
    const info = qs('#acct_info'); const actions = qs('#acct_actions');
    info.textContent='查詢中...'; actions.style.display='none';
    formPost(API_ACCT_SEARCH, { key })
      .then(({json})=>{
        updateCsrfFrom(json);
        if (json && json.ok){
          info.innerHTML = `帳號：<b>${json.data.id_loginid}</b> ｜ ID_IDX=${json.data.id_idx} ｜ UserLevel=${json.data.UserLevel} ｜ 點數=${json.data.mall_point}`;
          actions.style.display='block'; actions.dataset.acct = JSON.stringify(json.data);
        }else{
          info.innerHTML = '<span style="color:red;">'+(json && json.msg ? json.msg : '查無帳號')+'</span>';
          actions.style.display='none'; actions.dataset.acct='';
        }
      })
      .catch(()=>{ info.textContent='查詢失敗'; actions.style.display='none'; });
  });
  on(qs('#btnBan'),    'click', ()=>acctUpdate(4));
  on(qs('#btnUnban'),  'click', ()=>acctUpdate(6));
  on(qs('#btnMakeGM'), 'click', ()=>acctUpdate(2));

  // ===== 多人送到商城包包 =====
  const btnSendMulti = qs('#btnSendShopBagMulti');
  on(btnSendMulti, 'click', ()=>{
    let rawUsers = val('#shop_user_ids').replace(/，/g, ',');
    const userIds = rawUsers.split(/[\s,]+/).map(s=>s.trim()).filter(s=>s.length>0 && /^[A-Za-z0-9]+$/.test(s));

    let rawItems = val('#shop_item_codes').replace(/，/g, ',');
    const items = rawItems.split(/[\s,]+/).map(s=>s.trim()).filter(s=>/^\d+$/.test(s));

    const qty = parseInt(val('#shop_qty')||'0',10) || 0;

    if (!userIds.length){ alert('請輸入至少一個有效的英數帳號（id_loginid）'); return; }
    if (!items.length)  { alert('請輸入至少一個有效的商品編號'); return; }
    if (qty <= 0)       { alert('數量需大於 0'); return; }

    const msg = qs('#shop_msg'); const box = qs('#shop_result');
    btnSendMulti.disabled = true; btnSendMulti.textContent='處理中…';
    msg.textContent=''; msg.style.color=''; box.innerHTML='';

    formPost(API_SEND_SHOP_BAG_MULTI, { user_ids:userIds.join(','), item_idx:items.join(','), qty })
      .then(({json})=>{
        updateCsrfFrom(json);
        const ok = !!(json && (json.ok === true || json.success === true));
        msg.textContent = ok ? '發送完成' : (json && json.msg ? json.msg : '發送失敗');
        msg.style.color = ok ? '#28a745' : '#d9534f';

        const out = document.createElement('div');
        if (json && Array.isArray(json.results)){
          json.results.forEach(u=>{
            const head = document.createElement('div'); head.className='mono g-mb-5';
            head.textContent = `帳號 ${u.user_id || u.account || ''}（IDX:${u.user_idx || '-'}）`;
            out.appendChild(head);
            (u.items || []).forEach(it=>{
              const line = document.createElement('div'); line.className='mono';
              line.textContent = it.ok
                ? `  ✅ 物品 ${it.item} 成功（寫入 ${it.count||0} 筆，seal=${it.seal||0}，stack_max=${it.stack_max||0})`
                : `  ❌ 物品 ${it.item||'-'} 失敗：${it.msg||'未知錯誤'}`;
              out.appendChild(line);
            });
          });
        }else{
          const m=document.createElement('div'); m.className='small muted'; m.textContent='沒有回傳細節或格式不符。'; out.appendChild(m);
        }
        box.innerHTML=''; box.appendChild(out);
      })
      .catch(()=>{ msg.textContent='發送失敗（網路或伺服器錯誤）'; msg.style.color='#d9534f'; })
      .finally(()=>{ btnSendMulti.disabled=false; btnSendMulti.textContent='送至商城包包（多人）'; });
  });

  // ===== 發送點數 =====
  const btnGrant = qs('#btnGrantPoint');
  on(btnGrant, 'click', ()=>{
    const raw  = val('#mp_user_list');
    const amt  = parseInt(val('#mp_amount')||'0',10) || 0;
    const memo = val('#mp_memo');
    if (!raw){ alert('請輸入至少一個帳號（id_loginid）'); return; }
    if (amt === 0){ alert('點數不能為 0；正數=加點，負數=扣點'); return; }

    const parts = raw.replace(/，/g, ',').split(/[\s,]+/).map(s=>s.trim()).filter(Boolean);
    const ids = parts.filter(p=>/^[A-Za-z0-9]+$/.test(p));
    if (!ids.length){ alert('沒有有效的英數帳號'); return; }

    btnGrant.disabled=true; btnGrant.textContent='處理中…';
    qs('#mp_msg').textContent=''; qs('#mp_result').innerHTML='';

    formPost(API_GRANT_POINTS, { user_ids: ids.join(','), amount: amt, memo })
      .then(({json})=>{
        updateCsrfFrom(json);
        const msg = qs('#mp_msg');
        msg.textContent = (json && (json.success || json.ok)) ? '點數發送成功' : ((json && json.msg) ? json.msg : '發送失敗');

        const out = document.createElement('div');
        const okList=[]; const ngList=[];
        (json && json.results || []).forEach(r=>{
          if (r.ok){
            const sign = (r.amount>0?'+':'');
            okList.push(`帳號 ${r.user_id}（IDX:${r.user_idx}）：${r.before} ➜ ${r.after}（${sign}${r.amount}）`);
          } else {
            ngList.push(`帳號 ${r.user_id || r.user_idx || '-'}：${r.msg || '失敗'}`);
          }
        });
        if (okList.length){
          const t=document.createElement('div'); t.className='g-mb-5'; t.innerHTML=`<b>成功 (${okList.length})：</b>`; out.appendChild(t);
          const ul=document.createElement('ul'); ul.className='small mono'; okList.forEach(s=>{ const li=document.createElement('li'); li.textContent=s; ul.appendChild(li); }); out.appendChild(ul);
        }
        if (ngList.length){
          const t=document.createElement('div'); t.className='g-mb-5'; t.innerHTML=`<b style="color:#d9534f">失敗 (${ngList.length})：</b>`; out.appendChild(t);
          const ul=document.createElement('ul'); ul.className='small mono'; ul.style.color='#d9534f'; ngList.forEach(s=>{ const li=document.createElement('li'); li.textContent=s; ul.appendChild(li); }); out.appendChild(ul);
        }
        if (!okList.length && !ngList.length){
          const m=document.createElement('div'); m.className='small muted'; m.textContent='沒有回傳細節。'; out.appendChild(m);
        }
        qs('#mp_result').innerHTML=''; qs('#mp_result').appendChild(out);
      })
      .catch(()=>{ alert('發送失敗（網路或伺服器錯誤）'); })
      .finally(()=>{ btnGrant.disabled=false; btnGrant.textContent='發送點數'; });
  });

})();
</script>
