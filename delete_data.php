<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['owner', 'admin', 'petugas'])) {
    header("Location: list_data.php");
    exit;
}

$id = $_GET['id'] ?? '';

if (!empty($id)) {
    try {
        $stmt = $pdo->prepare("DELETE FROM data_siswa WHERE id = ?");
        $stmt->execute([$id]);
    } catch (PDOException $e) {
    }
}

header("Location: list_data.php");
exit;
?>