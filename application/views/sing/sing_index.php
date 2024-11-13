<!DOCTYPE html>
<html >
<meta charset="utf-8" name="viewport" content="width=device-width,initial-scale=1">
<title></title>
		<header >
		</header>
<style>

</style>
	
<span id="deviceUUID"></span>
</html >

<script>

function generateUUID() {
 // ⽣成⼀个随机UUID
 return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
 var r = Math.random() * 16 | 0,
 v = c === 'x' ? r : (r & 0x3 | 0x8);
 return v.toString(16);
 });
}
// 获取或创建设备唯⼀标识
function getDeviceUUID() {
 // 检查LocalStorage中是否已经有UUID
 let uuid = localStorage.getItem('deviceUUID');

 if (!uuid) {
 // 如果没有，则⽣成⼀个新的UUID并存入LocalStorage
 uuid = generateUUID();
 localStorage.setItem('deviceUUID', uuid);
 }
 return uuid;
}
const deviceUUID = getDeviceUUID();
console.log("设备唯⼀标识为: ", deviceUUID);
$('#deviceUUID').text(deviceUUID);
</script>

