<?php
session_start();
 require_once __DIR__ . '/../helper/data/db_conn.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';
$id     = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {

    if ($action === 'cancel') {
        $query_cancel = "UPDATE reservations SET status = 'dibatalkan' WHERE id = $id";
        $eksekusi_cancel = mysqli_query($conn, $query_cancel);

        if ($eksekusi_cancel) {
            header("Location: ../pages/reservation/detail.php?id=" . $id);
            exit();
        } else {
            die("Error: " . mysqli_error($conn));
        }

    } elseif ($action === 'delete') {
        $query_delete = "DELETE FROM reservations WHERE id = $id";
        $eksekusi_delete = mysqli_query($conn, $query_delete);

        if ($eksekusi_delete) {
            header("Location: ../pages/reservation/index.php");
            exit();
        } else {
            die("Error: " . mysqli_error($conn));
        }
    } elseif ($action === 'update') {
        $borrower_name  = isset($_POST['borrower_name']) ? mysqli_real_escape_string($conn, $_POST['borrower_name']) : '';
        $borrower_email = isset($_POST['borrower_email']) ? mysqli_real_escape_string($conn, $_POST['borrower_email']) : '';
        $notes          = isset($_POST['notes']) ? mysqli_real_escape_string($conn, $_POST['notes']) : '';

        if (!empty($borrower_name) && !empty($borrower_email)) {
            $query_update = "UPDATE reservations SET 
                                borrower_name = '$borrower_name', 
                                borrower_email = '$borrower_email', 
                                notes = '$notes' 
                             WHERE id = $id";

            $eksekusi_update = mysqli_query($conn, $query_update);

            if ($eksekusi_update) {
                header("Location: ../pages/reservation/detail.php?id=" . $id);
                exit();
            } else {
                die("Error: " . mysqli_error($conn));
            }
        } else {
            header("Location: ../pages/reservation/detail.php?id=" . $id . "&status=failed");
            exit();
        }
    } else {
        header("Location: ../pages/reservation/index.php");
        exit();
    }
} else {
    header("Location: ../pages/reservation/index.php");
    exit();
}

    } elseif ($action === 'update') {
        $borrower_name  = isset($_POST['borrower_name']) ? mysqli_real_escape_string($conn, $_POST['borrower_name']) : '';
        $borrower_email = isset($_POST['borrower_email']) ? mysqli_real_escape_string($conn, $_POST['borrower_email']) : '';
        $notes          = isset($_POST['notes']) ? mysqli_real_escape_string($conn, $_POST['notes']) : '';

        if (!empty($borrower_name) && !empty($borrower_email)) {
            $query_update = "UPDATE reservations SET 
                                borrower_name = '$borrower_name', 
                                borrower_email = '$borrower_email', 
                                notes = '$notes' 
                             WHERE id = $id";
            
            $eksekusi_update = mysqli_query($conn, $query_update);

            if ($eksekusi_update) {
                header("Location: ../pages/reservation/detail.php?id=" . $id);
                exit();
            } else {
                die("Error: " . mysqli_error($conn));
            }
        } else {
            header("Location: ../pages/reservation/detail.php?id=" . $id . "&status=failed");
            exit();
        }
        
    } else {
        header("Location: ../pages/reservation/index.php");
        exit();
    }

} else {
    header("Location: ../pages/reservation/index.php");
    exit();
}