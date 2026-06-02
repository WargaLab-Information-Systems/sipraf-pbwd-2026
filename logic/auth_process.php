<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../helper/db_conn.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        
        
        $hashed_password = md5($password);

       
        $stmt = $conn->prepare("SELECT id, name, email, role FROM users WHERE email = ? AND password = ?");
        
        
        $stmt->bind_param("ss", $email, $hashed_password); 
        
        
        $stmt->execute();
        
        
        $result = $stmt->get_result();
        $user = $result->fetch_assoc(); 

        if ($user) {
            
            $_SESSION['user_id']   = $user['id'];

            
            header("Location: ../pages/dashboard/index.php");
            exit;
        } else {
            $error_message = "Email atau password salah!";
        }
        
        
        $stmt->close();
    } else {
        $error_message = "Harap isi semua kolom!";
    }
}
?>