<?php
class userImageContent {
        // this class created for image process. 
        // I used imgur to keep image path on online instead of my computer,
        // it is little bit easier to do it. 
        //this function to create image and I am sending it with my spesific token
        // this token is in line 15 unutma access token koycan register degil. 
        // access token da documents da ninova/database/reimBilgiler.txt de unutma! 

        public static function userInstallImage($formname, $query, $params) {

                // image type will be this php function! tam arastir sonra! 
                $image = base64_encode(file_get_contents($_FILES[$formname]['tmp_name']));

                // I am fetcing to all information to array..
                $options = array('http'=>array(
                        'method'=>"POST",
                        'header'=>"Authorization: Bearer fd7e6e5d3546b813f57abd5204c8c9485957d2fd\n".
                        "Content-Type: application/x-www-form-urlencoded",
                        'content'=>$image
                ));

                // php ozel isleme.. 
                $context = stream_context_create($options);
                //resmin url si benim hesaba gelcek imgur/ermansahintatar a 

                $imgurURL = "https://api.imgur.com/3/image";
               
                // fazla mb resimleri almamak icin! unutma bug degil resim cok buyukse codition var.
                if ($_FILES[$formname]['size'] > 10240000) {
                        die('Image too big, must be 10MB or less!');
                }

                $response = file_get_contents($imgurURL, false, $context);
                $response = json_decode($response);

                $preparams = array($formname=>$response->data->link);

                $params = $preparams + $params;

                access::create_query($query, $params);

        }

}
?>
