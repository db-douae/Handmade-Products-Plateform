<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../models/user.php';

class AuthController {
    private $userModel;
    
    public function __construct($pdo) {
        $this->userModel = new User($pdo);
    }
    
    public function login() { 
        startSession();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
           $email = $_POST['email'];
           $password = $_POST['password'];

           $user = $this->userModel->findByEmail($email);

           if ($user && password_verify($password, $user['password'])) {
             loginUser($user);
             header("Location: /Handmade-Products-Plateform/project/pages/index.php");
             exit();
              } else {
                    $_SESSION['error'] = "Wrong informations.";
            header("Location: /Handmade-Products-Plateform/project/pages/auth/login.php");
exit();
            }  
        }
    }

    public function register(){
        startSession();
        if($_SERVER["REQUEST_METHOD"]=="POST"){

            $first_name=$_POST['first_name'];
            $last_name=$_POST['last_name'];
            $email=$_POST['email'];
            $password=$_POST['password'];

            $re_password = $_POST['re_password'];

            if ($password !== $re_password) {
            $_SESSION['error'] = "Passwords do not match!";
            header("Location: /Handmade-Products-Plateform/project/pages/auth/signin.php");
exit();
            return;
            }

            $re_email = $_POST['re_email'];

            if ($email !== $re_email) {
          $_SESSION['error'] = "Emails do not match!";
            header("Location: /Handmade-Products-Plateform/project/pages/auth/signin.php");
exit();
            return;
            }
            if (strlen($password) < 8) {
    $_SESSION['error'] = "Password must be at least 8 characters!";
    header("Location: /Handmade-Products-Plateform/project/pages/auth/signin.php");
    exit();
}

            $existingUser = $this->userModel->findByEmail($email);

            if(!$existingUser){
                $password=password_hash($password, PASSWORD_DEFAULT);
                $data = [
                        'first_name' => $first_name,
                        'last_name'  => $last_name,
                        'email'      => $email,
                        'password'   => $password,
                        'role'       => 'buyer'
                        ];

                $this->userModel->create($data);
                $user = $this->userModel->findByEmail($email); // نجيب المستخدم الجديد
                loginUser($user);

                header("Location: /Handmade-Products-Plateform/project/pages/auth/interests.php");
            }else{
                echo "choose another email.";
            }

        }
    }

    public function logout(){
        logoutUser();
    }

    public function saveInterests(){
        startSession();
        if($_SERVER["REQUEST_METHOD"]=="POST"){

            $interests=$_POST['interests'];
            $id=$_SESSION['userId'];

            $this->userModel->updateInterests($id, $interests);
            header("Location: /Handmade-Products-Plateform/project/pages/index.php");
            exit();

        }
    }
}




?>