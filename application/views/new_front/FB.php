<script>
// if(typeof FB != 'undefined') {
// 	$('#facebook-jssdk, #fb-root, .fb-login-button').remove(); // delete facebook sdk & login button
// 	delete FB; // delete FB object
//
// 	// append again
// 	$('#fb-login-button-parent').append(
// 		// remember to call checkLoginState() with 'onlogin' event
// 		$('<div class="fb-login-button" onlogin="checkLoginState();" data-width="200" data-max-rows="1" data-size="small" data-button-type="continue_with" data-show-faces="false" data-auto-logout-link="true" data-use-continue-as="false"></div>')
// 	);
// }

(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v3.3&appId=1345064518972339';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function statusChangeCallback(response) {
   console.log('statusChangeCallback');
   console.log(response);
   if(response.status === 'connected'){
     FB.api('/me?fields=id,name,email', function(response) {
       // FBlogin(response.email,response.name,response.id);
     });
   }

   // if (response.status === 'connected') {
    // 	 // Logged into your app and Facebook.
   //     var baseUrl = '<?=base_url('')?>';
   //     FB.api('/me?fields=id,name,email', function(response) {
   //       console.log(response);
   //       $.ajax({
   //         type:'POST',
   //         url: baseUrl + 'api/members/check_fb_id',
   //         data:{
   //           id:response.id
   //         },
   //         success:function(r){
   //           if(r.error_msg){
   //             var msg = r.error_msg;
   //             layer.alert(msg, {
   //               title:'',
   //               btn:'確定',
   //               icon:1,
   //               skin: 'layui-layer-molv'
   //               ,closeBtn: 0,
   //               anim:4,
   //             }, function(){
   //               fb_logout();
   //             });
   //           }else if(r.success_msg){
   //             window.location.href=baseUrl+"api/members/member_center";
   //           }
   //         }
   //       })
   //     });
   //
   //
    //  } else {
    // 	 // The person is not logged into your app or we are unable to tell.
   //
    //  }

 }


 function loginFB() {
   FB.getLoginStatus(function(response) {
     statusChangeCallback(response);
     if(response.status !== 'connected'){
       FB.login(function(response){
        if (response.status === 'connected') {
          FB.api('/me','GET',{
            "fields" : "id,name,gender,email"
          },function(response){
            if(response){
              console.log(response);
              //FB登入視窗點擊登入後，會將資訊回傳到此處。
              FBlogin(response.email,response.name,response.id);

            }else{
              layer.msg('FB登入發生錯誤');
            }


          });
        }
      },{
        scope : 'public_profile,email'
      });
    }
   });
 }

 // function doLogout() {
 //   FB.getLoginStatus(function(response) {
 //     if (response.status === 'connected') {
 //       if(confirm("確定登出")) {
 //         fb_logout();
 //       }
 //     } else {
 //       if(confirm("確定登出")) {
 //         location.href = '<?= base_url("loginFront/logout") ?>';
 //       }
 //     }
 //     console.log(response.status);
 //   });
 //
 // }

 function doLogout() {
   if(confirm("確定登出")) {
     location.href = '<?= base_url("loginFront/logout") ?>';
   }
   console.log(response.status);
 }

 function FBlogin(email,name,id) {
   $.ajax({
     url: '<?= base_url() ?>' + 'loginFrontLogin/do_fblogin',
     type: 'POST',
     data: {
       email : email,
       id : id,
       name : name
     },
     dataType: 'json',
     success: function(d) {
       if(d.error_msg) {
         layui.layer.msg(d.error_msg);
       } else {
         layui.layer.msg("成功登入");
         location.href='<?= base_url("loginFront") ?>';
       }
     },
     failure:function(){
       alert('faillure');
     }
   });
 }
  function fb_logout() {
    FB.getLoginStatus(function(response) {
      if (response.authResponse) {
        window.location = 'HTTPs://www.facebook.com/logout.php?access_token=' + response.authResponse.accessToken + '&next=https://www.ahda.com.tw/ahda_test/front/loginFrontLogin';
      }
    });
  }

 function checkLoginState() {
   FB.getLoginStatus(function(response) {
     statusChangeCallback(response);
   });
 }


window.fbAsyncInit = function() {
    FB.init({
      appId      : '{1345064518972339}',
      cookie     : true,  // enable cookies to allow the server to access
                          // the session
      xfbml      : true,  // parse social plugins on this page
      version    : 'v3.3' // use graph api version 2.8
    });

    FB.AppEvents.logPageView();

    // Now that we've initialized the JavaScript SDK, we call
    // FB.getLoginStatus().  This function gets the state of the
    // person visiting this page and can return one of three states to
    // the callback you provide.  They can be:
    //
    // 1. Logged into your app ('connected')
    // 2. Logged into Facebook, but not your app ('not_authorized')
    // 3. Not logged into Facebook and can't tell if they are logged into
    //    your app or not.
    //
    // These three cases are handled in the callback function.

    FB.getLoginStatus(function(response) {
      // statusChangeCallback(response);
    });

  };


  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
      console.log('Successful login for: ' + response.name);

    });
  }
</script>
