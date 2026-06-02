<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        
        $hashed_password = md5($password);

        
        $stmt = $pdo->prepare("SELECT id, name, email, role FROM users WHERE email = ? AND password = ?");
        $stmt->execute([$email, $hashed_password]);
        $user = $stmt->fetch();

        if ($user) {
 
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];


            header("Location: /index.php");
            exit;
        } else {
            $error_message = "Email atau password salah!";
        }
    } else {
        $error_message = "Harap isi semua kolom!";
    }
}