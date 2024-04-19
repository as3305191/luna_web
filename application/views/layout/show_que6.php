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

    <input type="hidden" id="qid" value="<?= isset($qid) ? $qid : '' ?>" />
    <input type="hidden" id="role_id" value="<?= isset($role_id) ? $role_id : '' ?>" />
    <input type="hidden" id="question_ans_id" value="<?= isset($question_ans_id) ? $question_ans_id : '' ?>" />
    A(10分); B(9分); C(8分); D(7分); E(6分)
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
			<tr>
				<td class="min50">分數</td>
        <!-- <?php for ($i=0;$i<10;$i++) : ?>
          <td id="example_tbody"y>
            <select id = "s<?= $i+1 ?>" class="s<?= $i+1 ?>" name="s<?= $i+1 ?>" onchange="sum('s<?= $i+1 ?>')">
              <option value="0">請選擇</option>
              <option value="10">A(10分):優異</option>
              <option value="9">B(9分):佳</option>
              <option value="8">C(8分):可</option>
              <option value="7">D(7分):普通</option>
              <option value="6">C(6分):不佳</option>
            </select>
          </td>
        <?php endfor ?> -->

			</tr>
			<tr>
				<td id="sum_id" colspan="11">總分合計:還有其他沒選擇</td>	
			</tr>
	</table>
  <div class="col-xs-12 no-padding" style="margin-top:20px">
    其他意見有問有答：</br>
    <textarea class="form-control" name="q1o"></textarea>
  </div>

    <div class="col-xs-12 no-padding" style="margin-top:20px">
        <div class="col-xs-6 no-padding">
            <button type="button" class="btn btn-secondary cancel" style="width:120px;height:40px;float:left">取消</button>
        </div>
        <?php if($question_ans_id==0): ?>

          <div class="col-xs-6 no-padding">
              <button type="button" class="btn btn-success dosubmit" style="width:120px;height:40px;float:right">送出</button>
          </div>
        <?php endif?>
    </div>
    </div>

    <?php $this->load->view('layout/plugins'); ?>
    <script type="text/javascript">
	// date-picker

  $( document ).ready(function() {
    $('#name').focus();
    load_ans();
  })
  

  var is_ok=false;
  var each_dom_script ='';



  for(var i=0;i<10;i++){
     $num=''
    now_script = '';
    $i_1 = i+1;
    each_dom_script+=' <td>'+
    '<select id = "s'+$i_1+'" class="s'+ $i_1 +'" name="s'+ $i_1 +'" onchange="sum(s'+$i_1+')">'+
            '<option value="0">請選擇</option>'+
              ' <option value="10">A(10分):優異</option>'+
              ' <option value="9">B(9分):佳</option>'+
              ' <option value="8">C(8分):可</option>'+
              '<option value="7">D(7分):普通</option>'+
              ' <option value="6">C(6分):不佳</option>'+
              '</select>'+
            '</td>';
    if(i==9){
      continue;

    }
  }

  $('#example_tbody').append(each_dom_script);






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
				sum_id.innerHTML = "總分合計:"+value ;
        is_ok=true;
      }
		}
		
    }



  $('.cancel').click(function() {
    var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
    parent.layer.close(index);
  })
  $('.dosubmit').click(function() {
    if (is_ok){
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


  function load_ans(){
    if($('#question_ans_id').val()>0){
      $.ajax({
  			url: '<?= base_url() ?>' + 'mgmt/question_for_user/load_ans',
  			type: 'POST',
  			data: {
  				id:$('#question_ans_id').val(),
  			},
  			dataType: 'json',
  			success: function(d) {
  				if(d) {
            for (var key in d.items) {
              obj= d.items;
              var str_key = key.toString().substr(0,1);
              var s_str_key = key.toString().substr(1,1);
              var last_str_key =  key.toString().substr(-1);
              var optionval = obj[key].toString();
              var select_class = '.'+key;

              if(str_key=='q' && s_str_key!=='u'){
                if(last_str_key=='o'){
                  $('.'+key).val(obj[key]);
                  // console.log(key+':'+obj[key]);
                  
                } else{
                  if(obj[key]!==null&&obj[key]!==''&&obj[key]!==NaN){
                  
                    console.log($('.s'+key).value);

                    // document.querySelector('#s'+key).value = optionval;
                  }
                 
                }
              }

            }
  				}
         
  			},
  			failure:function(){
  				layer.msg('faialure');
  			}
  		});
    }
  }

  
</script>
