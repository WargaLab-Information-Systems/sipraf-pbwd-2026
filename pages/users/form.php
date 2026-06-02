<?php
session_start();
require_once '../../helper/db_conn.php';

// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

// Mode check: Menentukan apakah form digunakan untuk Tambah atau Edit data
$edit_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$is_edit = $edit_id > 0;

// Inisialisasi nilai awal field
$name = $email = $role = $existing_foto = '';

// Jika mode Edit, ambil data user lama dari database untuk mengisi form
if ($is_edit) {
    $stmt = $conn->prepare("SELECT name, email, role, foto FROM users WHERE id = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($row) {
        $name          = $row['name'];
        $email         = $row['email'];
        $role          = $row['role'];
        $existing_foto = $row['foto'];
    } else {
        // Jika ID user tidak ditemukan, arahkan kembali ke mode Tambah
        header("Location: form.php");
        exit;
    }
}

// Baca pesan error & old input yang dikirim balik oleh user_process.php via session
$errors   = $_SESSION['form_errors'] ?? [];
$form_old = $_SESSION['form_old']    ?? [];
unset($_SESSION['form_errors'], $_SESSION['form_old']);

// Timpa dengan old input jika ada (setelah validasi gagal)
if (!empty($form_old)) {
    $name  = $form_old['name']  ?? $name;
    $email = $form_old['email'] ?? $email;
    $role  = $form_old['role']  ?? $role;
}

// Ubah array errors menjadi map per field agar template bisa pakai isset($errors['name'])
$error_map = [];
foreach ($errors as $msg) {
    // Deteksi field dari isi pesan
    if (stripos($msg, 'nama') !== false)     $error_map['name']     = $msg;
    elseif (stripos($msg, 'email') !== false) $error_map['email']    = $msg;
    elseif (stripos($msg, 'password') !== false) $error_map['password'] = $msg;
    elseif (stripos($msg, 'role') !== false)  $error_map['role']     = $msg;
    elseif (stripos($msg, 'foto') !== false)  $error_map['foto']     = $msg;
}
$errors = $error_map;

