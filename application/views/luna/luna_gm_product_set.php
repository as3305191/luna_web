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

          <!-- 物品尋找 -->
          <div class="col-lg-9">
            <div class="row g-mb-40">
              <div class="col-lg-12">
                <!-- 發點數區塊 -->
                <div class="card border-0 g-mb-20">
                  <div class="card-header d-flex align-items-center justify-content-between g-bg-gray-light-v5 border-0">
                    <h3 class="h6 mb-0">
                      <i class="icon-wallet g-pos-rel g-top-1 g-mr-5"></i> 發送點數（依帳號 USER_IDX）
                    </h3>
                  </div>
                  <div class="card-block g-pt-15 g-pb-10">
                    <div class="row g-mb-10">
                      <div class="col-md-6">
                        <label class="g-mb-5">帳號 <mark>USER_IDX</mark>（可多個，用逗號或換行分隔）</label>
                        <textarea id="mp_user_list" class="form-control mono" rows="4" placeholder="例：12345,67890 或逐行輸入"></textarea>
                        <div class="small muted g-mt-5">後端僅接受純數字。</div>
                      </div>
                      <div class="col-md-3">
                        <label class="g-mb-5">發送點數（正整數）</label>
                        <input id="mp_amount" type="number" class="form-control" min="1" value="100">
                      </div>
                      <div class="col-md-3">
                        <label class="g-mb-5">備註（選填）</label>
                        <input id="mp_memo" type="text" class="form-control" maxlength="200" placeholder="活動補償/GM補發…">
                      </div>
                    </div>
                    <div class="d-flex align-items-center">
                      <button id="btnGrantPoint" class="btn btn-success">發送點數</button>
                      <span id="mp_msg" class="g-ml-15" style="color:#28a745;"></span>
                    </div>
                    <div id="mp_result" class="g-mt-10"></div>
                  </div>
                </div>

                <!-- 發送物品區塊 -->
                <div class="p-3 g-pt-15 g-pb-10">
                  <div class="row g-mb-10">
                    <div class="col-md-6">
                      <label class="g-mb-5">玩家<mark>角色 ID</mark>（可多個，用逗號或換行分隔；<b>必須是數字</b>）</label>
                      <textarea id="player_list" class="form-control mono" rows="4" placeholder="例：1001,1002 或逐行輸入"></textarea>
                      <div class="small muted g-mt-5">後端僅接受純數字。</div>
                    </div>
                    <div class="col-md-6">
                      <label class="g-mb-5">物品編號（可用逗號；可附數量標記但目前僅做備註）</label>
                      <textarea id="item_codes" class="form-control mono" rows="4" placeholder="例：13000835,13000828,13000830"></textarea>
                      <small class="text-muted">
                        允許格式：<code>13000835</code>,<code>13000828</code>,<code>13000830</code>。<br>
                      </small>
                    </div>
                  </div>
                  <div class="row g-mb-10">
                    <div class="col-md-3">
                      <label class="g-mb-5">預設數量</label>
                      <input id="default_qty" type="number" class="form-control" min="1" value="1">
                    </div>
                    <div class="col-md-9 d-flex align-items-end">
                      <!-- <button id="sendItems" class="btn btn-success">發送物品（角色包包）角色需重新登入</button> -->
                      <button id="sendToShop" class="btn btn-warning g-ml-10">送到商城包包</button>
                      <span id="sendMsg" class="g-ml-15" style="color:#28a745;"></span>
                    </div>
                  </div>
                  <div id="sendResult" class="g-mt-10"></div>
                  <hr>
                </div>
                <!-- 帳號 → 角色查詢 -->
                <div class="row g-mb-10">
                  <div class="col-md-6">
                    <label class="g-mb-5">帳號 <mark>USER_IDX</mark></label>
                    <input id="search_user_idx" type="number" class="form-control mono" placeholder="例：123456">
                    <small class="muted">輸入帳號 USER_IDX，查出底下所有角色。</small>
                  </div>
                  <div class="col-md-6 d-flex align-items-end">
                    <button id="btnSearchUser" class="btn btn-info g-mr-10">查詢帳號角色</button>
                    <button id="btnAddSelectedChars" class="btn btn-secondary" disabled>將勾選角色加入上方角色ID框</button>
                  </div>
                </div>
                <div id="acc_characters_result" class="g-mb-15"></div>
                <div class="card border-0">
                  <div class="card-header d-flex align-items-center justify-content-between g-bg-gray-light-v5 border-0">
                    <h3 class="h6 mb-0">
                      <i class="icon-directions g-pos-rel g-top-1 g-mr-5"></i>
                      商品清單（Excel 欄位：O=販售狀態，BG=剩餘時間(秒)，BL=分類代碼）
                    </h3>
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

    <?php $this->load->view("luna/luna_footer"); ?>
  </main>
  <div class="u-outer-spaces-helper"></div>

  <?php $this->load->view("luna/luna_script"); ?>

  <script>
    const API_GET = '<?= site_url('luna/luna_gm_product_set/get_data') ?>';
    const API_SEND = '<?= site_url("luna/luna_gm_product_set/insert") ?>';
    const API_CHAR_LIST = '<?= site_url("luna/luna_gm_product_set/characters_by_user") ?>';
    const API_GRANT_POINTS = '<?= site_url("luna/luna_gm_product_set/grant_points") ?>';
    const CSRF_NAME = '<?= $this->security->get_csrf_token_name(); ?>';
    const CSRF_HASH = '<?= $this->security->get_csrf_hash(); ?>';

    let currentPage = 1;
    let currentQ = '';

    // 秒數 → 可讀
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

    function normalizeItemCodes(raw) {
      if (!raw) return '';
      const parts = raw.replace(/，/g, ',').split(/[\n,]+/).map(s => s.trim()).filter(Boolean);
      const ids = [];
      parts.forEach(p => {
        const id = (p.split('*')[0] || p).split(':')[0];
        if (/^\d+$/.test(id)) ids.push(id);
      });
      return Array.from(new Set(ids)).join(',');
    }

    function fetch_page(page) {
      const payload = { page, q: currentQ };
      if (CSRF_NAME && CSRF_HASH) payload[CSRF_NAME] = CSRF_HASH;

      $('.table').addClass('loading');

      $.ajax({
        type: 'POST',
        url: API_GET,
        data: payload,
        dataType: 'json',
        success: function(res){
          const $body = $('#dt_list_body').empty();
          const $msg  = $('#msg').empty();

          if (res.error) $msg.text(res.error);

          if (res.items && res.items.length) {
            res.items.forEach(function(me){
              const $tr = $('<tr/>');

              // 商品編號
              $('<td/>').addClass('mono').text(me.product_code || '').appendTo($tr);

              // 名稱
              $('<td/>').text(me.name || '').appendTo($tr);

              // 販售狀態(O)
              const sellstatusText = (me.sellstatus !== undefined && me.sellstatus !== null && me.sellstatus !== '')
                ? Number(me.sellstatus).toLocaleString('zh-Hant-TW') : '—';
              $('<td/>').addClass('text-right mono').text(sellstatusText).appendTo($tr);

              // 限時（BG 秒；0=永久；null/空：顯示「—」）
              let endCellHtml = '—';
              if (me.endtime !== undefined && me.endtime !== null && me.endtime !== '') {
                endCellHtml = humanizeSeconds(me.endtime);
              }
              $('<td/>').html(endCellHtml).appendTo($tr);

              // 分類（BL → 中文）＋ 原始代碼
              const cateName = (me.category && String(me.category).trim() !== '') ? me.category : '未分類';
              const cateCode = (me.category_code !== undefined && me.category_code !== null && me.category_code !== '' && !isNaN(parseInt(me.category_code,10)))
                ? ` (${parseInt(me.category_code,10)})` : '';
              $('<td/>').text(cateName + cateCode).appendTo($tr);

              // 操作：加入待發送
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
        error: function(xhr){
          console.error(xhr);
          $('#msg').text('資料載入失敗：' + xhr.status + ' ' + xhr.statusText);
        },
        complete: function(){
          $('.table').removeClass('loading');
        }
      });
    }

    // 分頁
    function render_pagination(page, totalPage){
      const $p = $('#pagination').empty();
      const windowSize = 8;
      if (totalPage < 1) totalPage = 1;

      function addBtn(label, targetPage, disabled = false, active = false) {
        const $li = $('<li class="list-inline-item"/>');
        const $a = $('<a class="u-pagination-v1__item u-pagination-v1-4 g-rounded-50 g-pa-7-14 page-ctrl"/>')
          .text(label)
          .toggleClass('u-pagination-v1-4--active', active)
          .toggleClass('disabled', disabled)
          .attr('href', 'javascript:void(0)');
        if (!disabled && !active) $a.on('click', () => fetch_page(targetPage));
        $li.append($a).appendTo($p);
      }
      function addEllipsis(){ $('<li class="list-inline-item page-ellipsis">…</li>').appendTo($p); }

      // Prev
      addBtn('«', Math.max(1, page - 1), page <= 1);

      let start = Math.floor((page - 1) / windowSize) * windowSize + 1;
      let end   = Math.min(start + windowSize - 1, totalPage);

      if (start > 1) {
        addBtn('1', 1, false, page === 1);
        addEllipsis();
      }

      for (let i = start; i <= end; i++) {
        addBtn(String(i), i, false, i === page);
      }

      if (end < totalPage) {
        addEllipsis();
        addBtn(String(totalPage), totalPage, false, page === totalPage);
      }

      // Next
      addBtn('»', Math.min(totalPage, page + 1), page >= totalPage);
    }

    // 搜尋（debounce 300ms）
    let t = null;
    $('#q').on('input', function(){
      clearTimeout(t);
      t = setTimeout(function(){
        currentQ = $('#q').val().trim();
        fetch_page(1);
      }, 300);
    });

    $(function(){ fetch_page(1); });

// 點數發送按鈕
$('#btnGrantPoint').on('click', function(){
  const raw = ($('#mp_user_list').val() || '').trim();
  const amt = parseInt($('#mp_amount').val(), 10) || 0;
  const memo = ($('#mp_memo').val() || '').trim();

  if (!raw) { alert('請輸入至少一個 USER_IDX'); return; }
  if (amt <= 0) { alert('發送點數必須是正整數'); return; }

  const payload = { user_idx: raw, amount: amt, memo: memo };
  if (CSRF_NAME && CSRF_HASH) payload[CSRF_NAME] = CSRF_HASH;

  $('#btnGrantPoint').prop('disabled', true).text('處理中…');
  $('#mp_msg').text('');
  $('#mp_result').empty();

  $.post(API_GRANT_POINTS, payload, function(res){
    if (res.success) {
      $('#mp_msg').text('點數發送成功');
    } else {
      $('#mp_msg').text(res.msg || '發送失敗');
    }

    const $box = $('<div/>');
    const okList = [];
    const ngList = [];

    (res.results || []).forEach(r => {
      if (r.ok) {
        okList.push(`帳號 ${r.user_idx}：${r.before} ➜ ${r.after}（+${amt}）`);
      } else {
        ngList.push(`帳號 ${r.user_idx}：${r.msg || '失敗'}`);
      }
    });

    if (okList.length) {
      $box.append(`<div class="g-mb-5"><b>成功 (${okList.length})：</b></div>`);
      const $ul = $('<ul class="small mono"/>');
      okList.forEach(s => $ul.append('<li>'+s+'</li>'));
      $box.append($ul);
    }
    if (ngList.length) {
      $box.append(`<div class="g-mb-5"><b style="color:#d9534f">失敗 (${ngList.length})：</b></div>`);
      const $ul2 = $('<ul class="small mono" style="color:#d9534f"/>');
      ngList.forEach(s => $ul2.append('<li>'+s+'</li>'));
      $box.append($ul2);
    }
    if (!okList.length && !ngList.length) {
      $box.append('<div class="small muted">沒有回傳細節。</div>');
    }

    $('#mp_result').html($box);
  }, 'json').fail(function(xhr){
    alert('發送失敗：' + xhr.status + ' ' + xhr.statusText);
  }).always(function(){
    $('#btnGrantPoint').prop('disabled', false).text('發送點數');
  });
});


    // 發送（角色包包）
    $('#sendItems').on('click', function() {
      const character_raw = $('#player_list').val() || '';
      const item_raw = $('#item_codes').val() || '';
      const qty = parseInt($('#default_qty').val(), 10) || 0;

      // 角色：保留純數字
      const charParts = character_raw.replace(/，/g, ',').split(/[\n,]+/).map(s => s.trim()).filter(Boolean);
      const charIds = charParts.filter(s => /^\d+$/.test(s));
      const character_idx = charIds.join(',');
      if (!character_idx) { alert('請輸入至少 1 個有效的角色 ID（純數字）'); return; }

      // 物品：剝除 * 或 : 數量標記
      const item_idx = normalizeItemCodes(item_raw);
      if (!item_idx) { alert('請輸入至少 1 個有效的物品編號（純數字）'); return; }

      if (qty <= 0) { alert('請輸入正確的預設數量 (>=1)'); return; }

      const payload = { send_mode: 'char_bag', character_idx, item_idx, qty };
      if (CSRF_NAME && CSRF_HASH) payload[CSRF_NAME] = CSRF_HASH;

      $('#sendItems, #sendToShop').prop('disabled', true);
      $('#sendMsg').text('處理中…');
      $('#sendResult').empty();

      $.post(API_SEND, payload, function(res) {
        $('#sendMsg').text(res && res.msg ? res.msg : '');

        // 彙整每筆結果
        const okList = [];
        const ngList = [];
        if (res && Array.isArray(res.results)) {
          res.results.forEach(r => {
            const line = `角色 ${r.char} × 物品 ${r.item} × 數量 ${r.qty}` + (r.log_idx ? `（LOG ${r.log_idx}）` : '');
            if (r.ng && r.ng > 0) ngList.push(line + (r.msg ? `｜${r.msg}` : ''));
            else okList.push(line);
          });
        }
        const $box = $('<div/>');

        if (okList.length) {
          $box.append(`<div class="g-mb-5"><b>成功 (${okList.length})：</b></div>`);
          const $ul = $('<ul class="small mono"/>');
          okList.forEach(s => $ul.append(`<li>${s}</li>`));
          $box.append($ul);
        }
        if (ngList.length) {
          $box.append(`<div class="g-mb-5"><b style="color:#d9534f">失敗 (${ngList.length})：</b></div>`);
          const $ul2 = $('<ul class="small mono" style="color:#d9534f"/>');
          ngList.forEach(s => $ul2.append(`<li>${s}</li>`));
          $box.append($ul2);
        }
        if (!okList.length && !ngList.length) $box.append('<div class="small muted">沒有回傳細節。</div>');

        $('#sendResult').html($box);
      }, 'json').fail(function(xhr){
        $('#sendMsg').text('');
        alert('發送失敗：' + xhr.status + ' ' + xhr.statusText);
      }).always(function(){
        $('#sendItems, #sendToShop').prop('disabled', false);
      });
    });

    // 送到商城包包（CHARACTER_IDX 由後端用該帳號第一隻角色帶入；ITEM_SHOPIDX=USER_IDX）
    $('#sendToShop').on('click', function(){
      const user_idx = parseInt($('#search_user_idx').val(), 10);
      const item_raw = $('#item_codes').val() || '';
      const qty = parseInt($('#default_qty').val(), 10) || 0;

      if (!user_idx || user_idx <= 0) { alert('請在「帳號 USER_IDX」輸入正確的帳號'); return; }

      const item_idx = normalizeItemCodes(item_raw);
      if (!item_idx) { alert('請輸入至少 1 個有效的物品編號（純數字）'); return; }
      if (qty <= 0) { alert('請輸入正確的預設數量 (>=1)'); return; }

      const payload = { send_mode: 'shop_bag', user_idx, item_idx, qty };
      if (CSRF_NAME && CSRF_HASH) payload[CSRF_NAME] = CSRF_HASH;

      $('#sendItems, #sendToShop').prop('disabled', true);
      $('#sendMsg').text('處理中…');
      $('#sendResult').empty();

      $.post(API_SEND, payload, function(res){
        $('#sendMsg').text(res && res.msg ? res.msg : '');

        const okList = [];
        const ngList = [];
        if (res && Array.isArray(res.results)) {
          res.results.forEach(r => {
            const line = `角色 ${r.char} × 物品 ${r.item} × 數量 ${r.qty}` + (r.log_idx ? `（LOG ${r.log_idx}）` : '');
            if (r.ng && r.ng > 0) ngList.push(line + (r.msg ? `｜${r.msg}` : ''));
            else okList.push(line);
          });
        }
        const $box = $('<div/>');
        if (okList.length) {
          $box.append(`<div class="g-mb-5"><b>成功 (${okList.length})：</b></div>`);
          const $ul = $('<ul class="small mono"/>');
          okList.forEach(s => $ul.append(`<li>${s}</li>`));
          $box.append($ul);
        }
        if (ngList.length) {
          $box.append(`<div class="g-mb-5"><b style="color:#d9534f">失敗 (${ngList.length})：</b></div>`);
          const $ul2 = $('<ul class="small mono" style="color:#d9534f"/>');
          ngList.forEach(s => $ul2.append(`<li>${s}</li>`));
          $box.append($ul2);
        }
        if (!okList.length && !ngList.length) $box.append('<div class="small muted">沒有回傳細節。</div>');
        $('#sendResult').html($box);
      }, 'json').fail(function(xhr){
        $('#sendMsg').text('');
        alert('發送失敗：' + xhr.status + ' ' + xhr.statusText);
      }).always(function(){
        $('#sendItems, #sendToShop').prop('disabled', false);
      });
    });

    // 新增：帳號→角色 API：把勾選角色加入上方「玩家角色ID」框
    function addCheckedCharsToTextarea() {
      const ids = [];
      $('#acc_characters_result input.char-check:checked').each(function(){
        const v = $(this).val();
        if (/^\d+$/.test(v)) ids.push(v);
      });
      if (!ids.length) { alert('請先勾選要加入的角色'); return; }

      const current = ($('#player_list').val() || '').replace(/，/g, ',')
        .split(/[\n,]+/).map(s => s.trim()).filter(Boolean);

      const merged = Array.from(new Set(current.concat(ids))); // 去重
      $('#player_list').val(merged.join(','));
    }

    // 渲染帳號角色清單
    function renderAccountCharacters(resp) {
      const $box = $('#acc_characters_result').empty();
      $('#btnAddSelectedChars').prop('disabled', true);

      if (resp.error) {
        $box.html('<div class="small" style="color:#d9534f;">'+ resp.error +'</div>');
        return;
      }
      const list = resp.characters || [];
      if (!list.length) {
        $box.html('<div class="small muted">查無角色。</div>');
        return;
      }

      const $table = $(`
        <div class="table-responsive">
          <table class="table table-sm table-bordered">
            <thead>
              <tr>
                <th class="w-80"><input type="checkbox" id="chk_all_chars"></th>
                <th class="w-140">角色ID</th>
                <th>角色名稱</th>
                <th class="w-80">等級</th>
                <th class="w-120">職業</th>
                <th class="w-140">最後異動</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
          <div class="small muted">共 ${list.length} 筆</div>
        </div>
      `);

      const $tbody = $table.find('tbody');
      list.forEach(row => {
        const tr = `
          <tr>
            <td class="text-center">
              <input type="checkbox" class="char-check" value="${row.CharId}">
            </td>
            <td class="mono">${row.CharId}</td>
            <td>${row.CharName || ''}</td>
            <td class="text-right">${row.Level ?? ''}</td>
            <td>${row.Job ?? ''}</td>
            <td class="small mono">${row.LastModified || ''}</td>
          </tr>
        `;
        $tbody.append(tr);
      });

      $box.append($table);

      // 全選
      $('#chk_all_chars').on('change', function(){
        $('.char-check').prop('checked', $(this).is(':checked'));
        $('#btnAddSelectedChars').prop('disabled', $('.char-check:checked').length === 0);
      });
      // 勾選監聽
      $box.on('change', '.char-check', function(){
        const any = $('.char-check:checked').length > 0;
        $('#btnAddSelectedChars').prop('disabled', !any);
      });
    }

    // 綁定：查詢帳號角色
    $('#btnSearchUser').on('click', function(){
      const user_idx = parseInt($('#search_user_idx').val(), 10);
      if (!user_idx || user_idx <= 0) { alert('請輸入正確的 USER_IDX (正整數)'); return; }

      const payload = { user_idx };
      if (CSRF_NAME && CSRF_HASH) payload[CSRF_NAME] = CSRF_HASH;

      $('#btnSearchUser').prop('disabled', true).text('查詢中…');
      $('#acc_characters_result').html('<div class="small muted">查詢中…</div>');

      $.post(API_CHAR_LIST, payload, function(res){
        renderAccountCharacters(res || {});
      }, 'json').fail(function(xhr){
        $('#acc_characters_result').html('<div class="small" style="color:#d9534f;">查詢失敗：'+xhr.status+' '+xhr.statusText+'</div>');
      }).always(function(){
        $('#btnSearchUser').prop('disabled', false).text('查詢帳號角色');
      });
    });

    // 綁定：把勾選角色加到上方角色ID框
    $('#btnAddSelectedChars').on('click', addCheckedCharsToTextarea);
  </script>
</body>
</html>
