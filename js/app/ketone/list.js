var KetoneClass = (function(app) {
	app.basePath = "mgmt/ketone/";
	app.disableRowClick = true;

	app.init = function() {
		app.mDtTable = $('#dt_list').DataTable($.extend(app.dtConfig,{
			ajax : {
				url : baseUrl + app.basePath + '/get_data',
				data : function(d) {
					d.type = $('#type').val();
					d.dt = $('#s_dt').val();
					d.e_dt = $('#e_dt').val();
				},
				dataSrc : 'items',
				dataType : 'json',
				type : 'post',
				complete:function(data){
					$('#s_total').html('推薦會員數:' + data.responseJSON.recordsTotal);
				}
			},

			columns : mCols,

			order : [[mOrderIdx, "desc"]],
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

		$('#type').on('change', function(){
			app.tableReload();
		});
		return app;
	};
	
	$(".dt_picker").datetimepicker({
			format: 'YYYY-MM-DD'
		}).on('dp.change',function(event){
			currentApp.tableReload();
		});
	// return self
	return app.init();
});
