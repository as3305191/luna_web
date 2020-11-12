var CarouselClass = (function(app) {
	app.basePath = "mgmt/carousel/";

	app.init = function() {
		app.mDtTable = $('#dt_list');

		// data table actions
		app.dtActions();
		app.tableReload = function() {
			app.mDtTable.ajax.reload(function(){
				if(typeof wOnResize != undefined) {
					wOnResize();
				}
			}, false);
		};
		// get year month list
		app.tableReload();

		return app;
	};

	// return self
	return app.init();
});
