<?php
session_start();
require_once '../helper/db_conn.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/auth/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'], $_GET['id'])
    && $_GET['action'] === 'delete') {

    $id = intval($_GET['id']);

    if ($id <= 0) {
        header("Location: ../pages/users/index.php?status=error");
        exit;
    }

    // Ambil foto lama supaya bisa dihapus dari disk
    $stmt = $conn->prepare("SELECT foto FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$row) {
        header("Location: ../pages/users/index.php?status=not_found");
        exit;
    }

    if (!empty($row['foto'])) {
        $path = __DIR__ . '/../assets/img/' . $row['foto'];
        if (file_exists($path)) unlink($path);
    }

    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: ../pages/users/index.php?status=deleted");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    $action = $_POST['action'];

    if ($action === 'create_user') {
        $name     = trim($_POST['name']     ?? '');
        $email    = trim($_POST['email']    ?? '');
        $password = trim($_POST['password'] ?? '');
        $role     = trim($_POST['role']     ?? '');
        $errors   = [];

        // Validasi
        if (empty($name) || strlen($name) < 3 || strlen($name) > 255)
            $errors['name'] = 'Nama wajib diisi (3–255 karakter).';

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Format email tidak valid.';
        } else {
            $s = $conn->prepare("SELECT id FROM users WHERE email = ?");
            $s->bind_param("s", $email);
            $s->execute();
            $s->store_result();
            if ($s->num_rows > 0) $errors['email'] = 'Email sudah digunakan.';
            $s->close();
        }

        if (empty($password) || strlen($password) < 6)
            $errors['password'] = 'Password wajib diisi, minimal 6 karakter.';

        $valid_roles = ['admin', 'supervisor', 'borrower'];
        if (!in_array($role, $valid_roles))
            $errors['role'] = 'Role tidak valid.';

        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;
            $_SESSION['form_old']    = compact('name', 'email', 'role');
            header("Location: ../pages/users/form.php");
            exit;
        }

        // Upload foto (opsional)
        $foto = '';
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] !== UPLOAD_ERR_NO_FILE) {
            $f       = $_FILES['foto'];
            $allowed = ['image/jpeg', 'image/png', 'image/gif'];
            if ($f['error'] === UPLOAD_ERR_OK && in_array($f['type'], $allowed) && $f['size'] <= 2 * 1024 * 1024) {
                $ext  = pathinfo($f['name'], PATHINFO_EXTENSION);
                $foto = uniqid('user_') . '.' . $ext;
                move_uploaded_file($f['tmp_name'], __DIR__ . '/../assets/img/' . $foto);
            }
        }

        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt   = $conn->prepare("INSERT INTO users (name, email, password, role, foto) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $hashed, $role, $foto);
        $stmt->execute();
        $stmt->close();

        header("Location: ../pages/users/index.php?success=created");
        exit;
    }

    if ($action === 'update_user') {
        $edit_id  = intval($_POST['edit_id'] ?? 0);
        $name     = trim($_POST['name']      ?? '');
        $email    = trim($_POST['email']     ?? '');
        $password = trim($_POST['password']  ?? '');
        $role     = trim($_POST['role']      ?? '');
        $errors   = [];

        if ($edit_id <= 0) {
            header("Location: ../pages/users/index.php?status=error");
            exit;
        }

        // Ambil foto lama
        $s = $conn->prepare("SELECT foto FROM users WHERE id = ?");
        $s->bind_param("i", $edit_id);
        $s->execute();
        $existing      = $s->get_result()->fetch_assoc();
        $existing_foto = $existing['foto'] ?? '';
        $s->close();

        // Validasi
        if (empty($name) || strlen($name) < 3 || strlen($name) > 255)
            $errors['name'] = 'Nama wajib diisi (3–255 karakter).';

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Format email tidak valid.';
        } else {
            $s = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
            $s->bind_param("si", $email, $edit_id);
            $s->execute();
            $s->store_result();
            if ($s->num_rows > 0) $errors['email'] = 'Email sudah digunakan user lain.';
            $s->close();
        }

        if (!empty($password) && strlen($password) < 6)
            $errors['password'] = 'Password minimal 6 karakter.';

        $valid_roles = ['admin', 'supervisor', 'borrower'];
        if (!in_array($role, $valid_roles))
            $errors['role'] = 'Role tidak valid.';

        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;
            $_SESSION['form_old']    = compact('name', 'email', 'role');
            header("Location: ../pages/users/form.php?id=$edit_id");
            exit;
        }

        // Upload foto baru (opsional)
        $foto = $existing_foto;
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] !== UPLOAD_ERR_NO_FILE) {
            $f       = $_FILES['foto'];
            $allowed = ['image/jpeg', 'image/png', 'image/gif'];
            if ($f['error'] === UPLOAD_ERR_OK && in_array($f['type'], $allowed) && $f['size'] <= 2 * 1024 * 1024) {
                $ext  = pathinfo($f['name'], PATHINFO_EXTENSION);
                $foto = uniqid('user_') . '.' . $ext;
                if (move_uploaded_file($f['tmp_name'], __DIR__ . '/../assets/img/' . $foto)) {
                    if ($existing_foto && file_exists(__DIR__ . '/../assets/img/' . $existing_foto))
                        unlink(__DIR__ . '/../assets/img/' . $existing_foto);
                } else {
                    $foto = $existing_foto;
                }
            }
        }

        if (!empty($password)) {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt   = $conn->prepare("UPDATE users SET name=?, email=?, password=?, role=?, foto=? WHERE id=?");
            $stmt->bind_param("sssssi", $name, $email, $hashed, $role, $foto, $edit_id);
        } else {
            $stmt = $conn->prepare("UPDATE users SET name=?, email=?, role=?, foto=? WHERE id=?");
            $stmt->bind_param("ssssi", $name, $email, $role, $foto, $edit_id);
        }
        $stmt->execute();
        $stmt->close();

        header("Location: ../pages/users/index.php?success=updated");
        exit;
    }

    if ($action === 'update_profile') {
        $user_id  = $_SESSION['user_id'];
        $name     = trim(mysqli_real_escape_string($conn, $_POST['name']  ?? ''));
        $email    = trim(mysqli_real_escape_string($conn, $_POST['email'] ?? ''));
        $password = trim($_POST['password'] ?? '');

        if (empty($name) || empty($email)) {
            die("Gagal: Nama dan Email wajib diisi!");
        }

        $pwd_part = '';
        if (!empty($password)) {
            $hashed   = md5($password);
            $pwd_part = ", password = '$hashed'";
        }

        $sql = "UPDATE users SET name='$name', email='$email' $pwd_part WHERE id=$user_id";
        if (mysqli_query($conn, $sql)) {
            header("Location: ../pages/profile/index.php");
            exit;
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>
