var Ordersv2AppClass = (function(app) {
	app.basePath = "mgmt/orders_v2/";

	app.init = function() {
		app.mDtTable = $('#dt_list').DataTable($.extend(app.dtConfig,{
			ajax : {
				url : baseUrl + app.basePath + '/get_data',
				data : function(d) {
					d.type_id = $('#type_id').val();
					d.status = $('#s_status').val();
					d.start_time = $('#s_start_time').val();
					d.station_id = $('#station_id').val();
				},
				dataSrc : 'items',
				dataType : 'json',
				type : 'post',
				complete:function(data){
				}
			},

			iDisplayLength : 50,

			columns : mCols,

			order : [[0, "desc"]],
			columnDefs : mColDefs
		}));

		// data table actions
		app.dtActions();

		// get year month list
		app.tableReload();

		// do submit
		app.doSubmit = function() {
			if(!$('#app-edit-form').data('bootstrapValidator').validate().isValid()) return;
			var url = baseUrl + app.basePath + 'insert'; // the script where you handle the form input.
			$.ajax({
				type : "POST",
				url : url,
				data : $("#app-edit-form").serialize() + "&" + $.param({
					"station_list": JSON.stringify(stationListStore),
					"type0_list": JSON.stringify(type0ProductStore),
					"type2_list": JSON.stringify(type2ProductStore),
				}),
				success : function(data) {
					app.mDtTable.ajax.reload(null, false);
					app.backTo();
				}
			});
		};

		app.doExportAll = function() {
			location.href = baseUrl + app.basePath + '/export_all';
		}



			app.doEdit = function(id) {
			var loading = $('<h1 class="ajax-loading-animation"><i class="fa fa-cog fa-spin"></i> Loading...</h1>')
										.appendTo($('#edit-modal-body').empty());
			$('.tab-pane').removeClass('active');
			$('#edit_page').addClass('active');
			app.lastDoEditId = id;
			$('#edit-modal-body').load(baseUrl + app.basePath + 'flow/' + id, {
				'station': $('#station_id_1').val()
			}, function(){
        	loading.remove();
			});
		};


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
