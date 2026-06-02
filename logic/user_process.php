<?php
session_start();
require_once '../helper/db_conn.php';

// Memastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/auth/login.php");
    exit;
}

// Cek apakah form dikirim dengan POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    
    $action = $_POST['action'];

    // PROSES UPDATE PROFIL
    if ($action == 'update_profile') {
        $user_id = $_SESSION['user_id'];
        
        // 1. Tangkap data teks (Nama, Email, Password)
        $name = trim(mysqli_real_escape_string($conn, $_POST['name']));
        $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
        $password_input = trim($_POST['password']);
        
        if (empty($name) || empty($email)) { 
            die("Gagal: Nama dan Email wajib diisi!"); 
        }

        // Cek jika password diisi
        $password_query = "";
        if (!empty($password_input)) {
            $hashed_password = md5($password_input); 
            $password_query = ", password = '$hashed_password'";
        }

        // 2. TANGKAP DATA FILE FOTO (Upload Gambar)
        $foto_query = ""; 
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
            
            $nama_file = $_FILES['foto']['name'];
            $tmp_file = $_FILES['foto']['tmp_name'];
            
            // Ambil format file (contoh: jpg, png)
            $ekstensi = pathinfo($nama_file, PATHINFO_EXTENSION);
            
            // Ganti nama file agar unik dan tidak menimpa file lain di server
            $nama_foto_baru = "profil_" . $user_id . "_" . time() . "." . $ekstensi;
            
            // Tentukan lokasi folder penyimpanan (ke assets/img/)
            $lokasi_simpan = "../assets/img/" . $nama_foto_baru;
            
            // Pindahkan file dari tempat sementara ke folder target kita
            if (move_uploaded_file($tmp_file, $lokasi_simpan)) {
                // Jika sukses pindah, siapkan potongan query SQL untuk update foto
                $foto_query = ", foto = '$nama_foto_baru'";
            }
        }

        // 3. Gabungkan semua dan simpan ke database
        $query = "UPDATE users SET name = '$name', email = '$email' $password_query $foto_query WHERE id = $user_id";
        
        if (mysqli_query($conn, $query)) {
            header("Location: ../pages/profile/index.php"); 
            exit;
        } else {
            echo "Error update profil: " . mysqli_error($conn);
        }
    }
}
?>
