<!DOCTYPE html>
<html >
<meta charset="utf-8" name="viewport" content="width=device-width,initial-scale=1">
<title></title>
		<header >
		</header>
<style>

</style>
	<span>mac:<?= $mac ?></span>

  </html >
<script>
chrome.system.network.getNetworkInterfaces((interfaces) => {

interfaces.forEach(interface => {


	console.log(`MAC Address: ${interface.macAddress}`);


});


});


</script>

