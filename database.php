<?php
    // $handle = new SQLite3('database.sqlite');
    ///set db to mysql in environment
    $conn = getenv('DB_connecion');
    $username = getenv('DB_username');
    $password = getenv('DB_password');
    $database = getenv('DB_database');


    // $handle->query('create table facimotion(url varchar(200), size bigint, width int, height int, emotion varchar(10))');
?>