$page_title = $is_edit ? 'Edit User' : 'Tambah User';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPRAF - <?= $page_title ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: #f5f7fa;
            color: #1e293b;
            min-height: 100vh;
        }

        .gabung{
            display: flex;
            min-height: 100vh;
        }

        .topbar {
            background: linear-gradient(135deg, #059669 0%, #10b981 50%, #34d399 100%);
            padding: 0 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 72px;
            box-shadow: 0 2px 12px rgba(5, 150, 105, 0.2);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-brand h1 {
            color: #fff;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -0.3px;
        }

        .topbar-brand span {
            color: rgba(255, 255, 255, 0.7);
            font-size: 12px;
        }

        .container {
            max-width: 820px;
            margin: 0 auto;
            padding: 32px 40px;
        }

        .page-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }

        .page-head h2 {
            font-size: 26px;
            font-weight: 700;
            color: #0f172a;
        }

        .page-head p {
            font-size: 14px;
            color: #64748b;
            margin-top: 4px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 24px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
            font-family: inherit;
        }

        .btn-outline {
            background: #fff;
            color: #475569;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        }

        .btn-outline:hover {
            border-color: #cbd5e1;
            background: #f8fafc;
        }

        .btn-green {
            background: #059669;
            color: #fff;
            box-shadow: 0 2px 8px rgba(5, 150, 105, 0.25);
        }

        .btn-green:hover {
            background: #047857;
            box-shadow: 0 4px 16px rgba(5, 150, 105, 0.35);
            transform: translateY(-1px);
        }

        .form-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04), 0 8px 32px rgba(0, 0, 0, 0.04);
            border: 1px solid #f1f5f9;
            overflow: hidden;
        }

        .form-header {
            padding: 24px 36px;
            border-bottom: 1px solid #f1f5f9;
            background: #fafcfd;
        }

        .form-header h3 {
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
        }

        .form-header p {
            font-size: 13px;
            color: #64748b;
            margin-top: 2px;
        }

        .form-body {
            padding: 32px 36px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px 28px;
        }

        .form-grid .full {
            grid-column: 1 / -1;
        }

        .field label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 7px;
        }

        .field label .req {
            color: #ef4444;
        }

        .field input,
        .field select {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            color: #1e293b;
            outline: none;
            transition: all 0.25s;
            background: #fff;
            font-family: inherit;
        }

        .field input:focus,
        .field select:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
        }

        .field input.err,
        .field select.err {
            border-color: #ef4444;
        }

        .field input.err:focus {
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
        }

        .err-text {
            font-size: 12px;
            color: #ef4444;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .hint {
            font-size: 12px;
            color: #94a3b8;
            margin-top: 5px;
        }

        .upload-area {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .upload-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border: 1px dashed #cbd5e1;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 500;
            color: #64748b;
            cursor: pointer;
            transition: all 0.2s;
            background: #fafcfd;
            font-family: inherit;
        }

        .upload-btn:hover {
            border-color: #10b981;
            color: #059669;
            background: #f0fdf4;
        }

        .upload-area input[type="file"] {
            display: none;
        }

        .upload-hint {
            font-size: 12px;
            color: #94a3b8;
        }

        .foto-stack {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-top: 4px;
        }

        .foto-current {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 14px 8px 10px;
            background: #f8fafc;
            border-radius: 10px;
        }

        .foto-current img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e2e8f0;
        }

        .foto-current span {
            font-size: 12px;
            color: #64748b;
        }

        #fotoPreview {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e2e8f0;
            display: none;
        }

        .form-foot {
            display: flex;
            gap: 12px;
            padding: 24px 36px;
            border-top: 1px solid #f1f5f9;
            background: #fafcfd;
        }

        @media (max-width: 640px) {
            .container {
                padding: 20px 16px;
            }

            .topbar {
                padding: 0 16px;
            }

            .form-body {
                padding: 24px 20px;
            }

            .form-header {
                padding: 20px;
            }

            .form-foot {
                padding: 20px;
                flex-direction: column;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .page-head {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
        }
    </style>
</head>

<body>
    <div class="gabung">
    <?php include '../../includes/sidebar.php'; ?>
    <div class="container">
        <div class="page-head">
            <div>
                <h2><?= $page_title ?></h2>
                <p><?= $is_edit ? 'Perbarui data pengguna' : 'Tambahkan pengguna baru ke sistem' ?></p>
            </div>
            <a href="index.php" class="btn btn-outline">Kembali</a>
        </div>

        <div class="form-card">
            <div class="form-header">
                <h3><?= $is_edit ? 'Edit Data User' : 'Form User Baru' ?></h3>
                <p><?= $is_edit ? 'Perbarui informasi pengguna di bawah ini.' : 'Isi informasi pengguna baru di bawah ini.' ?></p>
            </div>

            <form method="POST" action="../../logic/user_process.php" enctype="multipart/form-data" novalidate>
                <input type="hidden" name="action" value="<?= $is_edit ? 'update_user' : 'create_user' ?>">
                <input type="hidden" name="edit_id" value="<?= $edit_id ?>">

                <div class="form-body">
                    <div class="form-grid">
                        <div class="field">
                            <label>Nama Lengkap <span class="req">*</span></label>
                            <input type="text" name="name" class="<?= isset($errors['name']) ? 'err' : '' ?>" value="<?= htmlspecialchars($name) ?>" placeholder="Masukkan nama lengkap" maxlength="255">
                            <?php if (isset($errors['name'])): ?><div class="err-text">&#9888; <?= $errors['name'] ?></div><?php endif; ?>
                        </div>

                        <div class="field">
                            <label>Email <span class="req">*</span></label>
                            <input type="email" name="email" class="<?= isset($errors['email']) ? 'err' : '' ?>" value="<?= htmlspecialchars($email) ?>" placeholder="contoh@email.com" maxlength="255">
                            <?php if (isset($errors['email'])): ?><div class="err-text">&#9888; <?= $errors['email'] ?></div><?php endif; ?>
                        </div>

                        <div class="field">
                            <label>Password <?= $is_edit ? '' : '<span class="req">*</span>' ?></label>
                            <input type="password" name="password" class="<?= isset($errors['password']) ? 'err' : '' ?>" placeholder="<?= $is_edit ? 'Kosongkan jika tidak ingin mengubah' : 'Minimal 6 karakter' ?>" minlength="6">
                            <?php if (isset($errors['password'])): ?><div class="err-text">&#9888; <?= $errors['password'] ?></div><?php endif; ?>
                            <?php if ($is_edit): ?><div class="hint">Kosongkan jika tidak ingin mengubah password.</div><?php endif; ?>
                        </div>

                        <div class="field">
                            <label>Role <span class="req">*</span></label>
                            <select name="role" class="<?= isset($errors['role']) ? 'err' : '' ?>">
                                <option value="">-- Pilih Role --</option>
                                <option value="admin" <?= $role === 'admin' ? 'selected' : '' ?>>Admin</option>
                                <option value="supervisor" <?= $role === 'supervisor' ? 'selected' : '' ?>>Supervisor</option>
                                <option value="borrower" <?= $role === 'borrower' ? 'selected' : '' ?>>Borrower</option>
                            </select>
                            <?php if (isset($errors['role'])): ?><div class="err-text">&#9888; <?= $errors['role'] ?></div><?php endif; ?>
                        </div>

                        <div class="field full">
                            <label>Foto Profil <span style="color:#94a3b8;font-weight:400;">(opsional)</span></label>
                            <div class="upload-area">
                                <label class="upload-btn" id="uploadLabel">
                                    <span>&#128206;</span> Pilih Foto
                                    <input type="file" name="foto" accept="image/jpeg,image/png,image/gif" id="fotoInput">
                                </label>
                                <span class="upload-hint">Format: JPG, PNG, GIF. Maks 2MB.</span>
                            </div>
                            <?php if (isset($errors['foto'])): ?><div class="err-text">&#9888; <?= $errors['foto'] ?></div><?php endif; ?>
                            <div class="foto-stack">
                                <img id="fotoPreview" alt="Preview">
                                <?php if ($is_edit && $existing_foto && file_exists('../../assets/img/' . $existing_foto)): ?>
                                    <div class="foto-current">
                                        <img src="../../assets/img/<?= htmlspecialchars($existing_foto) ?>" alt="Current foto">
                                        <span>Foto saat ini</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-foot">
                    <button type="submit" class="btn btn-green"><?= $is_edit ? 'Simpan Perubahan' : 'Simpan' ?></button>
                    <a href="index.php" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('fotoInput')?.addEventListener('change', function(e) {
            const preview = document.getElementById('fotoPreview');
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(ev) {
                    preview.src = ev.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        });

        document.querySelector('form')?.addEventListener('submit', function(e) {
            let valid = true;
            const name = this.querySelector('[name="name"]');
            const email = this.querySelector('[name="email"]');
            const password = this.querySelector('[name="password"]');
            const role = this.querySelector('[name="role"]');
            const editId = this.querySelector('[name="edit_id"]');

            this.querySelectorAll('.err-text').forEach(el => el.remove());
            this.querySelectorAll('.err').forEach(el => el.classList.remove('err'));

            function showError(input, msg) {
                input.classList.add('err');
                const div = document.createElement('div');
                div.className = 'err-text';
                div.innerHTML = '&#9888; ' + msg;
                input.parentNode.appendChild(div);
                valid = false;
            }

            if (!name.value.trim()) showError(name, 'Nama wajib diisi.');
            else if (name.value.trim().length < 3) showError(name, 'Nama minimal 3 karakter.');

            if (!email.value.trim()) showError(email, 'Email wajib diisi.');
            else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())) showError(email, 'Format email tidak valid.');

            if (!editId.value || editId.value === '0') {
                if (!password.value.trim()) showError(password, 'Password wajib diisi.');
                else if (password.value.length < 6) showError(password, 'Password minimal 6 karakter.');
            } else {
                if (password.value && password.value.length < 6) showError(password, 'Password minimal 6 karakter.');
            }

            if (!role.value) showError(role, 'Role wajib dipilih.');

            if (!valid) e.preventDefault();
        });
    </script>
    </div>

</body>

</html>