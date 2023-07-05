<?php

$servername = "db-mysql-sgp1-28255-do-user-14089511-0.b.db.ondigitalocean.com";
$dbusername = "doadmin";
$dbpassword = 'AVNS_rLM2YTJyAioumr-mBT3';

try {
    while (1) {
        $conn = new PDO("mysql:host=$servername;dbname=defaultdb;port=25060", $dbusername, $dbpassword);

        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM streamings where status = 'up' LIMIT 1";
        $query = $conn->prepare($sql);
        $query->execute();
        $result = $query->fetch();

        if ($result != false && $result['id'] != null) {


            $conn = new PDO("mysql:host=$servername;dbname=defaultdb;port=25060", $dbusername, $dbpassword);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $update = "UPDATE streamings SET status = 'process' WHERE id = " . $result['id'];

            $conn->exec($update);


            $savefile_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $result['name']);
            $savefile_name = str_replace(" ", "_", $savefile_name);


            $save_path_640_360 = "/var/www/stream/uploads/" . $savefile_name . "/640-360/" . $savefile_name . ".m3u8";
            $save_path_854_480 = "/var/www/stream/uploads/" . $savefile_name . "/854-480/" . $savefile_name . ".m3u8";
            $save_path_1280_720 = "/var/www/stream/uploads/" . $savefile_name . "/1280-720/" . $savefile_name . ".m3u8";

            $directory_640_360 = "/var/www/stream/uploads/" . $savefile_name . "/640-360";
            $directory_854_480 = "/var/www/stream/uploads/" . $savefile_name . "/854-480";
            $directory_1280_720 = "/var/www/stream/uploads/" . $savefile_name . "/1280-720";
            exec('sudo mkdir -p ' . $directory_640_360);
            exec('sudo mkdir -p ' . $directory_854_480);
            exec('sudo mkdir -p ' . $directory_1280_720);

            $localpath = $result["path"];

            $conn = new PDO("mysql:host=$servername;dbname=defaultdb;port=25060", $dbusername, $dbpassword);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $update = "UPDATE streamings SET status = 'transcoding' WHERE id = " . $result['id'];

            $conn->exec($update);

            exec("ffmpeg  -i " . $localpath . " -profile:v baseline -r 30  -level 3.0 -s 640x360 -start_number 0 -hls_time 10 -hls_list_size 0 -vcodec h264 -acodec aac -b:v 400k -b:a 64k -f hls " . $save_path_640_360 . " -profile:v baseline -r 30 -level 3.0 -s 854x480 -start_number 0 -hls_time 4 -hls_list_size 0 -vcodec h264 -acodec aac -b:v 600k -b:a 96k -f hls " . $save_path_854_480 . " -profile:v baseline -r 30 -level 3.0 -s 1280x720 -start_number 0 -hls_time 4 -hls_list_size 0 -vcodec h264 -acodec aac -b:v 2000k -b:a 128k -f hls " . $save_path_1280_720);




            $content = "#EXTM3U
#EXT-X-VERSION:3
#EXT-X-STREAM-INF:BANDWIDTH=800000,RESOLUTION=640x360
./640-360/" . $savefile_name . ".m3u8
#EXT-X-STREAM-INF:BANDWIDTH=1400000,RESOLUTION=854x480
./854-480/" . $savefile_name . ".m3u8
#EXT-X-STREAM-INF:BANDWIDTH=2800000,RESOLUTION=1280x720
./1280-720/" . $savefile_name . ".m3u8";


            $fp = fopen("/var/www/stream/uploads/" . $savefile_name . "/playlist.m3u8", "w");

            fwrite($fp, $content);
            fclose($fp);


            //exec("ffmpeg -i ".$localpath." -s hd480 -c:v libx264 -crf 23 -c:a aac -strict -2 /mnt/volume_sgp1_01/mid_videos/".$savefile_name.".mp4");

            exec('ncftpput -R -v -u "postvod" -p "3de83dbf-ef8f-4a90-a3862c083a6b-309d-4918" "sg.storage.bunnycdn.com" uploads /mnt/volume_sgp1_01/stream/uploads/' . $savefile_name);


            $conn = new PDO("mysql:host=$servername;dbname=defaultdb;port=25060", $dbusername, $dbpassword);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $update = "UPDATE streamings SET status = 'yes' WHERE id = " . $result['id'];

            $conn->exec($update);

            //delet the local
            // if ($temp_path != "") {
            //     delete_files($temp_path);
            // }

            $stream_url = "http://165.232.171.9/uploads/" . $savefile_name . "/playlist.m3u8";

            $url = curl_init("http://http://165.232.171.9/api/posts/video/approve");
            curl_setopt($url, CURLOPT_POST, true);
            curl_setopt($url, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($url, CURLOPT_POSTFIELDS, json_encode(["post_id" => $result["id"], "url" => $stream_url]));
            $result = curl_exec($url);
            $code = curl_getinfo($url, CURLINFO_HTTP_CODE);
            curl_close($url);


            // delete_files("/var/www/stream/uploads/" . $savefile_name);

        } else {
            sleep(10);
        }
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}