<?php

    $DB_DSN = "mysql:host=0.0.0.0;";

    $DB_USER = "admin";

    $DB_PASSWORD = "admin";

    $CREATE_DB = "CREATE DATABASE IF NOT EXISTS camagru";

    $DB_MEMBERS = "CREATE TABLE IF NOT EXISTS camagru.members (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            email VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL,
            login VARCHAR(255) NOT NULL)";
            
