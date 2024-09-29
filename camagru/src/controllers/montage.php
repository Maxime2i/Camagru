<?php
require_once('src/models/montage.php');

class MontageController {
    public function index() {
        $recentImages = MontageModel::getRecentImages();
        
        include 'src/views/montage.php';
    }


}

?>