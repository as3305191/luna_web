var PlantAppClass = (function(app) {
	app.basePath = "mgmt/plant/";

	app.init = function() {
		app.mDtTable = $('#dt_list').DataTable($.extend(app.dtConfig,{
			ajax : {
				url : baseUrl + app.basePath + '/get_data',
				data : function(d) {
					d.type_id = $('#type_id').val();
					d.status = $('#s_status').val();
					d.start_time = $('#s_start_time').val();
				},
				dataSrc : 'items',
				dataType : 'json',
				type : 'post',
				complete:function(data){
				}
			},

			iDisplayLength : 50,

			columns : mCols,

			order : [[mOrderIdx, "desc"]],
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

		app.doFlow = function(id) {
			var loading = $('<h1 class="ajax-loading-animation"><i class="fa fa-cog fa-spin"></i> Loading...</h1>')
										.appendTo($('#edit-modal-body').empty());
			$('.tab-pane').removeClass('active');
			$('#edit_page').addClass('active');
			$('#edit-modal-body').load(baseUrl + app.basePath + 'flow/' + id, function(){
        	loading.remove();
			});
		};

		app.fnRowCallbackExt = function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
			// flow click
			$(nRow).find("a").eq(1).click(function() {
				app.doFlow(aData.id);
			});
		}

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
