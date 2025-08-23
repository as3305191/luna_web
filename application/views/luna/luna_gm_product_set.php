<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <?php $this->load->view("luna/luna_head"); ?>
  <style>
    td.text-right { text-align:right; }
    .pagination-wrap { display:flex; justify-content:center; gap:6px; flex-wrap:wrap; }
    .page-ctrl { cursor:pointer; user-select:none; }
    .page-ellipsis { padding:6px 10px; color:#999; }
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
                <div class="card border-0">
                  <div class="card-header d-flex align-items-center justify-content-between g-bg-gray-light-v5 border-0">
                    <h3 class="h6 mb-0"><i class="icon-directions g-pos-rel g-top-1 g-mr-5"></i> 商品清單（Excel 來源）</h3>
                    <div class="d-flex align-items-center">
                      <input id="q" type="text" class="form-control form-control-sm" placeholder="搜尋：編號 / 名稱 / 分類" style="width:240px;">
                    </div>
                  </div>

                  <div class="card-block g-pa-0">
                    <div class="table-responsive">
                      <table class="table table-bordered u-table--v2">
                        <thead class="text-uppercase g-letter-spacing-1">
                          <tr>
                            <th style="width:140px;">商品編號</th>
                            <th>名稱</th>
                            <th style="width:120px;" class="text-right">價格</th>
                            <th style="width:80px;">庫存</th>
                            <th style="width:140px;">分類</th>
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
    const CSRF_NAME = '<?= $this->security->get_csrf_token_name(); ?>';
    const CSRF_HASH = '<?= $this->security->get_csrf_hash(); ?>';

    let currentPage = 1;
    let currentQ = '';

    function fetch_page(page) {
      const payload = { page: page, q: currentQ };
      if (CSRF_NAME && CSRF_HASH) payload[CSRF_NAME] = CSRF_HASH;

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
              $('<td/>').text(me.product_code || '').appendTo($tr);
              $('<td/>').text(me.name || '').appendTo($tr);
              const priceText = (me.price !== undefined && me.price !== null && me.price !== '')
                ? Number(me.price).toLocaleString('zh-Hant-TW') : '';
              $('<td/>').addClass('text-right').text(priceText).appendTo($tr);
              const stockText = (me.stock !== undefined && me.stock !== null && me.stock !== '')
                ? parseInt(me.stock, 10) : '';
              $('<td/>').text(stockText).appendTo($tr);
              $('<td/>').text(me.category || '').appendTo($tr);
              $tr.appendTo($body);
            });
          } else {
            $('<tr><td colspan="5" class="text-center">查無資料</td></tr>').appendTo($body);
          }

          currentPage = res.page || 1;
          render_pagination(currentPage, res.total_page || 1);
        },
        error: function(xhr){
          console.error(xhr);
          $('#msg').text('資料載入失敗：' + xhr.status + ' ' + xhr.statusText);
        }
      });
    }

    // 分頁：每次顯示 10 個頁碼，含左右鍵與省略號
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
  </script>
</body>
</html>
