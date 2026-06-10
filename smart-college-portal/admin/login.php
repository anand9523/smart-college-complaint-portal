<?php

session_start();

include '../includes/db.php';

$error = "";

if(isset($_POST['login'])){

    $username = $_POST['username'];

    $password = md5($_POST['password']);

    $query = "SELECT * FROM admin
    WHERE username='$username'
    AND password='$password'";

    $result = mysqli_query($conn,$query);

    if(mysqli_num_rows($result) > 0){

        $_SESSION['admin'] = $username;

        header("Location: dashboard.php");
        exit();

    }else{

        $error = "Invalid Username or Password";

    }

}

?>

<!DOCTYPE html>
<html>
<head>

<title>Admin Login</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial;
}

body{
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:linear-gradient(to right,#1e3a8a,#2563eb);
}

.login-box{
    width:400px;
    background:white;
    padding:40px;
    border-radius:10px;
    box-shadow:0 0 20px rgba(0,0,0,0.2);
}

h2{
    text-align:center;
    margin-bottom:25px;
    color:#1e293b;
}

input{
    width:100%;
    padding:12px;
    margin:10px 0;
    border:1px solid #ccc;
    border-radius:5px;
}

button{
    width:100%;
    padding:12px;
    border:none;
    background:#2563eb;
    color:white;
    font-size:16px;
    border-radius:5px;
    cursor:pointer;
}

button:hover{
    background:#1d4ed8;
}

.error{
    color:red;
    margin-bottom:10px;
    text-align:center;
}

</style>

</head>
<body>

<div class="login-box">

    <h2>Admin Login</h2>

    <?php
    if($error != ""){
        echo "<p class='error'>$error</p>";
    }
    ?>

    <form method="POST">

        <input type="text"
        name="username"
        placeholder="Enter Username"
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

</body>
</html>