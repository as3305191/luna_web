var QuestionoptionAppClass = (function(app) {
	app.basePath = "mgmt/question_option/";
	app.disableRowClick = false;

	app.fnRowCallback1 = function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
				// edit click
				if(!app.disableRowClick) {
					var _rtd = $(nRow).find('td');
					if(!app.enableFirstClickable) {
						_rtd = _rtd.not(':first').not(':last')
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
							url: baseUrl + app.basePath + '/up_lock_question_list',
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
				data : 'question_style_name',
				render: function(d,t,r) {
					if(r.note){
						return d+'-'+r.note;
					} else{
						return d;
					}
				}
			}, {
				data : 'create_time'
			}, {
				data : 'id',
				render: function(d,t,r) {
					if(d){
						return '<button onclick="currentApp.doExportAll('+d+')" class="btn btn-xs btn-warning" data-toggle="dropdown">'
								+'<i class="fa fa-save"></i>匯出'
								+'</button>';
					} else{
						return d;
					}
				}
			}],
			ordering: false,
			order : [[2, "desc"]],
			columnDefs : [{
				targets : 0,
				data : null,
				render:function ( data, type, row ) {
					var input = '';
					if(row.is_close<1){
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

		app.doExportAll = function(id) {
			var loading = $('<h1 class="ajax-loading-animation"><i class="fa fa-cog fa-spin"></i> Loading...</h1>')
				.appendTo($('#export-modal-body').empty());
			$("#btn-submit-export").prop( "disabled", true);

			$('.tab-pane').removeClass('active'); 
			$('#export_page').addClass('active');
			$('#export-modal-body').load(baseUrl + 'mgmt/question_option/export/' + id, function(){
	        	$("#btn-submit-export").prop( "disabled", false);
	        	loading.remove();
			});
			// console.log(id);
		}

		// edit
		app.doEdit = function(id) {
		    var loading = $('<h1 class="ajax-loading-animation"><i class="fa fa-cog fa-spin"></i> Loading...</h1>')
		    	.appendTo($('#edit-modal-body').empty());
		    $("#btn-submit-edit").prop( "disabled", true);

			$('.tab-pane').removeClass('active'); $('#edit_page').addClass('active');

			$('#edit-modal-body').load(baseUrl + 'mgmt/question_option/edit/' + id, function(){
	        	$("#btn-submit-edit").prop( "disabled", false);
	        	loading.remove();
			});
		};

		
	
		return app;
	};

	// return self
	return app.init();
});

var QuestioneachdetailAppClass = (function(app) {
	app.basePath = "mgmt/question_option/";
	app.disableRowClick = true;
	app.fnRowCallback1 = function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
				// edit click
				if(!app.disableRowClick) {
					var _rtd = $(nRow).find('td');
					if(!app.enableFirstClickable) {
						_rtd = _rtd.not(':first').not(':last')
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

				$(nRow).find("a").eq(0).click(function() {
					app.setDelId(aData.id);
					$('#modal_do_delete')
					.prop('onclick',null)
					.off('click')
					.on('click', function(){
						app.doDelItem();
					});
				});

				if(app._lastPk && aData.id && app._lastPk == aData.id) {
					$(nRow).addClass('active');
				}

			

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
		app.mDtTable = $('#dt_list_each_detail').DataTable($.extend(app.dtConfig,{
			ajax : {
				url : baseUrl + app.basePath + '/get_data_each_detail',
				data : function(d) {
					d.item_id = $('#export_item_id').val()
					d.s_name = $('#s_name').val()
					return d;
				},
				dataSrc : 'items',
				dataType : 'json',
				type : 'post'
			},

			pageLength: 10,
			
			columns : [null,{
					data : 'user_name',
					render: function(d,t,r) {
						if(d.for_dep==0){
							return d;
						} else{
							return d;
						}
					},
					createdCell: function (td, cellData, rowData, row, col) {

						if ( rowData.for_dep==0) {
							$(td).removeClass('hide_s_i');
						} else {
							$(td).addClass('hide_s_i');
						}
					}
					
				},{
					data : 'dep_name',
					render: function(d,t,r) {
						if(d.for_dep==0){
							return d;
						} else{
							return d+'('+r.user_name+')';
						}
					},
					createdCell: function (td, cellData, rowData, row, col) {

						if ( rowData.for_dep==1) {
							$(td).removeClass('hide_s_i');
						} else {
							$(td).addClass('hide_s_i');
						}
					}
					
				},{
					data : 'create_time'
				},{
					data : 'id',
					render: function(d,t,r) {
						if(d.for_dep==0||d.for_dep==2){
							return '<button onclick="currentApp.each_detail.doExportAll('+d+')" class="btn btn-xs btn-warning" data-toggle="dropdown">'
									+'<i class="fa fa-save"></i>匯出'
									+'</button>';
						} else{
							return '<button onclick="currentApp.each_detail.doExportAll('+d+')" style="pointer-events:none;" class="btn btn-xs btn-warning disabledinput"  data-toggle="dropdown">'
									+'<i class="fa fa-save"></i>匯出'
									+'</button>';
						}
					}
				},],
			ordering: false,	
			order : [[0, "desc"]],
			columnDefs :[{
				targets : 0,
				data : null,
				defaultContent : '<a href="#deleteModal" role="button" data-toggle="modal" style="margin-right: 5px;"><i class="fa fa-trash fa-lg"></i></a>',
				searchable : false,
				orderable : false,
				width : "5%",
				className : ''
			}],

			footerCallback: function (row, data, start, end, display ) {
				var api = this.api();
			}

		}));

		
		
		// data table actions
		app.dtActions();

		app.mDtTable.on( 'xhr', function () {
		    var json = app.mDtTable.ajax.json();
	
		});

		app.doDelItem = function() {
			$.ajax({
				url : baseUrl + app.basePath  + 'delete_user_q_a/' + app._delId,
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
		$('#s_name').on('change', function(){
			app.tableReload();
		});
		app.doExportAll = function(id) {
			window.open(baseUrl + 'mgmt/question_option/export_excel/' + id);
		}
		app.export_item = function(id) {
			window.open(baseUrl + 'mgmt/question_option/export_excel_all/' + id);
		}
	
		

		if($('#export_item_for_dep').val()==0){
			$('.for_dep').addClass('hide_s_i');
		} else{
			if($('#export_item_for_dep').val()==1){
				$('.for_div').addClass('hide_s_i');
			} else{
				if($('#export_item_for_dep').val()==2){
			
				}
			}
		}

	

		app.tableReload();

		return app;
	};
	
	// return self
	return app.init();
});