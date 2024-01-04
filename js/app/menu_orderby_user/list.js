var menuorderuserAppClass = (function(app) {
	app.basePath = "mgmt/menu_orderby_user/";
	app.disableRowClick = true;
	app.init = function() {
		app.mDtTable = $('#dt_list').DataTable($.extend(app.dtConfig,{
			ajax : {
				url : baseUrl + app.basePath + '/get_data',
				data : function(d) {
					d.menu_id = $('#menu_name').val();
					
				},
				dataSrc : 'items',
				dataType : 'json',
				type : 'post',
				complete:function(data){
					
						// console.log(data.responseJSON.total);
						if(data.responseJSON.total!=='0'||data.responseJSON.total!==null||data.responseJSON.total>0){
							$('#total').text(data.responseJSON.total);
						} else{
							$('#total').text(0);
						}
						
					
				}
			},
			iDisplayLength : 50,
			columns : mCols,
			order : false,
			columnDefs : mColDefs
		}));

		// data table actions
		app.dtActions();

		// get year month list
		app.tableReload();

		app.doExportAll = function() {
			window.open(baseUrl + app.basePath + 'export_excel/' );
		}
		

		$('#menu_name').on('change', function(){
			app.tableReload();
		});
	    // $(window).trigger("hashchange");

		return app;
	};

	return app.init();
});
