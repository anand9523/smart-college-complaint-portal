<?php
session_start();

if(!isset($_SESSION['student_id'])){
    header("Location: login.php");
    exit();
}

$real_name = $_SESSION['student_name'];
$student_name ="****" . substr($real_name,-2);

include 'includes/db.php';

$student_id = $_SESSION['student_id'];

// SABKE COMPLAINTS KE LIYE (NO WHERE CONDITION) - ADMIN JAISA
$total_query = mysqli_query($conn,
"SELECT * FROM complaints");

$total = mysqli_num_rows($total_query);

$pending_query = mysqli_query($conn,
"SELECT * FROM complaints 
WHERE status='Pending'");

$pending = mysqli_num_rows($pending_query);

$progress_query = mysqli_query($conn,
"SELECT * FROM complaints 
WHERE status='In Progress'");

$progress = mysqli_num_rows($progress_query);

$resolved_query = mysqli_query($conn,
"SELECT * FROM complaints 
WHERE status='Resolved'");

$resolved = mysqli_num_rows($resolved_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Student Dashboard</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

body{
    display:flex;
    background:#f4f7fc;
}

/* Sidebar */

.sidebar{
    width:250px;
    height:100vh;
    background:#1e293b;
    color:white;
    position:fixed;
    left:0;
    top:0;
    padding-top:20px;
}

.logo{
    text-align:center;
    font-size:24px;
    font-weight:bold;
    color:#1e293b;
    border:5px solid #4ad1bd;
    border-radius:20px 0 20px 0;
    background:white;
    padding:10px;
    margin-bottom:30px; 
}

.sidebar ul{
    list-style:none;
}

.sidebar ul li{
    padding:15px 25px;
    transition:0.3s;
}

.sidebar ul li:hover{
    background:#334155;
}

.sidebar ul li a{
    text-decoration:none;
    color:white;
    font-size:16px;
    display:block;
}

/* Main Content */

.main-content{
    margin-left:250px;
    width:100%;
    padding:20px;
}

/* Top Bar */

.topbar{
    background:white;
    padding:20px;
    border-radius:10px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 2px 10px rgba(0,0,0,0.1);
}

.topbar h2{
    color:#1e293b;
}

/* Cards */

.cards{
    display:grid;
    grid-template-columns:repeat(auto-fit, minmax(200px,1fr));
    gap:20px;
    margin-top:25px;
}

.card{
    background:white;
    padding:25px;
    border-radius:10px;
    box-shadow:0 2px 10px rgba(0,0,0,0.1);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-5px);
}

.card h3{
    margin-bottom:10px;
    color:#64748b;
}

.card p{
    font-size:28px;
    font-weight:bold;
    color:#2563eb;
}

/* Recent Complaints */

.table-section{
    margin-top:30px;
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 2px 10px rgba(0,0,0,0.1);
}

.table-section h2{
    margin-bottom:20px;
    color:#1e293b;
}

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

/* Status */

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

/* Notification */

.notification{
    margin-top:25px;
    background:#dbeafe;
    color:#1e3a8a;
    padding:15px;
    border-radius:10px;
    border-left:5px solid #2563eb;
}

/* Responsive */

@media(max-width:768px){

    .sidebar{
        width:200px;
    }

    .main-content{
        margin-left:200px;
    }

}

</style>

</head>
<body>

<!-- Sidebar -->

<div class="sidebar">

    <div class="logo">
        Smart College Complaint Portal 
    </div>

    <ul>

        <li>
            <a href="dashboard.php">
                🏠 Dashboard
            </a>
        </li>

        <li>
            <a href="add-complaint.php">
                ➕ Add Complaint
            </a>
        </li>

        <li>
            <a href="view-complaints.php">
                📋 View Complaints
            </a>
        </li>

        <li>
            <a href="complaintStatus.php">
                📊 Complaint Status
            </a>
        </li>

        <li>
           <a href="logout.php">
            🚪 Logout
        </a>
        </li>

    </ul>

</div>

<!-- Main Content -->

<div class="main-content">

    <!-- Topbar -->

    <div class="topbar">

        <h2>
            Welcome, <?php echo $student_name; ?>
        </h2>

        <p>
            <?php echo date("d M Y"); ?>
        </p>

    </div>

    <!-- Cards -->

    <div class="cards">

        <div class="card">
            <h3>Total Complaints</h3>
            <p><?php echo $total; ?></p>
        </div>

        <div class="card">
            <h3>Pending</h3>
            <p><?php echo $pending; ?></p>
        </div>

        <div class="card">
            <h3>In Progress</h3>
            <p><?php echo $progress; ?></p>
        </div>

        <div class="card">
            <h3>Resolved</h3>
            <p><?php echo $resolved; ?></p>
        </div>

    </div>

    <!-- Notification -->

    <div class="notification">

        Your latest complaint is under review by the administration.

    </div>

    <!-- Recent Complaints -->

    <div class="table-section">

        <h2>
            Recent Complaints
        </h2>

        <table>

            <tr>
                <th>ID</th>
                <th>Complaint</th>
                <th>Category</th>
                <th>Status</th>
            </tr>

            <?php

$query = mysqli_query($conn,
"SELECT * FROM complaints
ORDER BY id DESC");

while($row = mysqli_fetch_assoc($query)){

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
?>

        <table>

    </div>

</div>

</body>
</html>