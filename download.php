

<?php

    function get_data($db, $emotion, $db_type){
        if($db_type == 'pgsql')
            $data = pg_query($db, 'select * from facimotion where emotion = \''.$emotion.'\';');
        else
            $data = $db->query('select * from facimotion where emotion = \''.$emotion.'\';');
        if(!$data)
            return null;
        $i = 0;
        $response = '';
        if($db_type == 'pgsql')
            while($unit = pg_fetch_row($data)){
                $response .= 'curl '.$unit['url'].' --output '.$emotion.'/image_'.$i.'.jpg<br>'; 
                $i++;
            }
        else
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

            include 'database.php';
            
            for ($i=0; isset($emotions[$i]) ; $i++) { 
                echo get_data($db, $emotions[$i], $db_type);
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

