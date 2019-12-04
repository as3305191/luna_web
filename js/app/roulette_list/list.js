var RouletteListAppClass = (function(app) {
	app.basePath = "mgmt/roulette_list/";

	app.init = function() {
		app.mDtTable = $('#dt_list').DataTable($.extend(app.dtConfig,{
			ajax : {
				url : baseUrl + app.basePath + '/get_data',
				data : function(d) {
					d.type_id = $('#type_id').val();
					d.receipt_sn = $('#s_receipt_sn').val();
				},
				dataSrc : 'items',
				dataType : 'json',
				type : 'post',
				complete:function(data){
					$('#s_total').html('推薦會員數:' + data.responseJSON.recordsTotal);
				}
			},

			columns : mCols,

			order : [[0, "desc"]],
			columnDefs : mColDefs,
			"footerCallback": function ( row, data, start, end, display ) {
	        var api = this.api(), data;
					window.mApi = api;
      }
		}));

		// data table actions
		app.dtActions();

		// get year month list
		app.tableReload();

		app.doExportAll = function() {
			location.href = baseUrl + app.basePath + '/export_all';
		}

		app.doEdit = function(id) {
			window.open(baseUrl + 'api/login/sign_record/' + id)
		}

		$('#type_id').on('change', function(){
			app.tableReload();
		});
		$('#s_receipt_sn').on('change keyup', function(){
			app.tableReload();
		});

		return app;
	};

	// return self
	return app.init();
});
