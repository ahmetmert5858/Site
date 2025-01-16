<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_dashboard.php?error=unauthorized");
    exit();
}

require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comment_id = isset($_POST['comment_id']) ? intval($_POST['comment_id']) : 0;
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    // Geçersiz istek kontrolü
    if ($comment_id <= 0 || !in_array($action, ['approve', 'reject'], true)) {
        header("Location: admin_dashboard.php?error=invalid_request");
        exit();
    }

    // İşlem tipine göre SQL
    if ($action === 'approve') {
        $sql = "UPDATE comments SET onayli = 1 WHERE id = ?";
    } elseif ($action === 'reject') {
        $sql = "DELETE FROM comments WHERE id = ?";
    }

    // SQL sorgusunu çalıştır
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $comment_id);

    if ($stmt->execute()) {
        if ($action === 'approve') {
            header("Location: admin_dashboard.php?success=comment_approved");
        } elseif ($action === 'reject') {
            header("Location: admin_dashboard.php?success=comment_rejected");
        }
    } else {
        header("Location: admin_dashboard.php?error=database_error");
    }
    exit();
}
?>
