<?php
    include_once 'cooent.php';

        $search = array();
        if(isset($_POST['user_name'])){
            $user_name=$_POST['user_name'];
           
        }
        if(isset($_POST['user_dep'])){
            $user_dep=$_POST['user_dep'];
          
        }
        // echo "<script type='text/javascript'>console.log(".$user_name.")</script>";
        // echo "<script type='text/javascript'>console.log(".$user_dep.")</script>";
        $sql_done="SELECT * FROM products WHERE  dep='$user_dep' AND used_user_name='$user_name'  AND used>0";
        $select_done=mysqli_query($link,$sql_done);
        $total_c_done=mysqli_num_rows($select_done);
        
        // echo $total_c_done;
        $data = array();
        if($total_c_done <1){
            $sql="SELECT * FROM `products` WHERE used<1";
            $select=mysqli_query($link,$sql);
            $total=mysqli_num_rows($select);
            $rows = array();
            $gift= array();
            $text= '';
            
            if($total>=1){
                while($r = mysqli_fetch_assoc($select)) {
                    $rows[] = $r;
                }
                // $_SESSION['id']=$id;
                for($i=0;$i<count($rows);$i++){
                    array_push($gift,intval($rows[$i]["id"]));
    
                }
            
                $random_key=array_rand($gift);
                // $data['item']=array_rand($gift);
                
                $get_id = intval($gift[$random_key]);
                $sql_update ="UPDATE `products` SET  used = '1',used_user_name='$user_name', dep='$user_dep' WHERE id=$get_id;";
                mysqli_query($link,$sql_update);
               
                $data['item'] = $gift[$random_key];
                $sql_f_p_name="SELECT * FROM `products` WHERE id= $get_id;";
                $sql_f_p_name_r = mysqli_query($link,$sql_f_p_name);
                while($rr = mysqli_fetch_assoc($sql_f_p_name_r)) {
                    $rrows[] = $rr;
                }
            
                // var_dump($rrows[0]) ;
                // echo $rrows[0]  ;
                $data['p_name'] = $rrows[0]['product_name'];
                unset($gift[$random_key]);
            } 
            else{
                $data['item'] = 'no_item';
            }
        } else{
            $data['item'] = 'done';
        }

       
       
        header("Content-Type: application/json");

        echo json_encode($data, true);

?>