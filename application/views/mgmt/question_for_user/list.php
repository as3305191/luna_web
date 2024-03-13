<style>
  .s_sum {
  	display: none;
  }
  .menu_img_unsuccess {
  	display: none;
  }
  .hide_s_i {
  	display: none;
  }
</style>
<div>
<header>
<link rel="stylesheet" href="<?= base_url('assets/vendor/fancybox/jquery.fancybox.min.css'); ?>" />
<!-- <link rel="stylesheet" href="<?= base_url('assets/smoke.css'); ?>" /> -->
</header>
<div class="tab-content">

	
		<div class="row" style="padding:0px 0px 6px 12px;">

			<div class="col-md-12 col-xs-12 col-sm-12 " style="padding:0px 0px 6px 0px;">
				<span style="font-size: 16pt;color:#0d0d56">開放問卷</span>
			</div>
			<?php if(isset($question_option_id_list)): ?>
				<?php foreach ($question_option_id_list as $each) : ?>
					<button class="btn_active btn-success text-light  menu_btn menu_0" style="border-radius: 5px; padding: 10px; width: 220px; height: 48px;" onclick="q_click(<?= $each['question_style_id']?>,<?= $each['id'] ?>)"><?=$each['question_title']?></button>
				<?php endforeach ?>
			<?php endif?>
			<!-- <button class="btn_active btn-success text-light  menu_btn menu_0" style="border-radius: 5px; padding: 10px; width: 220px; height: 48px;" onclick="q_click(2,7)">問卷2</button>
			<button class="btn_active btn-success text-light  menu_btn menu_0" style="border-radius: 5px; padding: 10px; width: 220px; height: 48px;" onclick="q_click(3,8)">問卷3</button>
			<button class="btn_active btn-success text-light  menu_btn menu_0" style="border-radius: 5px; padding: 10px; width: 220px; height: 48px;" onclick="q_click(4,9)">問卷4</button>
			<button class="btn_active btn-success text-light  menu_btn menu_0" style="border-radius: 5px; padding: 10px; width: 220px; height: 48px;" onclick="q_click(5,10)">問卷5</button> -->

			<!-- <button class="btn-success text-light btn_active menu_1" style="border-radius: 5px; padding: 10px; width: 160px; height: 48px;" onclick="backStep1()">菜單1</button>
			<button class="btn-light text-light btn_unsuccess menu_3" style="border-radius: 5px; padding: 10px; width: 160px; height: 48px;">菜單3</button> -->
		</div>

				
</div>


<?php $this -> load -> view('general/delete_modal'); ?>

<script type="text/javascript">

	loadScript(baseUrl + "js/class/BaseAppClass.js", function(){
		loadScript(baseUrl + "js/app/question_for_user/list.js", function(){
			currentApp = new QuestionforuserAppClass(new BaseAppClass({}));
		});
	});


	function q_click(q_num,id) {
		switch (q_num) {
			case 1: {
				url = 'mgmt/question_for_user/show_que'+q_num+'?id='+id;
				layer.open({
					type:2,
					title:'',
					closeBtn:0,
					area:['800px','600px'],
					shadeClose:true,
					content:'<?=base_url()?>'+url
				})
				break; 
			}
			case 2: {
				url = 'mgmt/question_for_user/show_que'+q_num+'?id='+id;
				layer.open({
					type:2,
					title:'',
					closeBtn:0,
					area:['1000px','1800px'],
					shadeClose:true,
					content:'<?=base_url()?>'+url
				})
				break;
			}
			case 3: {
				url = 'mgmt/question_for_user/show_que'+q_num+'?id='+id;
				layer.open({
					type:2,
					title:'',
					closeBtn:0,
					area:['1000px','1800px'],
					shadeClose:true,
					content:'<?=base_url()?>'+url
				})
				break;
			}
			case 4: {
				url = 'mgmt/question_for_user/show_que'+q_num+'?id='+id;
				layer.open({
					type:2,
					title:'',
					closeBtn:0,
					area:['800px','1000px'],
					shadeClose:true,
					content:'<?=base_url()?>'+url
				})
				break;
			}
			case 5: {
				url = 'mgmt/question_for_user/show_que'+q_num+'?id='+id;
				layer.open({
					type:2,
					title:'',
					closeBtn:0,
					area:['600px','600px'],
					shadeClose:true,
					content:'<?=base_url()?>'+url
				})
				break;
			}
		}
	}

</script>
