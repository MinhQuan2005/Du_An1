<?php
session_start();
session_unset();
session_destroy();
header("Location: ../../../Du an 1_Nhom 4/account/login.php");
exit();