var ProductionMonthlySumAppClass = (function(app) {
	app.basePath = "mgmt/production_monthly_sum/";
	app.disableRowClick = true;
	app.init = function() {
		app.mDtTable = $('#dt_list').DataTable($.extend(app.dtConfig,{
			ajax : {
				url : baseUrl + app.basePath + '/get_data',
				data : function(d) {
					d.dt = $('#s_dt').val();
					d.e_dt = $('#e_dt').val();
					d.multiple = $('#s_multiple').prop("checked") ? 1 : 0;
					d.station_id = $('#s_station_id').val();
					d.user_id = $('#s_user_id').val();
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
				data : 'create_date'
			},{
				data : 'station_name'
			},{
				data : 'account'
			}, {
				data : 'user_name'
			}, {
				data : 'psn'
			},{
				data : 'sn'
			},{
				data : 'lot_number'
			}, {
				data : 'product_name'
			}, {
				data : 'sum_weight',
				render: function(d,t,r) {
					return parseFloat(d).toFixed(2);
				}
			}, {
				data : 'salary_code',
				render:function(d,t,r) {
					if(r.is_foreign == '1') return r.salary_code_foreign;
					return d;
				}
			}, {
				data : 'salary_code',
				render:function(d,t,r) {
					var val = parseFloat(r.val);
					if(r.is_foreign == '1') {
						val = parseFloat(r.val_f);
					}
					return parseFloat(val).toFixed(2);
				}
			}, {
				data : 'salary_code',
				render:function(d,t,r) {
					var val = parseFloat(r.val);
					if(r.is_foreign == '1') {
						val = parseFloat(r.val_f);
					}
					val = val * parseFloat(r.sum_weight);
					return parseFloat(val).toFixed(2);
				}
			}, {
				data : 'cut_cost',
				render:function(d,t,r) {
					return d;
				}
			}, {
				data : 'cut_cost',
				render:function(d,t,r) {
					return parseFloat(d * r.sum_weight).toFixed(2);
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
				$('#sum_orders').html(numberWithCommas(json.items.length));

				var sumReward = 0;
				$.each(json.items, function(){
					sumReward += (this.is_foreign == '1' ? parseFloat(this.reward_foreign) : parseFloat(this.reward));
				});
				// $('#sum_reward').html(numberWithCommas(sumReward.toFixed(2)));

				var sumWeight = 0;
				$.each(json.items, function(){
					sumWeight += parseFloat(this.sum_weight);
				});
				$('#sum_weight').html(numberWithCommas(sumWeight.toFixed(2)));

				// var sumTotal = 0;
				// $.each(json.items, function(){
				// 	sumTotal += (this.is_foreign == '1' ? parseFloat(this.sum_reward_foreign) : parseFloat(this.sum_reward));
				// });
				// $('#sum_reward_total').html(numberWithCommas(sumTotal.toFixed(2)));
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

		// station change
		$('#s_station_id').on('change', function(){
			app.tableReload();
			app.reloadUser();
		});

		$('#s_user_id').on('change', function(){
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

		app.reloadUser = function() {

			var url = baseUrl + currentApp.basePath + 'get_user_list'; // the script where you handle the form input.
			$.ajax({
				type : "POST",
				url : url,
				data : {
					station_id: $('#s_station_id').val()
				},
				success : function(data) {
					console.log(data.list);

					var $sel = $('#s_user_id').empty();
					$("<option></option>").html("無").attr("value", 0).appendTo($sel);
					$.each(data.list, function(){
						var me = this;
						$("<option></option>").html(me.user_name).attr("value", me.id).appendTo($sel);
					});

					// reload table
					// app.tableReload();
				}
			});
		}

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
