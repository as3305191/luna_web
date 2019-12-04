var ProductTraceAppClass = (function(app) {
	app.basePath = "mgmt/product_trace/";
	// app.disableRowClick = true;

	app.init = function() {
		app.mDtTable = $('#dt_list').DataTable($.extend(app.dtConfig,{
			ajax : {
				url : baseUrl + app.basePath + '/get_data',
				data : function(d) {
					d.dt = $('#s_dt').val();
					d.e_dt = $('#e_dt').val();
					d.status_filter = $('input[name=options]:checked').val();
					d.pay_status_filter = $('#pay_status_filter input[name=pay_status]:checked').val();

					d.multiple = $('#s_multiple').prop("checked") ? 1 : 0;
					d.station_id = $('#s_station_id').val();

					d.lot_number = $('#s_lot_number').val();
					d.product_name = $('#s_product_name1').val();
					d.trace_batch = $('#s_trace_batch').val();
					d.container_sn = $('#s_container_sn').val();
					d.sn = $('#s_sn').val();

					d.type = $('#s_storage').val();
					return d;
				},
				dataSrc : 'items',
				dataType : 'json',
				type : 'post'
			},

			sDom :  "<'dt-toolbar'<'col-sm-12 col-xs-12'>r>"+
								"<'table-responsive'"+
								"t"+
								">"+
								"<'dt-toolbar-footer'<'col-sm-6 col-xs-12'><'col-xs-12 col-sm-6 hidden-xs'>>",

			columns : [{
				data : 'create_date'
			},{
				data : 'type',
				render:function(d,t,r) {
					if(d == 0 ) {
						return "原料";
					}
					if(d == 2 ) {
						return "成品";
					}
					return d;
				}
			},{
				data : 'container_sn'
			},{
				data : 'order_sn',
				render: function(d,t,r) {
					var html = d;
					html += $('<a class="btn btn-primary btn-xs" href="javascript:void(0)">流向</a>')[0].outerHTML;
					html += $('<a class="btn btn-danger btn-xs" href="javascript:void(0)">內容</a>')[0].outerHTML;
					return html;
				}
			},{
				data : 'lot_number'
			},{
				data : 'product_name'
			},{
				data : 'psn'
			},{
				data : 'trace_batch'
			}, {
				data : 'sum_weight',
				render: function(d,t,r) {
					return parseFloat(d).toFixed(2);
				}
			}, {
				data : 'sum_weight_0',
				render: function(d,t,r) {
					return parseFloat(d).toFixed(2);
				}
			}, {
				data : 'sum_weight_2',
				render: function(d,t,r) {
					return parseFloat(d).toFixed(2);
				}
			}, {
				data : 'sum_weight',
				render: function(d,t,r) {
					var html = '0';
					if(parseFloat(r.sum_weight_0) > 0) {
						html = (parseFloat(r.sum_weight_2) / parseFloat(r.sum_weight_0)).toFixed(2);
					}
					return html;
				}
			}],
			ordering: false,
			order : [[0, "desc"]],
			columnDefs : [{
				targets : 0,
				data : null,
				defaultContent : app.defaultContent,
				searchable : false,
				orderable : false,
				width : "5%",
				className : ''
			}, {
				"targets" : [1,2],
				"orderable" : false
			}],


			footerCallback: function ( row, data, start, end, display ) {
        var api = this.api();

      },
			fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
						// edit click
						if(!app.disableRowClick) {
							var _rtd = $(nRow).find('td');
							if(!app.enableFirstClickable) {
								_rtd = _rtd.not(':first')
							}
							_rtd.addClass('pointer').on('click', function(){
								if(app.isA1) {
									app.isA1 = false;
									return;
								}
								app.doEdit(aData.order_id);

								// remove all highlight first
								$(this).parent().parent().find('tr').removeClass('active');

								app._lastPk = aData.id;
								app._tr = $(this).parent();
								setTimeout(function(){
									app._tr.addClass('active');
								}, 100);
							});
						}

						if(app._lastPk && aData.id && app._lastPk == aData.id) {
							$(nRow).addClass('active');
						}

						// delete click
						$(nRow).find("a").eq(0).click(function() {
							app.isA1 = true;
							app._lastPk = aData.id;

							// remove all highlight first
							$(nRow).parent().find('tr').removeClass('active');

							app._lastPk = aData.id;
							setTimeout(function(){
								$(nRow).addClass('active');
							}, 100);
							app.doFlow(aData.order_id);
						});

						// if(app.fnRowCallbackExt) {
						// 	app.fnRowCallbackExt(nRow, aData, iDisplayIndex, iDisplayIndexFull, this);
						// }
				}

		}));

		// data table actions
		app.dtActions();

		function getCoVal(co, key) {
			if(co[key]) {
				return parseInt(co[key]);
			}
			return 0;
		}

		function setSpanVal(elId, val) {
			console.log("val: " + val);
			console.log("elId: " + elId);
			if(val > 0) {
	    		$('#' + elId).parent().find('span').show().text(val);
	    	} else {
	    		$('#' + elId).parent().find('span').hide();
	    	}
		}

		app.mDtTable.on( 'xhr', function () {
		    var json = app.mDtTable.ajax.json();
				$('#sum_orders').html(numberWithCommas(json.items.length));

				var sumWeight = 0;
				var sumWeight_0 = 0;
				var sumWeight_2 = 0;
				$.each(json.items, function(){
					sumWeight += parseFloat(this.sum_weight);
					if(this.type == 0) {
						sumWeight_0 += parseFloat(this.sum_weight);
					}
					if(this.type == 2) {
						sumWeight_2 += parseFloat(this.sum_weight);
					}
				});
				$('#sum_weight').html(numberWithCommas(sumWeight.toFixed(2)));
				$('#sum_weight_0').html(numberWithCommas(sumWeight_0.toFixed(2)));
				$('#sum_weight_2').html(numberWithCommas(sumWeight_2.toFixed(2)));
		});

		// get year month list
		app.tableReload();

		// set status filter
		$('#status_filter label').on('click', function(){
			$(this).find('input').prop('checked', true);
			app.tableReload();
		});
		$('#status_filter > label > span').hide();

		// set pay status filter
		$('#pay_status_filter label').on('click', function(){
			$(this).find('input').prop('checked', true);
			app.tableReload();
		});
		$('#pay_status_filter > label > span').hide();

		// edit
		app.doEdit = function(id) {
		    var loading = $('<h1 class="ajax-loading-animation"><i class="fa fa-cog fa-spin"></i> Loading...</h1>')
		    	.appendTo($('#edit-modal-body').empty());
		    $("#btn-submit-edit").prop( "disabled", true);

			$('.tab-pane').removeClass('active'); $('#edit_page').addClass('active');

			$('#edit-modal-body').load(baseUrl + 'mgmt/orders/edit_report/' + id, function(){
	        	$("#btn-submit-edit").prop( "disabled", false);
	        	loading.remove();
			});
		};

		app.doFlow = function(id) {
		    var loading = $('<h1 class="ajax-loading-animation"><i class="fa fa-cog fa-spin"></i> Loading...</h1>')
		    	.appendTo($('#edit-modal-body').empty());
		    $("#btn-submit-edit").prop( "disabled", true);

			$('.tab-pane').removeClass('active'); $('#edit_page').addClass('active');

			$('#edit-modal-body').load(baseUrl + 'mgmt/orders/flow/' + id, function(){
	        	$("#btn-submit-edit").prop( "disabled", false);
	        	loading.remove();
			});
		};

		app.doExportAll = function() {
			location.href = baseUrl + app.basePath + '/export_all';
		}

		// station change
		$('#s_station_id').on('change', function(){
			app.tableReload();
		});
		$('#s_product_name1').on('change', function(){
			app.tableReload();
			// alert("变化了");
		});
		$('#s_lot_number').on('change keyup', function(){
			app.tableReload();
		});
		$('#s_trace_batch').on('change keyup', function(){
			app.tableReload();
		});
		$('#s_container_sn').on('change keyup', function(){
			app.tableReload();
		});
		$('#s_storage').on('change', function(){
			app.tableReload();
		});
		$('#s_sn').on('change keyup', function(){
			app.tableReload();
		});

		$('#s_multiple').on('change', function(){
			if($('#s_multiple').prop("checked")) {
				// multiple
				$('#e_dt').prop("disabled", false)
			} else {
				$('#e_dt').prop("disabled", true)
			}

			app.tableReload();
		});

		$(".dt_picker").datetimepicker({
			format: 'YYYY-MM-DD'
		}).on('dp.change',function(event){
			currentApp.tableReload();
		});

		return app;
	};

	// return self
	return app.init();
});
