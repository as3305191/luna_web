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
</style>
<div class="col-xs-12" style="padding:20px">
    <div class="col-xs-12">
        <span style="font-size:12pt"><?= $this->_lang['q1_vh'] ?></span>
    </div>
    <hr/>
    <input type="hidden" id="qid" value="<?= isset($qid) ? $qid : '' ?>" />
    <table class="col-xs-12">
		<thead >
			<tr>
				<td class="min50">序號</td>
				<td>1</td>
				<td>2</td>
				<td>3</td>
				<td>4</td>
				<td>5</td>
				<td>6</td>
				<td>7</td>
				<td>8</td>
				<td>9</td>
				<td>10</td>
			</tr>
		</thead>
		<tbody id="example_tbody">
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
			<tr>
				<td class="min50">分數</td>
        <?php for ($i=0;$i<10;$i++) : ?>

          <td>
            <select name="s<?= $i+1 ?>" onchange="sum('s<?= $i+1 ?>')">
              <option value="0">請選擇</option>
              <option value="10">A(10分):優異</option>
              <option value="9">B(9分):佳</option>
              <option value="8">C(8分):可</option>
              <option value="7">D(7分):普通</option>
              <option value="6">C(6分):不佳</option>
            </select>
          </td>
        <?php endfor ?>

			</tr>
			<tr>
				<td id="sum_id" colspan="11">總分合計:</td>	
			</tr>
		</tbody>
	</table>
    <div class="col-xs-12 no-padding" style="margin-top:20px">
        <div class="col-xs-6 no-padding">
            <button type="button" class="btn btn-secondary cancel" style="width:120px;height:40px;float:left">取消</button>
        </div>
        <div class="col-xs-6 no-padding">
            <button type="button" class="btn btn-success dosubmit" style="width:120px;height:40px;float:right">送出</button>
        </div>
    </div>
    </div>

    <?php $this->load->view('layout/plugins'); ?>
    <script type="text/javascript">
	// date-picker

  $( document ).ready(function() {
    $('#name').focus();
  })
  
  var  q1 = null;
  var  q2 = null;
  var  q3 = null;
  var  q4 = null;
  var  q5 = null;
  var  q6 = null;
  var  q7 = null;
  var  q8 = null;
  var  q9 = null;
  var  q10 = null;
  var  q11 = null;
  var  q12 = null;
  
  var  q1o = '無';
  var  q2o = '無';
  var  q3o = '無';
  var is_ok=false;
  $('input:radio[name="q1_1"]').on('change', function(){
    q1 = $('input:radio[name="q1_1"]:checked').val();
   
  });
  $('input:radio[name="q1_2"]').on('change', function(){
    q2 = $('input:radio[name="q1_2"]:checked').val();
   
  });
  $('input:radio[name="q1_3"]').on('change', function(){
    q3 = $('input:radio[name="q1_3"]:checked').val();
   
  });
  $('input:radio[name="q1_4"]').on('change', function(){
    q4 = $('input:radio[name="q1_4"]:checked').val();
   
  });
  $('input:radio[name="q1_5"]').on('change', function(){
    q5 = $('input:radio[name="q1_5"]:checked').val();
   
  });
  
$("input[name='q1_6']").on('change', function(){
    obj = document.getElementsByName("q1_6");
    q6 = [];
    for (i in obj) {
        if (obj[i].checked){
          q6.push(obj[i].value);
        }
    }

    // console.log(q6);
  });
  $("input[name='q1_7']").on('change', function(){
    obj = document.getElementsByName("q1_7");
    q7 = [];

    for (i in obj) {
      if (obj[i].checked){
        q7.push(obj[i].value);
      }
    }
    // console.log(q7);

  });
  $('input:radio[name="q1_8"]').on('change', function(){
    q8 = $('input:radio[name="q1_8"]:checked').val();
   
  });
  $('input:radio[name="q1_9"]').on('change', function(){
    q9 = $('input:radio[name="q1_9"]:checked').val();
   
  });
  $('input:radio[name="q1_10"]').on('change', function(){
    q10 = $('input:radio[name="q1_10"]:checked').val();
   
  });
  $('input:radio[name="q1_11"]').on('change', function(){
    q11 = $('input:radio[name="q1_11"]:checked').val();
   
  });
  $('input:radio[name="q1_12"]').on('change', function(){
    q12 = $('input:radio[name="q1_12"]:checked').val();
   
  });
 


  $('[name="q1_1o"]').on('change', function(){
    q1o = $('[name="q1_1o"]').val();
    // console.log(q1o);
   
  });
  $('[name="q1_5o"]').on('change', function(){
    q2o = $('[name="q1_5o"]').val();
    // console.log(q2o);

  });
  $('[name="q1_6o"]').on('change', function(){
    q3o = $('[name="q1_6o"]').val();
    // console.log(q3o);

  });


  function sum(id_name) {
		onclick_option_val = $('select[name="'+id_name+'"]').val();
		val = parseInt(onclick_option_val);
		var value = 0;
		var sum_id = document.getElementById('sum_id');
		for (var j = 0; j < 10; j++) {
			name_num= j+1;   
			other_option_val =$('select[name="s'+name_num+'"]').val();
			if (other_option_val == 0){
        sum_id.innerHTML = "總分合計:還有其他沒選擇";
        break ;
				
			} else{
        value +=parseInt(other_option_val);
				sum_id.innerHTML = "總分合計:"+value 
      }
		}
		
    }



  $('.cancel').click(function() {
    var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
    parent.layer.close(index);
  })
  $('.dosubmit').click(function() {
    if (q1!==null&&q2!==null&&q3!==null&&q4!==null&&q5!==null&&q6!==null&&
         q7!==null&&q8!==null&&q9!==null&&q10!==null&&q11!==null&&q12!==null){
          $.ajax({
            url: '<?= base_url() ?>' + 'mgmt/question_for_user/save_q1',
            type: 'POST',
            data: {
              qid:$('#qid').val(),
              q1 : q1,
              q2 : q2,
              q3 : q3,
              q4 : q4,
              q5 : q5,
              q6 : q6.toString(),
              q7 : q7.toString(),
              q8 : q8,
              q9 : q9,
              q10 : q10,
              q11 : q11,
              q12 : q12,
              q1o : q1o,
              q2o : q2o,
              q3o : q3o,
            },
            dataType: 'json',
            success: function(d) {
              if(d) {
                console.log(d);
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
      alert('請填寫完全部題目！');

    }
   
})
  $('.trash_btn').click(function() {
    $(this).closest('.itemp').remove();
  })
</script>
