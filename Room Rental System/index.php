
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/website Logo.jpg">
    <link rel="stylesheet" href="css/style.css">
    <title>Ghar bhada</title>
</head>
<body>
    <!-- header section starts -->
     <?php
        include 'components/header.php';
    ?>
    <!-- header section ends -->
     <!-- main section starts -->
     <!-- main section starts -->
      <main>
        <!-- recent posts section starts -->
         <?php
            include 'components/recentposts.php';
        ?>
        <!-- recent posts section ends -->
         <!-- all posts and featured php starts -->
          <?php
            include 'components/AllPostsAndFeatured.php';
        ?>
         <!-- all posts and featured php end -->
      </main>
      <!-- main section ends -->
      <!-- main section ends -->
     <!-- footer section starts -->
    <?php
        include 'components/footer.php';
    ?>
    <!-- footer section ends -->
     <!-- js from here -->
     <script src="js/custom.js"></script>
</body>
</html>