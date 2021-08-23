var MembersloginAppClass = (function(app) {
	app.basePath = "mgmt/members_login/";
	app.disableRowClick = true;

	app.init = function() {
		app.mDtTable = $('#dt_list').DataTable($.extend(app.dtConfig,{
			ajax : {
				url : baseUrl + app.basePath + '/get_data',
				data : function(d) {
					d.role_id = $('#role_id').val();
					d.station_id = $('#station_id').val();
					d.is_valid_email = $('#is_valid_email').val();
					d.is_foreign = $('#is_foreign').val();
					d.bypass_point = $('#bypass_point').val();
					d.hospital_id = $('#hospital_id').val();
					d.dt = $('#s_dt').val();
					d.e_dt = $('#e_dt').val();
					d.user_name = $('#user_name').val();

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

		$('#hospital_id').on('change', function(){
			app.tableReload();
		});
		$('#role_id').on('change', function(){
			app.tableReload();
		});
		$('#is_valid_email').on('change', function(){
			app.tableReload();
		});
		$('#is_foreign').on('change', function(){
			app.tableReload();
		});
		$('#station_id').on('change', function(){
			app.tableReload();
		});
		$('#user_name').on('change keyup', function(){
			app.tableReload();
		});
		$(".dt_picker").datetimepicker({
				format: 'YYYY-MM-DD'
			}).on('dp.change',function(event){
				currentApp.tableReload();
			});
		return app;
	};

	// return self
	return app.init();
});
