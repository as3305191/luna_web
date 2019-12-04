function checkSumWeightRatio() {
	var ratio = 0;
	if(currentApp.sumWeight != undefined && currentApp.sumWeightType0 != undefined) {
		if(currentApp.sumWeightType0 > 0) {
			ratio = parseFloat(currentApp.sumWeight / currentApp.sumWeightType0).toFixed(2);
		}
	}
	$('#sum_weight_ratio').html(ratio);
}

var YieldRateStationAppClass = (function(app) {
	app.basePath = "mgmt/yield_rate_station/";
	app.disableRowClick = true;

	app.init = function() {
		app.mDtTable = $('#dt_list').DataTable($.extend(app.dtConfig,{
			ajax : {
				url : baseUrl + app.basePath + '/get_data',
				data : function(d) {
					d.dt = $('#s_dt').val();
					d.e_dt = $('#e_dt').val();
					d.status_filter = $('input[name=options]:checked').val();
					d.pay_status_filter = $('#pay_status_filter input[name=pay_status]:checked').val();

					d.container_sn = $('#s_container_sn').val();

					d.multiple = $('#s_multiple').prop("checked") ? 1 : 0;
					d.station_id = $('#s_station_id').val();
					d.bypass_101 = $('#s_bypass_101').is(':checked') ? 1 : 0;
					d.type = 1;
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
				data : 'station_name'
			},{
				data : 'lot_number'
			},{
				data : 'product_name'
			}, {
				data : 'sum_number'
			}, {
				data : 'sum_weight'
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
				$.each(json.items, function(){
					sumWeight += parseFloat(this.sum_weight);
				});
				$('#sum_weight').html(numberWithCommas(sumWeight.toFixed(2)));

				if(currentApp) {
					currentApp.sumWeight = sumWeight;
					checkSumWeightRatio();
				}
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

			$('#edit-modal-body').load(baseUrl + 'mgmt/orders/edit/' + id, function(){
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
		$('#s_bypass_101').on('change', function(){
			app.tableReload();
		});
		$('#s_container_sn').on('keyup', function(){
			app.tableReload();
		});
		// alert('hi..')

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
			app.tableReload();
		});

		return app;
	};

	// return self
	return app.init();
});

var YieldRateStationAppType1Class = (function(app) {
	app.basePath = "mgmt/yield_rate_station/";
	app.disableRowClick = true;

	app.init = function() {
		app.mDtTable = $('#dt_list_type_0').DataTable($.extend(app.dtConfig,{
			ajax : {
				url : baseUrl + app.basePath + '/get_data',
				data : function(d) {
					d.dt = $('#s_dt').val();
					d.e_dt = $('#e_dt').val();
					d.status_filter = $('input[name=options]:checked').val();
					d.pay_status_filter = $('#pay_status_filter input[name=pay_status]:checked').val();

					d.container_sn = $('#s_container_sn').val();

					d.multiple = $('#s_multiple').prop("checked") ? 1 : 0;
					d.station_id = $('#s_station_id').val();
					d.bypass_101 = $('#s_bypass_101').is(':checked') ? 1 : 0;
					d.type = 0;
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
				data : 'station_name'
			},{
				data : 'lot_number'
			},{
				data : 'product_name'
			}, {
				data : 'sum_number'
			}, {
				data : 'sum_weight'
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
				$('#sum_orders_type_0').html(numberWithCommas(json.items.length));

				var sumWeight = 0;
				$.each(json.items, function(){
					sumWeight += parseFloat(this.sum_weight);
				});
				$('#sum_weight_type_0').html(numberWithCommas(sumWeight.toFixed(2)));

				if(currentApp) {
					currentApp.sumWeightType0 = sumWeight;
					checkSumWeightRatio();
				}
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

			$('#edit-modal-body').load(baseUrl + 'mgmt/orders/edit/' + id, function(){
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
		$('#s_bypass_101').on('change', function(){
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

		$('#s_container_sn').on('keyup', function(){
			app.tableReload();
		});

		$(".dt_picker").datetimepicker({
			format: 'YYYY-MM-DD'
		}).on('dp.change',function(event){
			app.tableReload();
		});

		return app;
	};

	// return self
	return app.init();
});
