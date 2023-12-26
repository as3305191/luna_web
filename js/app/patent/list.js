var patentAppClass = (function(app) {
	app.basePath = "mgmt/patent/";
	app.init = function() {
		app.mDtTable = $('#dt_list').DataTable($.extend(app.dtConfig,{
			ajax : {
				url : baseUrl + app.basePath + '/get_data',
				data : function(d) {
					d.patent_name = $('#s_patent_name').val();
					d.now_category = $('#now_category').val();
					d.application_person = $('#application_person').val();
					d.application_num = $('#application_num_search').val();
					d.invention_person_search = $('#invention_person_search').val();
					d.public_num_search = $('#public_num_search').val();
					d.key_search = $('#key_search').val();
					d.patent_search = $('#patent_search').val();
					d.summary_search = $('#summary_search').val();
					d.patent_family_search = $('#patent_family_search').val();
					d.patent_status = $("input[name='patent_status[]']:checked").map(function() {
						return this.value
					}).get().join('#');
					d.or_and_type = $('#or_and_type').prop("checked") ? 1 : 0;
					d.key_search_array = $('#key_search_array').val();

				},
				dataSrc : 'items',
				dataType : 'json',
				type : 'post',
				complete:function(data){
				}
			},
			iDisplayLength : 50,
			columns : mCols,
			order : [[10, "desc"]],
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
