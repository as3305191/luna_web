var CarouselClass = (function(app) {
	app.basePath = "mgmt/carousel/";

	app.init = function() {
		app = $('#news_container');
		var wOnResize = function(){

			var currentListElId = "#news_container";
			if(currentApp && currentApp.dtListId) {
				currentListElId = currentApp.dtListId;
			}
			if($(window).height() < 700) {
				$('.t-box').css('height', ($(currentListElId).height()) + 'px');
			} else {
				$('.t-box').css('max-height', ($(window).height() - 320) + 'px');
			}
			$('#widget-grid').width($('#content').width() - 13);
		};
		// data table actions
		app.dtActions = function() {
			// search box
			$(app.dtListId + " thead th input[type=text]").on('change keyup', function() {
				var me = this;
	
				setTimeout(function(){
					app.settings()[0].jqXHR.abort();
					app.column($(me).parent().index() + ':visible').search(me.value).draw();
				}, 100);
			});
	
			// trigger on resize when draw datatable
			$(app.dtListId).on('draw.dt', function(){
				wOnResize();
			});
		};
		// get year month list
		app.Reload = function() {
			location.reload();
		};
		app.dtActions();
		// app.Reload();
		return app;
	};

	// return self
	return app.init();
});
