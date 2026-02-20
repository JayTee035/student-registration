<?php
ob_start(); // Important for redirects
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'db.php';
require_once 'functions/helpers.php';

// Debug - remove after testing
error_log("process.php accessed - " . date('Y-m-d H:i:s'));

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    
    // Sanitize inputs
    $form_data = [
        'name' => sanitize($_POST['name'] ?? ''),
        'reg_no' => sanitize($_POST['reg_no'] ?? ''),
        'email' => sanitize($_POST['email'] ?? ''),
        'password' => $_POST['password'] ?? '',
        'course' => sanitize($_POST['course'] ?? ''),
        'gender' => sanitize($_POST['gender'] ?? ''),
        'age' => !empty($_POST['age']) ? (int)$_POST['age'] : null
    ];
    
    $_SESSION['form_data'] = $form_data;
    
    // Validate
    $errors = validateRegistration($form_data, $pdo);
    
    if (empty($errors)) {
        try {
            $hashed_password = password_hash($form_data['password'], PASSWORD_DEFAULT);
            
            $sql = "INSERT INTO students (name, registration_number, email, password, course, gender, age) 
                    VALUES (:name, :reg_no, :email, :password, :course, :gender, :age)";
            
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute([
                ':name' => $form_data['name'],
                ':reg_no' => $form_data['reg_no'],
                ':email' => $form_data['email'],
                ':password' => $hashed_password,
                ':course' => $form_data['course'],
                ':gender' => $form_data['gender'],
                ':age' => $form_data['age']
            ]);
            
            if ($result) {
                $_SESSION['user_id'] = $pdo->lastInsertId();
                $_SESSION['user_name'] = $form_data['name'];
                
                setFlashMessage('success', 'Registration successful! Welcome ' . $form_data['name']);
                
                // Clear form data
                unset($_SESSION['form_data']);
                
                // IMPORTANT: Redirect to dashboard
                header('Location: dashboard.php');
                exit();
            }
        } catch (PDOException $e) {
            error_log("Registration error: " . $e->getMessage());
            setFlashMessage('error', 'Registration failed. Please try again.');
            $_SESSION['errors'] = ['Database error occurred'];
        }
    } else {
        $_SESSION['errors'] = $errors;
        setFlashMessage('error', 'Please correct the errors in the form.');
    }
    
    // If we get here, there were errors
    header('Location: index.php');
    exit();
    
} else {
    // Direct access to process.php
    header('Location: index.php');
    exit();
}
ob_end_flush();
?>
