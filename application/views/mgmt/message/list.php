<style>
  #ltian {
    overflow-y: auto;
    height: calc(100vh - 250px);
    border: 1px solid #ccc;
    padding: 10px;
  }
  .message-row {
    display: flex;
    margin-bottom: 10px;
    max-width: 60%;
    clear: both;
  }
  .message-row.me {
    margin-left: auto;
    justify-content: flex-end;
    text-align: right;
  }
  .message-row.other {
    justify-content: flex-start;
    text-align: left;
  }
  .message-content {
    background: #f0f0f0;
    padding: 8px 15px;
    border-radius: 15px;
    word-wrap: break-word;
    word-break: break-word;
    color: #000;
    white-space: normal;
  }
  .message-row.me .message-content {
    background: #a0d468;
    color: #000;
  }
  .message-timestamp {
    font-size: 0.75rem;
    color: #666;
    margin: 0 5px;
    white-space: nowrap;
  }
  .message-username {
    font-weight: bold;
    margin-right: 5px;
    white-space: nowrap;
  }
  #ems {
    position: absolute;
    background: white;
    border: 1px solid #ccc;
    display: none;
    width: 235px;
    padding: 5px;
    z-index: 1000;
  }
  #ems > div {
    margin-bottom: 5px;
  }
  #ems img {
    cursor: pointer;
    margin: 3px;
    vertical-align: middle;
  }
  #ems a {
    cursor: pointer;
    margin-right: 6px;
    padding: 2px 5px;
  }
  #ems a.ck {
    background-color: #a0d468;
    color: white;
    border-radius: 3px;
  }
</style>

<div id="ltian"></div>
<textarea id="nrong" rows="3" style="width: 100%;"></textarea>
<button id="imgbq">表情</button>

<div id="ems">
  <div></div> <!-- 表情圖片容器 -->
  <div></div> <!-- 分頁容器 -->
</div>

<script>
  var me_id = '你的用戶ID'; // 你要動態填入的ID
  var lct = document.getElementById('ltian');
  var bq = document.getElementById('imgbq');
  var ems = document.getElementById('ems');
  var nrong = document.getElementById('nrong');

  var l = 56, r = 4, c = 7, s = 0, p = Math.ceil(l/(r*c));
  var pt = '../img/face/';

  function ct() {
    var rect = bq.getBoundingClientRect();
    ems.style.top = (rect.bottom + window.scrollY + 5) + 'px';
    ems.style.left = (rect.left + window.scrollX) + 'px';
  }

  function hh() {
    ems.children[0].innerHTML = '';
    var z = Math.min(l, s + r * c);
    for(var i = s; i < z; i++) {
      var img = document.createElement('img');
      img.src = pt + i + '.gif';
      img.onclick = function(e) {
        var idx = this.src.match(/(\d+)\.gif$/)[1];
        nrong.value += '{\\' + idx + '}';
        hideEms();
        e.stopPropagation();
      };
      ems.children[0].appendChild(img);
    }
    ct();
  }

  function ef(t, i) {
    t.onclick = function(e) {
      s = i * r * c;
      hh();
      var siblings = ems.children[1].children;
      for(var j=0; j < siblings.length; j++) siblings[j].classList.remove('ck');
      this.classList.add('ck');
      e.stopPropagation();
    };
  }

  for(var i=0; i < p; i++) {
    var a = document.createElement('a');
    a.href = 'javascript:void(0);';
    a.textContent = i+1;
    if(i===0) a.classList.add('ck');
    ems.children[1].appendChild(a);
    ef(a, i);
  }
  hh();

  bq.onclick = function(e) {
    if(ems.style.display === 'block') {
      hideEms();
    } else {
      ems.style.display = 'block';
      ct();
      setTimeout(() => {
        document.addEventListener('click', hideEmsOnce, { once: true });
      }, 0);
    }
    e.stopPropagation();
  };

  function hideEms() {
    ems.style.display = 'none';
  }
  function hideEmsOnce() {
    hideEms();
  }

  // 聊天訊息載入範例函式 (模擬 AJAX 成功回調)
  function loadMessages(msg_list, to_user_name_list) {
    lct.innerHTML = '';
    msg_list.forEach(function(me) {
      var message = me.content.replace(/{\\(\d+)}/g, function(a,b) {
        return '<img src="../img/face/'+b+'.gif" style="vertical-align: middle;">';
      });

      var isMe = (me.from_user_id == me_id);
      var timeStr = '[' + me.create_time.substr(5) + ']';

      var div = document.createElement('div');
      div.className = 'message-row ' + (isMe ? 'me' : 'other');

      var html = '';
      if(!isMe) {
        html += '<span class="message-username">' + to_user_name_list.user_name + ':</span>';
      }
      html += '<div class="message-content">' +
                '<span class="message-timestamp">' + timeStr + '</span> ' +
                '<span class="message_row" msg_id="'+me.id+'">' + message + '</span>' +
              '</div>';

      div.innerHTML = html;
      lct.appendChild(div);
    });
    lct.scrollTop = lct.scrollHeight;
  }

  // 你可以用 loadMessages() 傳入實際訊息測試
</script>
