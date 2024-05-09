<?php

class LoginController {
    public function index() {
        include 'src/views/login.php';
    }

    public function submit() {
        include 'src/controllers/database.php';
        session_start();

        if (isset($_POST['submit'])){
            extract($_POST);
        
            if ($username != '' && $password != '') {
                $req = $connexion->prepare("SELECT * FROM users WHERE username = :username AND pass = :pass");
                $req->execute(
                    array(
                        "username" => $username,
                        "pass" => $password,
                    )
                );
                $rep = $req->fetch();
                if ($rep['id'] != false){
                    echo 'vous etes connecte';
                    $_SESSION['user_id'] = $rep['id'];
                    $_SESSION['username'] = $rep['username'];
                    $_SESSION['email'] = $rep['email'];
                    header("Location: index.php?page=homepage");
                    exit();
                } else {
                    echo 'error';
                    header("Location: index.php?page=login");
                }
            }

        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: index.php?page=login&action=index");
        exit();
    }
}
