<?php
session_start();
include 'connMysqli.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: .\interface\login.php');
    exit;
}

$level_akses = $_SESSION['level_akses'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Welcome to Dashboard</h2>
        <?php if ($level_akses == 'admin'): ?>
            <p>You have admin access.</p>
            <a href=".\interface\admin.php" class="btn btn-primary">Manage Users</a>
        <?php else: ?>
            <p>You have user access.</p>
        <?php endif; ?>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</body>
</html>