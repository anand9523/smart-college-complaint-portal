<?php
session_start();
include 'includes/db.php';

if(!isset($_SESSION['student_id'])){
    header("Location: login.php");
    exit();
}

$message = "";

/* =========================
   SUBMIT COMPLAINT
========================= */

if(isset($_POST['submit'])){

    // 🔥 SAFE STUDENT ID
    $student_id = (int) $_SESSION['student_id'];

    // 🔥 SAFE INPUTS
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // 🔥 DEFAULT STATUS
    $status = "Pending";

    $query = "INSERT INTO complaints 
    (student_id, title, category, description, status)
    VALUES
    ('$student_id','$title','$category','$description','$status')";

    if(mysqli_query($conn, $query)){
        $message = "Complaint Submitted Successfully";
    }else{
        $message = "Error: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Add Complaint</title>

<style>

body{
    font-family:Arial;
    background:#f4f7fc;
    padding:30px;
}

.container{
    width:500px;
    margin:auto;
    background:white;
    padding:30px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
}

h2{
    margin-bottom:20px;
}

input, textarea, select{
    width:100%;
    padding:12px;
    margin:10px 0;
    border:1px solid #ccc;
    border-radius:5px;
}

button{
    width:100%;
    padding:12px;
    background:#2563eb;
    color:white;
    border:none;
    border-radius:5px;
    cursor:pointer;
}

.message{
    margin-bottom:15px;
    color:green;
    font-weight:bold;
}

</style>

</head>

<body>

<div class="container">

<h2>Add Complaint</h2>

<?php if($message != ""){ ?>
    <p class="message"><?php echo $message; ?></p>
<?php } ?>

<form method="POST">

<select name="category" required>
    <option value="">Select Category</option>
    <option>Academics</option>
    <option>Infrastructure</option>
    <option>Library</option>
    <option>Hostel</option>
    <option>Security</option>
    <option>Electricity</option>
    <option>WiFi</option>
    <option>Other</option>
</select>

<input type="text" name="title" placeholder="Complaint Title" required>

<textarea rows="5" name="description" placeholder="Write Complaint" required></textarea>

<button type="submit" name="submit">Submit Complaint</button>

</form>

</div>

</body>
</html>