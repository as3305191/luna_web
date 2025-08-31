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
  // ---- API 路徑 ----
  const API_GET           = '<?= site_url('luna/luna_gm_product_set/get_data') ?>';
  const API_GRANT_POINTS  = '<?= site_url("luna/luna_gm_product_set/grant_points") ?>';
  const API_CREATE_USER   = '<?= site_url("luna/luna_gm_product_set/create_user") ?>';
  const API_ACCT_SEARCH   = '<?= site_url("luna/luna_gm_product_set/account_search") ?>';
  const API_ACCT_UPDATE   = '<?= site_url("luna/luna_gm_product_set/account_update") ?>';
  const API_SEND_SHOP_BAG_MULTI = '<?= site_url("luna/luna_gm_product_set/send_shop_bag_multi") ?>';

  // ---- CSRF Helper（吃 PJAX 更新）----
  function addCsrf(obj){
    obj = obj || {};
    var name = (window.CSRF && window.CSRF.name) || '<?= $this->security->get_csrf_token_name(); ?>';
    var hash = (window.CSRF && window.CSRF.hash) || '<?= $this->security->get_csrf_hash(); ?>';
    if (name && hash) obj[name] = hash;
    return obj;
  }
  function updateCsrfFrom(res){
    if (res && res.csrf_name && res.csrf_hash){
      window.CSRF = { name: res.csrf_name, hash: res.csrf_hash };
    }
  }
  // jQuery AJAX 一律加 Header（雙保險）
  if (window.jQuery) {
    $.ajaxSetup({
      beforeSend: function(xhr){ if (window.CSRF && window.CSRF.hash) xhr.setRequestHeader('X-CSRF-Token', window.CSRF.hash); }
    });
  }

  // ---- 公用小工具 ----
  function humanizeSeconds(sec) {
    const n = parseInt(sec, 10);
    if (!n || n <= 0) return '永久';
    const day = Math.floor(n / 86400);
    const hour = Math.floor((n % 86400) / 3600);
    const min = Math.floor((n % 3600) / 60);
    if (day >= 1 && hour === 0) return `${day}天`;
    if (day >= 1) return `${day}天${hour}小時`;
    if (hour >= 1) return `${hour}小時${min}分`;
    return `${min}分`;
  }

  // =============== 商品清單（分頁 + 搜尋） ===============
  let currentPage = 1;
  let currentQ = '';

  function fetch_page(page) {
    const payload = addCsrf({ page, q: currentQ });
    $('.table').addClass('loading');
    $.ajax({
      type: 'POST', url: API_GET, data: payload, dataType: 'json'
    }).done(function(res){
      updateCsrfFrom(res);
      const $body = $('#dt_list_body').empty();
      const $msg  = $('#msg').empty();
      if (res.error) $msg.text(res.error);
      if (res.items && res.items.length) {
        res.items.forEach(function(me){
          const $tr = $('<tr/>');
          $('<td/>').addClass('mono').text(me.product_code || '').appendTo($tr);
          $('<td/>').text(me.name || '').appendTo($tr);
          $('<td/>').text(me.endtime ? humanizeSeconds(me.endtime) : '永久').appendTo($tr);
          $('<td/>').text(`大類:${me.category_code} / 細類:${me.category_detail}`).appendTo($tr);

          const $btn = $('<button class="btn btn-primary btn-xs">加入待發送</button>').on('click', function(){
            const toAdd = String(me.product_code || '').trim();
            if (!toAdd) return;
            const $el = $('#shop_item_codes');
            const cur = ($el.val() || '').toString().trim();
            const next = cur ? (cur.endsWith(',') ? cur + toAdd : cur + ',' + toAdd) : toAdd;
            $el.val(next);
          });

          $('<td class="nowrap"/>').append($btn).appendTo($tr);
          $tr.appendTo($body);
        });
      } else {
        $('<tr><td colspan="5" class="text-center">查無資料</td></tr>').appendTo($body);
      }
      currentPage = res.page || 1;
      render_pagination(currentPage, res.total_page || 1);
    }).fail(function(xhr){
      $('#msg').text('資料載入失敗：' + xhr.status + ' ' + xhr.statusText);
    }).always(function(){
      $('.table').removeClass('loading');
    });
  }

  function render_pagination(page, totalPage){
    const $p = $('#pagination').empty();
    const windowSize = 8;
    if (totalPage < 1) totalPage = 1;
    function addBtn(label, targetPage, disabled=false, active=false) {
      const $li = $('<li class="list-inline-item"/>');
      const $a = $('<a class="u-pagination-v1__item u-pagination-v1-4 g-rounded-50 g-pa-7-14 page-ctrl"/>')
        .text(label).toggleClass('u-pagination-v1-4--active', active).toggleClass('disabled', disabled)
        .attr('href', 'javascript:void(0)');
      if (!disabled && !active) $a.on('click', () => fetch_page(targetPage));
      $li.append($a).appendTo($p);
    }
    function addEllipsis(){ $('<li class="list-inline-item page-ellipsis">…</li>').appendTo($p); }
    addBtn('«', Math.max(1, page - 1), page <= 1);
    let start = Math.floor((page - 1) / windowSize) * windowSize + 1;
    let end   = Math.min(start + windowSize - 1, totalPage);
    if (start > 1) { addBtn('1', 1, false, page === 1); addEllipsis(); }
    for (let i = start; i <= end; i++) addBtn(String(i), i, false, i === page);
    if (end < totalPage) { addEllipsis(); addBtn(String(totalPage), totalPage, false, page === totalPage); }
    addBtn('»', Math.min(totalPage, page + 1), page >= totalPage);
  }

  // 初次渲染 / PJAX 進場都抓一次
  fetch_page(1);
  document.addEventListener('page:enter', function(e){
    // 只在這頁重新進場時才動作（依 URL 片段判斷；視你的 route 調整）
    if ((e.detail && e.detail.url || location.href).indexOf('luna_gm_product_set') >= 0){
      fetch_page(1);
    }
  });

  // 搜尋（用委派 + 防抖，避免 PJAX 重綁）
  let _qTimer = null;
  $(document).off('input', '#q').on('input', '#q', function(){
    clearTimeout(_qTimer);
    _qTimer = setTimeout(function(){ currentQ = $('#q').val().trim(); fetch_page(1); }, 300);
  });

  // =============== 建立帳號 ===============
  $(document).off('click', '#btnCreateUser').on('click', '#btnCreateUser', function(){
    const login = ($('#new_login').val()||'').trim();
    const pwd   = ($('#new_password').val()||'').trim();
    const lvl   = parseInt($('#new_userLevel').val(),10)||6;
    if(!/^[A-Za-z0-9]{6,}$/.test(login)){ alert('帳號需為英數且至少 6 碼'); return; }
    if(!/^[A-Za-z0-9]{6,}$/.test(pwd)){ alert('密碼需為英數且至少 6 碼'); return; }
    const data = addCsrf({login:login, password:pwd, userLevel:lvl});
    $('#btnCreateUser').prop('disabled', true).text('建立中…');
    $('#cu_msg').text('');
    $.post(API_CREATE_USER, data, function(res){
      updateCsrfFrom(res);
      if(res && res.ok){
        $('#cu_msg').css('color','#28a745').text('建立成功，id_idx='+res.id_idx);
        $('#new_login,#new_password').val(''); $('#new_userLevel').val('6');
      }else{
        $('#cu_msg').css('color','#d9534f').text(res && res.msg ? res.msg : '建立失敗');
      }
    }, 'json').fail(function(xhr){
      $('#cu_msg').css('color','#d9534f').text('建立失敗：'+xhr.status+' '+xhr.statusText);
    }).always(function(){ $('#btnCreateUser').prop('disabled', false).text('建立帳號'); });
  });

  // =============== 帳號查詢/封鎖/解鎖/升級 ===============
  $(document).off('click', '#btnAcctSearch').on('click', '#btnAcctSearch', function(){
    const key = ($('#acct_query').val()||'').trim();
    if(!key){ alert('請輸入帳號或 USER_IDX'); return; }
    const payload = addCsrf({ key:key });
    $('#acct_info').text('查詢中...'); $('#acct_actions').hide();
    $.post(API_ACCT_SEARCH, payload, function(res){
      updateCsrfFrom(res);
      if(res && res.ok){
        $('#acct_info').html(`帳號：<b>${res.data.id_loginid}</b> ｜ ID_IDX=${res.data.id_idx} ｜ UserLevel=${res.data.UserLevel} ｜ 點數=${res.data.mall_point}`);
        $('#acct_actions').show().data('acct', res.data);
      }else{
        $('#acct_info').html('<span style="color:red;">'+(res.msg||'查無帳號')+'</span>');
        $('#acct_actions').hide();
      }
    },'json');
  });

  function acctUpdate(level){
    const acct = $('#acct_actions').data('acct'); if(!acct){ return; }
    const payload = addCsrf({ id_idx: acct.id_idx, level: level });
    $.post(API_ACCT_UPDATE, payload, function(res){
      updateCsrfFrom(res);
      if(res.ok){ alert('更新成功'); $('#btnAcctSearch').click(); }
      else{ alert('更新失敗：'+(res.msg||'')); }
    },'json');
  }
  $(document).off('click', '#btnBan').on('click', '#btnBan', ()=>acctUpdate(4));
  $(document).off('click', '#btnUnban').on('click', '#btnUnban', ()=>acctUpdate(6));
  $(document).off('click', '#btnMakeGM').on('click', '#btnMakeGM', ()=>acctUpdate(2));

  // =============== 多人送到商城包包 ===============
  $(document).off('click', '#btnSendShopBagMulti').on('click', '#btnSendShopBagMulti', function(){
    // 解析帳號
    let rawUsers = ($('#shop_user_ids').val() || '').replace(/，/g, ',').trim();
    const userIds = rawUsers.split(/[\s,]+/).map(s => s.trim()).filter(s => s.length > 0 && /^[A-Za-z0-9]+$/.test(s));
    // 解析物品
    let rawItems = ($('#shop_item_codes').val() || '').replace(/，/g, ',').trim();
    const items = rawItems.split(/[\s,]+/).map(s => s.trim()).filter(s => /^\d+$/.test(s));
    const qty = parseInt($('#shop_qty').val(), 10) || 0;

    if (!userIds.length) { alert('請輸入至少一個有效的英數帳號（id_loginid）'); return; }
    if (!items.length)   { alert('請輸入至少一個有效的商品編號'); return; }
    if (qty <= 0)        { alert('數量需大於 0'); return; }

    const payload = addCsrf({ user_ids: userIds.join(','), item_idx: items.join(','), qty: qty });

    $('#btnSendShopBagMulti').prop('disabled', true).text('處理中…');
    $('#shop_msg').text('').css('color', ''); $('#shop_result').empty();

    $.post(API_SEND_SHOP_BAG_MULTI, payload, function(res){
      updateCsrfFrom(res);
      const ok = !!(res && (res.ok === true || res.success === true));
      $('#shop_msg').text(ok ? '發送完成' : (res && res.msg ? res.msg : '發送失敗'))
                    .css('color', ok ? '#28a745' : '#d9534f');

      const $box = $('<div/>');
      if (res && Array.isArray(res.results)) {
        res.results.forEach(u => {
          const head = `帳號 ${u.user_id || u.account || ''}（IDX:${u.user_idx || '-'}）`;
          $box.append($('<div class="mono g-mb-5"/>').text(head));
          (u.items || []).forEach(it => {
            const line = it.ok
              ? `  ✅ 物品 ${it.item} 成功（寫入 ${it.count||0} 筆，seal=${it.seal||0}，stack_max=${it.stack_max||0})`
              : `  ❌ 物品 ${it.item||'-'} 失敗：${it.msg||'未知錯誤'}`;
            $box.append($('<div class="mono"/>').text(line));
          });
        });
      } else {
        $box.append('<div class="small muted">沒有回傳細節或格式不符。</div>');
      }
      $('#shop_result').html($box);
    }, 'json').fail(function(xhr){
      $('#shop_msg').text('發送失敗：' + xhr.status + ' ' + xhr.statusText).css('color', '#d9534f');
    }).always(function(){
      $('#btnSendShopBagMulti').prop('disabled', false).text('送至商城包包（多人）');
    });
  });

  // =============== 發送點數 ===============
  $(document).off('click', '#btnGrantPoint').on('click', '#btnGrantPoint', function(){
    const raw  = ($('#mp_user_list').val() || '').trim();
    const amt  = parseInt($('#mp_amount').val(), 10) || 0;
    const memo = ($('#mp_memo').val() || '').trim();
    if (!raw) { alert('請輸入至少一個帳號（id_loginid）'); return; }
    if (amt === 0) { alert('點數不能為 0；正數=加點，負數=扣點'); return; }
    const parts = raw.replace(/，/g, ',').split(/[\s,]+/).map(s => s.trim()).filter(Boolean);
    const ids = parts.filter(p => /^[A-Za-z0-9]+$/.test(p));
    if (!ids.length) { alert('沒有有效的英數帳號'); return; }
    const payload = addCsrf({ user_ids: ids.join(','), amount: amt, memo: memo });

    $('#btnGrantPoint').prop('disabled', true).text('處理中…');
    $('#mp_msg').text(''); $('#mp_result').empty();

    $.post(API_GRANT_POINTS, payload, function(res){
      updateCsrfFrom(res);
      if (res.success || res.ok) $('#mp_msg').text('點數發送成功');
      else $('#mp_msg').text(res.msg || '發送失敗');
      const $box = $('<div/>'); const okList = []; const ngList = [];
      (res.results || []).forEach(r => {
        if (r.ok) {
          const sign = (r.amount>0?'+':'');
          okList.push(`帳號 ${r.user_id}（IDX:${r.user_idx}）：${r.before} ➜ ${r.after}（${sign}${r.amount}）`);
        } else {
          ngList.push(`帳號 ${r.user_id || r.user_idx || '-'}：${r.msg || '失敗'}`);
        }
      });
      if (okList.length) { $box.append(`<div class="g-mb-5"><b>成功 (${okList.length})：</b></div>`); const $ul=$('<ul class="small mono"/>'); okList.forEach(s=> $ul.append('<li>'+s+'</li>')); $box.append($ul); }
      if (ngList.length) { $box.append(`<div class="g-mb-5"><b style="color:#d9534f">失敗 (${ngList.length})：</b></div>`); const $ul2=$('<ul class="small mono" style="color:#d9534f"/>'); ngList.forEach(s=> $ul2.append('<li>'+s+'</li>')); $box.append($ul2); }
      if (!okList.length && !ngList.length) $box.append('<div class="small muted">沒有回傳細節。</div>');
      $('#mp_result').html($box);
    }, 'json').fail(function(xhr){
      alert('發送失敗：' + xhr.status + ' ' + xhr.statusText);
    }).always(function(){
      $('#btnGrantPoint').prop('disabled', false).text('發送點數');
    });
  });

})();
</script>
