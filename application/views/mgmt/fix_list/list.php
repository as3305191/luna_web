<style>
.none {
	display: none;
}
.btn_1 {
    background-color: #FFD22F !important;
    color: #F57316 !important;
  }
.s_h_information{
    background: #ccc;
}
.s_h_i:hover .s_h_information{
    background: #aaa;
}
</style>
        <section class="tab-pane padding-10 no-padding-bottom" id="s_template" style="padding: 17px 0px">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="" class="control-label">維修種類</label>
                    <div class="input-group col-md-6">
                        <select id="fix_type" required class="form-control change-name">
                            <option value="1">電腦</option>
                            <option value="2">軟體</option>
                            <option value="3">硬體</option>

                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="" class="control-label">軟硬體名稱</label>
                    <div class="input-group col-md-6">
                        <input class="form-control" id="h_s_name" placeholder="請輸入軟硬體名稱">
                    </div>
                </div>
            </div>
			<div class="col-sm-12">
                <div class="form-group">
                    <label for="" class="control-label">軟硬體搜尋結果:</label>
                    <div class="input-group col-md-12" id="s_h_search_result">
                    </div>
                </div>
            </div>
            <hr>
            <div class="col-sm-12" style="padding-bottom: 10px;">
                <div class="col-md-4" style="float:left;"> 
                    <label for="" class="control-label">維修電腦:</label>
                    <input class="form-control" id="n_fix_computer" style="border:0;" readonly>
                </div>
                <div class="col-md-4" style="float:right;">
                    <label for="" class="control-label">序號:</label>
                    <input class="form-control" id="n_num" style="border:0;" readonly>
                </div>
            </div>

            <div class="col-sm-12" style="padding-bottom: 10px;">
                <div>
				<div class="form-group">
                    <label for="" class="control-label">維修方式</label>
                    <div class="input-group col-md-3">
                        <select id="fix_way" class="form-control change-name">
							<option value="fix">維修軟硬體</option>
                            <option value="change">更換軟硬體</option>
                            <option value="add">新增軟應體</option>
                        </select>
                    </div>
                </div>
                    <div class="card-body">
                        <div class="product-list">
                            <table class="table table-bordered fix">
                                <thead>
                                    <tr>
                                        <th>維修日期</th>
                                        <th>故障原因</th>
                                        <th>處置情形</th>
                                        <th>維修人員</th>
										<th></th>
                                    </tr>
									<tr>
										<td class="min150" style="border-right:none;">
                                            <div class="input-group col-md-12">
                                                <input type="text" class="form-control dt_picker" id="fix_date" placeholder="請選擇日期">
                                            </div>
                                        </td>
										<td style="border-right:none;">
                                            <div class="input-group col-md-12">
                                                <input type="text" class="form-control" id="fix_reason" placeholder="請輸入故障原因">
                                            </div>
                                        </td>
										<td style="border-right:none;">
                                            <div class="input-group col-md-12">
                                                <input type="text" class="form-control" id="fix_way_" placeholder="如果未修復，修復後請至維修紀錄中修改">
                                            </div>
                                        </td>
										<td class="min120" style="border-right:none;">
                                            <div class="input-group col-md-12">
                                                 <select id="fix_user" class="form-control">
                                                    <option selected disabled style="display:none">請選擇</option>
                                                    <?php foreach($engineer as $each): ?>
                                                        <option value="<?= $each -> id?>"><?=  $each -> user_name ?></option>
                                                    <?php endforeach ?>
                                                </select> 
                                            </div>
                                        </td>
										<td style="border-right:none;">
											<button type="button" class="btn btn-sm btn-primary" onclick="add_fix()"><i class="fa fa-plus-circle fa-lg"></i></button>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                </tbody>
                            </table>

							<table class="table table-bordered change none" >
                                <thead>
                                    <tr>
                                        <th>更換日期</th>
                                        <th>舊的軟硬體</th>
                                        <th>新的軟硬體</th>
                                        <th>故障原因</th>
                                        <th>處置情形</th>
                                        <th>維修人員</th>
										<th></th>
                                    </tr>
									<tr>
										<td class="min150 " style="border-right:none;">
                                            <div class="input-group col-md-12">
                                                <input type="text" class="form-control dt_picker" id="change_date" placeholder="請選擇日期">
                                            </div>
                                        </td>
										<td style="border-right:none;">
                                            <div class="input-group col-md-12">
                                                <select class="form-control" id="old_sh" onchange="new_sh_change()">
                                                    <option selected disabled style="display:none">目前沒有軟硬體</option>
                                                </select>
                                            </div>
                                        </td>
										<td style="border-right:none;">
                                            <div class="input-group col-md-12" id="new_sh_div">
                                                <select class="form-control" id="new_sh">
                                                 <option selected disabled style="display:none">目前沒有新的軟硬體</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td style="border-right:none;">
                                            <div class="input-group col-md-12">
                                                <input type="text" class="form-control" id="change_reason" placeholder="請輸入故障原因">
                                            </div>
                                        </td>
										<td style="border-right:none;">
                                            <div class="input-group col-md-12">
                                                <input type="text" class="form-control" id="change_way" placeholder="請輸入處置情況">
                                            </div>
                                        </td>
										<td class="min120" style="border-right:none;">
                                            <div class="input-group col-md-12">
                                                <select id="change_user" class="form-control">
                                                    <option selected disabled style="display:none">請選擇</option>
                                                    <?php foreach($engineer as $each): ?>
                                                        <option value="<?= $each -> id?>"><?=  $each -> user_name ?></option>
                                                    <?php endforeach ?>
                                                </select>   
                                            </div>
                                        </td>
										<td style="border-right:none;">
											<button type="button" class="btn btn-sm btn-primary" onclick="add_fix()"><i class="fa fa-plus-circle fa-lg"></i></button>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                </tbody>
                            </table>

							<table class="table table-bordered add none" >
                                <thead>
                                    <tr>
                                        <th>新增日期</th>
                                        <th>新增軟硬體</th>
                                        <th>故障原因</th>
                                        <th>處置情形</th>
                                        <th>維修人員</th>
										<th></th>
                                    </tr>
									<tr>
										<td class="min150" style="border-right:none;">
                                            <div class="input-group col-md-12">
                                                <input type="text" class="form-control dt_picker" id="add_date" placeholder="請選擇日期">
                                            </div>
                                        </td>
                                        <td style="border-right:none;">
                                            <select class="form-control" id="add_sh" >
                                                <?php if(!empty($soft_list) || !empty($hard_list)): ?>
                                                    <option selected disabled style="display:none">請選擇</option>
                                                    <?php foreach($soft_list as $each): ?>
                                                        <option value="asoft_<?= $each -> id?>"><?=  $each -> computer_soft_name ?></option>
                                                    <?php endforeach ?>
                                                    <?php foreach($hard_list as $each): ?>
                                                        <option value="ahard_<?= $each -> id?>"><?=  $each -> computer_hard_name ?></option>
                                                    <?php endforeach ?>
                                                <?php else: ?>
                                                    <option selected disabled style="display:none">目前沒有軟硬體</option>
                                                <?php endif ?>

                                             
                                            </select>
                                        </td>
                                        <td style="border-right:none;">
                                            <div class="input-group col-md-12">
                                                <input type="text" class="form-control" id="add_reason" placeholder="請輸入故障原因">
                                            </div>
                                        </td>
										<td style="border-right:none;">
                                            <div class="input-group col-md-12">
                                                <input type="text" class="form-control" id="add_way" placeholder="請輸入處置情況">
                                            </div>
                                        </td>
										<td class="min120" style="border-right:none;">
                                            <div class="input-group col-md-12">
                                                <select id="add_user" class="form-control">
                                                    <option selected disabled style="display:none">請選擇</option>
                                                    <?php foreach($engineer as $each): ?>
                                                        <option value="<?= $each -> id?>"><?=  $each -> user_name ?></option>
                                                    <?php endforeach ?>
                                                </select>                                     
                                            </div>
                                        </td>
										<td style="border-right:none;">
											<button type="button" class="btn btn-sm btn-primary" onclick="add_fix()"><i class="fa fa-plus-circle fa-lg"></i></button>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                </tbody>
                            </table>

                        </div>
                    </div>
				
				</div>
			
            </div>
			</hr>
			<div class="col-sm-12">
                <div class="form-group">
                    <label for="" class="control-label">目前新增維修紀錄</label>
                    <div class="input-group col-md-12" id="now_fix">
                    </div>
                </div>
            </div>
			<div class="col-md-12" style="margin-top:10px">
				<button onclick="currentApp.doSubmit()"  style="float:right;border-radius:5px;background-color:#45BA71;border-color:#308F57;font-size:14px;padding:10px" class="btn btn-success">
					確定新增
				</button>
			</div> 
			
        </section>
    
       

