<?php

    require_once "database.php";
    require_once __DIR__ . "/../app/controllers/database.php";

    try {
        $db = new database($DB_DSN, $DB_USER, $DB_PASSWORD);
        $db->query($CREATE_DB);
        $db->query($DB_MEMBERS);

    } catch (PDOException $e) {
        die($e->getMessage());
    }