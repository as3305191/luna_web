<style>
thead tr th {
	position:sticky;
	top:0;
	background-color:#FFFFFF !important;
	text-align:center;
}
</style>

<!-- CSS Unify Theme -->
<link rel="stylesheet" href="<?= base_url() ?>assets_co/assets_/css/styles.multipage-real-estate.css">
  
<div class="tab-content">
	
</div>
<!-- Station Serach Modal -->


<script type="text/javascript">
	var baseUrl = '<?=base_url('')?>';
	var mCols = [{
				targets : 0,
				data : 'status',
				render:function ( data, type, row ) {
					var input = '';
					var is_stop_html ='';
					if(row.status >0){//開放
						if(row.is_stop==0){//可以點
							is_stop_html  = '<button type="button" style="color:red;" class="btn btn-sm  pull-right" onclick="order_set('+row.id+')">暫停點餐</button>';
						} else{
							is_stop_html  = '<button type="button" style="color:green;" class="btn btn-sm  pull-right" onclick="order_set('+row.id+')">重啟點餐</button>';
						}
						input = '<input type="checkbox"  class="product-post onoffswitch-checkbox" checked id="'+row.id+'" >'
						var html = '<span class="onoffswitch" style="margin-top: 10px;">'
						+input
						+'<label class="onoffswitch-label" for="'+row.id+'">'
							+'<span class="onoffswitch-inner" data-swchon-text="開放" data-swchoff-text="開放"></span>'
							+'<span class="onoffswitch-switch"></span>'
						+'</label>'
					+'</span>'
					+is_stop_html
					+'<button type="button" class="btn btn-sm btn-primary pull-right" onclick="finish_menu('+row.id+')">完成</button>';
					}else{
						input = '<input type="checkbox"  class="product-post onoffswitch-checkbox" id="'+row.id+'" >'
						var html = '<span class="onoffswitch" style="margin-top: 10px;">'
						+input
						+'<label class="onoffswitch-label" for="'+row.id+'">'
							+'<span class="onoffswitch-inner" data-swchon-text="開放" data-swchoff-text="開放"></span>'
							+'<span class="onoffswitch-switch"></span>'
						+'</label>'
					+'</span>'
					+ '<a href="#deleteModal" role="button" data-toggle="modal" style="margin-left: 10px;"><i class="fa fa-trash fa-lg"></i></a>'
					+'<button type="button" class="btn btn-sm btn-primary pull-right" onclick="finish_menu('+row.id+')">完成</button>';
					}
					return html;
		    },
				searchable : false,
				orderable : false,
				width : "8%",
				className: ''
			},{
		data : 'style_name'
	},{
		data : 'menu_name',
		render:function ( data, type, row ) {
			var html ='';
			
			if(row.open_date!=='0000-00-00'){
				var weekarrary=["日","一","二","三","四","五","六"];
				var d = new Date(row.open_date);
				var month = '' + (d.getMonth() + 1);
				var day = '' + d.getDate();
				var weekday = d.getDay();
				html += month+'.'+day+' ('+weekarrary[weekday]+')'+' '+data;
			}  else{
				html += data;
			}
			if(row.open_dep!=='0'){
				html +='&nbsp;<i class="fa fa-lg fa-lock"></i>';
			}
			return html;

		}
	}];

	var mOrderIdx = 0;
	
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
		"targets" : [0,1,2],
		"orderable" : false
	}];

	loadScript(baseUrl + "js/class/BaseAppClass.js", function(){
		loadScript(baseUrl + "js/app/menu/list.js", function(){
			currentApp = new listmenuAppClass(new BaseAppClass({}));
			
		});
	});
	function order_set(id) {
		$.ajax({
			url: '<?= base_url() ?>' + 'mgmt/menu/order_set',
			type: 'POST',
			data: {
				id: id
			},
			dataType: 'json',
			success: function(d) {
					// console.log(d);
				currentApp.tableReload();
			},
			failure:function(){
				alert('faialure');
			}
		});
	}

	function finish_menu(id) {
		$.ajax({
			url: '<?= base_url() ?>' + 'mgmt/menu/finish_menu',
			type: 'POST',
			data: {
				id: id
			},
			dataType: 'json',
			success: function(d) {
					// console.log(d);
				currentApp.tableReload();
			},
			failure:function(){
				alert('faialure');
			}
		});
	}

	function load_menu_style() {
		$.ajax({
			url: '<?= base_url() ?>' + 'mgmt/menu/find_menu_style',
			type: 'POST',
			dataType: 'json',
			success: function(d) {
				if(d) {
					// console.log(d);
					$img_style = $('#s_menu_style').empty();
					var option = '<option value="0">全部</option>';
					$img_style.append(option);
					$.each(d.menu_style, function(){
						$('<option/>', {
							'value': this.id,
							'text': this.menu_style
						}).appendTo($img_style);
					});
				}
			},
			failure:function(){
				alert('faialure');
			}
		});
	}
load_menu_style();
$('#add_img_style').click(function() {
		layer.open({
			type:2,
			title:'',
			closeBtn:0,
			area:['400px','200px'],
			shadeClose:true,
			content:'<?=base_url('mgmt/menu/new_menu_style')?>'
		})
	})
</script>
