var patentAppClass = (function(app) {
	app.basePath = "mgmt/patent/";

	app.init = function() {
		app.mDtTable = $('#dt_list').DataTable($.extend(app.dtConfig,{
			ajax : {
				url : baseUrl + app.basePath + '/get_data',
				data : function(d) {
					// d.type_id = $('#type_id').val();
					// d.status = $('#s_status').val();
					// d.start_time = $('#s_start_time').val();
					// d.station_id = $('#station_id').val();
				},
				dataSrc : 'items',
				dataType : 'json',
				type : 'post',
				complete:function(data){
				}
			},

			iDisplayLength : 50,

			columns : mCols,

			order : [[7, "desc"]],
			columnDefs : mColDefs
		}));

		// data table actions
		app.dtActions();

		// get year month list
		app.tableReload();

		app.doExportAll = function() {
			location.href = baseUrl + app.basePath + '/export_all';
		}


		$('#station_id').on('change', function(){
			var station_id = $('#station_id').val();
			$('#station_id_1').val(station_id);
			$('#st_id1').val(station_id);
			app.tableReload();
		});
		$('#type_id').on('change', function(){
			app.tableReload();
		});
		$('#s_status').on('change', function(){
			app.tableReload();
		});
		return app;
	};

	// return self
	return app.init();
});
