var menuAppClass = (function(app) {
	app.basePath = "mgmt/menu/";
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

		app.doExportAll = function(id) {
			window.open(baseUrl + app.basePath + 'export_all/' + id);
		}
		$('#s_patent_name').on('keyup', function(){
			app.tableReload();
		});
		$('#application_person').on('keyup', function(){
			app.tableReload();
		});
		$('#application_num_search').on('keyup', function(){
			app.tableReload();
		});
		$('#invention_person_search').on('keyup', function(){
			app.tableReload();
		});
		$('#public_num_search').on('keyup', function(){
			app.tableReload();
		});
		$('#key_search').on('keyup', function(){
			app.tableReload();
		});
		$('#patent_search').on('keyup', function(){
			app.tableReload();
		});
		$('#summary_search').on('keyup', function(){
			app.tableReload();
		});
		$('#now_category').on('keyup', function(){
			app.tableReload();
		});
		$('#patent_family_search').on('keyup', function(){
			app.tableReload();
		});
		$("input[name='patent_status[]']").on('click', function(){
			app.tableReload();
		});

		$('#or_and_type').on('change', function(){
			app.tableReload();
		});

		$('#key_search_array').on('change', function(){
			app.tableReload();
		});
	    // $(window).trigger("hashchange");

		return app;
	};

	return app.init();
});
