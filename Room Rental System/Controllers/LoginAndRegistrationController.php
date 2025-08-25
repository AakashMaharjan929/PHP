<?php
require_once '../Models/RegistrationModel.php';

require_once '../Database/DatabaseConnection.php';

$userModel = new RegisterUser($db);
$userLoginModel = new LoginUser($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'register') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $role= $_POST['role'];

    if ($password !== $confirmPassword) {
        die("Passwords do not match.");
    }

    $user = $userLoginModel->loginUser($email);
    if ($user) {
        die("Email already exists.");
    }

    $userModel->registerUser($name, $email, $phone, $password, $role);

    header('Location: ../components/Login.php');
    exit();
}

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'login') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(empty($email) || empty($password)){
        $_SESSION['EmailError'] = "Please enter email";
        $_SESSION['passwordError'] = "Please enter password";
        header('Location: ../components/Login.php');
        exit();
    }

    $user = $userLoginModel->loginUser($email);
    
    if($user){
        if ($user['status'] == 0) {
            $_SESSION['AccountError'] = "Your account has been deactivated.";
            header('Location: ../components/Login.php');
            exit();
        }
        
        if($user['role']=="admin"){
            if(password_verify($password, $user['password'])){
                $_SESSION['user'] = $user;
                header('Location: ../components/Dashboard.php');
                exit();
            } else {
                $_SESSION['passwordError'] = "Incorrect password";
                header('Location: ../components/Login.php');
                exit();
            }
        }else {
            if(password_verify($password, $user['password']) && $user['role'] == "tenant"){
                $_SESSION['user'] = $user;
                header('Location: ../index.php');
                exit();
            } else if(password_verify($password, $user['password']) && $user['role'] == "landlord"){
                $_SESSION['user'] = $user;
                header('Location: ..\components\PostAnAdvertisement.php');
                exit();
            }
            else {
                $_SESSION['passwordError'] = "Incorrect password";
                header('Location: ../components/Login.php');
                exit();
            }
        }
        
    } else {
        $_SESSION['EmailError'] = "Email not found";
        header('Location: ../components/Login.php');
        exit();
    }

}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header('Location: ../index.php');
    exit();
}


if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header('Location: ../index.php');
    exit();
}
?>
