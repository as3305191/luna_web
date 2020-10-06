var patentAppClass = (function(app) {
	app.basePath = "mgmt/patent/";

	app.init = function() {
		app.mDtTable = $('#dt_list').DataTable($.extend(app.dtConfig,{
			ajax : {
				url : baseUrl + app.basePath + '/get_data',
				data : function(d) {
					// d.type_id = $('#type_id').val();
					// d.status = $('#s_status').val();
					// d.start_time = $('#s_start_time').val();
					// d.station_id = $('#station_id').val();

					// d.type_1 = $('#1').val();
					// d.type_2 = $('#2').val();
					// d.type_3 = $('#3').val();
					d.now_category = $('#now_category').val();
					d.application_person = $('#application_person').val();
					d.application_num = $('#application_num_search').val();
					d.invention_person_search = $('#invention_person_search').val();
					d.public_num_search = $('#public_num_search').val();
					d.key_search = $('#key_search').val();
					d.patent_search = $('#patent_search').val();
					d.summary_search = $('#summary_search').val();
				},
				dataSrc : 'items',
				dataType : 'json',
				type : 'post',
				complete:function(data){
				}
			},

			iDisplayLength : 50,

			columns : mCols,

			order : [[9, "desc"]],
			columnDefs : mColDefs
		}));

		// data table actions
		app.dtActions();

		// get year month list
		app.tableReload();

		app.doExportAll = function() {
			location.href = baseUrl + app.basePath + '/export_all';
		}

		// $('#1').on('change', function(){
		// 	app.tableReload();
		// });
		// $('#2').on('change', function(){
		// 	app.tableReload();
		// });
		// $('#3').on('change', function(){
		// 	app.tableReload();
		// });
		$('#application_person').on('change keyup', function(){
			app.tableReload();
		});
		$('#application_num_search').on('change keyup', function(){
			app.tableReload();
		});
		$('#invention_person_search').on('change keyup', function(){
			app.tableReload();
		});
		$('#public_num_search').on('change keyup', function(){
			app.tableReload();
		});
		$('#key_search').on('change keyup', function(){
			app.tableReload();
		});
		$('#patent_search').on('change keyup', function(){
			app.tableReload();
		});
		$('#summary_search').on('change keyup', function(){
			app.tableReload();
		});
		$('#now_category').on('change', function(){
			app.tableReload();
		});
		
		
		$('.p_category').on('change', function(){
			var me = $(this);
			var _dataVal = me.data("val");
			var select_Val = me.val();
			$('#now_category').val(select_Val);
				var next_c =_dataVal+1;
				console.log(next_c);
				$.ajax({
					url:  baseUrl + app.basePath + '/find_next_category',
					type: 'POST',
					data: {
						next_level:next_c,
						this_val:select_Val,
					},
					dataType: 'json',
					success: function(d) {
						var category_option = '<option value="all">全部</option>';
						var $category = $('#category_'+next_c).empty();
						$category.append(category_option);
						if(d.category){
							$.each(d.category, function(){
								$('<option />', {
									'value': this.id,
									'text': this.name,
								}).appendTo($category);
							});
						}
						app.tableReload();
					},
					failure:function(){
					}
				});

		});

	

		return app;
	};

	// return self
	return app.init();
});
