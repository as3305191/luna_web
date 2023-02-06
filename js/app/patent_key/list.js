var patentkeyAppClass = (function(app) {
	app.basePath = "mgmt/patent_key/";
	app.init = function() {
		app.mDtTable = $('#dt_list').DataTable($.extend(app.dtConfig,{
			ajax : {
				url : baseUrl + app.basePath + '/get_data',
				data : function(d) {
					d.key = $('#key_s').val();

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
		$('#key_s').on('keyup', function(){
			app.tableReload();
		});
	

		return app;
	};

	return app.init();
});
