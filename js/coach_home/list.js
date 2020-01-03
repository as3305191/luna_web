var CoachHomeAppClass = (function(app) {
	app.basePath = "mgmt/coach_home/";

	app.init = function() {
		app.enableFirstClickable = true;
		app.mDtTable = $('#dt_list').DataTable($.extend(app.dtConfig,{
			ajax : {
				url : baseUrl + app.basePath + '/get_data',
				data : function(d) {
					// d.role_id = $('#role_id').val();
				},
				dataSrc : 'items',
				dataType : 'json',
				type : 'post'
			},

			columns : [{
				data : 'user_name'
			}, {
				data : 'age'
			}, {
				data : 'height'
			}, {
				data : 'gender',
				render:function(d,t,r) {
					if(d == 0 ) {
						return "女";
					}
					if(d == 1 ) {
						return "男";
					}
					return d;
				}
			}],

			order : [[1, "desc"]],
			columnDefs : [{
				"targets" : 0,
				"orderable" : false
			},{
				"targets" : 1,
				"orderable" : false
			}]
		}));

		// data table actions
		app.dtActions();

		// get year month list
		app.tableReload();

		// $('#role_id').on('change', function(){
		// 	app.tableReload();
		// });

		return app;
	};

	// return self
	return app.init();
});
