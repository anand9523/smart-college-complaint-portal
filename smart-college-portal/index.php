<!DOCTYPE html>
<html>
<head>

<title>Smart College Complaint Portal</title>

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
    background:#f1f5f9;
}

/* Container */

.container{
    width:500px;
    background:white;
    padding:50px;
    text-align:center;
    border-radius:15px;
    box-shadow:0 0 20px rgba(0,0,0,0.1);
}

/* Heading */

h1{
    color:#1e293b;
    margin-bottom:40px;
}

/* Buttons */

a{
    display:inline-block;
    margin:10px;
    padding:15px 30px;
    background:#2563eb;
    color:white;
    text-decoration:none;
    border-radius:5px;
    font-size:18px;
}

a:hover{
    background:#1d4ed8;
}

</style>

</head>

<body>

<div class="container">

    <h1>
        Smart College Complaint Portal
    </h1>

    <!-- Student Login -->

    <a href="login.php">

        Student Login

    </a>

    <!-- Admin Login -->

    <a href="admin/login.php">

        Admin Login

    </a>

</div>

</body>
</html>