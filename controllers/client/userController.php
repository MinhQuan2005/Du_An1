<?php

require_once './models/client/user.php';
require_once './commons/function.php';

class UserController {
    private $userModel;

    private $pdo;


    public function __construct() {
        
        $host = 'localhost';
        $user="root";
        $db = 'x_shop';   
        $pass = '0017'; 
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            die("Lỗi kết nối: " . $e->getMessage());
        }

       
        $this->userModel = new User($this->pdo);
    }
    

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            if ($this->userModel->register($username, $email, $password)) {
                header("Location: account/login.php");
                exit();
            } else {
                echo "Error in registration!";
            }
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
    
            $user = $this->userModel->login($username, $password);
    
            if ($user) {
                session_start();
                $_SESSION['user'] = $user;
                $_SESSION['login_message'] = "Đăng nhập thành công!";
    
                if ($user['is_admin']) {
                    header("Location: ../../../Du an 1_Nhom 4/views/admin/adminDashboard.php");
                } else {
                    header("Location: index.php?act=home");
                }
                exit();
            } else {
                session_start();
                $_SESSION['login_message'] = "Sai thông tin đăng nhập hoặc tài khoản không tồn tại";
                header("Location: account/login.php");
                exit();
            }
        }
    }
    

    public function logout() {
        session_start();
        session_destroy();
        header("Location: account/login.php");
    }
}
?>
