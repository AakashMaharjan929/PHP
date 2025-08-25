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
$boostPost = $boostPostModel->getBoostPost();
$boostedPosts = $boostPostModel->getBoostedPosts();
$totalEarnings = $boostPostModel->getTotalEarnings();

$userCount = count($users)-2;
$postCount = count($posts);

session_start();

if (!isset($_SESSION['boostedPostCount'])) {
    $_SESSION['boostedPostCount'] = mysqli_num_rows($boostPost);
}

require_once '../Models/TransactionsModel.php';

$transactionModel = new TransactionsModel($db);
$transactionRequests = $transactionModel->getConfirmedTransactions();

// Calculate boostedPostCount and add the total_amount from transactionRequests
$boostedPostCount = (isset($_SESSION['boostedPostCount']) ? (int)$_SESSION['boostedPostCount'] * 250 : 0) + $transactionRequests['total_amount'];

require_once '../Models/TransactionsModel.php';
$transactionModel = new TransactionsModel($db);
$transactionRequests = $transactionModel->getTransactions();



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../images/website Logo.jpg">
    <link rel="stylesheet" href="../css/dashboard.css">
    <title>Dashboard</title>
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
                    <p>Rs. <?php echo $boostedPostCount; ?></p>
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
        <div id="ListOfUsers">
            <h1>List of Users</h1>
            <table>
                <tr>
                    <th>Username</th>
                    <th>User ID</th>
                    <th>Action</th>
                </tr>
                <?php foreach($users as $user): ?>
                    <?php if ($user['name'] === "admin" || $user['name'] === "") continue; ?>
                <tr>
                    <td><?php echo ($user['name']) ?></td>
                    <td><?php echo ($user['id']) ?></td>
                 
                    <td><button onclick="location.href = '../Controllers/UserController.php?action=activate&id=<?php echo ($user['id']) ?>'" >Enable</button>&nbsp;<button style="background: red" onclick="location.href = '../Controllers/UserController.php?action=delete&id=<?php echo ($user['id']) ?>'">Disable</button></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <div id="ListOfUsers">
            <h1>List of Advertisements</h1>
            <table>
                <tr>
                    <th>Username</th>
                    <th>Post Name</th>
                    <th>Post ID</th>
                    <th>Action</th>
                </tr>
                <?php foreach($posts as $post): ?>
                <tr>
                    <td><?php echo ($post['name']) ?></td>
                    <td><?php echo ($post['title']) ?></td>
                    <td><?php echo ($post['id']) ?></td>
                    <td><button><a href="../Controllers/PostCRUDController.php?action=delete&post_id=<?php echo ($post['id']); ?>" id="searchPost" style="text-decoration: none; color: white">Delete</a></button></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <div id="ListOfUsers">
            <h1>Boost Post Requests</h1>
            <table>
                <tr>
                    <th>Post ID</th>
                    <th>Post Name</th>
                    <th>Payment Image</th>
                    <th>Action</th>
                </tr>
                <?php foreach($boostedPosts as $boostedPost): ?>
                <tr>
                    <td><?php echo ($boostedPost['post_id']) ?></td>  
                    <td><?php echo ($boostedPost['post_name']) ?></td>
                    <td><img src="<?php echo ($boostedPost['transaction_screenshot']) ?>" alt=""></td>
                    <td><button><a href="../router.php?route=BoostPost&post_id=<?php echo ($boostedPost['post_id']); ?>" id="searchPost" style="text-decoration: none; color: white">Approve</a></button>&nbsp;<button style="background: red"><a href="../Controllers/BoostPostsController.php?action=DeleteBoostedPost&id=<?php echo ($boostedPost['id']); ?>" id="searchPost" style="text-decoration: none; color: white">Delete</a></button></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <div id="ListOfUsers">
        <h1>Transaction Requests</h1>
            <table>
                <tr>
                    <th>Post ID</th>
                    <th>Request Type</th>
                    <th>Payment Status</th>
                    <th>Payment Image</th>
                    <th>Action</th>
                </tr>
                <?php foreach($transactionRequests as $trasaction): ?>
                <tr>
                    <td><?php echo ($trasaction['post_id']) ?></td>  
                    <td><?php echo ($trasaction['request_type']) ?></td>
                    <td><?php echo ($trasaction['status']) ?></td>
                    <td><img src="<?php echo ($trasaction['transaction_screenshot']) ?>" alt=""></td>
                    <td><button><a href="../Controllers/BookTourController.php?action=ConfirmPost&id=<?php echo ($trasaction['post_id']); ?>&tranc_id=<?php echo ($trasaction['id']); ?>" id="searchPost" style="text-decoration: none; color: white">Confirm</a></button>&nbsp;
                    <button style="background: red"><a href="../Controllers/BookTourController.php?action=refund&id=<?php echo ($trasaction['post_id']); ?>&tranc_id=<?php echo ($trasaction['id']); ?>" id="searchPost" style="text-decoration: none; color: white">Refund</a></button></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </main>
</body>
</html>