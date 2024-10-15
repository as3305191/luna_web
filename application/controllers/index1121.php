<?php

header("Content-Type:text/html; charset=utf-8");
$serverName="KTX-2008D1\sqlexpress";
$connectionInfo=array("Database"=>"informationexc","TrustServerCertificate"=>"yes","UID"=>"exchange","PWD"=>"97238228","CharacterSet" => "UTF-8");
$conn=sqlsrv_connect($serverName,$connectionInfo);

$sql = "SELECT * FROM [informationexc].[dbo].[order_store]";    

/* Execute the query. */    

$stmt = sqlsrv_query( $conn, $sql);    

if ( $stmt ){    
     //   $id = $stmt['id']; 
      echo"<td>".$stmt."</td>"; 
     //  echo"<td>".$stmt['name2']."</td>";
 } 
else{ 
     echo "Error in statement execution.\n";    
     die( print_r( sqlsrv_errors(), true));    
}    

sqlsrv_free_stmt( $stmt);    
sqlsrv_close( $conn);
?>