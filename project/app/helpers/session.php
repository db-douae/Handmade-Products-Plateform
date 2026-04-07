<?php

function startSession() { 
    session_start();
 }

function loginUser($user) { 
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
    header("Location: /Handmade-Products-Plateform/project/pages/auth/login.php");
    exit();
 }    

?>