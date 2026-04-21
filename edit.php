<?php
require 'db.php';
$id = $_GET['id'];

// Fetch current data
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql = "UPDATE students SET name = ?, email = ?, course = ? WHERE id = ?";
    $pdo->prepare($sql)->execute([$_POST['name'], $_POST['email'], $_POST['course'], $id]);
    header("Location: index.php");
}
?>

<form method="POST">
    <input type="text" name="name" value="<?= $student['name'] ?>">
    <input type="email" name="email" value="<?= $student['email'] ?>">
    <input type="text" name="course" value="<?= $student['course'] ?>">
    <button type="submit">Update</button>
</form>