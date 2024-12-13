<html lang="en-us">

	<!-- #BODY -->
	<body id="form_div">
		
		<div >

			<!-- RIBBON -->
            部門：<input type="" id="user_dep"/>
			姓名：<input type="" id="user_name"/>
			

			<button type="button" onclick="do_lot();">抽籤</button>
			<div id="content">
			</div>
		</div>
	</body>
</html>
<script src="jquery.min.js"></script>
<!-- <script src="jquery-migrate.min.js"></script> -->
<script src="jquery.loading.min.js"></script>
	<script>
	
		function do_lot() {
			var user_name = $('#user_name').val();
			var user_dep = $('#user_dep').val();
			if(user_name.length>0 && user_dep.length>0){
				$('#content') .empty();
				$('#form_div').loading();
				
				$.ajax({
					url: 'api.php',
					type: 'POST',
					data: {
						user_name: $('#user_name').val(),
						user_dep: $('#user_dep').val(),
					},
					dataType: 'json',
					success: function(d) {
						$('#form_div').loading('stop');

						if(d){
							if(d.item=='done'){
								// alert('已抽過');
								$('#content') . append ( "<font  >已抽過</font >" ) ;
							} else{
								if(d.item=='no_item'){
									// alert('已無獎項');
									$('#content') . append ( "<font >已無獎項</font >" ) ;
								} else{
									// alert('恭喜抽到'+d.p_name);
									$('#content') . append ( '<font  color="red" size="6">恭喜抽到'+d.p_name+'</font >' ) ;
								}
							
							}
						}
						// location.reload();
					},
					failure:function(){
						$('#form_div').loading('stop');
						alert('faialure');
					}
				});
			} else{
				alert('請填寫全部欄位');
			}
			
		}
	</script>