var MenuAppClass = (function(app) {
	app.basePath = "mgmt/menu/";

	app.init = function() {
		app.mDtTable = $('#dt_list').DataTable($.extend(app.dtConfig,{
			ajax : {
				url : baseUrl + app.basePath + '/get_data',
				data : function(d) {
					d.corp_id = $('#corp_id').val();
					d.multiple = $('#s_multiple').prop("checked") ? 1 : 0;

				},
				dataSrc : 'items',
				dataType : 'json',
				type : 'post'
			},

			columns : [null, {
				data : 'menu_code'
			},{
				data : 'update_type'
			},{
				data : 'menu_name'
			},{
				data : 'meal_name'
			},{
				data : 'cuisine_type'
			},{
				data : 'rating',
				render: function(d,t,r) {
					if(r.count_rating>=0){
						return d+'('+r.count_rating+')筆';
					} else{
						return d;
					}
				}
			}, {
				data : 'date'
			}, {
				data : 'grain_rhizomes'
			}, {
				data : 'fish_eggs'
			}, {
				data : 'fish_eggs_l'
			},{
				data : 'fish_eggs_m'
			},{
				data : 'fish_eggs_h'
			},{
				data : 'fish_eggs_vh'
			},{
				data : 'oils_nuts'
			}, {
				data : 'vegetables'
			}, {
				data : 'fruit'
			}, {
				data : 'dairy_products'
			}, {
				data : 'dairy_products_off'
			}, {
				data : 'dairy_products_low'
			}, {
				data : 'dairy_products_all'
			}, {
				data : 'total_calories'
			}, {
				data : 'create_time'
			}],

			order : [[7, "desc"]],
			columnDefs : [{
				targets : 0,
				data : null,
				defaultContent : app.defaultContent,
				searchable : false,
				orderable : false,
				width : "5%",
				className : ''
			},{
				"targets" : [0,1,2,3,4,5,6,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22],
				"orderable" : false
			}]
		}));

		app.doSubmit = function() {
			if(!$('#app-edit-form').data('bootstrapValidator').validate().isValid()) return;

			$('#lang').val($('#sys_lang').val());

			var url = baseUrl + app.basePath + 'insert'; // the script where you handle the form input.
			$.ajax({
				type : "POST",
				url : url,
				data : $("#app-edit-form").serialize(),
				success : function(data) {
					app.mDtTable.ajax.reload(null, false);
					app.backTo();

					if($('#l_user_role').val() != '99') {
						app.doEdit($('#l_corp_id').val());
					} else {
						app.backTo();
					}

				}
			});
		};

		app.doPay = function() {
			doPay();
		}

		// data table actions
		app.dtActions();

		// get year month list
		app.tableReload();

		$('#corp_id').on('change', function(){
			$('#waring').hide();
			app.tableReload();
		});
		$('#s_multiple').on('change', function(){
			app.tableReload();
		});
		return app;
	};

	// return self
	return app.init();
});
