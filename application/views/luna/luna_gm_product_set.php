<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <?php $this->load->view("luna/luna_head"); ?>
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
</head>
<body>
  <main>
    <?php $this->load->view("luna/luna_header"); ?>

    <section class="g-mb-100">
      <div class="container">
        <div class="row">
          <?php $this->load->view("luna/luna_sidebar"); ?>

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

                <!-- 帳號管理：查詢 / 封鎖 / 解鎖 / 升級 -->
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

                <!-- 發點數（用帳號 id_loginid） -->
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

                <!-- 送物品 / 查角色 / 商品清單（維持原本，有需要你再接上） -->
                <div class="card border-0">
                  <div class="card-header d-flex align-items-center justify-content-between g-bg-gray-light-v5 border-0">
                    <h3 class="h6 mb-0"><i class="icon-directions g-pos-rel g-top-1 g-mr-5"></i> 商品清單</h3>
                    <div class="d-flex align-items-center">
                      <input id="q" type="text" class="form-control form-control-sm" placeholder="搜尋：編號 / 名稱 / 分類" style="width:260px;">
                    </div>
                  </div>
                  <div class="card-block g-pa-0">
                    <div class="table-responsive">
                      <table class="table table-bordered u-table--v2">
                        <thead class="text-uppercase g-letter-spacing-1">
                          <tr>
                            <th class="w-140">商品編號</th>
                            <th>名稱</th>
                            <th class="w-120 text-right">販售狀態 (O)</th>
                            <th class="w-120">限時 (BG)</th>
                            <th class="w-140">分類（BL，含代碼）</th>
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
          </div><!-- /col-lg-9 -->
        </div>
      </div>
    </section>
  </main>

  <div class="site-footer"><?php $this->load->view("luna/luna_footer"); ?></div>
  <div class="u-outer-spaces-helper"></div>
  <?php $this->load->view("luna/luna_script"); ?>

  <script>
    const API_GET           = '<?= site_url('luna/luna_gm_product_set/get_data') ?>';
    const API_GRANT_POINTS  = '<?= site_url("luna/luna_gm_product_set/grant_points") ?>';
    const API_CREATE_USER   = '<?= site_url("luna/luna_gm_product_set/create_user") ?>';
    const API_ACCT_SEARCH   = '<?= site_url("luna/luna_gm_product_set/account_search") ?>';
    const API_ACCT_UPDATE   = '<?= site_url("luna/luna_gm_product_set/account_update") ?>';

    const CSRF_NAME = '<?= $this->security->get_csrf_token_name(); ?>';
    const CSRF_HASH = '<?= $this->security->get_csrf_hash(); ?>';

    let currentPage = 1;
    let currentQ = '';

    function humanizeSeconds(sec) {
      const n = parseInt(sec, 10);
      if (!n || n <= 0) return '<span class="badge gray" title="0 秒">永久</span>';
      const day = Math.floor(n / 86400);
      const hour = Math.floor((n % 86400) / 3600);
      const min = Math.floor((n % 3600) / 60);
      let text = '';
      if (day >= 1 && hour === 0) text = `${day}天`;
      else if (day >= 1) text = `${day}天${hour}小時`;
      else if (hour >= 1) text = `${hour}小時${min}分`;
      else text = `${min}分`;
      return `<span class="badge orange" title="${n.toLocaleString('zh-Hant-TW')} 秒">${text}</span>`;
    }

    function fetch_page(page) {
      const payload = { page, q: currentQ };
      if (CSRF_NAME && CSRF_HASH) payload[CSRF_NAME] = CSRF_HASH;
      $('.table').addClass('loading');
      $.ajax({
        type: 'POST', url: API_GET, data: payload, dataType: 'json',
        success: function(res){
          const $body = $('#dt_list_body').empty();
          const $msg  = $('#msg').empty();
          if (res.error) $msg.text(res.error);
          if (res.items && res.items.length) {
            res.items.forEach(function(me){
              const $tr = $('<tr/>');
              $('<td/>').addClass('mono').text(me.product_code || '').appendTo($tr);
              $('<td/>').text(me.name || '').appendTo($tr);
              const sellstatusText = (me.sellstatus!==undefined && me.sellstatus!==null && me.sellstatus!=='')
                ? Number(me.sellstatus).toLocaleString('zh-Hant-TW') : '—';
              $('<td/>').addClass('text-right mono').text(sellstatusText).appendTo($tr);
              let endCellHtml = '—';
              if (me.endtime!==undefined && me.endtime!==null && me.endtime!=='') endCellHtml = humanizeSeconds(me.endtime);
              $('<td/>').html(endCellHtml).appendTo($tr);
              const cateName = (me.category && String(me.category).trim()!=='') ? me.category : '未分類';
              const cateCode = (me.category_code!==undefined && me.category_code!==null && me.category_code!=='' && !isNaN(parseInt(me.category_code,10)))
                ? ` (${parseInt(me.category_code,10)})` : '';
              $('<td/>').text(cateName + cateCode).appendTo($tr);
              const $btn = $('<button class="btn btn-primary btn-xs">加入待發送</button>').on('click', function(){
                const current = $('#item_codes').val().trim();
                const toAdd = String(me.product_code || '').trim();
                if (!toAdd) return;
                let next = current ? (current.endsWith(',') ? current + toAdd : current + ',' + toAdd) : toAdd;
                $('#item_codes').val(next);
              });
              $('<td class="nowrap"/>').append($btn).appendTo($tr);
              $tr.appendTo($body);
            });
          } else {
            $('<tr><td colspan="6" class="text-center">查無資料</td></tr>').appendTo($body);
          }
          currentPage = res.page || 1;
          render_pagination(currentPage, res.total_page || 1);
        },
        error: function(xhr){ $('#msg').text('資料載入失敗：' + xhr.status + ' ' + xhr.statusText); },
        complete: function(){ $('.table').removeClass('loading'); }
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

    $(function(){ fetch_page(1); });

    // 建立帳號
    $('#btnCreateUser').on('click', function(){
      const login = ($('#new_login').val()||'').trim();
      const pwd   = ($('#new_password').val()||'').trim();
      const lvl   = parseInt($('#new_userLevel').val(),10)||6;
      if(!/^[A-Za-z0-9]{6,}$/.test(login)){ alert('帳號需為英數且至少 6 碼'); return; }
      if(!/^[A-Za-z0-9]{6,}$/.test(pwd)){ alert('密碼需為英數且至少 6 碼'); return; }
      const data = {login:login, password:pwd, userLevel:lvl};
      data[CSRF_NAME] = CSRF_HASH;
      $('#btnCreateUser').prop('disabled', true).text('建立中…');
      $('#cu_msg').text('');
      $.post(API_CREATE_USER, data, function(res){
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

    // 帳號查詢/封鎖/解鎖/升級
    $('#btnAcctSearch').on('click', function(){
      const key = ($('#acct_query').val()||'').trim();
      if(!key){ alert('請輸入帳號或 USER_IDX'); return; }
      const payload = {}; payload[CSRF_NAME] = CSRF_HASH; payload['key']=key;
      $('#acct_info').text('查詢中...'); $('#acct_actions').hide();
      $.post(API_ACCT_SEARCH, payload, function(res){
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
      const payload={}; payload[CSRF_NAME]=CSRF_HASH; payload['id_idx']=acct.id_idx; payload['level']=level;
      $.post(API_ACCT_UPDATE, payload, function(res){
        if(res.ok){ alert('更新成功'); $('#btnAcctSearch').click(); }
        else{ alert('更新失敗：'+(res.msg||'')); }
      },'json');
    }
    $('#btnBan').on('click', ()=>acctUpdate(4));
    $('#btnUnban').on('click', ()=>acctUpdate(6));
    $('#btnMakeGM').on('click', ()=>acctUpdate(2));

    // 發送點數（id_loginid）
    $('#btnGrantPoint').on('click', function(){
      const raw  = ($('#mp_user_list').val() || '').trim();
      const amt  = parseInt($('#mp_amount').val(), 10) || 0;
      const memo = ($('#mp_memo').val() || '').trim();
      if (!raw) { alert('請輸入至少一個帳號（id_loginid）'); return; }
      if (amt === 0) { alert('點數不能為 0；正數=加點，負數=扣點'); return; }
      const parts = raw.replace(/，/g, ',').split(/[\s,]+/).map(s => s.trim()).filter(Boolean);
      const ids = []; parts.forEach(p => { if (/^[A-Za-z0-9]+$/.test(p)) ids.push(p); });
      if (!ids.length) { alert('沒有有效的英數帳號'); return; }
      const payload = { user_ids: ids.join(','), amount: amt, memo: memo };
      if (CSRF_NAME && CSRF_HASH) payload[CSRF_NAME] = CSRF_HASH;
      $('#btnGrantPoint').prop('disabled', true).text('處理中…');
      $('#mp_msg').text(''); $('#mp_result').empty();
      $.post(API_GRANT_POINTS, payload, function(res){
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

    // 搜尋（商品）
    let t = null;
    $('#q').on('input', function(){
      clearTimeout(t);
      t = setTimeout(function(){ currentQ = $('#q').val().trim(); fetch_page(1); }, 300);
    });
  </script>
</body>
</html>
