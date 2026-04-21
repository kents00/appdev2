<?php
require 'db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$message = '';
$error = '';

// Fetch current data
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch();

if (!$student) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $course = trim($_POST['course']);

    if (empty($name) || empty($email) || empty($course)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        $sql = "UPDATE students SET name = ?, email = ?, course = ? WHERE id = ?";
        if ($pdo->prepare($sql)->execute([$name, $email, $course, $id])) {
            header("Location: index.php?msg=updated");
            exit;
        } else {
            $error = "Failed to update student.";
        }
    }
}

include 'header.php';
?>

<div class="card" style="max-width: 600px; margin: 2rem auto;">
    <h2>Edit Student</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger" style="background: rgba(239, 68, 68, 0.1); color: var(--danger-color); border: 1px solid rgba(239, 68, 68, 0.2); padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;"><?= s($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" value="<?= s($student['name']) ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" value="<?= s($student['email']) ?>" required>
        </div>
        <div class="form-group">
            <label for="course">Course / Department</label>
            <input type="text" id="course" name="course" value="<?= s($student['course']) ?>" required>
        </div>
        
        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">Update Profile</button>
            <a href="index.php" class="btn btn-danger">Cancel</a>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>