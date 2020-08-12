<style>
.none {
	display: none;
}
.btn_1 {
    background-color: #FFD22F !important;
    color: #F57316 !important;
  }

.mask {
    position: absolute;
    top: 0;
    left: 0;
    width: 531px;
    height: 354px;
    background: rgba(101, 101, 101, 0.6);
    color: #ffffff;
    opacity: 0;
}

.mask h3 {
    text-align: center;
}

.img_div a:hover .mask {
    opacity: 1;           
}
</style>

<?php $this -> load -> view("mgmt/patent/patent_head")  ?>

    
        <div class="tab-content">
	<div class="tab-pane active" id="list_page">
		<!-- widget grid -->
        <section class="tab-pane padding-10 no-padding-bottom" id="s_template" style="padding: 17px 0px">
        <header>
            <div class="widget-toolbar pull-left">
                <div class="btn-group">
                    <button onclick="currentApp.doEdit(0)" class="btn dropdown-toggle btn-xs btn-success" data-toggle="dropdown">
                        <i class="fa fa-plus"></i>新增
                    </button>
                </div>
            </div>
        </header>
            <div class="col-sm-12">
                <div class="form-group">
                    <fieldset>
                        <div class="form-group">
                            <label for="" class="col-md-2 control-label">項目類別</label>
                            <div class="col-md-3">
                                <select id="fix_type" required class="form-control change-name">
                                    <option value="1">電腦</option>
                                    <option value="2">軟體</option>
                                    <option value="3">硬體</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select id="fix_type" required class="form-control change-name">
                                    <option value="1">電腦</option>
                                    <option value="2">軟體</option>
                                    <option value="3">硬體</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select id="fix_type" required class="form-control change-name">
                                    <option value="1">電腦</option>
                                    <option value="2">軟體</option>
                                    <option value="3">硬體</option>
                                </select>
                            </div>
                        </div>
                    </fieldset>	
                </div>
            </div>
            <div class="col-sm-12">
                <fieldset>
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">申請人</label>
                        <div class=" col-md-3">
                            <input class="form-control" id="h_s_name" placeholder="請輸入軟硬體名稱">
                        </div>
                        <label for="" class="col-md-2  control-label">申請號</label>
                        <div class=" col-md-3">
                            <input class="form-control" id="h_s_name" placeholder="請輸入軟硬體名稱">
                        </div>
                    </div>
                   
                </fieldset>	
            </div>
            <div class="col-sm-12">
                <fieldset>
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">發明人</label>
                        <div class=" col-md-3">
                            <input class="form-control" id="h_s_name" placeholder="請輸入軟硬體名稱">
                        </div>
                        <label for="" class="col-md-2  control-label">公開號</label>
                        <div class=" col-md-3">
                            <input class="form-control" id="h_s_name" placeholder="請輸入軟硬體名稱">
                        </div>
                    </div>
                   
                </fieldset>	
            </div>
            <div class="col-sm-12">
                <fieldset>
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">關鍵字</label>
                        <div class=" col-md-3">
                            <input class="form-control" id="keyword" placeholder="請輸入關鍵字">
                        </div>
                        <label for="" class="col-md-2  control-label">專利號</label>
                        <div class=" col-md-3">
                            <input class="form-control" id="h_s_name" placeholder="請輸入軟硬體名稱">
                        </div>
                    </div>
                </fieldset>	
            </div>
            <div class="col-sm-12">
                <fieldset>
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">摘要搜尋</label>
                        <div class=" col-md-3 " >
                            <input class="form-control" id="h_s_name" placeholder="請輸入軟硬體名稱">
                        </div>
                    </div>
                    <div class="col-sm-6 form-group pull-right">
                            <input type="radio" id="huey" name="drone" value="1">
                            <label for="huey">專利已核准</label>
                            <input type="radio" id="huey" name="drone" value="1">
                            <label for="huey">專利審查中</label>
                            <input type="radio" id="huey" name="drone" value="1">
                            <label for="huey">專利放棄/核駁審定</label>
                    </div>
                </fieldset>	
            </div>
            <hr>
            <div class="col-sm-12">
                <section class="koko-hot-product">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>搜尋結果:</h3>
                        </div>
                    </div>
                    <div class="owl-carousel owl-theme" id="patent_product">
                    </div>
                </section>
            </div>			
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
<script src="<?= base_url() ?>patent_vendor/ScrollToFixed-master/jquery-scrolltofixed.js"></script>
<script src="<?= base_url() ?>patent_vendor/OwlCarousel2-2.3.4/dist/owl.carousel.min.js"></script>
<script src="<?= base_url() ?>patent_vendor/mega-dropdown-master/js/jquery.menu-aim.js"></script>
<script src="<?= base_url() ?>patent_vendor/mega-dropdown-master/js/mega-dropdown.js"></script>
<script src="<?= base_url() ?>patent_vendor/fancybox/jquery.fancybox.min.js"></script>
<script src="<?= base_url() ?>patent_js/main.min.js"></script>

<script type="text/javascript">
var baseUrl = '<?= base_url(); ?>';

var data = {};

$(".dt_picker").datetimepicker({
    format : 'YYYY-MM-DD'
}).on('dp.change',function(event){

});

loadScript(baseUrl + "js/class/BaseAppClass.js", function(){
    loadScript(baseUrl + "js/app/patent/list.js", function(){
        currentApp = new patentAppClass(new BaseAppClass({}));
    });
});

var timeoutId = 0;

$('#keyword').keyup(function(){ 
	clearTimeout(timeoutId);
	var keyword = $('#keyword').val();
	if(keyword.length<1){
		return;
	}
	timeoutId = setTimeout(function () {
        data.keyword = $('#keyword').val();
        find_patent();
	}, 1000);
});

function find_patent(){
    	$.ajax({
			url: baseUrl + 'mgmt/patent/find_patent',
			type: 'POST',
			data: {
				data:data,
			},
			dataType: 'json',
			success: function(d) {
				if(d) {
                    // $('#patent_product').append('123');          
				    var _body = $("#patent_product").empty();

                    $.each(d.items, function() {
                        var me = this
                        $('<figure class="koko-card">'+
                           '<div class="box-up">'+
                                '<div class="img_div">'+
                                    '<img class="owl-lazy" data-src="'+ baseUrl+'api/images/get/'+me.img_id+'/thumb" alt="productnames">'+
                                    '<a href="#">'+
                                        '<div class="mask">'+
                                            '<h3>'+me.patent_name+'</h3>'+
                                        '</div>'+
                                    '</a>'+
                                '</div>'+
                                '<div class="info-inner">'+
                                    '<p class="p-name">'+me.patent_name+'</p>'+
                                '</div>'+
                           '</div>'+
                        '</figure>').appendTo(_body);
                    });
                    
                    $("#patent_product").owlCarousel({
                        stagePadding: 150,
                        margin: 20,
                        dots: true,
                        loop: false,
                        merge: true,
                        lazyLoad: true,
                        stagePadding:2,
                        responsive: {
                            0: {
                            items: 2
                            },
                            768: {
                            items: 3
                            },
                            992: {
                            items: 4
                            },
                            1046: {
                            items: 5
                            },
                            1200: {
                            items: 6
                            },
                            1400: {
                            items: 7
                            },
                            1600: {
                            items: 8
                            },
                        },
                    });
				}
			},
			failure:function(){
				alert('faialure');
			}
		});
}


  
</script>
