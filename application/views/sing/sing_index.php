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
fetch('/get-mac')

.then(response => response.json())


.then(data => console.log('MAC Address:', data.mac))


.catch(error => console.error('Error:', error));
</script>

