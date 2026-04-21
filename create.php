<?php
require 'db.php';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $course = trim($_POST['course']);

    if (empty($name) || empty($email) || empty($course)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        $sql = "INSERT INTO students (name, email, course) VALUES (:name, :email, :course)";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute(['name' => $name, 'email' => $email, 'course' => $course])) {
            $message = "Student added successfully!";
        } else {
            $error = "Failed to add student. Please try again.";
        }
    }
}

include 'header.php';
?>

<div class="card" style="max-width: 600px; margin: 2rem auto;">
    <h2>Add New Student</h2>
    
    <?php if ($message): ?>
        <div class="alert alert-success"><?= s($message) ?></div>
        <div style="margin-bottom: 2rem;">
            <a href="index.php" class="btn btn-primary">Back to Directory</a>
        </div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger" style="background: rgba(239, 68, 68, 0.1); color: var(--danger-color); border: 1px solid rgba(239, 68, 68, 0.2); padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;"><?= s($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" placeholder="John Doe" required value="<?= isset($_POST['name']) ? s($_POST['name']) : '' ?>">
        </div>
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" placeholder="john@example.com" required value="<?= isset($_POST['email']) ? s($_POST['email']) : '' ?>">
        </div>
        <div class="form-group">
            <label for="course">Course / Department</label>
            <input type="text" id="course" name="course" placeholder="Computer Science" required value="<?= isset($_POST['course']) ? s($_POST['course']) : '' ?>">
        </div>
        
        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">Add Student</button>
            <a href="index.php" class="btn btn-danger">Cancel</a>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>