<?php
    include_once 'cooent.php';
    
        $search = array();
        if(isset($_POST['area_num']) ){
            $area_num=$_POST['area_num'];
        }
      
      
        $sql_done="SELECT * FROM drink_users WHERE  area_num='$area_num'";
        $select_done=mysqli_query($link,$sql_done);
        $total_c_done=mysqli_num_rows($select_done);
        // echo $select_done;
        // echo $total_c_done;
        $data = array();
        if($total_c_done >=1){
            while($r = mysqli_fetch_assoc($select_done)) {
                $rows[] = $r;
            }
            // // $_SESSION['id']=$id;
            // for($i=0;$i<count($rows);$i++){
            //     array_push($gift,intval($rows[$i]["id"]));

            // }
            // $data['list'] = $rows;
            header("Content-Type: application/json");

            echo json_encode($rows, true);
        } 
       
       

?>