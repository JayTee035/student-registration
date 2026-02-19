<?php
session_start();
if(!isset($_SESSION['success'])){
    header('Location: index.php');
    exit;
}
include 'includes/header.php';
?>

<h2>Welcome to the Dashboard!</h2>
<p>Registration successful.</p>
<a href="logout.php">Logout</a>

<?php include 'includes/footer.php'; ?>
