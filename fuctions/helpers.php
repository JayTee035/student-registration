<?php
// helpers.php

// Sanitize input
function sanitize($data) {
    return htmlspecialchars(trim($data));
}

// Required field validation
function required($fieldName, $value) {
    if (empty($value)) return "$fieldName is required";
    return '';
}

// Email validation
function validateEmail($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return "Invalid email format";
    return '';
}

// Password complexity
function validatePassword($password) {
    if (strlen($password) < 6) return "Password must be at least 6 characters";
    if (!preg_match("/[A-Z]/", $password) || 
        !preg_match("/[0-9]/", $password) ||
        !preg_match("/[\W]/", $password)) {
        return "Password must contain uppercase, number & symbol";
    }
    return '';
}
?>
