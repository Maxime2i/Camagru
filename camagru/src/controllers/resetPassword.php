<?php
require_once "src/models/resetPassword.php";

class ResetPasswordController {
    public function index() {
        include 'src/views/resetPassword.php';
        $_SESSION['sucess'] = false;
    }

    public function submit() {
        session_start();
        include 'src/views/resetPassword.php';
        
        $sucess = false;

        if (isset($_GET['id']) && isset($_GET['token']) && isset($_POST['password'])) {
            $id = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');
            $token = htmlspecialchars($_GET['token'], ENT_QUOTES, 'UTF-8');
            $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');

            $user = ResetPasswordModel::getUserByIdAndToken($id, $token);

            if ($user) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                ResetPasswordModel::updatePassword($hashed_password, $id);
                $sucess = true;
            } else {
                echo "Token invalide";
            }

            $_SESSION['sucess'] = $sucess;
            header('Location: index.php?page=resetPassword');
           
        } else {
            exit();
        }
    }

}