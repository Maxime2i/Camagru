<?php
require_once("src/models/homepage.php");

class HomepageController {
    public function index() {
        session_start();
        
        if (isset($_SESSION['user_id'])) {
            $images = HomepageModel::getImages();
            
        } else {
            header("Location: index.php?page=login");
            exit();
        }

        include 'src/views/homepage.php';


    }
    }


?>