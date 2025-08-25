<?php

require_once '../Models/PostCRUDModel.php';
require_once '../Database/DatabaseConnection.php';

$PostCRUDModel = new PostCRUD($db);

session_start(); 


if (!isset($_SESSION['user'])) {
    header('Location: ../components/Login.php');
    exit();
}

$user = $_SESSION['user'];
$name = $user['name']; 
$phoneNumber = $user['phone'];
$id = $user['id'];

// $postCount = $PostCRUDModel->getUserPostCount($id);

// $postLimit = 2;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/website Logo.jpg">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../css/myProfile.css" />
    <link rel="stylesheet" href="../css/postAndAdvertisement.css">
    <title>Post an advertisement</title>
    <style>
        #NameField{
            display: none;
            color: red;
        }

        #PhoneNumberField{
            display: none;
            color: red;
        }

        #TitleField{
            display: none;
            color: red;
        }

        #RentField{
            display: none;
            color: red;
        }

        #LocationField{
            display: none;
            color: red;
        }

        #TypeField{
            display: none;
            color: red;
        }

        #FloorField{
            display: none;
            color: red;
        }

        #EntranceField{
            display: none;
            color: red;
        }

        #ForField{
            display: none;
            color: red;
        }

        #RoadSizeField{
            display: none;
            color: red;
        }

        #BedroomField{
            display: none;
            color: red;
        }

        #LivingroomField{
            display: none;
            color: red;
        }

        #RestroomField{
            display: none;
            color: red;
        }

        #Image1Field{
            display: none;
            color: red;
        }

        #Image2Field{
            display: none;
            color: red;
        }

        #Image3Field{
            display: none;
            color: red;
        }

        #DescriptionField{
            display: none;
            color: red;
        }
    </style>
</head>
<body>
    <?php
        include 'header.php';
    ?>

    <!-- Post and Advertisement section starts -->
     <section id="PostAnAdvertisement">
        <div id="pageLocation">
            <p id="pageLocationText">Home <i>/</i> <b>Post an Advertisment</b></p>
        </div>
        <h1 id="PostAnAdvertisementTitle">Post an advertisment</h1>
        <!-- <?php if ($postCount >= $postLimit): ?>
    <p id="exceedLimit" style="margin-left: 4.9rem; color: red;">You have exceeded the limit of 2 posts. <button onclick="PaymentForPremium(event)">Buy Premium</button> </p>
