<style>
/* *{
	margin:0;
} */
html,body{
	margin:0;
	padding:0;
	height:100%;
}
body{
	margin:0;
	padding:0;
	height:100%;
	font:100%;
}
</style>
<div  style="position:relative;width:100%;height:100%;">
	<iframe id="iframe_ktx" name="iframe_ktx" src="//192.168.1.211/index.aspx" style=" width:100%; height:1000px" frameborder="0" scrolling="auto"></iframe>
</div>


<script type="text/javascript">
var account='<?= $login_user->account?>';
var password='<?= $login_user->password?>';
// var iframe_index = ($('#iframe_ktx').contentDocument||$('#iframe_ktx').contentWindow);
	// $(document).ready(function(){
		
	
	// })
	// $('#iframe_ktx').contents().find('#TxbAccount').text(account);
	// iframe_index.contents().find('#TxbPassword').text(account);
	// iframe_index.getElementById('TxbPassword').value=password;

</script>
