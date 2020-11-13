var NewsEditAppClass = (function(app) {
	app.basePath = "mgmt/news_edit/";

	app.init = function() {
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

			columns : [null, {
				data : 'title'
			}, {
				data : 'news_style'
			}, {
				data : 'create_time'
			}],
			order : [[3, "desc"]],
			columnDefs : [{
				targets : 0,
				data : null,

				defaultContent : app.defaultContent,
				searchable : false,
				orderable : false,
				width : "5%",
				className : ''
			}, {
				"targets" : 0,
				"orderable" : false
			}, {
				"targets" : 1,
				"orderable" : false
			}, {
				"targets" : 2,
				"orderable" : false
			}]


		}));

		// data table actions
		app.dtActions();

		// get year month list
		app.tableReload();


		var imgIdList = app.getImgIdList();
		$.ajax({
			type : "POST",
			url : url,
			data : $("#app-edit-form").serialize()
					+ '&' + $("#app-edit-form-s3").serialize()
					// + '&' + $("#app-edit-form-s4").serialize()
					// + '&spec_list=' + encodeURIComponent(JSON.stringify(specStore))
					+ '&img_id_list=' + imgIdList.join(','),
			success : function(data) {
				app.tableReload();
				currentApp.doEdit(data.id);
				$('input[name="id"]').val(data.id);
				// $('#editModal').modal('hide');
			}
		});
	};
	app.getImgIdList = function() {
		var idList = [];
		$('.kv-file-content img').each(function() {
			if($(this).attr('src').indexOf('http') == 0) {
				var _id = $(this).attr('src').split('/').pop();
				idList.push(_id);
			}
		});
		return idList;
	};

	// image operations
	app.addImg = function(id) {
		if(!app.imgIds) {
			app.imgIds = [];
		}
		app.imgIds.push(id);
	};

	app.delImg = function(id) {
		if(app.imgIds && app.imgIds.length > 0) {
			for(var i = app.imgIds.length - 1; i >= 0; i--) {
				if(app.imgIds[i] === id) {
				   app.imgIds.splice(i, 1);
				}
			}
		}
	};

	app.getImgs = function() {
		if(!app.imgIds) {
			app.imgIds = [];
		}
		return app.imgIds;
	};

	app.clearImgs = function() {
		app.imgIds = [];
	};

		$('#s_news_style').on('change', function(){
			app.tableReload();
		});

		return app;
	};

	// return self
	return app.init();
});
