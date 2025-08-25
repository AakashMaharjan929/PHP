<?php
require_once '../Models/BoostPostsModel.php';

require_once '../Database/DatabaseConnection.php';

$BoostPosts = new BoostPosts($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'post'){
    $file_name = $_FILES['PayUsingEsewaMethod']['name'];
    $tempName = $_FILES['PayUsingEsewaMethod']['tmp_name'];
    $folder = "../BoostPosts/".$file_name;

    move_uploaded_file($tempName, $folder);

    $post_id = $_POST['PostID'];
    $post_name = $_POST['PostName'];
    $transaction_screenshot = $folder;

    $BoostPosts->CreateBoostPost($post_id, $post_name, $transaction_screenshot);

    header('Location: ../router.php?route=MyAdvertisements');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'boost'){
    $post_id = $_POST['PostID'];
    $post_name = $_POST['PostName'];
    $post_section = $_POST['Type'];

    $BoostPosts->BoostPost($post_id, $post_name, $post_section);
    $BoostPosts->addAmountToEarnings();

    header('Location: ../router.php?route=Featured');
    exit();
}

if (isset($_GET['action']) && $_GET['action'] === 'delete'){
    $post_id = $_GET['post_id'];

    $BoostPosts->deleteBoostPost($post_id);

    header('Location: ../router.php?route=Featured');
    exit();
}

if (isset($_GET['action']) && $_GET['action'] === 'DeleteBoostedPost'){
    $id = $_GET['id'];

    $BoostPosts->deleteBoostedPost($id);

    header('Location: ../router.php?route=DashBoard');
    exit();
}





?>