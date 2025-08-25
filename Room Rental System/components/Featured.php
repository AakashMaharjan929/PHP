<?php

require_once '../Models/UserModel.php';
require_once '../Models/PostCRUDModel.php';
require_once '../Models/BoostPostsModel.php';
require_once '../Database/DatabaseConnection.php';

$userModel = new UserModel($db);
$postModel = new PostCRUD($db);
$boostPostModel = new BoostPosts($db);

$users = $userModel->GetUsers();
$posts = $postModel->GetPosts();
$boostedPosts = $boostPostModel->getBoostPost();
$totalEarnings = $boostPostModel->getTotalEarnings();

$userCount = count($users)-2;
$postCount = count($posts);

session_start();

if (!isset($_SESSION['boostedPostCount'])) {
    $_SESSION['boostedPostCount'] = mysqli_num_rows($boostedPosts);
}

$boostedPostCount = $_SESSION['boostedPostCount']*250;

if (isset($_GET['post_id'])) {
    $Postid = $_GET['post_id'];
    $SinglePost = $postModel->getSinglePost($Postid);
} else {
    $SinglePost = null;
}   



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../images/website Logo.jpg">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/Featured.css">
    <title>Add to Featured/Best Deals</title>
</head>
<body>
    <header>
        <div id="Dashboard">
        <p><img src="../images/Dashboard/homeIcon.svg" alt=""><a href="../router.php?route=DashBoard">Home</a></p>
        <p><img src="../images/Dashboard/settingsIcon.svg" alt=""><a href="../router.php?route=Featured">Add to Featured/ Best Deals</a></p>
    </div>
        <div id="AdminInfo">
            <img src="../images/contactMenu/ProfileImage.svg" alt="">
            <p>Admin</p>
            <button id="Logout" onclick="location.href = '../Controllers/LoginAndRegistrationController.php?action=logout'">Logout</button>
        </div>
    </header>
    <main>
        <div id="DashboardMain">
            <div id="TotalEarnings">
                <img src="../images/Dashboard/shopIcon.svg" alt="">
                <div>
                    <h1>Total Earnings</h1>
                    <p>Rs. <?php echo $totalEarnings; ?></p>
                </div>
            </div>
            <div id="TotalUsers">
                <img src="../images/Dashboard/peopleIcon.svg" alt="">
                <div>
                    <h1>Total Users</h1>
                    <p><?php echo number_format($userCount) ?></p>
                </div>
            </div>
            <div id="TotalPosts">
                <img src="../images/Dashboard/listIcon.svg" alt="">
                <div>
                    <h1>Total Posts</h1>
                    <p><?php echo number_format($postCount) ?></p>    
                </div>
            </div>
        </div>
        <form action="../Controllers/BoostPostsController.php?action=boost" method="POST">
            <div id="formFeature">
                <label for="">Post ID</label><br>
                <input type="text" placeholder="Post ID" name="PostID" value="<?php echo $SinglePost['id'] ?? ''; ?>"readonly>
            </div>
            <div id="formFeature">
                <label for="">Post Name</label><br>
                <input type="text" placeholder="Post Name" name="PostName" value="<?php echo $SinglePost['title'] ?? ''; ?>" readonly>
            </div>
            <div id="formFeature">
                <label for="">Type</label><br>
                <select name="Type" id="Type">
                    <option value="featured">Featured</option>
                    <option value="bestdeals">Best Deals</option>
                </select>
            </div>
            <div>
            <button>Boost</button>
            </div>  
        </form>
        <div id="ListOfUsers">
            <h1>List of Boosted Posts</h1>
            <table>
                <tr>
                    <th>Post Name</th>
                    <th>Post Section</th>
                    <th>Boosted Date</th>
                    <th>Action</th>
                </tr>
                <?php foreach($boostedPosts as $boostedPost): ?>
                <tr>
                    <td><?php echo ($boostedPost['post_name']) ?></td>
                    <td><?php echo ($boostedPost['post_section']) ?></td>
                    <td><?php echo ($boostedPost['created_at']) ?></td>
                    <td><button><a href="../Controllers/BoostPostsController.php?action=delete&post_id=<?php echo ($boostedPost['post_id']); ?>" id="searchPost" style="text-decoration: none; color: white">Delete</a></button></td>   
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </main>
</body>
</html>