<?php
// pages/auth/login.php
session_start();

// Jika user sudah login, langsung lempar ke index.php luar
if (isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit;
}

// Mengambil koneksi dari helper/db_conn.php (Naik 2 tingkat dari pages/auth/)
require_once dirname(__DIR__, 2) . '/helper/db_conn.php';

$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        
        // Menggunakan MD5 sesuai dengan kode awalmu
        $hashed_password = md5($password);

        // Ambil data user
        $stmt = $pdo->prepare("SELECT id, name, email, role FROM users WHERE email = ? AND password = ?");
        $stmt->execute([$email, $hashed_password]);
        $user = $stmt->fetch();

        if ($user) {
            // Simpan data ke session
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];

            // Mundur 2 tingkat untuk langsung menemui index.php yang paling luar
            header("Location: ../../index.php");
            exit;
        } else {
            $error_message = "Email atau password salah!";
        }
    } else {
        $error_message = "Harap isi semua kolom!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIPRAF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .login-container h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #666;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .btn-login {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: white;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        .btn-login:hover {
            background-color: #0056b3;
        }
        .alert {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            text-align: center;
            border: 1px solid #f5c6cb;
        }
        .js-alert {
            display: none;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Login SIPRAF</h2>

    <?php if (!empty($error_message)): ?>
        <div class="alert">
            <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php endif; ?>

    <div id="js-error" class="alert js-alert"></div>

    <form id="loginForm" action="" method="POST">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required autocomplete="email" placeholder="masukan email anda">
        </div>
        
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required placeholder="masukan password anda">
        </div>

        <button type="submit" class="btn-login">Masuk</button>
    </form>
</div>

<script>
document.getElementById('loginForm').addEventListener('submit', function(event) {
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const errorBox = document.getElementById('js-error');
    
    const emailValue = emailInput.value.trim();
    const passwordValue = passwordInput.value.trim();
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    let errorMessage = "";

    if (emailValue === "" || passwordValue === "") {
        errorMessage = "Harap isi semua kolom!";
    } else if (!emailPattern.test(emailValue)) {
        errorMessage = "Format email tidak valid! (Contoh: user@email.com)";
    } else if (passwordValue.length < 6) {
        errorMessage = "Password minimal harus terdiri dari 6 karakter!";
    }

    if (errorMessage !== "") {
        event.preventDefault();
        errorBox.textContent = errorMessage;
        errorBox.style.display = 'block';
        
        if (errorMessage.includes("email")) {
            emailInput.focus();
        } else {
            passwordInput.focus();
        }
    } else {
        errorBox.style.display = 'none';
    }
});
</script>
</body>
</html>