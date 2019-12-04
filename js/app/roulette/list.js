var RouletteAppClass = (function(app) {
	app.basePath = "mgmt/roulette/";

	app.init = function() {

		return app;
	};

	// edit
	app.doEdit = function(id) {
			var loading = $('<h1 class="ajax-loading-animation"><i class="fa fa-cog fa-spin"></i> Loading...</h1>')
				.appendTo($('#edit-modal-body').empty());
			$("#btn-submit-edit").prop( "disabled", true);

		$('.tab-pane').removeClass('active'); $('#edit_page').addClass('active');

		$('#edit-modal-body').load(baseUrl + app.basePath + 'edit/' + id, function(){
					$("#btn-submit-edit").prop( "disabled", false);
					loading.remove();
		});
	};

	// do submit
	app.doSubmit = function() {
		if(!$('#app-edit-form').data('bootstrapValidator').validate().isValid()) return;
		var url = baseUrl + app.basePath + 'insert'; // the script where you handle the form input.
		$.ajax({
			type : "POST",
			url : url,
			data : $("#app-edit-form").serialize(),
			success : function(data) {
				app.backTo();
				$(window).trigger("hashchange");
			}
		});
	};

	// return self
	return app.init();
});
