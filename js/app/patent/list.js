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

					d.type_1 = $('#1').val();
					d.type_2 = $('#2').val();
					d.type_3 = $('#3').val();
					d.application_person = $('#application_person').val();
					d.application_num = $('#application_num').val();
					d.invention_person_search = $('#invention_person_search').val();
					d.public_num_search = $('#public_num_search').val();
					d.key_search = $('#key_search').val();
					d.patent_search = $('#patent_search').val();
					d.summary_search = $('#summary_search').val();
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


		// $('#station_id').on('change', function(){
		// 	var station_id = $('#station_id').val();
		// 	$('#station_id_1').val(station_id);
		// 	$('#st_id1').val(station_id);
		// 	app.tableReload();
		// });
		$('#1').on('change', function(){
			app.tableReload();
		});
		$('#2').on('change', function(){
			app.tableReload();
		});
		$('#3').on('change', function(){
			app.tableReload();
		});
		$('#application_person').on('change', function(){
			app.tableReload();
		});
		$('#application_num').on('change', function(){
			app.tableReload();
		});
		$('#invention_person_search').on('change', function(){
			app.tableReload();
		});
		$('#public_num_search').on('change', function(){
			app.tableReload();
		});
		$('#key_search').on('change', function(){
			app.tableReload();
		});
		$('#patent_search').on('change', function(){
			app.tableReload();
		});
		$('#summary_search').on('change', function(){
			app.tableReload();
		});
		
	
		return app;
	};

	// return self
	return app.init();
});
