<?php
set_time_limit(300);

$path = __DIR__ . '/popular_manga.json';
if (!file_exists($path)) {
    echo json_encode(["error" => "popular_manga.json not found"]);
    exit;
}

$data = json_decode(file_get_contents($path), true);
if (!$data || !is_array($data)) {
    echo json_encode(["error" => "Invalid data"]);
    exit;
}

function filterTop($data, $type, $limit = 10) {
    $now = time();
    $filtered = [];

    foreach ($data as $item) {
        if (!isset($item['updatedAt']) || empty($item['updatedAt'])) continue;

        $updatedAt = strtotime($item['updatedAt']);
        if ($updatedAt === false) continue;

        $diffDays = ($now - $updatedAt) / 86400;

        if (
            ($type === 'week' && $diffDays <= 7) ||
            ($type === 'month' && $diffDays <= 30) ||
            ($type === 'year' && $diffDays <= 365)
        ) {
            $filtered[] = $item;
        }
    }

    usort($filtered, function ($a, $b) {
        return $b['followed'] <=> $a['followed'];
    });

    return array_slice($filtered, 0, $limit);
}

$result = [
    'week' => filterTop($data, 'week'),
    'month' => filterTop($data, 'month'),
    'year' => filterTop($data, 'year')
];

echo json_encode([
    "result" => "ok",
    "ranking" => $result
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
