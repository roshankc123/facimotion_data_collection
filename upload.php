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
        ];
       
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
       
        $response = curl_exec($ch);
        return json_decode($response, true);
    }


    // $image = $_POST['image'];
    // print_r($_FILES);               ///size in bytes

    $key = file_get_contents('key');

    // if()
    // echo $key;
    // print_r($key);

    $data = [
        'name' => hash("md5", time()),
        'key' => $key,
        'image' => base64_encode(file_get_contents($_FILES['image']['tmp_name']))
    ];

    $response = apiRequest('https://api.imgbb.com/1/upload?', $data);

    // print_r($response);
    unset($data);
    if(!$response['data'])
        die('error');
    
    // this is the order of data in database
    $data = [
        'url' => $response['data']['url'],
        'size' => $response['data']['size'],
        "width" => $response['data']['width'],
        "height" => $response['data']['height'],
        'emotion' => $_POST['emotion']
    ];          

    $db = new SQLite3('database.sqlite');

    $values = "('".$data['url']."','".$data['size']."','".$data['width']."','".$data['height']."','".$data['emotion']."')";

    $db->query('insert into facimotion values'.$values);
    // $db->dba_insert()

    // print_r($data);


?>