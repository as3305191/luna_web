<?php $this->load->view('layout/head'); ?>
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
        <span style="font-size:12pt">暴力危害及風險評估之調查問卷</span>
    </div>
    <hr/>
    <input type="hidden" id="qid" value="<?= isset($qid) ? $qid : '' ?>" />
    第一部分、基本資料<br>
    一、個人概況： <br>
    1.工作型態：<br>
    <input type="radio" name="q1_1" value="辦公室人員" id="q1_11"><label for="q1_11">辦公室人員</label>
    <input type="radio" name="q1_1" value="現場人員" id="q1_12"><label for="q1_12">現場人員</label>
    <input type="radio" name="q1_1" value="外勤人員" id="q1_13"><label for="q1_13">外勤人員</label><br>
    <input type="radio" name="q1_1" value="其他" id="q1_14"><label for="q1_14">其他</label> <input name="q1_1o"><br>

    2.性別：
    <input type="radio" name="q1_2" value="男" id="q1_m"><label for="q1_m">男</label>
    <input type="radio" name="q1_2" value="女" id="q1_1fm"><label for="q1_1fm">女</label><br>
    二、工作年資：<br>
    1.工作型態：<br>
    <input type="radio" name="q1_3" value="未滿1年" id="q1_31"><label for="q1_31">未滿1年</label>
    <input type="radio" name="q1_3" value="1年-3年" id="q1_32"><label for="q1_32">1年-3年</label>
    <input type="radio" name="q1_3" value="3年-5年" id="q1_33"><label for="q1_33">3年-5年</label>
    <input type="radio" name="q1_3" value="5-10年" id="q1_34"><label for="q1_34">5-10年</label>
    <input type="radio" name="q1_3" value="10-15年" id="q1_35"><label for="q1_35">10-15年</label>
    <input type="radio" name="q1_3" value="15年以上" id="q1_36"><label for="q1_36">15年以上</label><br>
    2.平均每週工作時數:<br>
    <input type="radio" name="q1_4" value="42小時以下" id="q1_41"><label for="q1_41">42小時以下</label>
    <input type="radio" name="q1_4" value="43-48小時" id="q1_42"><label for="q1_42">43-48小時</label>
    <input type="radio" name="q1_4" value="49-54小時" id="q1_43"><label for="q1_43">49-54小時</label>
    <input type="radio" name="q1_4" value="55小時以上" id="q1_44"><label for="q1_44">55小時以上</label><br>
    三、工作形態：<br>
    <input type="radio" name="q1_5" value="正常班" id="q1_51"><label for="q1_51">正常班</label>
    <input type="radio" name="q1_5" value="需假日出勤" id="q1_52"><label for="q1_52">需假日出勤</label>
    <input type="radio" name="q1_5" value="需外勤" id="q1_53"><label for="q1_53">需外勤</label>
    <input type="radio" name="q1_5" value="需值班" id="q1_54"><label for="q1_54">需值班</label>
    說明：<input name="q1_5o"><br>
    四、在您的工作環境中，曾經遭遇下列的暴力攻擊情境？（可複選）<br>
    <input type="checkbox" name="q1_6" value="肢體暴力，如毆打、踢、推、捏、拉扯等" id="q1_61"><label for="q1_61">肢體暴力，如毆打、踢、推、捏、拉扯等</label>
    <input type="checkbox" name="q1_6" value="言語暴力，如辱罵、言語騷擾、冷嘲熱諷等" id="q1_62"><label for="q1_62">言語暴力，如辱罵、言語騷擾、冷嘲熱諷等</label>
    <input type="checkbox" name="q1_6" value="心理暴力，如威脅、恐嚇、歧視、排擠、騷擾等" id="q1_63"><label for="q1_63">心理暴力，如威脅、恐嚇、歧視、排擠、騷擾等</label>
    <input type="checkbox" name="q1_6" value="性騷擾，如不當的性暗示與行為" id="q1_64"><label for="q1_64">性騷擾，如不當的性暗示與行為</label>
    <input type="checkbox" name="q1_6" value="其他" id="q1_65"><label for="q1_65">其他</label> <input name="q1_6o">
    <input type="checkbox" name="q1_6" value="無" id="q1_66"><label for="q1_66">無</label><br>
    五、公司是否提供有關預防暴力攻擊之衛生教育訓練？<br>
    <input type="checkbox" name="q1_7" value="曾提供任何工作安全衛生教育訓練" id="q1_71"><label for="q1_71">曾提供任何工作安全衛生教育訓練（免勾其他選項）</label>
    <input type="checkbox" name="q1_7" value="人身安全之防範" id="q1_72"><label for="q1_72">人身安全之防範</label>
    <input type="checkbox" name="q1_7" value="防護用具之使用" id="q1_73"><label for="q1_73">防護用具之使用</label>
    <input type="checkbox" name="q1_7" value="危害通識教育訓練" id="q1_74"><label for="q1_74">危害通識教育訓練</label>
    <input type="checkbox" name="q1_7" value="法規教育" id="q1_75"><label for="q1_75">法規教育</label><br>
    第二部分、暴力預防認知現況<br>
    1.我清楚了解如何辨識職場發生的暴力危害<br>
    <input type="radio" name="q1_8" value="非常同意" id="q1_81"><label for="q1_81">非常同意</label>
    <input type="radio" name="q1_8" value="同意" id="q1_82"><label for="q1_82">同意</label>
    <input type="radio" name="q1_8" value="沒意見" id="q1_83"><label for="q1_83">沒意見</label>
    <input type="radio" name="q1_8" value="不同意" id="q1_84"><label for="q1_84">不同意</label>
    <input type="radio" name="q1_8" value="非常不同意" id="q1_85"><label for="q1_85">非常不同意</label><br>
    2.我清楚了解如何進行暴力危害的風險評估<br>
    <input type="radio" name="q1_9" value="非常同意" id="q1_91"><label for="q1_91">非常同意</label>
    <input type="radio" name="q1_9" value="同意" id="q1_92"><label for="q1_92">同意</label>
    <input type="radio" name="q1_9" value="沒意見" id="q1_93"><label for="q1_93">沒意見</label>
    <input type="radio" name="q1_9" value="不同意" id="q1_94"><label for="q1_94">不同意</label>
    <input type="radio" name="q1_9" value="非常不同意" id="q1_95"><label for="q1_95">非常不同意</label><br>
    3.我清楚了解如何避免或遠離暴力危害事件<br>
    <input type="radio" name="q1_10" value="非常同意" id="q1_101"><label for="q1_101">非常同意</label>
    <input type="radio" name="q1_10" value="同意" id="q1_102"><label for="q1_102">同意</label>
    <input type="radio" name="q1_10" value="沒意見" id="q1_103"><label for="q1_103">沒意見</label>
    <input type="radio" name="q1_10" value="不同意" id="q1_104"><label for="q1_104">不同意</label>
    <input type="radio" name="q1_10" value="非常不同意" id="q1_105"><label for="q1_105">非常不同意</label><br>
    4.我清楚了解暴力危害事件發生時如何尋求支援管道<br>
    <input type="radio" name="q1_11" value="非常同意" id="q1_111"><label for="q1_111">非常同意</label>
    <input type="radio" name="q1_11" value="同意" id="q1_112"><label for="q1_112">同意</label>
    <input type="radio" name="q1_11" value="沒意見" id="q1_113"><label for="q1_113">沒意見</label>
    <input type="radio" name="q1_11" value="不同意" id="q1_114"><label for="q1_114">不同意</label>
    <input type="radio" name="q1_11" value="非常不同意" id="q1_115"><label for="q1_115">非常不同意</label><br>
    5.我具備因應暴力危害事件的事務處理與執行能力<br>
    <input type="radio" name="q1_12" value="非常同意" id="q1_121"><label for="q1_121">非常同意</label>
    <input type="radio" name="q1_12" value="同意" id="q1_122"><label for="q1_122">同意</label>
    <input type="radio" name="q1_12" value="沒意見" id="q1_123"><label for="q1_123">沒意見</label>
    <input type="radio" name="q1_12" value="不同意" id="q1_124"><label for="q1_124">不同意</label>
    <input type="radio" name="q1_12" value="非常不同意" id="q1_125"><label for="q1_125">非常不同意</label><br>

    <div class="col-xs-12 no-padding" style="margin-top:20px">
        <div class="col-xs-6 no-padding">
            <button type="button" class="btn btn-secondary cancel" style="width:120px;height:40px;float:left">取消</button>
        </div>
        <div class="col-xs-6 no-padding">
            <button type="button" class="btn btn-success dosubmit" style="width:120px;height:40px;float:right">送出</button>
        </div>
    </div>
    <?php $this->load->view('layout/plugins'); ?>
    <script type="text/javascript">
	// date-picker

  $( document ).ready(function() {
    $('#name').focus();
  })
