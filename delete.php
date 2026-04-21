<?php
require 'db.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id']; // Cast to int for security
    $stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: index.php?msg=deleted");
exit;
?>

