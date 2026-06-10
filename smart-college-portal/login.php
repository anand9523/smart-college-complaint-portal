<?php

session_start();

include 'includes/db.php';

$error = "";
$success = "";

/* =========================
   REGISTER LOGIC
========================= */

if(isset($_POST['register'])){

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $department = trim($_POST['department']);

    $error = "";

    /* =========================
       BASIC VALIDATION
    ========================= */

    if(empty($name) || empty($email) || empty($password) || empty($department)){
        $error = "All fields are required";
    }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = "Invalid email format";
    }
    elseif(strlen($password) < 6){
        $error = "Password must be at least 6 characters";
    }
    elseif(!preg_match("/^[a-zA-Z ]*$/", $name)){
        $error = "Name only contain letters and spaces";
    }
    else{

        /* CHECK EMAIL */
        $check = "SELECT * FROM students WHERE email='$email'";
        $check_result = mysqli_query($conn, $check);

        if(mysqli_num_rows($check_result) > 0){
            $error = "Email Already Exists";
        }
        else{

            /* SECURE PASSWORD HASH */
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            /* INSERT DATA */
            $query = "INSERT INTO students (name, email, password, department)
                      VALUES ('$name', '$email', '$hashed_password', '$department')";

            if(mysqli_query($conn, $query)){
                $success = "Registration Successful";
                header("Location: login.php");
                exit();
            }else{
                $error = "Registration Failed";
            }
        }
    }
}

/* =========================
   LOGIN LOGIC
========================= */

if(isset($_POST['login'])){

    $email = $_POST['email'];

    $password = md5($_POST['password']);

    $query = "SELECT * FROM students

    WHERE email='$email'

    AND password='$password'";

    $result = mysqli_query($conn,$query);

    if(mysqli_num_rows($result) > 0){

        $data = mysqli_fetch_assoc($result);

        $_SESSION['student_id'] = $data['id'];

        $_SESSION['student_name'] = $data['name'];

        header("Location: dashboard.php");

        exit();

    }else{

        $error = "Invalid Email or Password";

    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
Smart College Complaint Portal
</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

body{
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:linear-gradient(to right,#106EBE,#0FFCBE);
    overflow:hidden;
    position:relative;
    padding-top:70px;
}

/* Heading */

.main-heading{
    position:absolute;
    top:20px;
    width:100%;
    text-align:center;
    font-size:32px;
    font-weight:bold;
    color:white;
}

/* Main Box */

.container{
    width:750px;
    height:450px;
    background:white;
    border-radius:20px;
    overflow:hidden;
    position:relative;
    box-shadow:0px 0px 20px rgba(0,0,0,0.2);
}

/* Form Box */

.form-box{
    position:absolute;
    width:50%;
    height:100%;
    top:0;
    padding:50px;
    transition:0.6s ease-in-out;
    background:white;
}

/* Login */

.login-box{
    left:0;
}

/* Register */

.register-box{
    left:100%;
}

/* Active Animation */

.container.active .login-box{
    left:-100%;
}

.container.active .register-box{
    left:50%;
}

/* Overlay */

.overlay{
    position:absolute;
    width:50%;
    height:100%;
    top:0;
    right:0;
    color:white;
    display:flex;
    justify-content:center;
    align-items:center;
    flex-direction:column;
    text-align:center;
    padding:40px;
    transition:0.6s ease-in-out;
    background:#2563eb;
}

.container.active .overlay{
    right:50%;
    background:#9333ea;
}

/* Inputs */

input{
    width:100%;
    padding:12px;
    margin:10px 0;
    border:1px solid #ccc;
    border-radius:5px;
    outline:none;
}

/* Buttons */

button{
    width:100%;
    padding:12px;
    border:none;
    border-radius:5px;
    background:#2563eb;
    color:white;
    font-size:16px;
    cursor:pointer;
    margin-top:10px;
}

.register-btn{
    background:#9333ea;
}

button:hover{
    opacity:0.9;
}

/* Switch Button */

.switch-btn{
    width:180px;
    background:white;
    color:#2563eb;
    font-weight:bold;
}

.container.active .switch-btn{
    color:#9333ea;
}

/* Text */

h2{
    margin-bottom:20px;
    color:#1e293b;
}

.overlay p{
    margin:15px 0;
    line-height:22px;
}

/* Messages */

.error{
    color:red;
    margin-bottom:10px;
}

.success{
    color:green;
    margin-bottom:10px;
}

</style>

</head>

<body>

<h1 class="main-heading">
Smart College Complaint Portal
</h1>

<div class="container <?php if($success != '') echo 'active'; ?>" id="container">

    <!-- LOGIN -->

    <div class="form-box login-box">

        <h2>Student Login</h2>

        <?php
        if($error != ""){
            echo "<p class='error'>$error</p>";
        }
        ?>

        <form method="POST" autocomplete="off">

            <input type="email"
            name="email"
            placeholder="Enter Email"
            required>

            <input type="password"
            name="password"
            placeholder="Enter Password"
            required>

            <button type="submit"
            name="login">

                Login

            </button>

        </form>

    </div>

    <!-- REGISTER -->

    <div class="form-box register-box">

        <h2>Create Account</h2>

        <?php
        if($success != ""){
            echo "<p class='success'>$success</p>";
        }
        ?>

        <form method="POST">

            <input type="text"
            name="name"
            placeholder="Enter Name"
            required>

            <input type="email"
            name="email"
            placeholder="Enter Email"
            required>

            <input type="password"
            name="password"
            placeholder="Enter Password"
            required>

            <input type="text"
            name="department"
            placeholder="Department"
            required>

            <button type="submit"
            name="register"
            class="register-btn">

                Register

            </button>

        </form>

    </div>

    <!-- OVERLAY -->

    <div class="overlay">

        <h1 id="overlay-title">
            Hello Student!
        </h1>

        <p id="overlay-text">
            Register yourself to submit complaints.
        </p>

        <button class="switch-btn"
        id="toggleBtn">

            Register

        </button>

    </div>

</div>

<script>

const container =
document.getElementById("container");

const toggleBtn =
document.getElementById("toggleBtn");

const title =
document.getElementById("overlay-title");

const text =
document.getElementById("overlay-text");

let isLogin = true;

toggleBtn.addEventListener("click", ()=>{

    container.classList.toggle("active");

    if(isLogin){

        toggleBtn.innerText = "Login";

        title.innerText = "Welcome Back!";

        text.innerText =
        "Already have an account? Login now.";

        isLogin = false;

    }else{

        toggleBtn.innerText = "Register";

        title.innerText = "Hello Student!";

        text.innerText =
        "Register yourself to submit complaints.";

        isLogin = true;

    }

});

</script>

</body>
</html>