var CarouselClass = (function(app) {
	app.basePath = "mgmt/carousel/";

	app.init = function() {
		app.mDtTable = $('#dt_list');

		// data table actions
		app.dtActions();
		app.tableReload = function() {
			location.reload();
		};
		// get year month list
		// app.tableReload();

		return app;
	};

	// return self
	return app.init();
});
