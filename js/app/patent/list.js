var patentAppClass = (function(app) {
	app.basePath = "mgmt/patent/";

	app.init = function() {
		app.mDtTable = $('#dt_list').DataTable($.extend(app.dtConfig,{
			ajax : {
				url : baseUrl + app.basePath + '/get_data',
				data : function(d) {
				
				},
				dataSrc : 'items',
				dataType : 'json',
				type : 'post',
				complete:function(data){
				}
			},

			iDisplayLength : 50,

			// columns : mCols,

			// order : [[0, "desc"]],
			// columnDefs : mColDefs
		}));

		// data table actions
		app.dtActions();

		// get year month list
		// app.tableReload();

		// // do submit
		// app.doSubmit = function() {
		// 	if(!$('#app-edit-form').data('bootstrapValidator').validate().isValid()) return;
		// 	var url = baseUrl + app.basePath + 'insert'; // the script where you handle the form input.
		// 	$.ajax({
		// 		type : "POST",
		// 		url : url,
		// 		data : {
		// 			id: $('#item_id').val(),
		// 			patnet_name: $('#patnet_name').val(),
		// 			img: img,
		// 			pdf_array: pdf_array.join(","),
		// 		},
		// 		success : function(d) {
		// 			currentApp.doEdit(0);
		// 		}
		// 	});
		// };


		app.doEdit = function(id) {
		    var loading = $('<h1 class="ajax-loading-animation"><i class="fa fa-cog fa-spin"></i> Loading...</h1>')
		    	.appendTo($('#edit-modal-body').empty());
		    $("#btn-submit-edit").prop( "disabled", true);

			$('.tab-pane').removeClass('active'); $('#edit_page').addClass('active');

			$('#edit-modal-body').load(baseUrl + 'mgmt/patent/edit/' + id, function(){
	        	$("#btn-submit-edit").prop( "disabled", false);
	        	loading.remove();
			});
		};

		app.doExportAll = function() {
			location.href = baseUrl + app.basePath + '/export_all';
		}

		return app;
	};

	// return self
	return app.init();
});