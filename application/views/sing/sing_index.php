<!DOCTYPE html>
<html >
<meta charset="utf-8" name="viewport" content="width=device-width,initial-scale=1">
<script src="<?= base_url() ?>sing/sing.js"></script>

<title></title>
		<header >
		</header>
<style>

</style>
	
  </html >

<script>

document.addEventListener('plusready',function(){ 
	function device(name){
		 return plus.device.name;
	}
	console.log(device('uuid'));
	console.log(device('imei'));
	console.log(device('model'));
	console.log(device('vendor'));
	console.log(device('imsi'));
})
</script>

