<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: pages/auth/login.php");
    exit; 
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SIPRAF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f6f9;
        }
        .dashboard-box {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .btn-logout {
            display: inline-block;
            padding: 8px 15px;
            background-color: #dc3545;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 15px;
        }
        .btn-logout:hover {
            background-color: #bd2130;
        }
    </style>
</head>
<body>

    <div class="dashboard-box">
        <h2>Selamat Datang di SIPRAF, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h2>
        <p><strong>Email Anda:</strong> Terverifikasi</p>
        <p><strong>Hak Akses (Role):</strong> <?php echo htmlspecialchars($_SESSION['user_role']); ?></p>
        
        <a href="pages/auth/logout.php" class="btn-logout">Keluar / Logout</a>
    </div>

</body>
</html>