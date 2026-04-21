<?php
require 'db.php';

$search = isset($_GET['q']) ? $_GET['q'] : '';

if ($search) {
    $stmt = $pdo->prepare("SELECT * FROM students WHERE name LIKE ? OR email LIKE ? OR course LIKE ?");
    $searchTerm = "%$search%";
    $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
} else {
    $stmt = $pdo->query("SELECT * FROM students ORDER BY id DESC");
}

$students = $stmt->fetchAll();

$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
$alert = '';

if ($msg == 'updated') {
    $alert = "Student record updated successfully!";
} elseif ($msg == 'deleted') {
    $alert = "Student record deleted successfully!";
}

include 'header.php';
?>

<?php if ($alert): ?>
    <div class="alert alert-success fade-in"><?= s($alert) ?></div>
<?php endif; ?>

<div class="card">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1>Student Directory</h1>
        <a href="create.php" class="btn btn-primary">Add New Student</a>
    </div>

    <form action="index.php" method="GET" class="search-bar">
        <input type="search" name="q" placeholder="Search by name, email or course..." value="<?= s($search) ?>">
        <button type="submit" class="btn btn-primary">Search</button>
        <?php if ($search): ?>
            <a href="index.php" class="btn btn-danger">Clear</a>
        <?php endif; ?>
    </form>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Course</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($students)): ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 2rem; color: var(--text-muted);">
                            No students found matching your criteria.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($students as $s): ?>
                    <tr>
                        <td>#<?= $s['id'] ?></td>
                        <td><strong><?= s($s['name']) ?></strong></td>
                        <td><?= s($s['email']) ?></td>
                        <td><?= s($s['course']) ?></td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="edit.php?id=<?= $s['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                                <form action="delete.php" method="GET" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this record?')">
                                    <input type="hidden" name="id" value="<?= $s['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'footer.php'; ?>