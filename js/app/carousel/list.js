var CarouselClass = (function(app) {
	app.basePath = "mgmt/carousel/";

	app.init = function() {
	
		// data table actions
		app.dtActions();

		// get year month list
		app.Reload = function() {
			app.ajax.reload(function(){
				if(typeof wOnResize != undefined) {
					wOnResize();
				}
			}, false);
		};

		app.Reload();
		return app;
	};

	// return self
	return app.init();
});
