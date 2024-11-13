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
const getmac = require('node:getmac');

getmac.getMac((err, macAddress) => {


  if (err) throw err;


  console.log('MAC Address: ' + macAddress);


});
</script>

