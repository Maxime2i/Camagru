<?php
require_once('src/models/montage.php');

class MontageController {
    public function index() {
        include 'src/views/montage.php';

        $recentImages = MontageModel::getRecentImages();
    }


}

?>