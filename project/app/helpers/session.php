<?php
if (!function_exists('startSession')) {
function startSession() { 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
 }

function loginUser($user) { 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    $_SESSION['userId']=$user['id'];
    $_SESSION['role']=$user['role'];

}       

function isLoggedIn() { 
     return isset($_SESSION['userId']);
 }        

function getUserRole() { 
    return $_SESSION['role'];
}         

function isArtisan() { 
     return getUserRole() === 'artisan';
 } 

function logoutUser() { 
    session_destroy();
    header("Location: /Handmade-Products-Plateform/project/pages/index.php");
    exit();
 }
 
 function requireLogin() {
    startSession();
    if (!isLoggedIn()) {
        header("Location: /Handmade-Products-Plateform/project/pages/auth/login.php");
        exit();
    }
}

function requireAdmin() {
    requireLogin();
    if (getUserRole() !== 'admin') {
        header("Location: /Handmade-Products-Plateform/project/pages/index.php");
        exit();
    }
}

function clean($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function requireRole($role) {
    startSession();
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== $role) {
        header("Location: /Handmade-Products-Plateform/project/pages/index.php");
        exit();
    }

}
}


?>
