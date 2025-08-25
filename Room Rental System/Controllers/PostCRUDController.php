<?php
require_once '../Models/PostCRUDModel.php';

require_once '../Database/DatabaseConnection.php';

$PostCRUDModel = new PostCRUD($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'post') {

    
    $file_name1 = $_FILES['image1']['name'];
    $tempName1 = $_FILES['image1']['tmp_name'];
    $folder1 = "../PostImages/".$file_name1;

    move_uploaded_file($tempName1, $folder1);

    $file_name2 = $_FILES['image2']['name'];
    $tempName2 = $_FILES['image2']['tmp_name'];
    $folder2 = "../PostImages/".$file_name2;

    move_uploaded_file($tempName2, $folder2);

    $file_name3 = $_FILES['image3']['name'];
    $tempName3 = $_FILES['image3']['tmp_name'];
    $folder3 = "../PostImages/".$file_name3;

    move_uploaded_file($tempName3, $folder3);


    $userId = $_POST['user_id'];
    $name = $_POST['name'];
    $phoneNumber = $_POST['phoneNumber'];
    $title = $_POST['title'];
    $rent = $_POST['rent'];
    $location = $_POST['location'];
    $type = $_POST['type'];
    $floor = $_POST['floor'];
    $entrance = $_POST['entrance'];
    $forWhom = $_POST['for'];
    $roadSize = $_POST['RoadSize'];
    $bedrooms = $_POST['Bedroom'];
    $livingRooms = $_POST['LivingRoom'];
    $restrooms = $_POST['Restroom'];
    $image1 = $folder1;
    $image2 = $folder2;
    $image3 = $folder3;
    $description = $_POST['description'];

    $PostCRUDModel->createPost($userId, $name, $phoneNumber, $title, $rent, $location, $type, $floor, $entrance, $forWhom, $roadSize, $bedrooms, $livingRooms, $restrooms, $image1, $image2, $image3, $description);

    header('Location: ../index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'update'){

    $id = $_POST['id'];
    $name = $_POST['name'];
    $phoneNumber = $_POST['phoneNumber'];
    $title = $_POST['title'];
    $rent = $_POST['rent'];
    $location = $_POST['location'];
    $type = $_POST['type'];
    $floor = $_POST['floor'];
    $entrance = $_POST['entrance'];
    $forWhom = $_POST['for'];
    $roadSize = $_POST['RoadSize'];
    $bedrooms = $_POST['Bedroom'];
    $livingRooms = $_POST['LivingRoom'];
    $restrooms = $_POST['Restroom'];
    $description = $_POST['description'];

    $PostCRUDModel->UpdatePost($name, $phoneNumber, $title, $rent, $location, $type, $floor, $entrance, $forWhom, $roadSize, $bedrooms, $livingRooms, $restrooms, $description, $id);

    header('Location: ../index.php');
    exit();
}

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
    
    // Call the delete method from the PostCRUD class
    $result = $PostCRUDModel->deletePost($post_id);

    session_start();
    $user=$_SESSION['user'];
    $name=$user['name'];

    if ($result) {
        if($name === "admin"){
            header('Location: ../router.php?route=DashBoard');
            exit();
        }
        header('Location: ../router.php?route=MyAdvertisements');
        exit();
    }
}

?>