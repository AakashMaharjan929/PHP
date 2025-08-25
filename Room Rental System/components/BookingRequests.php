<?php
// Get the current script's filename
$current_file = basename($_SERVER['PHP_SELF']);

// Initialize background colors
$background_color_profile = ''; // Default color or other color if needed
$background_color_ads = ''; // Default color or other color if needed

// Check if the current script is MyProfile.php inside the components folder
if (strpos($_SERVER['REQUEST_URI'], '/components/MyProfile.php') !== false) {
    $background_color_profile = '#1ABA1A';
      $text_colorInfo = 'white';
    $arrowColorInfo = 'arrowProfileInfo.svg';
}else{
    $background_color_profile = 'white';
    $text_colorInfo = 'black';
    $arrowColorInfo = 'blackArrow.svg';
}

// Check if the current script is MyAdvertisements.php inside the components folder
if (strpos($_SERVER['REQUEST_URI'], '/components/MyAdvertisements.php') !== false) {
    $background_color_ads = '#1ABA1A';
    $text_color = 'white';
  $arrowColor = 'arrowProfileInfo.svg';
}else{
    $background_color_ads = 'white';
    $text_color = 'black';
    $arrowColor = 'blackArrow.svg';
}

if (strpos($_SERVER['REQUEST_URI'], '/components/MyBookings.php') !== false) {
    $background_color_ads1 = '#1ABA1A';
    $text_color1 = 'white';
  $arrowColor1 = 'arrowProfileInfo.svg';
}else{
    $background_color_ads1 = 'white';
    $text_color1 = 'black';
    $arrowColor1 = 'blackArrow.svg';
}
if (strpos($_SERVER['REQUEST_URI'], '/components/BookingRequests.php') !== false) {
    $background_color_ads2 = '#1ABA1A';
    $text_color2 = 'white';
  $arrowColor2 = 'arrowProfileInfo.svg';
}else{
    $background_color_ads2 = 'white';
    $text_color2 = 'black';
    $arrowColor2 = 'blackArrow.svg';
}

session_start(); 


if (!isset($_SESSION['user'])) {
    header('Location: ../components/Login.php');
    exit();
}

$user = $_SESSION['user'];
$name = $user['name']; 
$email = $user['email'];
$phoneNumber = $user['phone'];

$nameParts = explode(' ', $name);

// Check if we have at least two parts (first and last name)
if (count($nameParts) >= 2) {
    $firstName = $nameParts[0];
    $lastName = $nameParts[1];
} else {
    // Handle cases where the name might not be in "First Last" format
    $firstName = $name;
    $lastName = ''; // or some default value
}

require_once '../Models/BookTourModel.php';
require_once '../Database/DatabaseConnection.php';
require_once '../Models/PostCRUDModel.php';


$user_id = $_SESSION['user']['id'];

$PostCRUDModel = new PostCRUD($db);
$UserPost = $PostCRUDModel->getUserPosts($user_id);

$BookTourModel = new BookTour($db);
$Posts = $BookTourModel->getAllPosts();


// Create an array to store the matched posts
$matchedPosts = [];

foreach ($UserPost as $userPost) {
    foreach ($Posts as $post) {
        // Compare "id" from both arrays if both are using "id"
        if ($userPost['id'] == $post['post_id']) {
            $matchedPosts[] = $post;
        }
    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/website Logo.jpg">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/myProfile.css">
    <title>My Profile</title>
</head>
<body>
    <?php
        include 'header.php';
    ?>

    <!-- My Profile section starts -->
     <section id="Profile">
        <div id="pageLocation">
            <p id="pageLocationText">Home <i>/</i> <b>profile</b></p>
        </div>
        <div id="ProfileBox">
            <div id="ProfileInfo">
                <img src="../images/MyProfile/MyProfile.svg" alt="" id="ProfileImage">
                <h1><?php echo ($name); ?></h1>
                <p><?php echo ($email); ?></p>
                <div class="MyAccount" style="background-color: <?php echo $background_color_profile;?>; color: <?php echo $text_colorInfo;?> ">
    <a href="../router.php?route=MyProfile" style="text-decoration: none; color: <?php echo $text_colorInfo;?>">My Profile</a> <img src="../images/MyProfile/<?php echo $arrowColorInfo ?>" alt="" id="arrowProfile">
</div>
<div class="MyAccount" style="background-color: <?php echo $background_color_ads;?>; color: <?php echo $text_color;?> ">
    <a href="../router.php?route=MyAdvertisements" style="text-decoration: none; color: <?php echo $text_color;?>">My Advertisements</a> <img src="../images/MyProfile/<?php echo $arrowColor ?>" alt="" id="arrowProfile">
</div>
<?php
// Check if the user is not a landlord (e.g., tenant or admin)
if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] !== 'landlord') {
?>
   <div class="MyAccount" style="background-color: <?php echo $background_color_ads1;?>; color: <?php echo $text_color1;?> ">
    <a href="../router.php?route=MyBookings" style="text-decoration: none; color: <?php echo $text_color1;?>">My Bookings</a> <img src="../images/MyProfile/<?php echo $arrowColor1 ?>" alt="" id="arrowProfile">
</div>
<?php
}
?>


<div class="MyAccount" style="background-color: <?php echo $background_color_ads2;?>; color: <?php echo $text_color2;?> ">
    <a href="../router.php?route=BookingRequests" style="text-decoration: none; color: <?php echo $text_color2;?>">Booking Requests</a> <img src="../images/MyProfile/<?php echo $arrowColor2 ?>" alt="" id="arrowProfile">
</div>
            </div>
    <div id="AdvertismentMain">
          <h1>Booking Requests</h1>
          <div id="AdvertisementList">
            <p id="PostName">Tenant Name</p>
            <p id="PostName">Post Name</p>
            <p id="PostName">Tour Date</p>       
            <p id="PostName">Status</p>          
            <div id="PostName">
              <p>Actions</p>
            </div>
          </div>
          <?php foreach ($matchedPosts as $post): ?>
            <?php

            
    
        $postDetails = $PostCRUDModel->getPostById($post['post_id']); // Adjust the method call as needed

        // Extract post_name from the fetched post details
        $post_name = $postDetails['title']; // Assuming 'post_name' is part of the post data
    ?>
    <div id="BookingList1">
        <p id="BookingName"><?php echo $post['tenantName']; ?></p> <!-- Assuming 'tenant_name' is part of $post -->
        <p id="BookingName"><?php echo $post_name; ?></p> <!-- Assuming 'post_name' is part of $post -->
        <p id="BookingName"><?php echo $post['TourDate']; ?></p> <!-- Assuming 'tour_date' is part of $post -->
        <p id="BookingName"><?php echo $post['status']; ?></p> <!-- Assuming 'status' is part of $post -->
        <div id="PostActionTour">
        <button id="DeletePost">
        <a href="../Controllers/BookTourController.php?action=cancel&post_id=<?php echo $post['post_id']; ?>&tranc_id=<?php echo $post['uid']; ?>" id="searchPost_<?php echo $post['post_id']; ?>" style="text-decoration: none; color: white">Cancel</a>
</button>
        </div>
    </div>  
<?php endforeach; ?>

        </div>
    </div>
     </section>
    <!-- My Profile section ends -->

    <?php
        include 'footer.php';
    ?>
</body>
</html>