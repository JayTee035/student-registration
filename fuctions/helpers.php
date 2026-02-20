<?php

function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function emailExists($pdo, $email) {
    // Check if column is 'email' (should be correct)
    $stmt = $pdo->prepare("SELECT id FROM students WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetch() ? true : false;
}

function regNumberExists($pdo, $reg_no) {
    // Try 'registration_number' first, if error, change to 'reg_no'
    try {
        // Try with 'registration_number' first
        $stmt = $pdo->prepare("SELECT id FROM students WHERE registration_number = ?");
        $stmt->execute([$reg_no]);
        return $stmt->fetch() ? true : false;
    } catch (PDOException $e) {
        // If error, try with 'reg_no' instead
        error_log("First attempt failed, trying reg_no: " . $e->getMessage());
        $stmt = $pdo->prepare("SELECT id FROM students WHERE reg_no = ?");
        $stmt->execute([$reg_no]);
        return $stmt->fetch() ? true : false;
    }
}

function validateRegistration($data, $pdo) {
    $errors = [];
    
    if (empty($data['name'])) {
        $errors['name'] = "Name is required";
    } elseif (strlen($data['name']) < 2) {
        $errors['name'] = "Name must be at least 2 characters";
    }
    
    if (empty($data['reg_no'])) {
        $errors['reg_no'] = "Registration number is required";
    } elseif (regNumberExists($pdo, $data['reg_no'])) { // This line was causing error
        $errors['reg_no'] = "Registration number already exists";
    }
    
    if (empty($data['email'])) {
        $errors['email'] = "Email is required";
    } elseif (!validateEmail($data['email'])) {
        $errors['email'] = "Invalid email format";
    } elseif (emailExists($pdo, $data['email'])) {
        $errors['email'] = "Email already registered";
    }
    
    if (empty($data['password'])) {
        $errors['password'] = "Password is required";
    } elseif (strlen($data['password']) < 6) {
        $errors['password'] = "Password must be at least 6 characters";
    }
    
    if (empty($data['course'])) {
        $errors['course'] = "Course is required";
    }
    
    if (empty($data['gender'])) {
        $errors['gender'] = "Gender is required";
    }
    
    if (!empty($data['age']) && (!is_numeric($data['age']) || $data['age'] < 1 || $data['age'] > 120)) {
        $errors['age'] = "Please enter a valid age (1-120)";
    }
    
    return $errors;
}

function setFlashMessage($type, $message) {
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message
    ];
}

function getFlashMessage() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}
?>
