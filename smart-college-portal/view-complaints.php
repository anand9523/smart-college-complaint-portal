<?php
session_start();
include 'includes/db.php';

if(!isset($_SESSION['student_id'])){
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

$query = "SELECT * FROM complaints
WHERE student_id='$student_id'
ORDER BY id DESC";

$result = mysqli_query($conn,$query);
?>

<!DOCTYPE html>
<html>
<head>

<title>My Complaints</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

body{
    background:#f4f7fc;
    padding:30px;
}

/* Container */

.container{
    width:95%;
    margin:auto;
    background:white;
    padding:25px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
}

/* Heading */

h2{
    margin-bottom:20px;
    color:#1e293b;
}

/* Table */

table{
    width:100%;
    border-collapse:collapse;
}

table th{
    background:#2563eb;
    color:white;
    padding:12px;
    text-align:left;
}

table td{
    padding:12px;
    border-bottom:1px solid #ddd;
}

/* Status Colors */

.pending{
    color:orange;
    font-weight:bold;
}

.progress{
    color:#2563eb;
    font-weight:bold;
}

.resolved{
    color:green;
    font-weight:bold;
}

/* Back Button */

.back-btn{
    display:inline-block;
    margin-top:20px;
    padding:10px 20px;
    background:#2563eb;
    color:white;
    text-decoration:none;
    border-radius:5px;
}

.back-btn:hover{
    background:#1d4ed8;
}

/* No Complaint */

.no-data{
    text-align:center;
    padding:20px;
    color:#64748b;
}

</style>

</head>

<body>

<div class="container">

<h2>My Complaints</h2>

<table>

<tr>
    <th>ID</th>
    <th>Title</th>
    <th>Category</th>
    <th>Description</th>
    <th>Status</th>
</tr>

<?php

if(mysqli_num_rows($result) > 0){

while($row = mysqli_fetch_assoc($result)){

?>

<tr>

<td>
<?php echo $row['id']; ?>
</td>

<td>
<?php echo $row['title']; ?>
</td>

<td>
<?php echo $row['category']; ?>
</td>

<td>
<?php echo $row['description']; ?>
</td>

<td>

<?php

$status = $row['status'];

if($status == "Pending"){

    echo "<span class='pending'>Pending</span>";

}elseif($status == "In Progress"){

    echo "<span class='progress'>In Progress</span>";

}else{

    echo "<span class='resolved'>Resolved</span>";
}

?>

</td>

</tr>

<?php

}

}else{

?>

<tr>

<td colspan="5" class="no-data">
    No Complaints Found
</td>

</tr>

<?php } ?>

</table>

<a href="dashboard.php" class="back-btn">
    ← Back Dashboard
</a>

</div>

</body>
</html>