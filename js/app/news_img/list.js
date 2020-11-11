var NewsimgClass = (function(app) {
	app.basePath = "mgmt/news_img/";
	app.disableRowClick = true;

	app.fnRowCallback1 = function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
				// edit click
				if(!app.disableRowClick) {
					var _rtd = $(nRow).find('td');
					if(!app.enableFirstClickable) {
						_rtd = _rtd.not(':first')
					}
					_rtd.addClass('pointer').on('click', function(){
						app.doEdit(aData.id);

						// remove all highlight first
						$(this).parent().parent().find('tr').removeClass('active');

						app._lastPk = aData.id;
						app._tr = $(this).parent();
						setTimeout(function(){
							app._tr.addClass('active');
						}, 100);
					});
				}

				if(app._lastPk && aData.id && app._lastPk == aData.id) {
					$(nRow).addClass('active');
				}

					// delete click
					$(nRow).find("a").eq(0).click(function() {
						app.setDelId(aData.id);
						$('#modal_do_delete')
							.prop('onclick',null)
							.off('click')
							.on('click', function(){
								app.doDelItem();
							});
					});

					//img post
					$(nRow).find('.product-post').eq(0).click(function(){
						var me = $(this).attr('id');
						$.ajax({
							url: baseUrl + app.basePath + '/img_post',
							data: {
							  'img_id': me
							},
							error: function() {
							},
							dataType: 'json',
							success: function(data) {
							if(data.success){
								$.smallBox({
									title: data.success_msg,
									content: "<i class='fa fa-clock-o'></i> <i>1 seconds ago...</i>",
									color: "#5F895F",
									iconSmall: "fa fa-check bounce animated",
									timeout: 4000
								});

								$.ajax({
									url: baseUrl + 'carousel',
									data: {
									  'reload': 1
									},
									error: function() {
									},
									dataType: 'json',
									success: function(data) {
								
									},
									type: 'POST'
								})

							}
							if(data.message){
								layer.msg(data.message);
							}
							app.tableReload();
							},
							type: 'POST'
						})
					})

				if(app.fnRowCallbackExt) {
					app.fnRowCallbackExt(nRow, aData, iDisplayIndex, iDisplayIndexFull);
				}
		};

	app.dtConfig = {
		processing : true,
		serverSide : true,
		responsive : true,

		deferLoading : 0, // don't reload on init
		iDisplayLength : 10,
		sDom: app.sDom,
		language : {
			url : baseUrl + "js/datatables-lang/zh-TW.json"
		},
		bSortCellsTop : true,
		fnRowCallback : app.fnRowCallback1,
		footerCallback: function( tfoot, data, start, end, display ) {
			setTimeout(function(){ $(window).trigger('resize'); }, 300);
		}
	};


	app.init = function() {
		app.mDtTable = $('#pic_list').DataTable($.extend(app.dtConfig,{
			ajax : {
				url : baseUrl + app.basePath + 'get_data_image',
				data : function(d) {
					d.place_mark_id = $('#item_id').val();
					return d;
				},
				dataSrc : 'items',
				dataType : 'json',
				type : 'post'
			},

			pageLength: 50,

			columns : [null,{
				data : 'style_name'
			},{
				data : 'id',
				render: function (data) {
					if(data>0){
						return (data && data > 0 ? '<div class="img_con" style="width:150px;height:150px;background-image:url(' + baseUrl + 'api/images/get/' + data + '/thumb)" />' : "");
					} else{
						return '';
					}
		    	} 
			},{
				data : 'id',
				render: function (data) {
					if(data){
						return String(baseUrl + 'api/images/get/' + data + '/thumb');
					} else{
						return  '';

					}
				}
			},{
				data : 'upload_time'
			}],
			ordering: false,
			order : [[2, "desc"]],
			columnDefs : [{
				targets : 0,
				data : null,
				render:function ( data, type, row ) {
					var input = '';
					if(row.status == 1){
						input = '<input type="checkbox"  class="product-post onoffswitch-checkbox" checked id="'+row.id+'" >'
					}else{
						input = '<input type="checkbox"  class="product-post onoffswitch-checkbox" id="'+row.id+'" >'
					}

					if(row.status == 1){
						input = '<input type="checkbox"  class="product-post onoffswitch-checkbox" checked id="'+row.id+'" >'
						var html = '<span class="onoffswitch" style="margin-top: 10px;">'
						+input
						+'<label class="onoffswitch-label" for="'+row.id+'">'
							+'<span class="onoffswitch-inner" data-swchon-text="預設" data-swchoff-text="非預設"></span>'
							+'<span class="onoffswitch-switch"></span>'
						+'</label>'
					+'</span>';
					}else{
						input = '<input type="checkbox"  class="product-post onoffswitch-checkbox" id="'+row.id+'" >'
						var html = '<span class="onoffswitch" style="margin-top: 10px;">'
						+input
						+'<label class="onoffswitch-label" for="'+row.id+'">'
							+'<span class="onoffswitch-inner" data-swchon-text="預設" data-swchoff-text="非預設"></span>'
							+'<span class="onoffswitch-switch"></span>'
						+'</label>'
					+'</span>'
					+ '<a href="#deleteModal" role="button" data-toggle="modal" style="margin-left: 10px;"><i class="fa fa-trash fa-lg"></i></a>';
					}
					return html;
		    },
				searchable : false,
				orderable : false,
				width : "8%",
				className: ''
			}, {
				"targets" : 1,
				"orderable" : false
			}, {
				"targets" : 2,
				"orderable" : false
			}],

			footerCallback: function (row, data, start, end, display ) {
				var api = this.api();

			}



			
		}));

		// data table actions
		app.dtActions();

		function getCoVal(co, key) {
			if(co[key]) {
				return parseInt(co[key]);
			}
			return 0;
		}

		function setSpanVal(elId, val) {
			console.log("val: " + val);
			console.log("elId: " + elId);
			if(val > 0) {
	    		$('#' + elId).parent().find('span').show().text(val);
	    	} else {
	    		$('#' + elId).parent().find('span').hide();
	    	}
		}

		// get year month list
		app.tableReload();

	

		$('#status_filter > label > span').hide();

		// set pay status filter
		$('#pay_status_filter label').on('click', function(){
			$(this).find('input').prop('checked', true);
			app.tableReload();
		});
		$('#pay_status_filter > label > span').hide();



		app.doDelItem = function() {
			$.ajax({
				url : baseUrl + app.basePath  + 'delete_img/' + app._delId,
				success: function(d) {
					if(d.success){
						app.mDtTable.ajax.reload();
					}
					if(d.message){
						layer.msg(d.message);
					}
				},
				failure: function() {
					alert('Network Error...');
				}
			});
		};


		// edit
		app.doEdit = function(id) {
		    var loading = $('<h1 class="ajax-loading-animation"><i class="fa fa-cog fa-spin"></i> Loading...</h1>')
		    	.appendTo($('#edit-modal-body').empty());
		    $("#btn-submit-edit").prop( "disabled", true);

			$('.tab-pane').removeClass('active'); $('#edit_page').addClass('active');

			$('#edit-modal-body').load(baseUrl + 'mgmt/fish_table/edit/' + id, function(){
	        	$("#btn-submit-edit").prop( "disabled", false);
	        	loading.remove();
			});
		};



		return app;
	};

	// return self
	return app.init();
});
