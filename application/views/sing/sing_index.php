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
    transform: translate(-50%, 70%);
    padding: 10px;
  }
  .element_top {
    /* border: 5px solid; */
    position: absolute;
    top: 80%;
    /* left: 50%;
    /* transform: translate(-50%, -10%); */
    padding: 10px;
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
              <div class="element_top" >
                <!-- <span id="UUID" type="hidden"></span> -->
                <select name="num" id="num">
                  <option value="0">--請選擇--</option>
                  <option value="m_1">1. <?= isset($item) ? $item -> m_1 : '' ?></option>
                  <option value="m_2">2. <?= isset($item) ? $item -> m_2 : '' ?></option>
                  <option value="m_3">3. <?= isset($item) ? $item -> m_3 : '' ?></option>
                  <option value="m_4">4. <?= isset($item) ? $item -> m_4 : '' ?></option>
                  <option value="m_5">5. <?= isset($item) ? $item -> m_5 : '' ?></option>
                </select>

              </div>
              <button type="button" class="btn btn-sm btn-primary element" onclick="do_save()">投票</button>

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
  // $('#UUID').text(deviceUUID);

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
				
			}
		});
		
	};

</script>
