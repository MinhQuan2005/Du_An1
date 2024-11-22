<?php
    function connectDB(){
        $host="mysql:host=localhost;dbname=x_shop;charset=utf8";
        $user="root";
        $pass="0017";
        try {
            $conn=new PDO($host,$user,$pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
?>