<?php endif; ?> -->
        <p id="fillAllBoxes">Please fill all boxes</p>
        <form action="../Controllers/PostCRUDController.php?action=post" id="PostForm" method="POST" onsubmit="ValidatePostForm(event)" enctype="multipart/form-data" >
            <input type="text" name="user_id" value="<?php echo($id) ?>" hidden>
            <div class="formGroupLarge">
            <div class="formGroup">
                <label for="name">Name <b>*</b></label><span id="NameField">Please Enter Name</span><br>
                <input type="text" id="name" name="name"  value="<?php echo ($name); ?>">
            </div>
            <div class="formGroup">
                <label for="name">Phone Number <b>*</b></label><span id="PhoneNumberField">Please Enter Phone Number</span><br>
                <input type="text" id="phoneNumberform" name="phoneNumber"  value="<?php echo ($phoneNumber); ?>">
            </div>
        </div>
            <div class="formGroupLarge">
            <div class="formGroup">
                <label for="name">Title of the room/apartment for rent <b>*</b></label><span id="TitleField">Please Enter Title</span><br>
                <input type="text" id="titlePost" name="title" placeholder="E.g 2BHK apartment for rent">
            </div>
        </div>
        <div class="formGroupLarge">
            <div class="formGroup">
                <label for="name">Rent per month  <b>*</b></label><span id="RentField">Please Enter Rent</span><br>
                <input type="text" id="rentPerMonth" name="rent" placeholder="E.g 15000">
            </div>
            <div class="formGroup">
                <label for="name">Location <b>*</b></label><span id="LocationField">Please Enter Location</span><br>
                <input type="text" id="location" name="location" placeholder="E.g Balaju">
            </div>
        </div>
        <div class="formGroupLarge">
            <div class="formGroup">
                <label for="name">Type <b>*</b></label><span id="TypeField">Please Enter Type</span><br>
                <select name="type" id="type" onchange="updateForOptions()">
                    <option value="residential" selected>Residential</option>
                    <option value="commercial">Commercial</option>
                </select>
            </div>
        </div>
        <div class="formGroupLarge">
            <div class="formGroup">
                <label for="name">Floor  <b>*</b></label><span id="FloorField">Please Enter Floor</span><br>
                <input type="text" id="floor" name="floor" placeholder="E.g 2">
            </div>
            <div class="formGroup">
                <label for="name">Entrance <b>*</b></label><span id="EntranceField">Please Enter Entrance</span><br>
                <input type="text" id="entrance" name="entrance" placeholder="E.g Main, Separate">
            </div>
        </div>
        <div class="formGroupLarge">
            <div class="formGroup">
                <label for="name">For <b>*</b></label><span id="ForField">Please Enter For</span><br>
                <select name="for" id="for" >
                    <option value="Family" selected>Family</option>
                    <option value="Single">Single</option>
                </select>
            </div>
        </div>
        <div class="formGroupLarge">
            <div class="formGroup">
                <label for="name">Road Size  <b>*</b></label><span id="RoadSizeField">Please Enter Road Size</span><br>
                <input type="text" id="RoadSize" name="RoadSize" placeholder="E.g 20">
            </div>
            <div class="formGroup">
                <label for="name">Number of bedroom <b>*</b></label><span id="BedroomField">Please Enter number of bedroom</span><br>
                <input type="text" id="Bedroom" name="Bedroom" placeholder="E.g 2">
            </div>
        </div>
        <div class="formGroupLarge">
            <div class="formGroup">
                <label for="name">Number of living room <b>*</b></label><span id="LivingroomField">Please Enter number of living room</span><br>
                <input type="text" id="LivingRoom" name="LivingRoom" placeholder="E.g 1">
            </div>
            <div class="formGroup">
                <label for="name">Number of Restroom <b>*</b></label><span id="RestroomField">Please Enter number of restroom</span><br>
                <input type="text" id="Restroom" name="Restroom" placeholder="E.g 1">
            </div>
        </div>
        <div class="formGroupLarge">
            <div class="formGroup" id="image1box">
                <label for="name">Image 1 <b>*</b></label><span id="Image1Field">Please Enter Image 1</span><br>
                <input type="file" id="image1" name="image1"><label for="image1" id="ChooseFile">Choose file</label>
            </div>
            <div class="formGroup">
                <label for="name">Image 2 <b>*</b></label><span id="Image2Field">Please Enter Image 2</span><br>
                <input type="file" id="image2" name="image2"><label for="image2" id="ChooseFile">Choose file</label>
            </div>
            <div class="formGroup">
                <label for="name">Image 3 <b>*</b></label><span id="Image3Field">Please Enter Image 3</span><br>
                <input type="file" id="image3" name="image3"><label for="image3" id="ChooseFile">Choose file</label>
            </div>
            </div>
            </div>
        </div>
        <div class="formGroupLarge" id="DescriptionBox">
            <div class="formGroup>
                <label for="name">Description <b>*</b></label><span id="DescriptionField">Please Enter Description</span><br><br>
                <textarea name="description" id="description" placeholder="Room features, requirements, etc." ></textarea>
            </div>
        </div>
        <!-- <button id="submitPost" type="submit" <?php echo $postCount >= $postLimit ? 'disabled' : ''; ?>>Submit</button> -->
        <button id="submitPost" type="submit">Submit</button>
        </form>
     </section>
    <!-- Post and Advertisement section ends -->

    <div id="PaymentInfo">
        <h1>Payment Info</h1>
        <p>Pay using Esewa</p>
        <img src="../images/RecentPosts/image.png" alt="">
        <form action="../Controllers/BoostPostsController.php?action=post" method="POST" enctype="multipart/form-data">
          <label for="PostID">Post Id</label>
          <input type="text" id="PostID" name="PostID" placeholder="Post ID">
          <label for="PostName">Post Name</label>
          <input type="text" id="PostName1" name="PostName" placeholder="Post Name">
          <label for="PayUsingEsewaMethod" id="PaymentScreenShotPicture">Upload Transaction Screenshot</label>
          <input type="file" id="PayUsingEsewaMethod" name="PayUsingEsewaMethod">
          <button onclick="PaymentMade()">Submit</button>
        </form>
      </div>

    <?php
        include 'footer.php';
    ?>

    <script>
        function PaymentForPremium(event) {
    event.stopPropagation(); // Prevent the click event from bubbling up

    let paymentInfo = document.getElementById("PaymentInfo");
    paymentInfo.style.display = "flex";


    function handleClickOutside(event) {
        if (!paymentInfo.contains(event.target)) {
            paymentInfo.style.display = "none";
            document.removeEventListener("click", handleClickOutside);
        }
    }

    document.addEventListener("click", handleClickOutside);
}

        function ValidatePostForm(event){
            console.log('Validating');
            let name = document.getElementById('name').value;
            let phoneNumber = document.getElementById('phoneNumberform').value;
            let title = document.getElementById('titlePost').value;
            let rent = document.getElementById('rentPerMonth').value;
            let location = document.getElementById('location').value;
            let type = document.getElementById('type').value;
            let floor = document.getElementById('floor').value;
            let entrance = document.getElementById('entrance').value;
            let forValue = document.getElementById('for').value;
            let roadSize = document.getElementById('RoadSize').value;
            let bedroom = document.getElementById('Bedroom').value;
            let livingroom = document.getElementById('LivingRoom').value;
            let restroom = document.getElementById('Restroom').value;
            let image1 = document.getElementById('image1').value;
            let image2 = document.getElementById('image2').value;
            let image3 = document.getElementById('image3').value;
            let description = document.getElementById('description').value;

            let isValid = true;

            if(name == ""){
                document.getElementById('NameField').style.display = 'block';
                isValid = false;
            }else{
                document.getElementById('NameField').style.display = 'none';
            }

            if(phoneNumber == ""){
                document.getElementById('PhoneNumberField').style.display = 'block';
                isValid = false;
            }else{
                document.getElementById('PhoneNumberField').style.display = 'none';
            }

            if(title == ""){
                document.getElementById('TitleField').style.display = 'block';
                isValid = false;
            }else{
                document.getElementById('TitleField').style.display = 'none';
            }

            if (rent === "" || !/^\d+$/.test(rent)) {
    document.getElementById('RentField').style.display = 'block';
    document.getElementById('RentField').textContent = 
        rent === "" 
        ? "Please enter rent" 
        : "Rent must be a valid integer!";
    isValid = false;
} else {
    document.getElementById('RentField').style.display = 'none';
}


            if(location == ""){
                document.getElementById('LocationField').style.display = 'block';
                isValid = false;
            }else{
                document.getElementById('LocationField').style.display = 'none';
            }

            if(type == ""){
                document.getElementById('TypeField').style.display = 'block';
                isValid = false;
            }else{
                document.getElementById('TypeField').style.display = 'none';
            }

            if (floor === "" || !/^\d+$/.test(floor)) {
    document.getElementById('FloorField').style.display = 'block';
    document.getElementById('FloorField').textContent = 
        floor === "" 
        ? "Please enter floor" 
        : "Floor must be a valid integer!";
    isValid = false;
} else {
    document.getElementById('FloorField').style.display = 'none';
}


            if(entrance == ""){
                document.getElementById('EntranceField').style.display = 'block';
                isValid = false;
            }else{
                document.getElementById('EntranceField').style.display = 'none';
            }

            if(forValue == ""){
                document.getElementById('ForField').style.display = 'block';
                isValid = false;
            }else{
                document.getElementById('ForField').style.display = 'none';
            }

            if (roadSize === "" || !/^\d+$/.test(roadSize)) {
    document.getElementById('RoadSizeField').style.display = 'block';
    document.getElementById('RoadSizeField').textContent = 
        roadSize === "" 
        ? "Please enter the road size!" 
        : "Road size must be a valid integer!";
    isValid = false;
} else {
    document.getElementById('RoadSizeField').style.display = 'none';
}

if (bedroom === "" || !/^\d+$/.test(bedroom)) {
    document.getElementById('BedroomField').style.display = 'block';
    document.getElementById('BedroomField').textContent = 
        bedroom === "" 
        ? "Please enter the bedroom count!" 
        : "Bedroom count must be a valid integer!";
    isValid = false;
} else {
    document.getElementById('BedroomField').style.display = 'none';
}

if (livingroom === "" || !/^\d+$/.test(livingroom)) {
    document.getElementById('LivingroomField').style.display = 'block';
    document.getElementById('LivingroomField').textContent = 
        livingroom === "" 
        ? "Please enter the living room count!" 
        : "Living room count must be a valid integer!";
    isValid = false;
} else {
    document.getElementById('LivingroomField').style.display = 'none';
}

if (restroom === "" || !/^\d+$/.test(restroom)) {
    document.getElementById('RestroomField').style.display = 'block';
    document.getElementById('RestroomField').textContent = 
        restroom === "" 
        ? "Please enter the restroom count!" 
        : "Restroom count must be a valid integer!";
    isValid = false;
} else {
    document.getElementById('RestroomField').style.display = 'none';
}


            if(image1 == ""){
                document.getElementById('Image1Field').style.display = 'block';
                isValid = false;
            }else{
                document.getElementById('Image1Field').style.display = 'none';
            }

            if(image2 == ""){
                document.getElementById('Image2Field').style.display = 'block';
                isValid = false;
            }else{
                document.getElementById('Image2Field').style.display = 'none';
            }

            if(image3 == ""){
                document.getElementById('Image3Field').style.display = 'block';
                isValid = false;
            }else{
                document.getElementById('Image3Field').style.display = 'none';
            }

            if(description == ""){
                document.getElementById('DescriptionField').style.display = 'block';
                isValid = false;
            }else{
                document.getElementById('DescriptionField').style.display = 'none';
            }

            if(isValid) {
            return true; 
        } else {
            event.preventDefault(); 
            return false;
        }
         


        }

        function updateForOptions() {
    const type = document.getElementById("type").value;
    const forDropdown = document.getElementById("for");
    
    // Clear existing options
    forDropdown.innerHTML = "";

    // Populate options based on the selected type
    if (type === "commercial") {
        forDropdown.innerHTML = `
            <option value="Shop" selected>Shop</option>
            <option value="Office">Office</option>
        `;
    } else if (type === "residential") {
        forDropdown.innerHTML = `
            <option value="Family" selected>Family</option>
            <option value="Single">Single</option>
        `;
    }
}
    </script>

</body>
</html>