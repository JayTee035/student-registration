<?php
ini_set('display errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);
?>
<?php
require 'functions/helpers.php';
$old = [
    'name'=>'','email'=>'','reg_no'=>'','password'=>'','gender'=>'','course'=>''
];
$errors = [];

// Repopulate old values from session if redirected back
if(isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    $old = $_SESSION['old'];
    unset($_SESSION['errors']);
    unset($_SESSION['old']);
}

include 'includes/header.php';
?>

<h2>Student Registration Form</h2>

<form id="studentForm" action="process.php" method="POST" novalidate>

    <label>
        Full Name:
        <input type="text" name="name" value="<?= htmlspecialchars($old['name']) ?>">
        <div class="error"><?= $errors['name'] ?? '' ?></div>
    </label>

    <label>
        Email:
        <input type="email" name="email" value="<?= htmlspecialchars($old['email']) ?>">
        <div class="error"><?= $errors['email'] ?? '' ?></div>
    </label>

    <label>
        Registration Number:
        <input type="text" name="reg_no" value="<?= htmlspecialchars($old['reg_no']) ?>">
        <div class="error"><?= $errors['reg_no'] ?? '' ?></div>
    </label>

    <label>
        Password:
        <input type="password" name="password">
        <div class="error"><?= $errors['password'] ?? '' ?></div>
    </label>

    <label>
        Gender:
        <select name="gender">
            <option value="">--Select--</option>
            <option value="Male" <?= $old['gender']=='Male'?'selected':'' ?>>Male</option>
            <option value="Female" <?= $old['gender']=='Female'?'selected':'' ?>>Female</option>
            <option value="Other" <?= $old['gender']=='Other'?'selected':'' ?>>Other</option>
        </select>
        <div class="error"><?= $errors['gender'] ?? '' ?></div>
    </label>

    <label>
        Course:
        <select name="course">
            <option value="">--Select--</option>
            <option value="Computer Science" <?= $old['course']=='Computer Science'?'selected':'' ?>>Computer Science</option>
            <option value="Engineering" <?= $old['course']=='Engineering'?'selected':'' ?>>Engineering</option>
            <option value="Business" <?= $old['course']=='Business'?'selected':'' ?>>Business</option>
        </select>
        <div class="error"><?= $errors['course'] ?? '' ?></div>
    </label>

    <button type="submit">Register</button>
</form>

<?php include 'includes/footer.php'; ?>
