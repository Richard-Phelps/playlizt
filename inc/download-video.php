<?php
// require('../classes/youtube-dl.class.php');
// try {
//     $mytube = new yt_downloader("https://www.youtube.com/watch?v=dFOErVWlsxg", TRUE, "audio");
//     $audio = $mytube->get_audio();
//     $path_dl = $mytube->get_downloads_dir();
//     die($path_dl);
//     clearstatcache();
//     if($audio !== FALSE && file_exists($path_dl . $audio) !== FALSE)
//     {
//         print "<a href='". $path_dl . $audio ."' target='_blank'>Click, to open downloaded audio file.</a>";
//     } else {
//         print "Oups. Something went wrong.";
//     }
//     $log = $mytube->get_ffmpeg_Logfile();
//     if($log !== FALSE) {
//         print "<br><a href='" . $log . "' target='_blank'>Click, to view the Ffmpeg file.</a>";
//     }
// }
// catch (Exception $e) {
//     die($e->getMessage());
// }

// function get_string_between($string, $start, $end){
//     $string = ' ' . $string;
//     $ini = strpos($string, $start);
//     if ($ini == 0) return '';
//     $ini += strlen($start);
//     $len = strpos($string, $end, $ini) - $ini;
//     return substr($string, $ini, $len);
// }
//
// $page_content  = htmlentities(file_get_contents('http://www.youtubeinmp3.com/widget/button/?video=https://www.youtube.com/watch?v=33h-_mig8eE'));
// $download_link = get_string_between($page_content, 'id=&quot;downloadButton&quot; href=&quot;', '&quot;&gt;');
// // echo file_get_contents(substr('http://www.youtubeinmp3.com' . $download_link, 0, -33));
// set_time_limit(0);
//
// $url = substr('http://www.youtubeinmp3.com' . $download_link, 0, -33);
// $ch = curl_init();
// $source = $url;
// curl_setopt($ch, CURLOPT_URL, $source);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// $data = curl_exec ($ch);
// curl_close ($ch);
//
// $destination = "/asubfolder/afile.zip";
// $file = fopen($destination, "w+");
// fputs($file, $data);
// fclose($file);
// $file = fopen(dirname(__FILE__) . '/videos', 'w+');
//
// $curl = curl_init($url);
//
// // Update as of PHP 5.4 array() can be written []
// curl_setopt_array($curl, [
//     CURLOPT_URL            => $url,
// //  CURLOPT_BINARYTRANSFER => 1, --- No effect from PHP 5.1.3
//     CURLOPT_RETURNTRANSFER => 1,
//     CURLOPT_FILE           => $file,
//     CURLOPT_TIMEOUT        => 50,
//     CURLOPT_USERAGENT      => 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)'
// ]);
//
// $response = curl_exec($curl);
//
// if($response === false) {
//     // Update as of PHP 5.3 use of Namespaces Exception() becomes \Exception()
//     throw new \Exception('Curl error: ' . curl_error($curl));
// }
//
// $response; // Do something with the response.

// $mp3_content = file_get_contents('http://dl4.downloader.space/dl.php?id=427ef55d007d4a1a750169914cb1dd52');
// file_put_contents('test.mp3', $mp3_content);

// echo file_get_contents('http://www.youtubeinmp3.com/fetch/?video=https://www.youtube.com/watch?v=dFOErVWlsxg');

// $url = 'http://www.listentoyoutube.com/process.php';
// $fields = array(
// 	'url' => urlencode('https://www.youtube.com/watch?v=dFOErVWlsxg')
// );
//
// //url-ify the data for the POST
// foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
// rtrim($fields_string, '&');
//
// //open connection
// $ch = curl_init();
//
// //set the url, number of POST vars, POST data
// curl_setopt($ch,CURLOPT_URL, $url);
// curl_setopt($ch,CURLOPT_POST, count($fields));
// curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
//
// //execute post
// $result = curl_exec($ch);
//
// //close connection
// curl_close($ch);
//
// echo $result;

// echo file_get_contents('http://www.grabfrom.com/Converter/index.php?output=yt/dFOErVWlsxg/128%7e%7e256%7e%7eSTORMZY_STORMZY1_-_BIG_FOR_YOUR_BOOTS_uuid-593f2506bf0d2.mp3');



?>
