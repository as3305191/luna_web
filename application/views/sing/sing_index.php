<style>
  .s_sum {
  	display: none;
  }
  .menu_img_unsuccess {
  	display: none;
  }
  .hide_s_i {
  	display: none;
  }
  .element {
    /* border: 5px solid; */
    position: absolute;
    top: 110%;
    left: 50%;
    transform: translate(-50%, -10%);
    padding: 10px;
  }
  .element_table {
    /* border: 5px solid; */
    position: absolute;
    top: 110%;
    /* left: 50%;
    transform: translate(-50%, -50%);
    padding: 10px; */
  }
@media only screen and (max-width: 750px) {
	.dt_list_th{
	  min-width: 67px !important;
	}
  .dt_list_th_big{
	  min-width: 100px !important;
	}
}

</style>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php $this -> load -> view("sing/old_system_view_head")  ?>
  <link rel="stylesheet" href="<?= base_url('assets/vendor/fancybox/jquery.fancybox.min.css'); ?>" />

</head>

<body>
  <main>
    <!-- Header -->
    <?php $this -> load -> view("old_system_view/old_system_view_header")  ?>
    <!-- End Header -->

    <section class="g-mb-100">
      <div class="container">
        <div class="row">

          <!-- Coach Sidebar -->
          <?php $this -> load -> view("old_system_view/old_system_view_sidebar")  ?>
          <!-- End Coach Sidebar -->

          <!-- Profile Content -->
          <div class="col-lg-9">
            <!-- Overall Statistics -->
            <!-- Profile Content -->
            <div class="col-lg-12">
              <!-- Overall Statistics -->
              <div class="" >
                <span id="UUID"></span>
                <select name="num" id="num">
                  <option value="0">--請選擇--</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                </select>
              </div>
            </div>
            <!-- End Profile Content -->
            </div>
          </div>
          <!-- End Profile Content -->
        </div>
      </div>
    </section>

    <!-- Footer -->
    <?php $this -> load -> view("old_system_view/old_system_view_footer")  ?>
    <!-- End Footer -->
  </main>

<div class="u-outer-spaces-helper"></div>

</body>
</html>


<?php $this -> load -> view("old_system_view/old_system_view_script")  ?>
<script>
  var baseUrl = '<?=base_url('')?>';
  function generateUUID() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
    var r = Math.random() * 16 | 0,
    v = c === 'x' ? r : (r & 0x3 | 0x8);
    return v.toString(16);
    });
  }
  function getDeviceUUID() {
    let uuid = localStorage.getItem('deviceUUID');

    if (!uuid) {
    uuid = generateUUID();
    localStorage.setItem('deviceUUID', uuid);
    }
    return uuid;
  }
  const deviceUUID = getDeviceUUID();
  $('#UUID').text(deviceUUID);

  function do_save() {
		var url = baseUrl + 'sing/index/give_ticket';

		$.ajax({
			type : "POST",
			url : url,
			data : {
				deviceUUID: deviceUUID,
				num: $('#num').val(),	
				
			},
			success : function(data) {
				if(data.error_msg) {
					layer.msg(data.error_msg);
				} else {
					var this_id = $('#item_id').val;
					if(this_id>0){
						currentApp.mDtTable.ajax.reload(null, false);
						currentApp.back(this_id);
					} else{
						currentApp.mDtTable.ajax.reload(null, false);
						currentApp.backTo();
					}
				}
			}
		});
		
	};

</script>
