var ReceiptAppClass = (function(app) {
	app.basePath = "mgmt/receipt/";
	// app.disableRowClick = true;

	app.init = function() {
		app.reloadFlow = function(){
			$("#m_result").load(app.basePath + "flow", {
				s_dt:	$('#s_dt').val(),
				e_dt:	$('#e_dt').val(),
				multiple: $('#s_multiple').prop("checked") ? 1 : 0
			});
		}

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

		$('#s_multiple').on('change', function(){
			if($('#s_multiple').prop("checked")) {
				// multiple
				$('#e_dt').prop("disabled", false)
			} else {
				$('#e_dt').prop("disabled", true)
			}

			app.reloadFlow();
		});



		$(".dt_picker").datetimepicker({
			format: 'YYYY-MM-DD'
		}).on('dp.change',function(event){
			app.reloadFlow();
		});

		return app;
	};

	// return self
	return app.init();
});
