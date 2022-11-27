<?php
    // $handle = new SQLite3('database.sqlite');
    ///set db to mysql in environment
    $conn = env('DB_connecion', null);
    $username = env('DB_username', null);
    $password = env('DB_password', null);
    $database = env('DB_database', null);


    // $handle->query('create table facimotion(url varchar(200), size bigint, width int, height int, emotion varchar(10))');
?>