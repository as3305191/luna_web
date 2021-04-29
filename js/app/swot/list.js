var SwotAppClass = (function(app) {
	app.basePath = "mgmt/swot/";
	// app.disableRowClick = true;
	app.init = function() {
		app.mDtTable = $('#dt_list').DataTable($.extend(app.dtConfig,{
			ajax : {
				url : baseUrl + app.basePath + '/get_data',
				data : function(d) {
					// d.now_category = $('#now_category').val();
				},
				dataSrc : 'items',
				dataType : 'json',
				type : 'post',
				complete:function(data){
				}
			},
			iDisplayLength : 50,
			columns : mCols,
			order : [[2, "desc"]],
			columnDefs : mColDefs
		}));

		// data table actions
		app.dtActions();

		app.do_remove = function() {
			var url = baseUrl + 'mgmt/swot/do_remove'; 
			$.ajax({
				type : "POST",
				url : url,
				data : {
				},
				success : function(d) {
					if(d.success) {
						// alert('已成功清除');
					} else {
					}
				}
			});
		}

		app.tableReload = function() {
			if(app.mDtTable.settings()[0].jqXHR) {
				app.mDtTable.settings()[0].jqXHR.abort();
			}
	
			app.mDtTable.ajax.reload(function(){
				if(typeof wOnResize != undefined) {
					wOnResize();
				}
			}, false);
			app.do_remove();
		};
		// get year month list
		app.tableReload();

		app.isUse = function(id) {
			$.ajax({
				url : baseUrl + app.basePath  + 'is_use/' + id,
				success: function() {
				},
				failure: function() {
				}
			});
		};

		app.doExportAll = function(id) {
			window.open(baseUrl + app.basePath + 'export_all/' + id);
		}

		app.doEdit = function(id) {
			var loading = $('<h1 class="ajax-loading-animation"><i class="fa fa-cog fa-spin"></i> Loading...</h1>')
				.appendTo($('#edit-modal-body').empty());
			$("#btn-submit-edit").prop( "disabled", true);
			$('.tab-pane').removeClass('active');
			$('#edit_page').addClass('active');	
				$('#edit-modal-body').load(baseUrl + app.basePath + 'edit/' + id, function(){
					// window.location.hash = app.basePath + 'edit/' + id;
					$("#btn-submit-edit").prop( "disabled", false);
					loading.remove();

				});
		};

	

		app.back= function(id) {
			if(id) {
				$.ajax({
					url : baseUrl + app.basePath  + 'not_use/' + id,
					success: function() {
						app.backTo();
					},
					failure: function() {
					}
				});
			}
		};


		return app;
	};

	return app.init();
});
