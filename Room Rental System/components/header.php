<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>
<!-- header section starts -->
 <header>
        <!-- menu with contact information, post an Advertisement and My Profile, logo -->
        <section id="menu">
            <!-- top menu with contact information, post an Advertisement and My Profile-->
            <div id="contactMenu">
                <div class="contactInfo">
                <div class="landlineBox">
                <div class="landline">Landline <img src="../images/contactMenu/Phone off the Hook.svg" alt=""></div>
                <p id="landlinNumber">(01) 449922</p>
                </div>
                <div class="phoneBox">
                <div class="phone">Phone <img src="../images/contactMenu/Smartphone.svg" alt=""></div>
                <p id="phoneNumber">(977) 9847586972</p>
                </div>
                </div>
                <div class="postAndProfile">
                <!-- <div class="postAnAdvertisement"><a href="../router.php?route=postanadvertisement">Post an Advertisement</a></div> -->
                <div id="marginLine"></div>
                <div class="myProfile">
                    <img src="../images/contactMenu/ProfileImage.svg" alt="" class="profileImage">
                    <p class="myProfileText"><a href="../router.php?route=MyProfile">My Profile</a></p>
                </div>
                </div>
            </div>
            <!-- Menu containing search, login and register -->
            <!-- <div id="logoAndLoginMenu">
                <a href="../router.php?route="><img src="../images/logoAndLoginMenu/main logo.svg" alt="" id="logo"></a>
                <div class="loginAndRegister">
                    <div class="login">
                        <p class="welcomeText">WELCOME</p>
                        <p class="loginText"><a href="../router.php?route=login">Login</a></p>
                    </div>
                    <div class="register">
                        <p class="newToGharbhadaText">NEW TO GHARBHADA?</p>
                        <p class="registerText"><a href="../router.php?route=register"> Register</a></p>
                    </div>
                </div>
            </div> -->
            <div id="logoAndLoginMenu">
            <?php
// Start the session at the top of the file (if not already included elsewhere)


// Check if user is logged in and has a role, otherwise use a default
if (isset($_SESSION['user']) && isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'tenant') {
    // Show default link for tenants
?>
    <a href="../router.php?route=">
        <img src="../images/logoAndLoginMenu/main logo.svg" alt="" id="logo">
    </a>
<?php
} else if (isset($_SESSION['user']) && isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'landlord') {
    // Show "Post An Advertisement" link for landlords
?>
    <a href="../components/PostAnAdvertisement.php">
        <img src="../images/logoAndLoginMenu/main logo.svg" alt="" id="logo">
    </a>
<?php
} else {
    // Show default link for all other cases (including non-logged-in users)
?>
    <a href="../router.php?route=">
        <img src="../images/logoAndLoginMenu/main logo.svg" alt="" id="logo">
    </a>
<?php
}
?>


    <?php if (!isset($_SESSION['user'])): // Show login/register if user is not logged in ?>
        <div class="loginAndRegister">
            <div class="login">
                <p class="welcomeText">WELCOME</p>
                <p class="loginText"><a href="../router.php?route=login">Login</a></p>
            </div>
            <div class="register">
                <p class="newToGharbhadaText">NEW TO GHARBHADA?</p>
                <p class="registerText"><a href="../router.php?route=register">Register</a></p>
            </div>
        </div>
    <?php endif; ?>
</div>
        </section>
    </header>
    <section id="searchMenu">
        <div class="searchBar">
            <form action="../Controllers/SearchController.php?action=search" method="POST" style="display: block;">
            <input type="text" placeholder="Search for location..." name="location">
              <button type="submit" style="background: none; border: none; padding: 0; cursor: pointer;">
        <img src="../images/searchMenu/search.svg" alt="Search" id="searchIcon">
    </button>
            </form>
        </div>
        <div class="informationTextGroup">
        <p class="informationText">Find your dream apartment</p>
        <p class="informationText">easy and hassle free!</p>
        <p class="informationText">across 100 locations</p>
        </div>
    </section>
    <!-- header section ends -->