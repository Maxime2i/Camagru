<?php
require_once "src/models/resetPassword.php";

class ResetPasswordController {
    public function index() {
        include 'src/views/resetPassword.php';

    }

    public function submit() {
        session_start();

        if (isset($_POST['id']) && isset($_POST['token']) && isset($_POST['password'])) {
            $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
            $token = htmlspecialchars($_POST['token'], ENT_QUOTES, 'UTF-8');
            $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');

            $user = ResetPasswordModel::getUserByIdAndToken($id, $token);

            if ($user) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $isREsetPassword = ResetPasswordModel::updatePassword($hashed_password, $id);

                if ($isREsetPassword) {
                    $isUpdateToken = ResetPasswordModel::updateToken($id);
                    echo json_encode(['success' => true, 'message' => 'Mot de passe modifié']);
                    exit();
                }
                else {
                    echo json_encode(['success' => false, 'message' => 'Une erreur est survenue']);
                    exit();
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Token invalide']);
                exit();
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Une erreur est survenue']);
            exit();
        }
    }

}