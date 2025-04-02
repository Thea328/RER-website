<?php
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $dbname = 'test';

    $conn = mysqli_connect($host,$user,$pass,$dbname);

    if($conn){
       echo "Connection ok";
    }else{

        echo "connection failed" .mysqli_connect_error();
    }
?>