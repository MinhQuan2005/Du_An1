<?php
    function connectDB(){
        $host="mysql:host=localhost;dbname=x_shop;charset=utf8"; 
        $user="root";
        $pass="";
        try {
            $conn = new PDO($host, $user, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->exec("SET NAMES 'utf8'");  
            return $conn;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
?>
