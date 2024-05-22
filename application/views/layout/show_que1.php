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
    <?= $this->_lang['q1_binf'] ?><br>
    <?= $this->_lang['q1_pf'] ?><br>
    <?= $this->_lang['q1_wt'] ?><br>
    <input type="radio" name="q1_1" value="辦公室人員" id="q1_11"><label for="q1_11"><?= $this->_lang['q1_wt_of'] ?></label>
    <input type="radio" name="q1_1" value="現場人員" id="q1_12"><label for="q1_12"><?= $this->_lang['q1_wt_sp'] ?></label>
    <input type="radio" name="q1_1" value="外勤人員" id="q1_13"><label for="q1_13"><?= $this->_lang['q1_wt_ft'] ?></label><br>
    <input type="radio" name="q1_1" value="其他" id="q1_14"><label for="q1_14"><?= $this->_lang['q1_wt_ot'] ?></label> <input name="q1_1o"><br>

    <?= $this->_lang['q1_g'] ?>
    <input type="radio" name="q1_2" value="男" id="q1_m"><label for="q1_m"><?= $this->_lang['q1_g_m'] ?></label>
    <input type="radio" name="q1_2" value="女" id="q1_1fm"><label for="q1_1fm"><?= $this->_lang['q1_g_f'] ?></label><br>
    <?= $this->_lang['q1_wexp'] ?><br>
    <?= $this->_lang['q1_sen'] ?><br>
    <input type="radio" name="q1_3" value="未滿1年" id="q1_31"><label for="q1_31"><?= $this->_lang['q1_sen_n1'] ?></label>
    <input type="radio" name="q1_3" value="1年-3年" id="q1_32"><label for="q1_32"><?= $this->_lang['q1_sen_n3'] ?></label>
    <input type="radio" name="q1_3" value="3年-5年" id="q1_33"><label for="q1_33"><?= $this->_lang['q1_sen_n5'] ?></label>
    <input type="radio" name="q1_3" value="5-10年" id="q1_34"><label for="q1_34"><?= $this->_lang['q1_sen_n10'] ?></label>
    <input type="radio" name="q1_3" value="10-15年" id="q1_35"><label for="q1_35"><?= $this->_lang['q1_sen_n15'] ?></label>
    <input type="radio" name="q1_3" value="15年以上" id="q1_36"><label for="q1_36"><?= $this->_lang['q1_sen_y15'] ?></label><br>
    <?= $this->_lang['q1_aw'] ?><br>
    <input type="radio" name="q1_4" value="42小時以下" id="q1_41"><label for="q1_41"><?= $this->_lang['q1_aw_n42'] ?></label>
    <input type="radio" name="q1_4" value="43-48小時" id="q1_42"><label for="q1_42"><?= $this->_lang['q1_aw_n48'] ?></label>
    <input type="radio" name="q1_4" value="49-54小時" id="q1_43"><label for="q1_43"><?= $this->_lang['q1_aw_n54'] ?></label>
    <input type="radio" name="q1_4" value="55小時以上" id="q1_44"><label for="q1_44"><?= $this->_lang['q1_aw_y55'] ?></label><br>
    <?= $this->_lang['q1_wf'] ?><br>
    <input type="radio" name="q1_5" value="正常班" id="q1_51"><label for="q1_51"><?= $this->_lang['q1_wf_nc'] ?></label>
    <input type="radio" name="q1_5" value="需假日出勤" id="q1_52"><label for="q1_52"><?= $this->_lang['q1_wf_nha'] ?></label>
    <input type="radio" name="q1_5" value="需外勤" id="q1_53"><label for="q1_53"><?= $this->_lang['q1_wf_nfs'] ?></label>
    <input type="radio" name="q1_5" value="需值班" id="q1_54"><label for="q1_54"><?= $this->_lang['q1_wf_od'] ?></label>
    <?= $this->_lang['q1_wf_noote'] ?><input name="q1_5o"><br>
    <?= $this->_lang['q1_we_v'] ?><br>
    <input type="checkbox" name="q1_6" value="無" id="q1_66"><label for="q1_66"><?= $this->_lang['q1_we_n'] ?><?= $this->_lang['q1_nwst'] ?></label><br>
    <input type="checkbox" name="q1_6" value="肢體暴力，如毆打、踢、推、捏、拉扯等" id="q1_61"><label for="q1_61"><?= $this->_lang['q1_we_pbv'] ?></label> <?= $this->_lang['q1_wf_noote'] ?><input name="q1_7o"><br>
    <input type="checkbox" name="q1_6" value="言語暴力，如辱罵、言語騷擾、冷嘲熱諷等" id="q1_62"><label for="q1_62"><?= $this->_lang['q1_we_vv'] ?></label> <?= $this->_lang['q1_wf_noote'] ?><input name="q1_8o"><br>
    <input type="checkbox" name="q1_6" value="心理暴力，如威脅、恐嚇、歧視、排擠、騷擾等" id="q1_63"><label for="q1_63"><?= $this->_lang['q1_we_pv'] ?></label> <?= $this->_lang['q1_wf_noote'] ?><input name="q1_9o"><br>
    <input type="checkbox" name="q1_6" value="性騷擾，如不當的性暗示與行為" id="q1_64"><label for="q1_64"><?= $this->_lang['q1_we_sh'] ?></label> <?= $this->_lang['q1_wf_noote'] ?><input name="q1_10o"><br>
    <input type="checkbox" name="q1_6" value="其他" id="q1_65"><label for="q1_65"><?= $this->_lang['q1_we_o'] ?></label> <input name="q1_6o"><br>
    <?= $this->_lang['q1_dfv'] ?><input name="q1_5o"><br>
    <input type="checkbox" name="q1_7" value="沒有提供任何工作安全衛生教育訓練" id="q1_71"><label for="q1_71"><?= $this->_lang['q1_nwst'] ?></label><br>
    <input type="checkbox" name="q1_7" value="人身安全之防範" id="q1_72"><label for="q1_72"><?= $this->_lang['q1_pap'] ?></label><br>
    <input type="checkbox" name="q1_7" value="防護用具之使用" id="q1_73"><label for="q1_73"><?= $this->_lang['q1_upe'] ?></label><br>
    <input type="checkbox" name="q1_7" value="危害通識教育訓練" id="q1_74"><label for="q1_74"><?= $this->_lang['q1_dgt'] ?></label><br>
    <input type="checkbox" name="q1_7" value="法規教育" id="q1_75"><label for="q1_75"><?= $this->_lang['q1_rt'] ?></label><br>
    <?= $this->_lang['q1_dfvn'] ?><br>
    <?= $this->_lang['q1_iwv'] ?><br>
    <input type="radio" name="q1_8" value="非常同意" id="q1_81"><label for="q1_81"><?= $this->_lang['q1_t_va'] ?></label>
    <input type="radio" name="q1_8" value="同意" id="q1_82"><label for="q1_82"><?= $this->_lang['q1_t_a'] ?></label>
    <input type="radio" name="q1_8" value="沒意見" id="q1_83"><label for="q1_83"><?= $this->_lang['q1_t_nc'] ?></label>
    <input type="radio" name="q1_8" value="不同意" id="q1_84"><label for="q1_84"><?= $this->_lang['q1_t_na'] ?></label>
    <input type="radio" name="q1_8" value="非常不同意" id="q1_85"><label for="q1_85"><?= $this->_lang['q1_t_vna'] ?></label><br>
    <?= $this->_lang['q1_ira'] ?><br>
    <input type="radio" name="q1_9" value="非常同意" id="q1_91"><label for="q1_91"><?= $this->_lang['q1_t_va'] ?></label>
    <input type="radio" name="q1_9" value="同意" id="q1_92"><label for="q1_92"><?= $this->_lang['q1_t_a'] ?></label>
    <input type="radio" name="q1_9" value="沒意見" id="q1_93"><label for="q1_93"><?= $this->_lang['q1_t_nc'] ?></label>
    <input type="radio" name="q1_9" value="不同意" id="q1_94"><label for="q1_94"><?= $this->_lang['q1_t_na'] ?></label>
    <input type="radio" name="q1_9" value="非常不同意" id="q1_95"><label for="q1_95"><?= $this->_lang['q1_t_vna'] ?></label><br>
    <?= $this->_lang['q1_iav'] ?><br>
    <input type="radio" name="q1_10" value="非常同意" id="q1_101"><label for="q1_101"><?= $this->_lang['q1_t_va'] ?></label>
    <input type="radio" name="q1_10" value="同意" id="q1_102"><label for="q1_102"><?= $this->_lang['q1_t_a'] ?></label>
    <input type="radio" name="q1_10" value="沒意見" id="q1_103"><label for="q1_103"><?= $this->_lang['q1_t_nc'] ?></label>
    <input type="radio" name="q1_10" value="不同意" id="q1_104"><label for="q1_104"><?= $this->_lang['q1_t_na'] ?></label>
    <input type="radio" name="q1_10" value="非常不同意" id="q1_105"><label for="q1_105"><?= $this->_lang['q1_t_vna'] ?></label><br>
    <?= $this->_lang['q1_ivnsc'] ?><br>
    <input type="radio" name="q1_11" value="非常同意" id="q1_111"><label for="q1_111"><?= $this->_lang['q1_t_va'] ?></label>
    <input type="radio" name="q1_11" value="同意" id="q1_112"><label for="q1_112"><?= $this->_lang['q1_t_a'] ?></label>
    <input type="radio" name="q1_11" value="沒意見" id="q1_113"><label for="q1_113"><?= $this->_lang['q1_t_nc'] ?></label>
    <input type="radio" name="q1_11" value="不同意" id="q1_114"><label for="q1_114"><?= $this->_lang['q1_t_na'] ?></label>
    <input type="radio" name="q1_11" value="非常不同意" id="q1_115"><label for="q1_115"><?= $this->_lang['q1_t_vna'] ?></label><br>
    <?= $this->_lang['q1_ihea'] ?><br>
    <input type="radio" name="q1_12" value="非常同意" id="q1_121"><label for="q1_121"><?= $this->_lang['q1_t_va'] ?></label>
    <input type="radio" name="q1_12" value="同意" id="q1_122"><label for="q1_122"><?= $this->_lang['q1_t_a'] ?></label>
    <input type="radio" name="q1_12" value="沒意見" id="q1_123"><label for="q1_123"><?= $this->_lang['q1_t_nc'] ?></label>
    <input type="radio" name="q1_12" value="不同意" id="q1_124"><label for="q1_124"><?= $this->_lang['q1_t_na'] ?></label>
    <input type="radio" name="q1_12" value="非常不同意" id="q1_125"><label for="q1_125"><?= $this->_lang['q1_t_vna'] ?></label><br>

    <div class="col-xs-12 no-padding" style="margin-top:20px">
        <div class="col-xs-6 no-padding">
            <button type="button" class="btn btn-secondary cancel" style="width:120px;height:40px;float:left"><?= $this->_lang['cancel'] ?></button>
        </div>
        <div class="col-xs-6 no-padding">
            <button type="button" class="btn btn-success dosubmit" style="width:120px;height:40px;float:right"><?= $this->_lang['send'] ?></button>
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
  var  q4o = '無';
  var  q5o = '無';
  var  q6o = '無';
  var  q7o = '無';

  var is_ok=false;
  var is_ok61=true;
  var is_ok62=true;
  var is_ok63=true;
  var is_ok64=true;
  var is_ok65=true;

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
    var the_checkbox65 = document.getElementById("q1_65");
    if(the_checkbox65.checked){
      if(q3o.length<=2){
        is_ok65=false
      } else{
        is_ok65=true
      }
    }else{
      is_ok65=true
    }
    console.log(is_ok65);

  });

  $('[name="q1_7o"]').on('change', function(){
    q4o = $('[name="q1_7o"]').val();
    // console.log(q3o);
    var the_checkbox61 = document.getElementById("q1_61");
    if(the_checkbox61.checked){
      if(q4o.length<=2){
        is_ok61=false
      } else{
        is_ok61=true
      }
    }else{
      is_ok61=true
    }
    console.log(is_ok61);

  });
  $('[name="q1_8o"]').on('change', function(){
    q5o = $('[name="q1_8o"]').val();
    // console.log(q3o);
    var the_checkbox62 = document.getElementById("q1_62");
    if(the_checkbox62.checked){
      if(q5o.length<=2){
        is_ok62=false
      } else{
        is_ok62=true
      }
    }else{
      is_ok62=true
    }
    console.log(is_ok62);

  });
  $('[name="q1_9o"]').on('change', function(){
    q6o = $('[name="q1_9o"]').val();
    // console.log(q3o);
    var the_checkbox63 = document.getElementById("q1_63");
    if(the_checkbox63.checked){
      if(q6o.length<=2){
        is_ok63=false
      } else{
        is_ok63=true
      }
    }else{
      is_ok63=true
    }
    console.log(is_ok63);
  });
  $('[name="q1_10o"]').on('change', function(){
    q7o = $('[name="q1_10o"]').val();
    // console.log(q3o);
    var the_checkbox64 = document.getElementById("q1_64");
    if(the_checkbox64.checked){
      if(q7o.length<=2){
        is_ok64=false
      } else{
        is_ok64=true
      }
    }else{
      is_ok64=true
    }
    
    console.log(is_ok64);

  });

  $("input[name='q1_6']").on('change', function(){
    obj = document.getElementsByName("q1_6");
    q6 = [];
    for (i in obj) {
        if (obj[i].checked){
          q6.push(obj[i].value);
        }
    }
  });

  $('.cancel').click(function() {
    var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
    parent.layer.close(index);
  })
  $('.dosubmit').click(function() {
    if (q1!==null&&q2!==null&&q3!==null&&q4!==null&&q5!==null&&q6!==null&&
         q7!==null&&q8!==null&&q9!==null&&q10!==null&&q11!==null&&q12!==null){
          if(is_ok61&&is_ok62&&is_ok63&&is_ok64&&is_ok65){
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
                q3o : q4o,
                q3o : q5o,
                q3o : q6o,
                q3o : q7o,
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
            alert('請詳細填寫遭遇情況！');
          }
 
           
    } else{
      alert('請填寫完全部題目！');

    }
   
})
  $('.trash_btn').click(function() {
    $(this).closest('.itemp').remove();
  })
</script>
