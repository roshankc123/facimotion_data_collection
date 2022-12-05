<?php
    if(!getenv('DB_connection')){
        $db = new SQLite3('database.sqlite');
        $db_type = 'sqlite';
    }
    else{
        $conn = getenv('DB_connection');
        $username = getenv('DB_username');
        $password = getenv('DB_password');
        $database = getenv('DB_database');
        $db =  pg_connect(getenv("DATABASE_URL"));
        $db_type = 'pgsql';
    }
    ///set db to mysql in environment
    


    // $handle->query('create table facimotion(url varchar(200), size bigint, width int, height int, emotion varchar(10))');
?>