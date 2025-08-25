## Ghar bhada : A rental rooms/aparment Advertisment Posting Platform
GharBhada is a project which helps to post rental rooms or flats advertisements. It helps to connect potential tentants with potential landlords directly in a fast, cost effective, hassle free and simple way.

## 1 Features 

## 2 Installation Instruction

## 3 Usage

## 4 Configuration

### fonts
requires fonts from @import url('https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap');and 
 @import url('https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');and
 @import url('https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');

## 5 Chanellog

### August 10
header component created and made responsive
The fonts used are Lato and Roboto.

### August 11
footer component created and made responsive

recent posts section created and made responsive

### August 12
homepage created and made responsive

### August 13
Login, Register and Search Pages created and made responsive

### August 16
Post an advertisement created and made responsive
My profile created and made responsive
Admin dashboard created and made responsive


### August 17
Single Post created and made responsive

### August 18
Backend started  
MVC model implemented  
View = components folder
Model = Models folder
Controller = Controllers folder  
First the database is connected from
DatabaseConnection.php  
The database name is GharBhada and the table created is users with fields (name, email, phone, password and created_at) using MySql Workbench  
The Registration page was validated using JS when onsubmit with ValidateRegisterForm(event) is called and form is validated if isValid is true then the form is redirected to the LoginAndRegistrationController.php where DatabaseConnection and Registration model is included.  

The registration model takes the parameters name, email,phone and password and uses password_hash function to hash the password and send it to the database by preparing stmt and executing it.  

The Controller takes the field value from the Registration form and calls the Model and then goes to the login page  

In login page the user enters the email and password after submit the controller gets the $user from the model and checks the password with password verify function is the password is correct session is started with $user and if email and password is incorrect the session is set with the respective errors and sent back to the login. Session is started in login.php and the error is shown with span tag and after that the session value is unset.  

The user can view his or her info from the My Profile and logout which lets the Controller session_destroy and redirect to homepage.  

the $name is split using explode() function in My Profile for firstName and lastName

### August 19  
#### Post CRUD started to be Implement
##### CRUD Create  
The Post an advertisement form was create and validated using JS after submit the data is sent to PostCRUDController where the data is the data is kept on respective fields and the images are kept on file_name, tempName and folder location after that move_uploaded_file is used to upload the file to the PostImages folder in the Project folder The path to the images is saved to the database  

The respective fields for Posts in database are  
Name  
Phone  
Title  
Type  
For  
Floor  
bedrooms  
livingroom  
resttoom    
Rent  
Image1  
Image2  
Image3  
description  

Demo data was manually inserted from the Post form

##### CRUD Read
The respect Models for getting posts from the database were created. The RecentPosts and AllPosts Included the Database Connection and the Model after which they get the required posts and assign them to local variables. The local variables are in array form so they are looped with foreach and data is shown in homepage.  

The SinglePost gets the user_id from the session and sends that id to the model. The model responds with the array of posts which the user has created which in shown in MyAdvertisements.


##### CRUD Update

The edit button in myadvertisements sends the loggedin user to the updateForm where the user updates the posts. When update button is pressed Controller is called which takes the data and sends to model. The model updates the posts and user is sent to homepage  

##### CRUD Delete

The delete button in MyAdvertisements calls the controller with post ID. The model is called to delete the post and user is sent to MyAdvertisements. The images are also deleted in the folder using file_exists and unlink function.


#### Search

The users gives the search location and search is pressed after that the user is taken to the search page where the user location is set to location. The location is sent to Model which searches the data and returns. The data is then looped in search page.  

#### Admin
Admin login made and admin dashboard backend made  
count function used to count the number of users and advertisements  
status field made for featured and best deals  
status 0 deafault  
1 Featured  
2 Best Deals  
Boost Post feature made where the user can scan QR code  
When post is boosted it is added in bootpost table and status is updated and when deleted from the table status is default
