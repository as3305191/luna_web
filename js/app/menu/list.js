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

			columns : [null],

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
				"targets" : [0],
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
