var SwotAppClass = (function(app) {
	app.basePath = "mgmt/swot/";
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

		// get year month list
		app.tableReload();

		app.doExportAll = function(id) {
			window.open(baseUrl + app.basePath + 'export_all/' + id);
		}

		app.fnRowCallback = function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
			// edit click
			if(aData.is_use==0){
				if(!app.disableRowClick) {
					var _rtd = $(nRow).find('td');
					if(!app.enableFirstClickable) {
						_rtd = _rtd.not(':first')
					}
					_rtd.addClass('pointer').on('click', function(){
						app.doEdit(aData.id);
						// remove all highlight first
						$(this).parent().parent().find('tr').removeClass('active');
						app._lastPk = aData.id;
						app._tr = $(this).parent();
						setTimeout(function(){
							app._tr.addClass('active');
						}, 100);
					});
				}
				if(app._lastPk && aData.id && app._lastPk == aData.id) {
					$(nRow).addClass('active');
				}
				// delete click
				$(nRow).find("a").eq(0).click(function() {
					app.setDelId(aData.id);
	
					$('#modal_do_delete')
						.prop('onclick',null)
						.off('click')
						.on('click', function(){
							app.doDelItem();
						});
				});
	
				if(app.fnRowCallbackExt) {
					app.fnRowCallbackExt(nRow, aData, iDisplayIndex, iDisplayIndexFull, this);
				}
			} else{
				app.disableRowClick = true;
			}
			
		};

		app.doEdit = function(id) {
			var loading = $('<h1 class="ajax-loading-animation"><i class="fa fa-cog fa-spin"></i> Loading...</h1>')
				.appendTo($('#edit-modal-body').empty());
			$("#btn-submit-edit").prop( "disabled", true);
			$('.tab-pane').removeClass('active');
			$('#edit_page').addClass('active');	
			app.isUse(id);
				$('#edit-modal-body').load(baseUrl + app.basePath + 'edit/' + id, function(){
					// window.location.hash = app.basePath + 'edit/' + id;
					$("#btn-submit-edit").prop( "disabled", false);
					loading.remove();
				});
		};

		app.isUse = function(id) {
			$.ajax({
				url : baseUrl + app.basePath  + 'is_use/' + id,
				success: function() {
				},
				failure: function() {
				}
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

		app.backTo = function(target) {
			if(!target) {
				$('#edit-modal-body').empty();
	
				$('.tab-pane').removeClass('active');
				$('#list_page').addClass('active');
	
				// prevent datable height zero
				$(window).trigger('resize');
				// window.history.back();
				// history.go(-1);
			}
		};
		return app;
	};

	return app.init();
});
