<?php $this->load->view('layout/head'); ?>
<?php require_once(APPPATH."views/lang/$lang.php"); ?>
<style>
  span{
    color:#003355;
  }
  label{
    color:#003355;
  }
  th span{
    color:white;
  }
  table {
      border-collapse: collapse;
  }
  table, th, td {
      border: 1px solid black;
  }
</style>
<div class="col-xs-12" style="padding:20px">
  <?php if (isset($question_ans_id) && $question_ans_id>0) : ?>
      <div class="widget-toolbar pull-right">
        <button onclick="doExportAll_for_6(<?= isset($question_ans_id) ? $question_ans_id : '' ?>)" class="btn btn-xs btn-warning" data-toggle="dropdown">
          <i class="fa fa-save"></i>匯出
        </button>
      </div>
    </hr>
  <?php endif ?>

    <input type="hidden" id="qid" value="<?= isset($qid) ? $qid : '' ?>" />
    <input type="hidden" id="role_id" value="<?= isset($role_id) ? $role_id : '' ?>" />
    <input type="hidden" id="question_ans_id" value="<?= isset($question_ans_id) ? $question_ans_id : '' ?>" />
    員工滿意度：員工填寫(員工對公司考核)</br>
    ※你認為公司有做的程度，每項打分：</br>
    &nbsp;&nbsp;&nbsp;A優異(10分); B佳(9分); C可(8分); D普通(7分); E不佳(6分)</br>
    <table class="col-xs-12">
		<tbody >
			<tr>
				<td class="min50">項目</td>
				<td>系統</td>
				<td>制度</td>
				<td>成本</td>
				<td>協助</td>
				<td>彈性</td>
				<td>分工</td>
				<td>訓練</td>
				<td>福利</td>
				<td>分享</td>
				<td>公平</td>
			</tr>
			<tr id="body_tr">
				<td class="min50">分數</td>
        <?php for ($i=0;$i<10;$i++) : ?>
          <?php if ($items_count>0) : ?>
            <td >
              <select id = "s_s_<?= $i+1 ?>" class="s<?= $i+1 ?>" name="s<?= $i+1 ?>" onchange="sum('s<?= $i+1 ?>')">
                <option value="0" <?= isset($items)&& $items[$i]==0 ? 'selected' : '' ?>>請選擇</option>
                <option value="10" <?= isset($items)&& $items[$i]==10 ? 'selected' : '' ?>>A(10分):優異</option>
                <option value="9" <?= isset($items)&& $items[$i]==9 ? 'selected' : '' ?>>B(9分):佳</option>
                <option value="8" <?= isset($items)&& $items[$i]==8 ? 'selected' : '' ?>>C(8分):可</option>
                <option value="7" <?= isset($items)&& $items[$i]==7 ? 'selected' : '' ?>>D(7分):普通</option>
                <option value="6" <?= isset($items)&& $items[$i]==6 ? 'selected' : '' ?>>C(6分):不佳</option>
              </select>
            </td>
          <?php else :?>
            <td >
              <select id = "s_s_<?= $i+1 ?>" class="s<?= $i+1 ?>" name="s<?= $i+1 ?>" onchange="sum('s<?= $i+1 ?>')">
                <option value="0">請選擇</option>
                <option value="10" >A(10分):優異</option>
                <option value="9">B(9分):佳</option>
                <option value="8">C(8分):可</option>
                <option value="7">D(7分):普通</option>
                <option value="6">C(6分):不佳</option>
              </select>
            </td>
          <?php endif ?>
        <?php endfor ?>

			</tr>
			<tr>
        <?php if ($items_count>0) : ?>
         <td id="sum_id" colspan="11"><?= isset($items)? '總分合計:'.$items[$items_count] : '總分合計:還有其他沒選擇' ?></td>	

        <?php else :?>
          <td id="sum_id" colspan="11">總分合計:</td>	
        <?php endif ?>
			</tr>
	</table>
  <div class="col-xs-12 no-padding" style="margin-top:20px">
    其他意見有問有答：</br>
    <?php if ($items_count>0) : ?>
      <textarea class="form-control" name="q1o" ><?= isset($items)? $items[10] : '' ?></textarea>

    <?php else :?>
      <textarea class="form-control" name="q1o" ></textarea>
    <?php endif ?>
  </div>

    <div class="col-xs-12 no-padding" style="margin-top:20px">
        <div class="col-xs-6 no-padding">
            <button type="button" class="btn btn-secondary cancel" style="width:120px;height:40px;float:left"><?= $this->_lang['cancel'] ?></button>
        </div>
        <?php if($question_ans_id==0): ?>

          <div class="col-xs-6 no-padding">
              <button type="button" class="btn btn-success dosubmit" style="width:120px;height:40px;float:right"><?= $this->_lang['send'] ?></button>
          </div>
        <?php endif?>
    </div>
    </div>

    <?php $this->load->view('layout/plugins'); ?>
    <script type="text/javascript">
	// date-picker

  $( document ).ready(function() {
    $('#name').focus();
  })
  
  var str_ok=false;
  var is_ok=false;
  function sum(id_name) {
		onclick_option_val = $('select[name="'+id_name+'"]').val();
		val = parseInt(onclick_option_val);
		var value = 0;
		var sum_id = document.getElementById('sum_id');
		for (var j = 0; j < 10; j++) {
			name_num= j+1;   
			other_option_val =$('select[name="s'+name_num+'"]').val();
			if (other_option_val == 0){
        sum_id.innerHTML = "總分合計:";
        is_ok=false;
        break ;
      } else{
        value +=parseInt(other_option_val);
				sum_id.innerHTML = "總分合計:"+value ;
        is_ok=true;
      }
		}
		
  }

  $('[name="q1o"]').on('change', function(){
    var  q1o_str = $('[name="q1o"]').val();
    if(q1o_str.length<=630||q1o_str==''){
      str_ok=true;
    }
	});

  $('.cancel').click(function() {
    var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
    parent.layer.close(index);
  })
  $('.dosubmit').click(function() {
    if (is_ok){
      if (str_ok){
        $.ajax({
            url: '<?= base_url() ?>' + 'mgmt/question_for_user/save_q6',
            type: 'POST',
            data: {
              qid:$('#qid').val(),
              q1 : $('select[name="s1"]').val(),
              q2 : $('select[name="s2"]').val(),
              q3 : $('select[name="s3"]').val(),
              q4 : $('select[name="s4"]').val(),
              q5 : $('select[name="s5"]').val(),
              q6 : $('select[name="s6"]').val(),
              q7 : $('select[name="s7"]').val(),
              q8 : $('select[name="s8"]').val(),
              q9 : $('select[name="s9"]').val(),
              q10 : $('select[name="s10"]').val(),

              q1o : $('[name="q1o"]').val(),
              role_id :$('#role_id').val(),
            },
            dataType: 'json',
            success: function(d) {
              if(d) {
                // console.log(d);
              }
              if(d.success){
                var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                parent.layer.close(index);
                parent.location.reload();
              }
              if(d.error){
                layer.msg(d.error);
              }
            },
            failure:function(){
              layer.msg('faialure');
            }
          });  
      } else{
        alert('字數請勿超過630字');
      }
            
    } else{
      alert('請填寫完全部題目！');

    }
   
})
  $('.trash_btn').click(function() {
    $(this).closest('.itemp').remove();
  })

	function doExportAll_for_6(id) {
    var baseUrl = '<?=base_url('')?>';
    window.open(baseUrl + 'mgmt/question_option/export_all_word/' + id);
	}
  
</script>