var q1_6_check_value = [];
var q1_7_check_value = [];
$("input[name='q1_6']").on('change', function(){
    q1_6_check_value = [''];
    obj = document.getElementsByName("q1_6_check_value");
    for (i in obj) {
        if (obj[i].checked){
          q1_6_check_value.push(obj[i].value);
        }
    }
  });
  $("input[name='q1_7']").on('change', function(){
    q1_7_check_value = [''];
    for (i in obj) {
      obj = document.getElementsByName("q1_7_check_value");
      if (obj[i].checked){
        q1_7_check_value.push(obj[i].value);
      }
    }
  });
  $('.cancel').click(function() {
    var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
    parent.layer.close(index);
  })
  $('.dosubmit').click(function() {
   
   $.ajax({
     url: '<?= base_url() ?>' + 'mgmt/question_for_user/save_q1',
     type: 'POST',
     data: {
       qid:$('#qid').val(),
       q1 : document.querySelector("input[name='q1_1']:checked").value,
       q2 : document.querySelector("input[name='q1_2']:checked").value,
       q3 : document.querySelector("input[name='q1_3']:checked").value,
       q4 : document.querySelector("input[name='q1_4']:checked").value,
       q5 : document.querySelector("input[name='q1_5']:checked").value,
       q6 : q1_6_check_value,
       q7 : q1_7_check_value,
       q8 : document.querySelector("input[name='q1_8']:checked").value,
       q9 : document.querySelector("input[name='q1_9']:checked").value,
       q10 : document.querySelector("input[name='q1_10']:checked").value,
       q11 : document.querySelector("input[name='q1_11']:checked").value,
       q12 : document.querySelector("input[name='q1_12']:checked").value,
       q1o : document.querySelector("input[name='q1_1o']").value,
       q2o: document.querySelector("input[name='q1_5o']").value,
       q3o : document.querySelector("input[name='q1_6o']").value,

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
})
  $('.trash_btn').click(function() {
    $(this).closest('.itemp').remove();
  })
</script>
