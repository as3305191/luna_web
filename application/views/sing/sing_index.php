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
    transform: translate(-50%, 700%);
    padding: 10px;
  }
  .element_top {
    /* border: 5px solid; */
    position: absolute;
    /* top: 20%; */
    left: 50%;
    transform: translate(-50%, 10%);
    padding: 10px;
  }
 
  .div_center {
    display: flex;
    justify-content: center;    
    align-items: center;
  }
  .t_center {
    text-align: left;
  }
@media only screen and (max-width: 750px) {
	.dt_list_th{
	  min-width: 67px !important;
	}
  .dt_list_th_big{
	  min-width: 100px !important;
	}
  .div_center {
    display: flex;
    justify-content: center;    
    align-items: center;
  }
  .t_center {
    text-align: left;
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
              <div class="col-md-12 g-mb-30">
                <!-- Icon Blocks -->


                  <div class="g-brd-around--md g-brd-gray-light-v4 text-center g-pa-10 g-px-30--lg g-py-40--lg">
                  <span class="d-block g-color-gray-dark-v4 g-font-size-40 g-mb-15">
                    <i class="icon-education-087 u-line-icon-pro"></i>
                  </span>
                  <input id="test">

                  <?php if (isset($item)): ?>
                    <input id="sing_status_id" type="hidden" value="<?= isset($item) ? $item->id: '' ?>">
                    <h3 class="h5 g-color-black g-mb-10">請將票投給您最喜歡的參賽者</h3>
                      <ul class="list-unstyled g-px-30 g-mb-0 ">
                        <li class="g-brd-bottom g-brd-gray-light-v3 g-py-10 div_center"><div class="col-lg-2 col-md-2 col-sm-2 t_center"><input type="radio" name="m" value="m_1" id="m_1"><label for="m_1">1. <?= isset($item) ? $item -> m_1 : '' ?></label></div></li>
                        <li class="g-brd-bottom g-brd-gray-light-v3 g-py-10 div_center"><div class="col-lg-2 col-md-2 col-sm-2 t_center"><input type="radio" name="m" value="m_2" id="m_2"><label for="m_2">2. <?= isset($item) ? $item -> m_2 : '' ?></label></div></li>
                        <li class="g-brd-bottom g-brd-gray-light-v3 g-py-10 div_center"><div class="col-lg-2 col-md-2 col-sm-2 t_center"><input type="radio" name="m" value="m_3" id="m_3"><label for="m_3">3. <?= isset($item) ? $item -> m_3 : '' ?></label></div></li>
                        <li class="g-brd-bottom g-brd-gray-light-v3 g-py-10 div_center"><div class="col-lg-2 col-md-2 col-sm-2 t_center"><input type="radio" name="m" value="m_4" id="m_4"><label for="m_4">4. <?= isset($item) ? $item -> m_4 : '' ?></label></div></li>
                        <li class="g-brd-bottom g-brd-gray-light-v3 g-py-10 div_center"><div class="col-lg-2 col-md-2 col-sm-2 t_center"><input type="radio" name="m" value="m_5" id="m_5"><label for="m_5">5. <?= isset($item) ? $item -> m_5 : '' ?></label></div></li>
                        <li class="g-py-8"> <button type="button" class="btn btn-sm btn-primary" onclick="do_save()">投票</button></li>
                        <li class="g-py-8"> <button type="button" class="btn btn-sm btn-primary" onclick="view_ranking()">顯示投票結果</button></li>
                      </ul>
                  <?php else: ?>
                      <h3 class="h5 g-color-black g-mb-10">目前無開放的歌唱活動</h3>

                   <?php endif; ?>

                  </div> 

                <!-- End Icon Blocks -->
                </div>

              </div>


            </div>
          </div>
          <!-- End Profile Content -->
        </div>
      </div>
    </section>

    <!-- Footer -->
    <!-- End Footer -->
  </main>

<div class="u-outer-spaces-helper"></div>

</body>
</html>


<?php $this -> load -> view("old_system_view/old_system_view_script")  ?>
<script>
  	$(function() {      
        $('#test').val().append(deviceUUID);
    })

  var baseUrl = '<?=base_url('')?>';
  var  m = null;

  $('input:radio[name="m"]').on('change', function(){
    m = $('input:radio[name="m"]:checked').val();
  });

  function find_uuid_is_used(){
    const now = new Date();
    var url = baseUrl + 'sing/index/find_uuid_is_used';
    uuid = generateUUID();
		$.ajax({
			type : "POST",
			url : url,
			data : {
				uuid: uuid,
			},
			success : function(data) {
        if(data.not_use){
          const item = {
            value: uuid,
            // expired: now.getTime()+43200000
            expired: now.getTime()+5

          }
          localStorage.setItem('deviceUUID', JSON.stringify(item));
          return item;

        } else{
          // console.log('is_used');
          find_uuid_is_used();
        }
        
			}
		});
  }

  function getWithExpiry () {
    const itemStr = localStorage.getItem('deviceUUID');
    if (!itemStr) {
      return null;
    }

    const item = JSON.parse(itemStr);
    if (new Date().getTime() > item.expired) {
      localStorage.removeItem('deviceUUID')
      // console.log(localStorage.getItem('deviceUUID')) // null
      return null;

    }
    return item.value;
 }


  function generateUUID() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
      var r = Math.random() * 16 | 0,
      v = c === 'x' ? r : (r & 0x3 | 0x8);
      return v.toString(16);
    });
  }
  function getDeviceUUID() {
    getWithExpiry ();
    let uuid = localStorage.getItem('deviceUUID');
    if (!uuid) {
      
      uuid = find_uuid_is_used();
     
    }
    return uuid;
  }

  const deviceUUID = getDeviceUUID();
  function do_save() {
		var url = baseUrl + 'sing/index/give_ticket';

		$.ajax({
			type : "POST",
			url : url,
			data : {
				deviceUUID: deviceUUID,
        sing_status_id: $('#sing_status_id').val(),	
				num: m,	
			},
			success : function(data) {
        if(data.last_id){
          alert('投票完成');
          location.reload();
        } else{
          if(data.re_msg){
            alert(data.re_msg);
            location.reload();
          } else{
            alert(data.msg);
            location.reload();

          }
        }
				
			}
		});
		
	};

  function view_ranking() {
		var url = baseUrl + 'sing/index/view_ranking';

		$.ajax({
			type : "POST",
			url : url,
			data : {
			},
			success : function(data) {
        if(data.success){
          location.href = "<?= base_url('sing/index/ranking') ?>";
        } else{
          alert(data.msg);

        }
				
			}
		});
		
	};

</script>
