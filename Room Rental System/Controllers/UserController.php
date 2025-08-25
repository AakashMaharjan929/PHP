<?php
require_once '../Models/UserModel.php';

require_once '../Database/DatabaseConnection.php';

$UserModel = new UserModel($db);

if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id = $_GET['id'];
    $UserModel->setUserStatus($id, 0); 
    echo "<script>
        alert('User has been deactivated.');
        window.location.href = '../router.php?route=DashBoard';
    </script>";
    exit;
}

if (isset($_GET['action']) && $_GET['action'] === 'activate') {
    $id = $_GET['id'];
    $UserModel->setUserStatus($id, 1); 
    echo "<script>
        alert('User has been activated.');
        window.location.href = '../router.php?route=DashBoard';
    </script>";
    exit;
}


?>