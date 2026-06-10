<?php
session_start();

session_unset();

session_destroy();

header("Location: ../login.php");
// ya student logout ke liye:
header("Location: login.php");

exit();
?>