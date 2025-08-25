<?php
require_once '../Models/PostCRUDModel.php';

require_once '../Database/DatabaseConnection.php';

$PostCRUDModel = new PostCRUD($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'search') {
    $location = $_POST['location'];
    header('Location: ../router.php?route=search&location=' . $location);
    exit();
}

?>