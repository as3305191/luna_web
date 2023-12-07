var QuestionTitleAppClass = (function(app) {
	app.basePath = "mgmt/question_title/";
	app.disableRowClick = false;

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
							url: baseUrl + app.basePath + '/up_lock',
							data: {
							  'id': me
							},
							error: function() {
							},
							dataType: 'json',
							success: function(data) {
								if(data.success_msg){
									$.smallBox({
										title: data.success_msg,
										content: "<i class='fa fa-clock-o'></i> <i>1 seconds ago...</i>",
										color: "#5F895F",
										iconSmall: "fa fa-check bounce animated",
										timeout: 4000
									});

									app.tableReload();
								}
								if(data.message){
									layer.msg(data.message);
								}
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
		app.mDtTable = $('#dt_list').DataTable($.extend(app.dtConfig,{
			ajax : {
				url : baseUrl + app.basePath + 'get_data',
				data : function(d) {
					// d.item_id = $('#item_id').val();
					// d.s_news_style = $('#s_news_style').val();
					return d;
				},
				dataSrc : 'items',
				dataType : 'json',
				type : 'post'
			},
			pageLength: 50,
			columns : [null, {
				data : 'swot_title'
			}, {
				data : 'create_time'
			}],
			ordering: false,
			order : [[2, "desc"]],
			columnDefs : [{
				targets : 0,
				data : null,
				render:function ( data, type, row ) {
					var input = '';
					if(row.is_lock < 1){
						input = '<input type="checkbox"  class="product-post onoffswitch-checkbox" checked id="'+row.id+'" >'
						var html = '<span class="onoffswitch" style="margin-top: 10px;">'
						+input
						+'<label class="onoffswitch-label" for="'+row.id+'">'
							+'<span class="onoffswitch-inner" data-swchon-text="編輯" data-swchoff-text="編輯"></span>'
							+'<span class="onoffswitch-switch"></span>'
						+'</label>'
					+'</span>';
					}else{
						input = '<input type="checkbox"  class="product-post onoffswitch-checkbox" id="'+row.id+'" >'
						var html = '<span class="onoffswitch" style="margin-top: 10px;">'
						+input
						+'<label class="onoffswitch-label" for="'+row.id+'">'
							+'<span class="onoffswitch-inner" data-swchon-text="編輯" data-swchoff-text="編輯"></span>'
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
				"targets" : 0,
				"orderable" : false
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
				url : baseUrl + app.basePath  + 'delete/' + app._delId,
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

			$('#edit-modal-body').load(baseUrl + 'mgmt/question_title/edit/' + id, function(){
	        	$("#btn-submit-edit").prop( "disabled", false);
	        	loading.remove();
			});
		};

		$('#s_news_style').on('change', function(){
			app.tableReload();
		});
	
		return app;
	};

	// return self
	return app.init();
});

var questioneachAppClass = (function(app) {
	app.basePath = "mgmt/swot_title/";
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
			// $(nRow).find("a").eq(0).click(function() {
			// 	app.setDelId(aData.id);
			// 	$('#modal_do_delete')
			// 	.prop('onclick',null)
			// 	.off('click')
			// 	.on('click', function(){
			// 		app.doDelItem();
			// 	});
			// });

			//img post
			$(nRow).find('.product-post').eq(0).click(function(){
				var me = $(this).attr('id');
				$.ajax({
					url: baseUrl + app.basePath + '/up_lock_swot_style',
					data: {
					  'swot_title_id': $('#swot_title_id').val(),
					  'swot_style_id': me
					},
					error: function() {
					},
					dataType: 'json',
					success: function(data) {
						if(data.success_msg){
							$.smallBox({
								title: data.success_msg,
								content: "<i class='fa fa-clock-o'></i> <i>1 seconds ago...</i>",
								color: "#5F895F",
								iconSmall: "fa fa-check bounce animated",
								timeout: 4000
							});

							app.tableReload();
						}
						if(data.message){
							layer.msg(data.message);
						}
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
		app.mDtTable = $('#swot_style_table').DataTable($.extend(app.dtConfig,{
			ajax : {
				url : baseUrl + app.basePath + '/swot_title_get_data',
				data : function(d) {
					d.swot_title_id = $('#swot_title_id').val();
					return d;
				},
				dataSrc : 'items',
				dataType : 'json',
				type : 'post'
			},

			pageLength: 50,

			columns : [null,
				{
					data : 'swot_name'
				}
		],
			ordering: false,
			order : [[0, "desc"]],
			columnDefs : [{
				targets : 0,
				data : null,
				render:function ( data, type, row ) {
					var input = '';
					if(row.now_is_lock < 1){
						input = '<input type="checkbox"  class="product-post onoffswitch-checkbox" checked id="'+row.id+'" >'
						var html = '<span class="onoffswitch" style="margin-top: 10px;">'
						+input
						+'<label class="onoffswitch-label" for="'+row.id+'">'
							+'<span class="onoffswitch-inner" data-swchon-text="編輯" data-swchoff-text="編輯"></span>'
							+'<span class="onoffswitch-switch"></span>'
						+'</label>'
					+'</span>';
					}else{
						input = '<input type="checkbox"  class="product-post onoffswitch-checkbox" id="'+row.id+'" >'
						var html = '<span class="onoffswitch" style="margin-top: 10px;">'
						+input
						+'<label class="onoffswitch-label" for="'+row.id+'">'
							+'<span class="onoffswitch-inner" data-swchon-text="編輯" data-swchoff-text="編輯"></span>'
							+'<span class="onoffswitch-switch"></span>'
						+'</label>'
					+'</span>';
					}
					return html;
		    },
				searchable : false,
				orderable : false,
				width : "8%",
				className: ''
			},{
				"targets" : [0,1],
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


		app.mDtTable.on( 'xhr', function () {
		    var json = app.mDtTable.ajax.json();
			
		});

		// get year month list
		app.tableReload();

		$('#s_bypass_101').on('change', function(){
			app.tableReload();
		});


		return app;
	};

	// return self
	return app.init();
});
