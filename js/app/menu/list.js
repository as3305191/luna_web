var MenuAppClass = (function(app) {
	app.basePath = "mgmt/menu/";
	app.init = function() {
		app.mDtTable = $('#dt_list').DataTable($.extend(app.dtConfig,{
			ajax : {
				url : baseUrl + app.basePath + '/get_data',
				data : function(d) {
					// d.now_category = $('#now_category').val();
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

		// app.doExportAll = function(id) {
		// 	window.open(baseUrl + app.basePath + 'export_all/' + id);
		// }

		// $('#application_person').on('keyup', function(){
		// 	app.tableReload();
		// });
	
	    // $(window).trigger("hashchange");

		return app;
	};

	return app.init();
});
