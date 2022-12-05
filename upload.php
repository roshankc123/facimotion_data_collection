<?php
    function apiRequest($url, $post=FALSE, $headers=array(),$token=null) {
        // echo $url;
        // print_r($post);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
       
        if($post)
          curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        $headers = [
          'Accept: application/json',
          'User-Agent: http://'.$_SERVER['HTTP_HOST'],
          "mimeType: multipart/form-data",
          "processData: ".false,
          "contentType: ".false,
        ];
       
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
       
        $response = curl_exec($ch);
        return json_decode($response, true);
    }


    // $image = $_POST['image'];
    // print_r($_FILES);               ///size in bytes
    if(getenv('key')){
        echo 'env key';
    }else{
        $key = file_get_contents('key');
    }
    
    // echo $key;

    // file_put_contents('/tmp/abc', $_POST['image']);

    // if()
    // echo $key;
    // print_r($key);

    $data = [
        // 'name' => hash("md5", time()).'.png',
        'key' => $key,
        'image' => $_POST['image'],      ////base64_encode(file_get_contents($_POST['image']['tmp_name']))
        // 'name' => 'temp.png',
    ];

    // print_r($_POST['image']);
    // str_split($_POST['image'], )
    

    $response = apiRequest('https://api.imgbb.com/1/upload?', $data);

    // print_r($response);
    unset($data);
    // print_r($response);
    if(!$response['data'])
        die(json_encode([
            'status' => 0,
            'message' => 'error with image uploading',
        ]));
    
    // this is the order of data in database
    $data = [
        'url' => $response['data']['url'],
        'size' => $response['data']['size'],
        "width" => $response['data']['width'],
        "height" => $response['data']['height'],
        'emotion' => $_POST['emotion']
    ];          

    include 'database.php';
    // echo $db_type;
        
    $values = "('".$data['url']."','".$data['size']."','".$data['width']."','".$data['height']."','".$data['emotion']."')";
    if($db_type == 'pgsql'){
        if(!pg_query($db, 'insert into facimotion values'.$values)){
            die(json_encode([
                'status' => 0,
                'message' => 'error with us',
            ]));
        }
    }else{
        if(!$db->query('insert into facimotion values'.$values)){
            die(json_encode([
                'status' => 0,
                'message' => 'error with us',
            ]));
        }
            
    }
        

        // print_r($db);


    echo json_encode([
        'status' => 1,
        'message' => 'thanks for the data',
    ]);
    // $db->dba_insert()

    // print_r($data);


?>