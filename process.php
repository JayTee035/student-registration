<?php
require 'functions/helpers.php';
require 'db.php';
session_start();

$errors = [];
$old = [
    'name'=>'','email'=>'','reg_no'=>'','password'=>'','gender'=>'','course'=>''
];

if($_SERVER['REQUEST_METHOD']==='POST'){

    foreach($old as $key=>$value){
        $old[$key] = sanitize($_POST[$key] ?? '');
    }

    // Validation
    if($msg = required('Full Name',$old['name'])) $errors['name']=$msg;
    if($msg = required('Email',$old['email'])) $errors['email']=$msg;
    elseif($msg = validateEmail($old['email'])) $errors['email']=$msg;

    if($msg = required('Registration Number',$old['reg_no'])) $errors['reg_no']=$msg;
    if($msg = required('Password',$_POST['password'])) $errors['password']=$msg;
    elseif($msg = validatePassword($_POST['password'])) $errors['password']=$msg;

    if($msg = required('Gender',$old['gender'])) $errors['gender']=$msg;
    if($msg = required('Course',$old['course'])) $errors['course']=$msg;

    // If errors, redirect back
    if(!empty($errors)){
        $_SESSION['errors']=$errors;
        $_SESSION['old']=$old;
        header('Location: index.php');
        exit;
    }

    // Insert into database
    $stmt = $pdo->prepare("INSERT INTO students (name,email,reg_no,password,gender,course) VALUES (?,?,?,?,?,?)");
    $stmt->execute([
        $old['name'],
        $old['email'],
        $old['reg_no'],
        password_hash($_POST['password'], PASSWORD_DEFAULT),
        $old['gender'],
        $old['course']
    ]);

    $_SESSION['success'] = "Student registered successfully!";
    header('Location: dashboard.php');
    exit;
}
?>
