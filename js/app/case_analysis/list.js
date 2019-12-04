var CaseanalysisAppClass = (function(app) {
	app.basePath = "mgmt/case_analysis/";

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

		app.doEdit = function(id) {
			var loading = $('<h1 class="ajax-loading-animation"><i class="fa fa-cog fa-spin"></i> Loading...</h1>')
										.appendTo($('#edit-modal-body').empty());
			$('.tab-pane').removeClass('active');
			$('#edit_page').addClass('active');
			app.lastDoEditId = id;
			$('#edit-modal-body').load(baseUrl + app.basePath + 'edit/' + id, {
			}, function(){

			});
		};

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
