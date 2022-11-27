

<?php

    function get_data($db, $emotion){
        $data = $db->query('select * from facimotion where emotion = "'.$emotion.'"');
        $i = 0;
        $response = '';
        while($unit = $data->fetchArray()){
            $response .= 'curl '.$unit['url'].' --output '.$emotion.'/image_'.$i.'.jpg<br>'; 
            $i++;
        }
        return $response;
    }


    if(isset($_POST['password'])){
        if($_POST['password'] == 'blahblahh'){
            include 'emotions.php';
            for ($i=0; isset($emotions[$i]) ; $i++) { 
                echo 'mkdir '.$emotions[$i].'<br>';
            }
            $curl = 'mkdir ';
            if(getenv('DB') == null){
                $db = new SQLite3('database.sqlite');
            }
            else{
                include 'database.php';
                $db =  pg_connect("host=".$conn." port=5432 dbname=".$database." user=".$username." password=".$password);
            }
            
            for ($i=0; isset($emotions[$i]) ; $i++) { 
                echo get_data($db, $emotions[$i]);
            }
            
        }
        else{
            $message = 'authentication failed';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>download dataset</title>
</head>
<body>
    <?=$message ?? ''?>
    <form action="" method="post">
        <input type="password" name="password" id="">
        <input type="submit" value="download">
    </form>
</body>
</html>

