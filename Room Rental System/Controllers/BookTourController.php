<?php
require_once '../Models/BookTourModel.php';

require_once '../Database/DatabaseConnection.php';

require_once '../Models/TransactionsModel.php';

session_start();

$bookTour = new BookTour($db);
$transaction = new TransactionsModel($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'post') {
    $post_id = $_POST['PostID'];
    $TourDate = $_POST['TourDate'];
    $user_id = $_SESSION['user']['id'];
    $name = $_SESSION['user']['name'];
    $RequestType = $_POST['RequestType']; // Add this to your form

    // Handle file upload for transaction screenshot
    if (isset($_FILES['TransactionScreenShot']) && $_FILES['TransactionScreenShot']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../Transactions/';
        $fileName = uniqid() . '-' . basename($_FILES['TransactionScreenShot']['name']);
        $transaction_screenshot = $uploadDir . $fileName;

        if (!move_uploaded_file($_FILES['TransactionScreenShot']['tmp_name'], $transaction_screenshot)) {
            die('File upload failed.');
        }
    } else {
        $transaction_screenshot = null; // Optional field, can be null
    }

    // Call CreateTourRequest with correct parameters
    $bookTour->CreateTourRequest($post_id, $TourDate, $user_id, $name, $RequestType, $transaction_screenshot);

    // Optionally update transactions with CallPrice as transact_amount
    if ($CallPrice) {
        $stmt = $db->prepare("UPDATE transactions SET transact_amount = ? WHERE post_id = ? AND request_type = ? ORDER BY id DESC LIMIT 1");
        $stmt->bind_param("dis", $CallPrice, $post_id, $RequestType);
        $stmt->execute();
        $stmt->close();
    }

    header('Location: ../components/SinglePost.php?post_id=' . $post_id);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['bookTour_id'])) {
    $bookTour_id = $_GET['bookTour_id'];

    // Assuming $bookTour is the instance of your BookTour class
    $bookTour->DeleteTourRequest($bookTour_id);
    header('Location: ../components/MyBookings.php');
    exit();
}




if (isset($_GET['action']) && $_GET['action'] === 'ConfirmPost'){
    $id = $_GET['id'];
    $tranc_id = $_GET['tranc_id'];

    $transaction->confirmPost($id, $tranc_id);

    header('Location: ../router.php?route=DashBoard');
    exit();
}

if (isset($_GET['action']) && $_GET['action'] === 'refund'){
    $id = $_GET['id'];
    $tranc_id = $_GET['tranc_id'];

    $transaction->refund($id, $tranc_id);

    header('Location: ../router.php?route=DashBoard');
    exit();
}

if (isset($_GET['action']) && $_GET['action'] === 'cancel'){
    $post_id = $_GET['post_id'];
    $tranc_id = $_GET['tranc_id'];

    $bookTour->rejectPost($post_id, $tranc_id);
    header('Location: ../components/BookingRequests.php');
    exit();
}
if (isset($_GET['action']) && $_GET['action'] === 'cancelNew'){
    $post_id = $_GET['post_id'];
    $tranc_id = $_GET['tranc_id'];

    $bookTour->rejectPostNew($post_id, $tranc_id);
    header('Location: ../components/MyBookings.php');
    exit();
}

?>

