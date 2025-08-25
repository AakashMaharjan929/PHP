<?php
require_once '../Models/SearchModel.php';
require_once '../Database/DatabaseConnection.php';

$SearchModel = new SearchModel($db);

if (isset($_GET['location'])) {
    $location = $_GET['location'];
    $SearchResult = $SearchModel->searchPosts($location);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/website Logo.jpg">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../css/SearchPosts.css">
    <title>Search</title>
</head>
<body>
    <?php
        include 'header.php';
    ?>

    <!-- Search posts section starts -->
     <section id="SearchPosts">
        <div id="pageLocation">
            <p id="pageLocationText">Home <i>/</i> <b>Search</b></p>
        </div>
        <div id="SearchPostBox">
            <?php foreach ($SearchResult as $post): ?>
            <a href="../router.php?route=SinglePost&post_id=<?php echo ($post['id']); ?>" id="searchPost"> 
                <div id="AllPost">
                <img src="<?php echo($post['image1']) ?>" alt="" id="AllPostImg">
                <div id="AllPostInformation">
                    <h1 id="AllPostTitle"><?php echo($post['title']) ?></h1>
                    <p id="AllPostDescription"><?php echo($post['description']) ?> </p>
                    <p id="AllPostPrice"><?php echo($post['rent']) ?></p>
                    <div id="AllPostType">
                        <div id="AllPostLocation"><?php echo($post['location']) ?></div>
                        <div id="AllPostRoomType"><?php echo($post['for_whom']) ?></div>
                    </div>
                    <div id="AllPostPhoneNumber">
                        <img src="../images/RecentPosts/phoneIcon.svg" alt="phone icon" id="AllPostPhoneIcon">
                        <p id="AllPostNumber"><?php echo($post['phone_number']) ?></p>
                    </div>
                </div>
            </div></a>
            <?php endforeach; ?>
        </div>
        
     </section>
    <!-- Search posts section ends -->

    <?php
        include 'footer.php';
    ?>
</body>
</html>