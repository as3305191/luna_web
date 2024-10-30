<?php
    include_once 'cooent.php';
    
        $search = array();
        if(isset($_POST['user_name']) && isset($_POST['area'])&& isset($_POST['dep'])&& isset($_POST['morning_drink'])&& isset($_POST['morning_s'])&& isset($_POST['morning_i'])&& isset($_POST['afternoon_drink'])&& isset($_POST['afternoon_s'])&& isset($_POST['afternoon_i'])){
            $user_name=$_POST['user_name'];
            $dep=$_POST['dep'];
            $morning_drink=$_POST['morning_drink'];
            $morning_s=$_POST['morning_s'];
            $morning_i=$_POST['morning_i'];
            $afternoon_drink=$_POST['afternoon_drink'];
            $afternoon_s=$_POST['afternoon_s'];
            $afternoon_i=$_POST['afternoon_i'];
            $area=$_POST['area'];
        }
      
        // echo "<script type='text/javascript'>console.log(".$user_name.")</script>";
        // echo "<script type='text/javascript'>console.log(".$user_dep.")</script>";
        $sql_done="SELECT * FROM ktx_drink WHERE  dep='$dep' AND user_name='$user_name'";
        $select_done=mysqli_query($link,$sql_done);
        $total_c_done=mysqli_num_rows($select_done);
        
        // echo $total_c_done;
        $data = array();
        if($total_c_done <1){
            $sql="INSERT INTO ktx_drink (dep, user_name, morning_drink,morning_s,morning_i,afternoon_drink,afternoon_s,afternoon_i,area)
            VALUES ('$dep', '$user_name', '$morning_drink','$morning_s','$morning_i','$afternoon_drink','$afternoon_s','$afternoon_i','$area');";
            mysqli_query($link,$sql);
   
            $data['item'] = 'done';
        } else{
            $sql="UPDATE ktx_drink SET morning_drink = '$morning_drink',morning_s='$morning_s',morning_i='$morning_i',afternoon_drink='$afternoon_drink',afternoon_s='$afternoon_s',afternoon_i='$afternoon_i',area='$area' WHERE dep='$dep' AND user_name='$user_name';";
            mysqli_query($link,$sql);
            $data['item'] = 'update';
        }

       
       
        header("Content-Type: application/json");

        echo json_encode($data, true);

?>