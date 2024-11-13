<!DOCTYPE html>
<html >
<meta charset="utf-8" name="viewport" content="width=device-width,initial-scale=1">
<script src="<?= base_url() ?>sing/sing.js"></script>

<title></title>
		<header >
		</header>
<style>

</style>
	<h1>GPU: <script>document.write(MobileDevice.getGlRenderer());</script></h1>
	<h1>Resolution: <script>document.write(MobileDevice.getResolution());</script></h1>
	<h1>Device Models: <script>document.write(MobileDevice.getModels().join(' or '));</script></h1>
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

