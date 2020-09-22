
   <!-- CSS Unify Theme -->
   <link rel="stylesheet" href="<?= base_url() ?>assets/assets_/css/styles.multipage-real-estate.css">
   <link rel="stylesheet" href="<?= base_url() ?>assets/css/unify-core.css">
   <link rel="stylesheet" href="<?= base_url() ?>assets/css/unify-components.css">
   <link rel="stylesheet" href="<?= base_url() ?>assets/css/unify-globals.css">
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
							<div class="widget-toolbar pull-left">
								<div class="btn-group">
									<button onclick="currentApp.doEdit(0)" class="btn dropdown-toggle btn-xs btn-success" data-toggle="dropdown">
										<i class="fa fa-plus"></i>新增
									</button>
								</div>
							</div>
                            <!-- <div class="widget-toolbar pull-left">
								<label>範圍查詢 <input id="s_multiple" type="checkbox" class="" value="" /></label>
							</div>
							<div class="widget-toolbar pull-left">
								<input id="s_dt" placeholder="請輸入日期" type="text" class="dt_picker" value="<?= date('Y-m-d') ?>" />
							</div>
							<div class="widget-toolbar pull-left" disabled>
								~ <input id="e_dt" disabled placeholder="請輸入日期" type="text" class="dt_picker" value="<?= date('Y-m-d') ?>" />
							</div> -->
							<div class="widget-toolbar pull-left">
								<label>項目類別</label>
							</div>
							<div class="widget-toolbar pull-left">
								<select name="" id="1" class="">
									<option value="0">原料</option>
									<option value="2">成品</option>
								</select>
							</div>
                            <div class="widget-toolbar pull-left">
								<select name="" id="2" class="">
									<option value="0">原料</option>
									<option value="2">成品</option>
								</select>
                            </div>
                            <div class="widget-toolbar pull-left">
								<select name="" id="3" class="">
									<option value="0">原料</option>
									<option value="2">成品</option>
								</select>
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
								<input id="application_num" type="text" class="form-control" autocomplete="off" />
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
								<input id="public_num_search"  type="text" class="form-control" style="background:#FFFFFF" value="" readonly/>
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
                            <div class="widget-toolbar pull-left">
								<label>摘要搜尋</label>
							</div>
							<div class="widget-toolbar pull-left">
								<input id="summary_search" type="text" class="form-control"autocomplete="off" />
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
											<th class="min100">id</th>
											<th class="min100">plant</th>
											<th class="min100">sloc</th>
											<th class="min100">desc</th>
											<th class="min100">is_show</th>
										</tr>
										<tr class="search_box">
									    <th></th>
									    <th><input class="form-control input-xs min100" type="text" /></th>
									    <th><input class="form-control input-xs min100" type="text" /></th>
									    <th><input class="form-control input-xs min100" type="text" /></th>
									    <th><input class="form-control input-xs min100" type="text" /></th>
									    <th></th>
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
    var patent_status = $("input[name='patent_status[]']:checked").map(function() {
        return this.value
    }).get();

	var mCols = [null, {
		data : 'id'
	}, {
		data : 'plant'
	}, {
		data : 'sloc'
	}, {
		data : 'desc',
		render: function(d,t,r) {
			return d + " / " + r.reward_foreign;
		}
	}, {
		data : 'is_show'
	}];

	var mOrderIdx = 5;

	var defaultContent = '<a href="#deleteModal" role="button" data-toggle="modal" style="margin-right: 5px;"><i class="fa fa-trash fa-lg"></i></a>';

	var mColDefs = [{
		targets : 0,
		data : null,
		defaultContent : defaultContent,
		searchable : false,
		orderable : false,
		width : "5%",
		className : ''
	}, {
		"targets" : [1,2,3,4],
		"orderable" : false
	}];

	loadScript(baseUrl + "js/class/BaseAppClass.js", function(){
		loadScript(baseUrl + "js/app/patent/list.js", function(){
			currentApp = new patentAppClass(new BaseAppClass({}));
		});
	});
</script>
