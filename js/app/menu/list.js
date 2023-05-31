var listmenuAppClass = (function(app) {
	app.basePath = "mgmt/menu/";
	app.init = function() {
		app.mDtTable = $('#dt_list').DataTable($.extend(app.dtConfig,{
			ajax : {
				url : baseUrl + app.basePath + '/get_data',
				data : function(d) {
					d.s_menu_name = $('#s_menu_name').val();

				},
				dataSrc : 'items',
				dataType : 'json',
				type : 'post',
				complete:function(data){
				}
			},
			iDisplayLength : 30,
			columns : mCols,
			order :false,
			columnDefs : mColDefs
		}));
		// data table actions
		app.dtActions();

		// get year month list
		app.tableReload();

		app.doExportAll = function(id) {
			window.open(baseUrl + app.basePath + 'export_all/' + id);
		}
	

		return app;
	};

	return app.init();
});
