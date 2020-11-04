
   <!-- CSS Unify Theme -->
   <link rel="stylesheet" href="<?= base_url() ?>assets_co/assets_/css/styles.multipage-real-estate.css">
  
<div class="tab-content">
	<div class="tab-pane active" id="list_page">

		<!-- widget grid -->
		<section id="widget-grid" class="">

			<!-- row -->
			<div class="row">

				<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget">
						<header>
						<input type="hidden" name="l_user_id" id="l_user_id" value="<?= isset($login_user->role_id) ? $login_user->role_id: '' ?>" />
							<?php if($login_user->role_id==52 ||$login_user->role_id==26): ?>
								<div class="widget-toolbar pull-left">
									<div class="btn-group">
										<button onclick="currentApp.doEdit(0)" class="btn btn-xs btn-success" data-toggle="dropdown">
											<i class="fa fa-plus"></i>新增
										</button>
									</div>
								</div>
							<?php endif?>
							<div class="widget-toolbar pull-left">
								<label>項目類別</label>
							</div>
							<input id="now_category" type="hidden"/>

							<div id="category">
							</div>
						
							<div class="widget-toolbar pull-left">
								<label>申請人</label>
							</div>
							<div class="widget-toolbar pull-left">
								<input id="application_person" ondragover="" autocomplete="off" type="text" class="form-control" />
							</div>
							<div class="widget-toolbar pull-left">
								<label>申請號</label>
							</div>
							<div class="widget-toolbar pull-left">
								<input id="application_num_search" type="text" class="form-control" autocomplete="off" />
							</div>
							<div class="widget-toolbar pull-left">
								<label>發明人</label>
							</div>
							<div class="widget-toolbar pull-left">
								<input id="invention_person_search" ondragover="" type="text" class="form-control" autocomplete="off"/>
							</div>
							<div class="widget-toolbar pull-left">
								<label>公開號</label>
							</div>
							<div class="widget-toolbar pull-left">
								<input id="public_num_search"  type="text" class="form-control" style="background:#FFFFFF" autocomplete="off"/>
							</div>
							<div class="widget-toolbar pull-left">
								<label>關鍵字</label>
							</div>
							<div class="widget-toolbar pull-left">
								<input id="key_search" type="text" class="form-control"autocomplete="off" />
                            </div>
                            <div class="widget-toolbar pull-left">
								<label>專利號</label>
                            </div>
                            <div class="widget-toolbar pull-left">
								<input id="patent_search" type="text" class="form-control"autocomplete="off" />
                            </div>

                            <div class="widget-toolbar pull-left" id="patent_status">
                                <div>
                                <?php foreach ($patent_status as $each) : ?>
                                    <label class="u-check g-pl-0">
                                        <input class="g-hidden-xs-up g-pos-abs g-top-0 g-left-0" name="patent_status[]" type="checkbox" value="<?= $each->id ?>">
                                        <span class="btn btn-md btn-block u-btn-outline-lightgray g-color-white--checked g-bg-primary--checked rounded-0"><?= $each->name ?></span>
                                    </label>
                                <?php endforeach ?>
                                </div>
                            </div>
						</header>

						<!-- widget div-->
						<div>

							<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->

							</div>
							<!-- end widget edit box -->

							<!-- widget content -->
							<div class="widget-body no-padding">

								<table id="dt_list" class="table table-striped table-bordered table-hover" width="100%">
									<thead>
										<tr>
											<th class="min25"></th>
											<th class="min100">專利名稱</th>
											<th class="min100">代表圖</th>
											<th class="min100">申請人</th>
											<th class="min100">發明人</th>
											<th class="min100">專利號</th>
											<th class="min100">公開號</th>
											<th class="min100">申請日</th>
											<th class="min100">公告日</th>
											<th class="min100">更新日</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
							<!-- end widget content -->

						</div>
						<!-- end widget div -->

					</div>
					<!-- end widget -->

				</article>
				<!-- WIDGET END -->

			</div>

			<!-- end row -->

		</section>
		<!-- end widget grid -->
	</div>

	<div class="tab-pane animated fadeIn" id="edit_page">
		<section class="">
			<!-- row -->
			<div class="row">
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="edit-modal-body">
									
				</article>
			</div>
		</section>
	</div>
</div>
<?php $this -> load -> view('general/delete_modal'); ?>
<script type="text/javascript">
	var baseUrl = '<?=base_url('')?>';
    var patent_status = $("input[name='patent_status[]']:checked").map(function() {
        return this.value
    }).get();

	var mCols = [null,{
		data : 'patent_name'
	}, {
		data : 'image',
		render: function(d,t,r){
			if(d>0){
				var html = '<img src="'+baseUrl+'api/images/get/'+d+'/thumb" style="max-height:200px;max-width:200px" >';
				return html;
			} else{
				return '';
			}
		}
		
	},{
		data : 'applicant'
	},{
		data : 'inventor'
	}, {
		data : 'patnet_num'
	}, {
		data : 'public_num'
	}, {
		data : 'application_date'
	}, {
		data : 'announcement_date'
	}, {
		data : 'update_date'
	}];

	var mOrderIdx = 5;

	if($('#l_user_id').val()=='52' || $('#l_user_id').val()=='26' ){
		var defaultContent = '<a href="#deleteModal" role="button" data-toggle="modal" style="margin-right: 5px;"><i class="fa fa-trash fa-lg"></i></a>';
	} else{
		var defaultContent = '<a role="button" data-toggle="modal" style="margin-right: 5px;" ><i class="fa fa-trash fa-lg"></i></a>';
	}

	var mColDefs = [{
		targets : 0,
		data : null,
		defaultContent : defaultContent,
		searchable : false,
		orderable : false,
		width : "5%",
		className : ''
	}, {
		"targets" : [0,1,2,3,4,5,6],
		"orderable" : false
	}];

	loadScript(baseUrl + "js/class/BaseAppClass.js", function(){
		loadScript(baseUrl + "js/app/patent/list.js", function(){
			currentApp = new patentAppClass(new BaseAppClass({}));
		});
	});
	var total_category=0;
	function load_category() {
		$.ajax({
				url: '<?= base_url() ?>' + 'mgmt/patent/find_all_category',
				type: 'POST',
				data: {},
				dataType: 'json',
				success: function(d) {
					if(d) {
						// console.log(d);
						$category = $('#category').empty();
						var i=0;
						var html='';
						total_category = d.max;
						for(i;i<=d.max;i++){
							html+='<div class="widget-toolbar pull-left">'+
									'<select id="category_'+i+'" class="p_category" data-val="'+i+'" >'+
									'</select>'+
								'</div>';
						}
						$(html).appendTo($category);
						var category_option = '<option value="all">全部</option>';
						var $category_0 = $('#category_0').empty();
						$category_0.append(category_option);
						$.each(d.category, function(){
							if(this.level==0){
								$('<option />', {
									'value': this.id,
									'text': this.name,
								}).appendTo($category_0);
							}
						});
					}
				},
				failure:function(){
					alert('faialure');
				}
		});

	}	
	load_category();
	
</script>
