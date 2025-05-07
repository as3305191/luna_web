var SwotAppClass = (function(app) {
	app.basePath = "mgmt/swot/";
	// app.disableRowClick = true;
	app.init = function() {
		app.mDtTable = $('#dt_list').DataTable($.extend(app.dtConfig,{
			ajax : {
				url : baseUrl + app.basePath + '/get_data',
				data : function(d) {
					d.list_title = $('#list_title').val();
					if($('#d_or_c1').val()==17 || $('#d_or_c1').val()==6 || $('#d_or_c1').val()==16 || $('#d_or_c1').val()==9||$('#d_or_c1').val()==69){
						d.d_or_c = $('#d_or_c').val();

					} else{
						d.d_or_c = $('#d_or_c1').val();
					}
					d.list_style = $('#list_style').val();

				},
				dataSrc : 'items',
				dataType : 'json',
				type : 'post',
				complete:function(data){
				}
			},
			iDisplayLength : 50,
			columns : mCols,
			order : [[5, "desc"]],
			columnDefs : mColDefs
		}));

		// data table actions
		app.dtActions();

		app.doEdit = function(id,title=0,style=0,dep=0,unify_type) {
			var loading = $('<h1 class="ajax-loading-animation"><i class="fa fa-cog fa-spin"></i> Loading...</h1>')
				.appendTo($('#edit-modal-body').empty());
			$("#btn-submit-edit").prop( "disabled", true);
			$('.tab-pane').removeClass('active');
			$('#edit_page').addClass('active');	
				$('#edit-modal-body').load(baseUrl + app.basePath + 'edit/' + id+'?title='+title+'&style='+style+'&dep='+dep+'&unify_type='+unify_type+'&type=0', function(){
					// window.location.hash = app.basePath + 'edit/' + id;
					$("#btn-submit-edit").prop( "disabled", false);
					loading.remove();

				});
		};

		app.doEdit1 = function(id,title=0,style=0,dep=0) {
			var loading = $('<h1 class="ajax-loading-animation"><i class="fa fa-cog fa-spin"></i> Loading...</h1>')
				.appendTo($('#edit-modal-body').empty());
			$("#btn-submit-edit").prop( "disabled", true);
			$('.tab-pane').removeClass('active');
			$('#edit_page').addClass('active');	
				$('#edit-modal-body').load(baseUrl + app.basePath + 'edit/' + id+'?title='+title+'&style='+style+'&dep='+dep+'&unify_type=0'+'&type=1', function(){
					// window.location.hash = app.basePath + 'edit/' + id;
					$("#btn-submit-edit").prop( "disabled", false);
					loading.remove();

				});
		};

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

		app.doExportAll = function(id) {
			window.open(baseUrl + app.basePath + 'export_all/' + id);
		}

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

		$('#list_title').on('change', function(){
			app.tableReload();
		});
		$('#d_or_c').on('change', function(){
			app.tableReload();
		});
		$('#list_style').on('change', function(){
			app.tableReload();
		});

		return app;
	};

	return app.init();
});
