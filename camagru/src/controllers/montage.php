<?php
require_once('src/models/montage.php');

class MontageController {
    public function index() {
        // Affiche le formulaire de connexion

        $recentImages = MontageModel::getRecentImages();

        include 'src/views/montage.php';
    }


    public function submit() {
        
    }

}

?>