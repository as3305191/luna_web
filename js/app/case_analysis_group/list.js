var CaseanalysisgroupAppClass = (function(app) {
	app.basePath = "mgmt/Case_analysis_group/";
	app.tableReload = function() {
		app.mDtTable.ajax.reload(function(){
			if(typeof wOnResize != undefined) {
				wOnResize();
			}
		}, false);
	};
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
					d.hospital = $('#f_hospital').val();
					d.doctor = $('#f_doctor').val();
					d.manager = $('#f_manager').val();

				},
				dataSrc : 'items',
				dataType : 'json',
				type : 'post',
				complete:function(data){
					$('#s_total').html('推薦會員數:' + data.responseJSON.recordsTotal);
				}
			},


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
		$('#bypass_point').on('change', function(){
			app.tableReload();
		});



		return app;
	};

	// return self
	return app.init();
});
