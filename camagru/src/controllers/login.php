<?php

class LoginController {
    public function index() {
        // Affiche le formulaire de connexion
        include 'src/views/login.php';
    }

    public function submit() {
        include 'src/controllers/database.php';
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
                    header("Location: index.php?page=homepage");
                    exit();
                } else {
                    echo 'error';
                    header("Location: index.php?page=login");
                }
            }

        }


    }
}