<?php $this -> load -> view('general/delete_modal'); ?>
<script type="text/javascript">
$(".dt_picker").datetimepicker({
	format : 'YYYY-MM-DD'
}).on('dp.change',function(event){

});

$('#fix_way').on('change', function(){
	if($('#fix_way').val()=='fix'){
		$('.fix').removeClass('none');
		$('.change').addClass('none');
		$('.add').addClass('none');

	}
	if($('#fix_way').val()=='change'){
		$('.change').removeClass('none');
		$('.fix').addClass('none');
		$('.add').addClass('none');
	}
	if($('#fix_way').val()=='add'){
		$('.add').removeClass('none');
		$('.fix').addClass('none');
		$('.change').addClass('none');
	}
});
var now_computer_id = [];
var timeoutId = 0;
$('#h_s_name').keyup(function(){ 
	clearTimeout(timeoutId);
	var h_s_name = $('#h_s_name').val();
	if(h_s_name.length<1){
		return;
	}
    now_computer_id = [];
	timeoutId = setTimeout(function () {
		$.ajax({
			url: baseUrl + 'mgmt/fix_list/find_now_s_h_list',
			type: 'POST',
			data: {
				fix_type: $('#fix_type').val(),
				h_s_name: $('#h_s_name').val()
			},
			dataType: 'json',
			success: function(d) {
				if(d) {
					$('#s_h_search_result').empty();
                    $('#n_fix_computer').val('');
                    $('#n_num').val('');
					var $s_array_list = '';
					var $h_array_list = '';
					if(d.fix_type=='1'){//電腦維修
						$.each(d.fix_list, function(){
							var me = this;
							$.each(me.h_array, function(){
								var me_h = this;
								// console.log(me_h);
								$h_array_list += '<div style="padding: 0px 15px"><span">名稱:'+me_h.computer_hard_name+'  序號:'+me_h.computer_num+'</span></div></br>';
							});
							$.each(me.s_array, function(){
								var me_s = this;
								$s_array_list += '<div style="padding: 0px 15px"><span">名稱:'+me_s.computer_soft_name+'  序號:'+me_s.computer_num+'</span></div></br>';
							});
							var $now_s_h_list = $('<div class="col-sm-12" onclick="draw_now_computer('+me.id+','+d.fix_type+');" style="border-width:3px;border-style:double;border-color:#FFAC55;padding:5px;"><div class="col-sm-6"><span computer_id="'+me.id+'"></br>電腦名稱: '+me.computer_name+'  </br>電腦序號: '+me.computer_num+'  </br>電腦使用者: '+me.computer_property_num+'</span></div><div class="col-sm-6" style="float:right;">擁有硬體: '+$h_array_list+'擁有軟體: '+$s_array_list+'</div></div></hr>').appendTo($('#s_h_search_result'));
                            $now_s_h_list.hover(function(){
                             $(this).css("background-color", "yellow");
                            }, function(){
                              $(this).css("background-color", "#ccc");
                            })
                        });
					}
				}
			},
			failure:function(){
				alert('faialure');
			}
		});
	}, 1000);
});
var  now_sh_list = [];
function draw_now_computer($now_s_h_id,fix_type){
    $('#s_h_search_result').empty();
    $('#n_fix_computer').val('');
    $('#n_num').val('');
    now_sh_list = [];
    $.ajax({
			url: baseUrl + 'mgmt/fix_list/find_this_computer',
			type: 'POST',
			data: {
				now_s_h_id:$now_s_h_id,
                fix_type:fix_type
			},
			dataType: 'json',
			success: function(d) {
				if(d) {
                    if(d.fix_type==1) {
                        $('#n_fix_computer').val(d.now_s_h_list.computer.computer_name);
                        $('#n_num').val(d.now_s_h_list.computer.computer_num);
                        now_sh_list.push({
                            fix_type: d.fix_type,
                            computer_id: d.now_s_h_list.computer.id
                        });

                        $('#old_sh').empty();
                        console.log(now_sh_list);
                        var html = '<option selected disabled style="display:none">請選擇</option>';
                         $(html).appendTo($('#old_sh'));
                        $.each(d.now_s_h_list.s_array, function(){
                            $('<option />', {
                                'value': 'soft_'+this.id,
                                'text': this.computer_soft_name,
                            }).appendTo($('#old_sh'));
                        });
                        $.each(d.now_s_h_list.h_array, function(){
                            $('<option />', {
                                'value': 'hard_'+this.id,
                                'text': this.computer_hard_name,
                            }).appendTo($('#old_sh'));
                        });
                    }
				}
			},
			failure:function(){
				alert('faialure');
			}
		});
}

