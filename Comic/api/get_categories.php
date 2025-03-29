<?php
header('Content-Type: application/json');

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Fetch categories from MangaDex API using cURL
$apiUrl = "https://api.mangadex.org/manga/tag";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'ComicBase/1.0 (http://localhost; contact@example.com)'); // Required User-Agent
curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Set timeout to 10 seconds
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']); // Specify JSON acceptance

$tagJson = curl_exec($ch);
$curlError = curl_error($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($tagJson !== false && empty($curlError) && $httpCode == 200) {
    $tagData = json_decode($tagJson, true);
    if (isset($tagData['data']) && is_array($tagData['data'])) {
        $categories = [];
        foreach ($tagData['data'] as $tag) {
            if (isset($tag['attributes']['name']['en'])) {
                $categories[] = $tag['attributes']['name']['en'];
            }
        }
        // Sort categories alphabetically
        sort($categories);
        $response = [
            'status' => 'success',
            'data' => $categories
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Invalid API response structure: ' . json_last_error_msg()
        ];
    }
} else {
    $response = [
        'status' => 'error',
        'message' => 'Unable to fetch categories from MangaDex API: ' . $curlError . ' (HTTP Code: ' . $httpCode . ')'
    ];
    // Log the error for further investigation
    error_log("API Error: " . $curlError . " (HTTP Code: " . $httpCode . ")");
}

echo json_encode($response, JSON_PRETTY_PRINT);
?>