<?php
session_start();
require_once '../helper/db_conn.php';

// memastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/auth/login.php");
    exit;
}

// Cek apakah form dikirim dengan POST dan ada penanda aksi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    
    $action = $_POST['action'];

    if ($action == 'update_profile') {
        $user_id = $_SESSION['user_id'];
        
        // menagkap dan membersihkan input
        $name = trim(mysqli_real_escape_string($conn, $_POST['name']));
        $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
        $password_input = trim($_POST['password']);
        
        // Validasi PHP Server-Side
        if (empty($name) || empty($email)) { 
            die("Gagal: Nama dan Email wajib diisi!"); 
        }

        // Cek jika password diganti
        $password_query = "";
        if (!empty($password_input)) {
            $hashed_password = md5($password_input); 
            $password_query = ", password = '$hashed_password'";
        }

        // Query eksekusi
        $query = "UPDATE users SET name = '$name', email = '$email' $password_query WHERE id = $user_id";
        
        if (mysqli_query($conn, $query)) {
            header("Location: ../pages/profile/index.php"); // Kembali ke profil
            exit;
        } else {
            echo "Error update profil: " . mysqli_error($conn);
        }
    }
    
    // ----------------------------------------------------
    // BLOK(TAMBAH USER) 
    // akan diletakkan di bawah ini (else if action == 'create_user')
    // ----------------------------------------------------
}
?>