<?php

session_start();

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

include '../includes/db.php';

/* =========================
   STATUS UPDATE
========================= */

if(isset($_GET['id']) && isset($_GET['status'])){

    $id = $_GET['id'];
    $status = $_GET['status'];

    mysqli_query($conn,
    "UPDATE complaints
    SET status='$status'
    WHERE id='$id'");

    header("Location: view-complaints.php");
    exit();
}

/* =========================
   FETCH COMPLAINTS
========================= */

$query = mysqli_query($conn,
"SELECT * FROM complaints ORDER BY id DESC");

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin View Complaints</title>

<style>

/* GLOBAL */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial;
}

body{
    display:flex;
    background:#f1f5f9;
}

/* SIDEBAR */
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
    background:white;
    color:#1e293b;
    margin:10px;
    padding:10px;
    border-radius:10px;
}

.sidebar ul{
    list-style:none;
    margin-top:30px;
}

.sidebar ul li{
    padding:15px 25px;
}

.sidebar ul li:hover{
    background:#334155;
}

.sidebar ul li a{
    color:white;
    text-decoration:none;
}

/* MAIN */
.main-content{
    margin-left:250px;
    width:100%;
    padding:20px;
}

/* TOPBAR */
.topbar{
    background:white;
    padding:15px;
    border-radius:10px;
    display:flex;
    justify-content:space-between;
    box-shadow:0 2px 10px rgba(0,0,0,0.1);
}

/* TABLE */
.table-section{
    margin-top:25px;
    background:white;
    padding:20px;
    border-radius:10px;
}

table{
    width:100%;
    border-collapse:collapse;
}

table th{
    background:#2563eb;
    color:white;
    padding:12px;
}

table td{
    padding:12px;
    border-bottom:1px solid #ddd;
}

/* STATUS */
.pending{ color:orange; font-weight:bold; }
.progress{ color:#2563eb; font-weight:bold; }
.resolved{ color:green; font-weight:bold; }

/* =========================
   🔥 BUTTONS (FIXED SIZE)
========================= */

.btn-group{
    display:flex;
    gap:6px;
}

.btn{
    width:85px;
    height:32px;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:12px;
    font-weight:600;
    text-decoration:none;
    color:white;

    border-radius:6px;
}

/* COLORS */
.pending-btn{ background:#f59e0b; }
.progress-btn{ background:#2563eb; }
.resolved-btn{ background:#22c55e; }

/* HOVER */
.btn:hover{
    opacity:0.85;
}

</style>

</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">

    <div class="logo">Admin Panel</div>

    <ul>
        <li><a href="dashboard.php">📊 Dashboard</a></li>
        <li><a href="view-complaints.php">📋 View Complaints</a></li>
        <li><a href="logout.php">🚪 Logout</a></li>
    </ul>

</div>

<!-- MAIN -->
<div class="main-content">

    <div class="topbar">
        <h2>Complaint Management</h2>
        <p><?php echo date("d M Y"); ?></p>
    </div>

    <div class="table-section">

        <table>

            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Category</th>
                <th>Description</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($query)) { ?>

            <tr>

                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['category']; ?></td>
                <td><?php echo $row['description']; ?></td>

                <td>
                    <?php
                    if($row['status']=="Pending"){
                        echo "<span class='pending'>Pending</span>";
                    }elseif($row['status']=="In Progress"){
                        echo "<span class='progress'>In Progress</span>";
                    }else{
                        echo "<span class='resolved'>Resolved</span>";
                    }
                    ?>
                </td>

                <td>
                    <div class="btn-group">

                        <a class="btn pending-btn"
                        href="view-complaints.php?id=<?php echo $row['id']; ?>&status=Pending">
                            Pending
                        </a>

                        <a class="btn progress-btn"
                        href="view-complaints.php?id=<?php echo $row['id']; ?>&status=In Progress">
                            Progress
                        </a>

                        <a class="btn resolved-btn"
                        href="view-complaints.php?id=<?php echo $row['id']; ?>&status=Resolved">
                            Resolve
                        </a>

                    </div>
                </td>

            </tr>

            <?php } ?>

        </table>

    </div>

</div>

</body>
</html>