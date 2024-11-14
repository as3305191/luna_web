var SingstatusAppClass = (function(app) {
	app.basePath = "mgmt/sing_status/";
	app.fnRowCallback_new = function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
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
					url: baseUrl + app.basePath + '/switch_sing',
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
	fnRowCallback : app.fnRowCallback_new,
	footerCallback: function( tfoot, data, start, end, display ) {
		setTimeout(function(){ $(window).trigger('resize'); }, 300);
	}
};

	app.init = function() {
		app.mDtTable = $('#dt_list').DataTable($.extend(app.dtConfig,{
			ajax : {
				url : baseUrl + app.basePath + '/get_data',
				data : function(d) {
					d.s_date = $('#s_date').val();
				},
				dataSrc : 'items',
				dataType : 'json',
				type : 'post',
				complete:function(data){
				}
			},
			iDisplayLength : 50,
			columns : mCols,
			order : [[0, "desc"]],
			columnDefs : mColDefs
		}));

		// data table actions
		app.dtActions();

		// get year month list
		app.tableReload();

		app.doExportAll = function(id) {
			window.open(baseUrl + 'mgmt/menu_orderby_user/export_excel/' + id);
		}

		
		$('#s_date').on('keyup', function(){
			console.log('1');
			app.tableReload();
		});
		// $('#s_menu_name').on('keyup', function(){
		// 	app.tableReload();
		// });
	    // $(window).trigger("hashchange");

		return app;
	};

	return app.init();
});
