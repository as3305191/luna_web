var PatentstatusAppClass = (function(app) {
	app.basePath = "mgmt/patent_status/";
	app.init = function() {
		// init add wrapper marker
		app.addDtWrapper = false;

		
	app.doSubmit = function() {
		if(!$('#app-edit-form').data('bootstrapValidator').validate().isValid()) return;
		var url = baseUrl + app.basePath + 'insert'; // the script where you handle the form input.
		$.ajax({
			type : "POST",
			url : url,
			data : $("#app-edit-form").serialize(),
			success : function(d) {
				if(d.success){
					location.reload();
				}
			}
		});
	};
		return app;
	};

	// return self
	return app.init();
});
