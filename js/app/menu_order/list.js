var menuorderAppClass = (function(app) {
	app.basePath = "mgmt/menu_order/";
	app.disableRowClick = true;


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
				url : baseUrl + app.basePath + '/get_data',
				data : function(d) {
					// d.computer = $('#item_id').val();
					// d.lottery_no = $('#lottery_select').val();
					return d;
				},
				dataSrc : 'items',
				dataType : 'json',
				type : 'post'
			},

			pageLength: 10,

			columns : [null,{
				data : 'menu_name'
			},{
				data : 'order_name'
			},{
				data : 'amount'
			},{
				data : 'note'
			}],
			ordering: false,
			order : [[0, "desc"]],
			columnDefs : [{
				"targets" : [0,1,2,3,4],
				"orderable" : false
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

		// get year month list
		app.tableReload();

	


		// do submit
	
		return app;
	};

	// return self
	return app.init();
});



var menu_otherAppClass = (function(app) {
	app.basePath = "mgmt/menu_order/";
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
		app.mDtTable = $('#dt_list_other').DataTable($.extend(app.dtConfig,{
			ajax : {
				url : baseUrl + app.basePath + '/get_data_other',
				data : function(d) {
					// d.computer = $('#item_id').val();
					// d.lottery_no = $('#lottery_select').val();
					return d;
				},
				dataSrc : 'items',
				dataType : 'json',
				type : 'post'
			},

			pageLength: 10,

			columns : [{
					data : 'menu_name'
				},{
					data : 'user_name'
				},{
					data : 'order_name'
				},{
					data : 'amount'
				},{
					data : 'note'
				}],
			ordering: false,
			order : [[0, "desc"]],
			columnDefs : [{
				"targets" : [0,1,2,3,4],
				"orderable" : false
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

		// get year month list
		app.tableReload();

	


		// do submit
	
		return app;
	};

	// return self
	return app.init();
});