function new_sh_change(){
    var old_sh = $('#old_sh').val();
    var oldArray = new Array();
    var oldArray = old_sh.split("_");

  
    $('#new_sh').empty();
    // console.log(NewArray);
    $.ajax({
        url: '<?= base_url() ?>' + 'mgmt/fix_list/find_h_or_s',
        type: 'POST',
        data: {
            type: oldArray[0],
            s_h_id: oldArray[1],
        },
        dataType: 'json',
        success: function(d) {
            if(d) {
                if(!d.msg){
                    if(d.type=='hard') {
                       
                        $.each(d.s_h_list, function(){
                            $('<option/>', {
                                'value': this.id,
                                'text': this.computer_hard_name
                            }).appendTo($('#new_sh'));
                        });
                    }
                    if(d.type=='soft') {
                        $.each(d.s_h_list, function(){
                            $('<option/>', {
                                'value': this.id,
                                'text': this.computer_soft_name
                            }).appendTo($('#new_sh'));
                        });
                    }  
                } 
               
            }
        },
        failure:function(){
            alert('faialure');
        }
    });
  }

  function add_fix(){//按下+按鈕時新增畫面以及寫入資料庫
    var fix_date = $('#fix_date').val();
    var fix_reason = $('#fix_reason').val();
    var fix_way = $('#fix_way_').val();
    var fix_user = $('#fix_user').val();

    var change_date = $('#change_date').val();
    var old_sh = $('#old_sh').val();
    var new_sh = $('#new_sh').val();
    var change_reason = $('#change_reason').val();
    var change_way = $('#change_way').val();
    var change_user = $('#change_user').val();

    var add_date = $('#add_date').val();
    var add_sh = $('#add_sh').val();
    var add_reason = $('#add_reason').val();
    var add_way = $('#add_way').val();
    var add_user = $('#add_user').val();

    var oldArray = new Array();
    var oldArray = old_sh.split("_");
    

    if($('#fix_way').val()=='fix'){
        $('#change_date').empty();
        $('#old_sh').empty();
        $('#new_sh').empty();
        $('#change_reason').empty();
        $('#change_way').empty();
        $('#change_user').empty();

        $('#add_date').empty();
        $('#add_sh').empty();
        $('#add_reason').empty();
        $('#add_way').empty();
        $('#add_user').empty();

        $.ajax({
            url: '<?= base_url() ?>' + 'mgmt/fix_list/fix_record_insert',
            type: 'POST',
            data: {
                fix_type: $('#fix_type').val(),
                fix_way: $('#fix_way').val(),
                fix_reason: fix_reason,//維修原因
                fix_way: fix_way,//處置方式
                fix_user: fix_user,//維修的人
                fix_date: fix_date,
                computer_id: now_sh_list[0]['computer_id'],

            },
            dataType: 'json',
            success: function(d) {
                if(d) {
                    var $now_fix_list = $('<div class="col-sm-12" style="border-width:3px;border-style:double;border-color:#ccc;padding:5px;"><div class="col-sm-6"><span fix_id="">  維修原因:  '+fix_reason+'  處置情形:  '+fix_way+'  維修者:  '+fix_user+'</span></div></div></hr>').appendTo($('#now_fix'));
                }
            },
            failure:function(){
                alert('faialure');
            }
        });

    }

    if($('#fix_way').val()=='change'){
        $('#fix_date').empty();
        $('#fix_reason').empty();
        $('#fix_way_').empty();
        $('#fix_user').empty();

        $('#add_date').empty();
        $('#add_sh').empty();
        $('#add_reason').empty();
        $('#add_way').empty();
        $('#add_user').empty();
     
        $.ajax({
            url: '<?= base_url() ?>' + 'mgmt/fix_list/fix_record_insert',
            type: 'POST',
            data: {
                fix_type: $('#fix_type').val(),
                fix_way: $('#fix_way').val(),
                s_h_type: oldArray[0],//硬體or軟體
                s_h_id: oldArray[1],
                new_sh: new_sh,//新的
                computer_id: now_sh_list[0]['computer_id'],
                change_reason: change_reason,//更換原因
                change_way: change_way,//處置方式
                change_user: change_user,//更換的人
                change_date: change_date,
            },
            dataType: 'json',
            success: function(d) {
                if(d) {
                    var $now_change_list = $('<div class="col-sm-12" style="border-width:3px;border-style:double;border-color:#ccc;padding:5px;"><div class="col-sm-6"><span change_id="'+d.last_id+'">舊有軟硬體:  '+old_sh+'   換成: '+new_sh+'  更換原因:  '+change_reason+'  處置情形:  '+change_way+'  維修者:  '+change_user+'</span></div></div></hr>').appendTo($('#now_fix'));
                }
            },
            failure:function(){
                alert('faialure');
            }
        });
    }

    if($('#fix_way').val()=='add'){
        $('#fix_date').empty();
        $('#fix_reason').empty();
        $('#fix_way_').empty();
        $('#fix_user').empty();

        $('#change_date').empty();
        $('#old_sh').empty();
        $('#new_sh').empty();
        $('#change_reason').empty();
        $('#change_way').empty();
        $('#change_user').empty();
        var newArray = new Array();
        var newArray = add_sh.split("_");
        $.ajax({
            url: '<?= base_url() ?>' + 'mgmt/fix_list/fix_record_insert',
            type: 'POST',
            data: {
                fix_type: $('#fix_type').val(),
                fix_way: $('#fix_way').val(),
                s_h_type: newArray[0],//硬體or軟體
                s_h_id: newArray[1],
                add_reason: add_reason,//新增原因
                add_way: add_way,//處置方式
                add_user: add_user,//新增的人
                add_date: add_date,
                computer_id: now_sh_list[0]['computer_id'],

            },
            dataType: 'json',
            success: function(d) {
                if(d) {
                    var $now_add_list = $('<div class="col-sm-12" style="border-width:3px;border-style:double;border-color:#ccc;padding:5px;"><div class="col-sm-6"><span add_id="">  新增軟硬體: '+add_sh+'  新增原因:  '+add_reason+'  處置情形:  '+add_way+'  維修者:  '+add_user+'</span></div></div></hr>').appendTo($('#now_fix'));
                }
            },
            failure:function(){
                alert('faialure');
            }
        });
    }   
  }

</script>
