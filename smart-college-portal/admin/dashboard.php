<?php

session_start();

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

include '../includes/db.php';

/* Counts */

$total = mysqli_num_rows(
mysqli_query($conn,"SELECT * FROM complaints")
);

$pending = mysqli_num_rows(
mysqli_query($conn,
"SELECT * FROM complaints
WHERE status='Pending'")
);

$progress = mysqli_num_rows(
mysqli_query($conn,
"SELECT * FROM complaints
WHERE status='In Progress'")
);

$resolved = mysqli_num_rows(
mysqli_query($conn,
"SELECT * FROM complaints
WHERE status='Resolved'")
);

$students = mysqli_num_rows(
mysqli_query($conn,"SELECT * FROM students")
);

/* Recent Complaints */

$query = mysqli_query($conn,
"SELECT * FROM complaints
ORDER BY id DESC LIMIT 5");

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
Admin Dashboard
</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

body{
    display:flex;
    background:#f1f5f9;
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
    font-size:22px;
    font-weight:bold;
    color:#1e293b;
    background:white;
    margin:10px;
    padding:12px;
    border-radius:15px 0 15px 0;
    border:4px solid #38bdf8;
}

.sidebar ul{
    list-style:none;
    margin-top:30px;
}

.sidebar ul li{
    padding:15px 25px;
    transition:0.3s;
}

.sidebar ul li:hover{
    background:#334155;
}

.sidebar ul li a{
    color:white;
    text-decoration:none;
    font-size:16px;
    display:block;
}

/* Main Content */

.main-content{
    margin-left:250px;
    width:100%;
    padding:20px;
}

/* Topbar */

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
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
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
    font-size:30px;
    font-weight:bold;
    color:#2563eb;
}

/* Table */

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

</style>

</head>

<body>

<!-- Sidebar -->

<div class="sidebar">

    <div class="logo">
        Admin Panel
    </div>

    <ul>

        <li>
            <a href="dashboard.php">
                📊 Dashboard
            </a>
        </li>

        <li>
            <a href="view-complaints.php">
                📋 View Complaints
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
            Welcome Admin
        </h2>

        <p>
            <?php echo date("d M Y"); ?>
        </p>

    </div>

    <!-- Cards -->

    <div class="cards">

        <div class="card">

            <h3>Total Complaints</h3>

            <p>
                <?php echo $total; ?>
            </p>

        </div>

        <div class="card">

            <h3>Pending</h3>

            <p>
                <?php echo $pending; ?>
            </p>

        </div>

        <div class="card">

            <h3>In Progress</h3>

            <p>
                <?php echo $progress; ?>
            </p>

        </div>

        <div class="card">

            <h3>Resolved</h3>

            <p>
                <?php echo $resolved; ?>
            </p>

        </div>

        <div class="card">

            <h3>Total Students</h3>

            <p>
                <?php echo $students; ?>
            </p>

        </div>

    </div>

    <!-- Recent Complaints -->

    <div class="table-section">

        <h2>
            Recent Complaints
        </h2>

        <table>

            <tr>

                <th>ID</th>

                <th>Title</th>

                <th>Category</th>

                <th>Status</th>

            </tr>

            <?php
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

                if($row['status']=="Pending"){

                    echo "<span class='pending'>
                    Pending
                    </span>";

                }elseif($row['status']=="In Progress"){

                    echo "<span class='progress'>
                    In Progress
                    </span>";

                }else{

                    echo "<span class='resolved'>
                    Resolved
                    </span>";
                }

                ?>

                </td>

            </tr>

            <?php } ?>

        </table>

    </div>

</div>

</body>
</html>