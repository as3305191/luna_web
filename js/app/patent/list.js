var patentAppClass = (function(app) {
	app.basePath = "mgmt/patent/";
	app.init = function() {
		app.mDtTable = $('#dt_list').DataTable($.extend(app.dtConfig,{
			ajax : {
				url : baseUrl + app.basePath + '/get_data',
				data : function(d) {
			
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
				

				},
				dataSrc : 'items',
				dataType : 'json',
				type : 'post',
				complete:function(data){
				}
			},
			iDisplayLength : 50,
			columns : mCols,
			order : [[9, "desc"]],
			columnDefs : mColDefs
		}));

		// data table actions
		app.dtActions();

		// get year month list
		app.tableReload();

		app.doExportAll = function(id) {
			window.open(baseUrl + app.basePath + 'export_all/' + id);
		}

		// $('#1').on('change', function(){
		// 	app.tableReload();
		// });
		// $('#2').on('change', function(){
		// 	app.tableReload();
		// });
		// $('#3').on('change', function(){
		// 	app.tableReload();
		// });
		$('#application_person').on('change keyup', function(){
			app.tableReload();
		});
		$('#application_num_search').on('change keyup', function(){
			app.tableReload();
		});
		$('#invention_person_search').on('change keyup', function(){
			app.tableReload();
		});
		$('#public_num_search').on('change keyup', function(){
			app.tableReload();
		});
		$('#key_search').on('change keyup', function(){
			app.tableReload();
		});
		$('#patent_search').on('change keyup', function(){
			app.tableReload();
		});
		$('#summary_search').on('change keyup', function(){
			app.tableReload();
		});
		$('#now_category').on('change', function(){
			app.tableReload();
		});
		$('#patent_family_search').on('change keyup', function(){
			app.tableReload();
		});
		$("input[name='patent_status[]']").on('click', function(){
			app.tableReload();
		});

	    $(window).trigger("hashchange");

		return app;
	};

	return app.init();
});
