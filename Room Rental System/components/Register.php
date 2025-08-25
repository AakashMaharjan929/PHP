<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/website Logo.jpg">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/login.css">
    <title>Register</title>
</head>
<style>
    #EnterNameError{
        color: red;
        display: none;
    }

    #EnterEmailError{
        color: red;
        display: none;
    }

    #EnterPhoneNumberError{
        color: red;
        display: none;
    }

    #EnterPasswordError{
        color: red;
        display: none;
    }

    #EnterPasswordError2{
        color: red;
        display: none;
    }

    #PasswordDoNotMatch{
        color: red;
        display: none;
    }

    #PhoneNumber10{
        color: red;
        display: none;
    }

    #roleDiv{
        display: flex;
        justify-content: space-between;
        width: 16rem;
        align-items: center;
    }

    #loginForm form #roleDiv input{
        width: 2rem;
        height: 2rem;
    }
</style>
<body>
    <?php
        include 'header.php';
    ?>

    <!-- log in section starts -->
     <section id="Register">
        <div id="pageLocation">
            <p id="pageLocationText">Home <i>/</i> <b>Register</b></p>
        </div>
        <div id="RegisterMain">
            <img src="../images/loginAndRegistration/login.svg" alt="">
            <div id="loginForm">
                <form action="../Controllers/LoginAndRegistrationController.php?action=register" method="POST" onsubmit="ValidateRegisterForm(event)">
                    <h1 id="WelcomeBack">Register</h1>
                    <p id="loginToContinue">Join to us</p>
                    <label for="Name" class="loginLabel">Your name <span id="EnterNameError">Please Enter Name</span></label>
                    <input type="text" placeholder="Ram Laxman" name="name">
                    <label for="email" class="loginLabel">Email Address<span id="EnterEmailError">Please Enter Email</span></label>
                    <input type="email" placeholder="Example@gmail.com" name="email">
                    <label for="phone number" class="loginLabel">Phone Number<span id="EnterPhoneNumberError">Please Enter Phone Number</span><span id="PhoneNumber10">Phone number should be 10</span></label>
                    <input type="text" placeholder="98*******" name="phone">
                    <label for="role" class="loginLabel">Are you a?</label>
                    <div id="roleDiv">
                    <input type="radio" name="role" value="tenant" class="roleIn">tenant
                    <input type="radio" name="role" value="landlord" class="roleIn">landlord
                </div>
                    <label for="password" class="loginLabel">Password<span id="EnterPasswordError">Please Enter Password</span><span id="EnterPasswordError2">Password should be 8 characters long</span></label>
                    <input type="password" placeholder="..." name="password">
                    <label for="confirm password" class="loginLabel">Confirm Password<span id="PasswordDoNotMatch">Password do not match</span></label>
                    <input type="password" placeholder="..." name="confirm_password">
                    <button type="submit">Register</button>     
                    <p id="SignUpHere">already user ? <b><a href="">Login</a></b></p>
                </form>
            </div>
        </div>
     </section>
    <!-- log in section ends -->

    <?php
        include 'footer.php';
    ?>

    <script>
        function ValidateRegisterForm(event) {
            let isValid = true;

            const name = document.querySelector("input[name='name']").value;
            const email = document.querySelector("input[name='email']").value;
            const phone = document.querySelector("input[name='phone']").value;
            const password = document.querySelector("input[name='password']").value;
            const confirmPassword = document.querySelector("input[name='confirm_password']").value;

            if (name === "" || !/^[a-zA-Z\s]+$/.test(name)) {
    document.getElementById("EnterNameError").style.display = "block";
    document.getElementById("EnterNameError").textContent = 
        name === "" 
        ? "Please enter name" 
        : "Name must contain only letters and spaces!";
    isValid = false;
} else {
    document.getElementById("EnterNameError").style.display = "none";
}


            if (email === "") {
                document.getElementById("EnterEmailError").style.display = "block";
                isValid = false;
            } else {
                document.getElementById("EnterEmailError").style.display = "none";
            }

            if (phone === "") {
                document.getElementById("EnterPhoneNumberError").style.display = "block";
                isValid = false;
            } else {
                document.getElementById("EnterPhoneNumberError").style.display = "none";
            }

            if(phone.length !== 10){
                document.getElementById("PhoneNumber10").style.display = "block";
                isValid = false;
            } else {
                document.getElementById("PhoneNumber10").style.display = "none";
            }

            if (password === "") {
        document.getElementById("EnterPasswordError").style.display = "block";
        isValid = false;
    }  else {
    document.getElementById("EnterPasswordError").style.display = "none";

    }

    if (password.length < 8) {
    document.getElementById("EnterPasswordError2").style.display = "block"; 
    isValid = false;
    } else{
        document.getElementById("EnterPasswordError2").style.display = "none";
    }



            if (password !== confirmPassword) {
                document.getElementById("PasswordDoNotMatch").style.display = "block";
                isValid = false;
            } else {
                document.getElementById("PasswordDoNotMatch").style.display = "none";
            }

            if (!isValid) {
                event.preventDefault();
            }
        };
    </script>
</body>
</html>