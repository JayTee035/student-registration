<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Registration</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<?php
// Show success message if exists
if (isset($_SESSION['success'])) {
    echo "<div class='success'>{$_SESSION['success']}</div>";
    unset($_SESSION['success']);
}
?>
