var DailyReportOrderAppClass = (function(app) {
	app.basePath = "mgmt/daily_report/";
	app.enableFirstClickable = true;
	app.init = function() {
		app.mDtTable = $('#dt_list').DataTable($.extend(app.dtConfig,{
			ajax : {
				url : baseUrl + app.basePath + '/get_data',
				data : function(d) {
					d.start_time = $('#s_dt').val();
					d.e_dt = $('#e_dt').val();
					d.multiple = $('#s_multiple').prop("checked") ? 1 : 0;

					d.status_filter = $('input[name=options]:checked').val();
					d.pay_status_filter = $('#pay_status_filter input[name=pay_status]:checked').val();
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
				data : 'start_time'
			}, {
				data : 'sn'
			}, {
				data : 'status_name'
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
				data : 'sum_weight_2',
				render: function(d,t,r) {
					if(r.sum_weight_0 > 0) {
						return parseFloat(r.sum_weight_2 / r.sum_weight_0).toFixed(2);
					}
					return "-";
				}
			}, {
				data : 'finish_time'

			}],

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
				"targets" : [1,2,3],
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
				//setSpanVal('o_all', json.items.length);
				$('#sum_orders').html(numberWithCommas(json.items.length));

		    if(json.status_cnt) {
		    	var co = json.status_cnt, po = json.pay_status_cnt, val = 0;
					window.co = co;
		    	// o_0
		    	val = getCoVal(co, 0);
		    	setSpanVal('o_0', val);

		    	// o_1
		    	val = getCoVal(co, 1);
		    	setSpanVal('o_1', val);

		    	// o_2
		    	val = getCoVal(co, 2);
		    	setSpanVal('o_2', val);

		    	// o_3
		    	val = getCoVal(co, 3);
		    	setSpanVal('o_3', val);

		    	// o_m10
		    	val = getCoVal(co, -10);
		    	setSpanVal('o_m10', val);
		    	// o_m20
		    	val = getCoVal(co, -20);
		    	setSpanVal('o_m20', val);
		    	// o_m40
		    	val = getCoVal(co, -40);
		    	setSpanVal('o_m40', val);

		    	// o_m50
		    	val = getCoVal(co, -50);
		    	setSpanVal('o_m50', val);

		    	// ps_0
		    	val = getCoVal(po, 0);
		    	setSpanVal('ps_0', val);
		    	// ps_1
		    	val = getCoVal(po, 1);
		    	setSpanVal('ps_1', val);
		    	// ps_2
		    	val = getCoVal(po, 2);
		    	setSpanVal('ps_2', val);
		    	// ps_3
		    	val = getCoVal(po, 3);
		    	setSpanVal('ps_3', val);
		    	// ps_m1
		    	val = getCoVal(po, -1);
		    	setSpanVal('ps_m1', val);
		    	// ps_m2
		    	val = getCoVal(po, -2);
		    	setSpanVal('ps_m2', val);
		    	// ps_m3
		    	val = getCoVal(po, -3);
		    	setSpanVal('ps_m3', val);
		    }
		} );

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

		app.doExportAll = function() {
			location.href = baseUrl + app.basePath + '/export_all';
		}

		app.doExportById = function() {
			location.href = baseUrl + app.basePath + '/export_by_id';
		}

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
