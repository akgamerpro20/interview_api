<?php

function delete_files($target)
{
    if (is_dir($target)) {
        $files = glob($target . '*', GLOB_MARK); //GLOB_MARK adds a slash to directories returned

        foreach ($files as $file) {
            delete_files($file);
        }

        if (file_exists($target)) {

            rmdir($target);
        }
    } elseif (is_file($target)) {
        unlink($target);
    }
}


$servername = "db-mysql-sgp1-28255-do-user-14089511-0.b.db.ondigitalocean.com";
$dbusername = "doadmin";
$dbpassword = 'AVNS_rLM2YTJyAioumr-mBT3';
try {
    while (1) {
        $conn = new PDO("mysql:host=$servername;dbname=defaultdb", $dbusername, $dbpassword);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM streamings where status = 'no' LIMIT 1";
        $query = $conn->prepare($sql);
        $query->execute();
        $result = $query->fetch();

        echo $sql;
        return;
        if ($result != false && $result['id'] != null) {


            $conn = new PDO("mysql:host=$servername;dbname=mizzima_transcoder", $dbusername, $dbpassword);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $update = "UPDATE streamings SET status = 'process' WHERE id = " . $result['id'];

            $conn->exec($update);


            $savefile_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $result['name']);
            $savefile_name = str_replace(" ", "_", $savefile_name);
            //echo $savefile_name;
            if ($result['type'] == "movie") {

                // $save_path_426_240 = "/var/www/stream/movies/".$savefile_name."/426-240/".$savefile_name.".m3u8";
                $save_path_640_360 = "/var/www/stream/movies/" . $savefile_name . "/640-360/" . $savefile_name . ".m3u8";
                $save_path_854_480 = "/var/www/stream/movies/" . $savefile_name . "/854-480/" . $savefile_name . ".m3u8";
                $save_path_1280_720 = "/var/www/stream/movies/" . $savefile_name . "/1280-720/" . $savefile_name . ".m3u8";

                mkdir("/var/www/stream/movies/" . $savefile_name);
                //mkdir("/var/www/stream/movies/".$savefile_name."/426-240");
                mkdir("/var/www/stream/movies/" . $savefile_name . "/640-360");
                mkdir("/var/www/stream/movies/" . $savefile_name . "/854-480");
                mkdir("/var/www/stream/movies/" . $savefile_name . "/1280-720");

            } elseif ($result['type'] == "trailer") {

                //$save_path_426_240 = "/var/www/stream/trailers/".$savefile_name."/426-240/".$savefile_name.".m3u8";
                $save_path_640_360 = "/var/www/stream/trailers/" . $savefile_name . "/640-360/" . $savefile_name . ".m3u8";
                $save_path_854_480 = "/var/www/stream/trailers/" . $savefile_name . "/854-480/" . $savefile_name . ".m3u8";
                $save_path_1280_720 = "/var/www/stream/trailers/" . $savefile_name . "/1280-720/" . $savefile_name . ".m3u8";

                mkdir("/var/www/stream/trailers/" . $savefile_name);
                //mkdir("/var/www/stream/trailers/".$savefile_name."/426-240");
                mkdir("/var/www/stream/trailers/" . $savefile_name . "/640-360");
                mkdir("/var/www/stream/trailers/" . $savefile_name . "/854-480");
                mkdir("/var/www/stream/trailers/" . $savefile_name . "/1280-720");

            } elseif ($result['type'] == "series") {


                //$save_path_426_240 = "/var/www/stream/series/".$savefile_name."/426-240/".$savefile_name.".m3u8";
                $save_path_640_360 = "/var/www/stream/series/" . $savefile_name . "/640-360/" . $savefile_name . ".m3u8";
                $save_path_854_480 = "/var/www/stream/series/" . $savefile_name . "/854-480/" . $savefile_name . ".m3u8";
                $save_path_1280_720 = "/var/www/stream/series/" . $savefile_name . "/1280-720/" . $savefile_name . ".m3u8";

                mkdir("/var/www/stream/series/" . $savefile_name);
                //mkdir("/var/www/stream/series/".$savefile_name."/426-240");
                mkdir("/var/www/stream/series/" . $savefile_name . "/640-360");
                mkdir("/var/www/stream/series/" . $savefile_name . "/854-480");
                mkdir("/var/www/stream/series/" . $savefile_name . "/1280-720");

            } elseif ($result['type'] == "ads") {

                $save_path_640_360 = "/var/www/stream/ads/" . $savefile_name . "/640-360/" . $savefile_name . ".m3u8";
                $save_path_854_480 = "/var/www/stream/ads/" . $savefile_name . "/854-480/" . $savefile_name . ".m3u8";
                $save_path_1280_720 = "/var/www/stream/ads/" . $savefile_name . "/1280-720/" . $savefile_name . ".m3u8";

                mkdir("/var/www/stream/ads/" . $savefile_name);
                mkdir("/var/www/stream/ads/" . $savefile_name . "/640-360");
                mkdir("/var/www/stream/ads/" . $savefile_name . "/854-480");
                mkdir("/var/www/stream/ads/" . $savefile_name . "/1280-720");

            }

            $localpath = $result["path"];

            $conn = new PDO("mysql:host=$servername;dbname=mizzima_transcoder", $dbusername, $dbpassword);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $update = "UPDATE streamings SET status = 'transcoding' WHERE id = " . $result['id'];

            $conn->exec($update);



            // exec("ffmpeg  -i ".$localpath." -profile:v baseline -r 30 -level 3.0 -s 426x240 -vcodec h264 -acodec aac -b:v 300k -b:a 64k -f mp4 ".$save_temp_426_240." -profile:v baseline -r 30  -level 3.0 -s 640x360  -vcodec h264 -acodec aac -b:v 600k -b:a 64k -f mp4 ".$save_temp_640_360." -profile:v baseline -r 30 -level 3.0 -s 854x480 -vcodec h264 -acodec aac -b:v 800k -b:a 96k -f mp4 ".$save_temp_854_480." -profile:v baseline -r 30 -level 3.0 -s 1280x720 -vcodec h264 -acodec aac -b:v 2000k -b:a 128k -f mp4 ".$save_temp_1280_720);

            // exec("ffmpeg  -i ".$save_temp_426_240." -profile:v baseline -r 30 -level 3.0 -s 426x240 -start_number 0 -hls_time 10 -hls_list_size 0 -vcodec h264 -acodec aac -b:v 300k -b:a 64k -f hls ".$save_path_426_240);
            // exec("ffmpeg  -i ".$save_temp_640_360." -profile:v baseline -r 30  -level 3.0 -s 640x360 -start_number 0 -hls_time 10 -hls_list_size 0 -vcodec h264 -acodec aac -b:v 400k -b:a 64k -f hls ".$save_path_640_360);
            // exec("ffmpeg  -i ".$save_temp_854_480." -profile:v baseline -r 30 -level 3.0 -s 854x480 -start_number 0 -hls_time 4 -hls_list_size 0 -vcodec h264 -acodec aac -b:v 600k -b:a 96k -f hls ".$save_path_854_480);
            // exec("ffmpeg  -i ".$save_temp_1280_720." -profile:v baseline -r 30 -level 3.0 -s 1280x720 -start_number 0 -hls_time 4 -hls_list_size 0 -vcodec h264 -acodec aac -b:v 2000k -b:a 128k -f hls ".$save_path_1280_720);

            exec("ffmpeg  -i " . $localpath . " -profile:v baseline -r 30  -level 3.0 -s 640x360 -start_number 0 -hls_time 10 -hls_list_size 0 -vcodec h264 -acodec aac -b:v 400k -b:a 64k -f hls " . $save_path_640_360 . " -profile:v baseline -r 30 -level 3.0 -s 854x480 -start_number 0 -hls_time 4 -hls_list_size 0 -vcodec h264 -acodec aac -b:v 600k -b:a 96k -f hls " . $save_path_854_480 . " -profile:v baseline -r 30 -level 3.0 -s 1280x720 -start_number 0 -hls_time 4 -hls_list_size 0 -vcodec h264 -acodec aac -b:v 2000k -b:a 128k -f hls " . $save_path_1280_720);




            $content = "#EXTM3U
#EXT-X-VERSION:3
#EXT-X-STREAM-INF:BANDWIDTH=800000,RESOLUTION=640x360
./640-360/" . $savefile_name . ".m3u8
#EXT-X-STREAM-INF:BANDWIDTH=1400000,RESOLUTION=854x480
./854-480/" . $savefile_name . ".m3u8
#EXT-X-STREAM-INF:BANDWIDTH=2800000,RESOLUTION=1280x720
./1280-720/" . $savefile_name . ".m3u8";

            if ($result['type'] == "movie") {
                $fp = fopen("/var/www/stream/movies/" . $savefile_name . "/playlist.m3u8", "w");
            } elseif ($result['type'] == "trailer") {
                $fp = fopen("/var/www/stream/trailers/" . $savefile_name . "/playlist.m3u8", "w");
            } elseif ($result['type'] == "series") {
                $fp = fopen("/var/www/stream/series/" . $savefile_name . "/playlist.m3u8", "w");
            } elseif ($result['type'] == "ads") {
                $fp = fopen("/var/www/stream/ads/" . $savefile_name . "/playlist.m3u8", "w");
            }
            fwrite($fp, $content);
            fclose($fp);

            if ($result['type'] == "series") {
                exec('ncftpput -R -v -u "mizzimavod" -p "302c59d8-5abd-482d-88ad071e38db-7a5b-4789" "la.storage.bunnycdn.com" series /mnt/volume_sgp1_01/stream/series/' . $savefile_name);
            } elseif ($result['type'] == "movie") {
                exec("ffmpeg -i " . $localpath . " -s hd480 -c:v libx264 -crf 23 -c:a aac -strict -2 /mnt/volume_sgp1_01/mid_videos/" . $savefile_name . ".mp4");

                exec('ncftpput -R -v -u "mizzimavod" -p "302c59d8-5abd-482d-88ad071e38db-7a5b-4789" "la.storage.bunnycdn.com" movies /mnt/volume_sgp1_01/stream/movies/' . $savefile_name);
            } elseif ($result['type'] == "trailer") {
                exec('ncftpput -R -v -u "mizzimavod" -p "302c59d8-5abd-482d-88ad071e38db-7a5b-4789" "la.storage.bunnycdn.com" trailers /mnt/volume_sgp1_01/stream/trailers/' . $savefile_name);
            }

            $conn = new PDO("mysql:host=$servername;dbname=mizzima_transcoder", $dbusername, $dbpassword);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $update = "UPDATE streamings SET status = 'yes' WHERE id = " . $result['id'];

            $conn->exec($update);

            //delet the local
            // if ($temp_path != "") {
            //     delete_files($temp_path);
            // }

        } else {
            sleep(10);
        }
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}