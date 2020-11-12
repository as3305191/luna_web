var CarouselClass = (function(app) {
	app.basePath = "mgmt/carousel/";

	app.init = function() {
		app.mDtTable = $('#dt_list');

		// data table actions
		app.dtActions();

		// get year month list
		app.tableReload();

		return app;
	};

	// return self
	return app.init();
});
