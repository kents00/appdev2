<?php
require 'db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

// Fetch current data
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch();

if (!$student) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql = "UPDATE students SET name = ?, email = ?, course = ? WHERE id = ?";
    $pdo->prepare($sql)->execute([$_POST['name'], $_POST['email'], $_POST['course'], $id]);
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student - Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container" style="max-width: 500px;">
        <div class="nav">
            <a href="index.php" style="color: #64748b; text-decoration: none; font-size: 0.875rem;">&larr; Back to Records</a>
        </div>
        <div class="card">
            <h1>Edit Student</h1>
            
            <form method="POST">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($student['name']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($student['email']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Course</label>
                    <input type="text" name="course" value="<?= htmlspecialchars($student['course']) ?>" required>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; margin-top: 1rem;">Update Record</button>
            </form>
        </div>
    </div>
</body>
</html>