<?php
$ch = curl_init('https://api.mangadex.org/manga?limit=1');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($ch, CURLOPT_VERBOSE, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'ComicBase/1.0 (http://localhost; contact@example.com)'); 
$verbose = fopen('php://temp', 'w+');
curl_setopt($ch, CURLOPT_STDERR, $verbose);
$response = curl_exec($ch);
$error = curl_error($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
rewind($verbose);
$verboseLog = stream_get_contents($verbose);
fclose($verbose);
curl_close($ch);
echo $response ?: "Error: $error (HTTP $httpCode)\nDebug: $verboseLog";
?>