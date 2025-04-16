<?php
set_time_limit(300);

$jsonFile = __DIR__ . '/popular_manga.json';
if (!file_exists($jsonFile)) {
    die("❌ File popular_manga.json không tồn tại.");
}

$data = json_decode(file_get_contents($jsonFile), true);
if (!$data || !is_array($data)) {
    die("❌ Không thể đọc dữ liệu JSON.");
}

function fetchLatestChapter($mangaId) {
    $params = [
        'limit' => 1,
        'order[readableAt]' => 'desc', // lấy theo ngày mới nhất
    ];
    $url = "https://api.mangadex.org/manga/$mangaId/feed?" . http_build_query($params);
    $res = @file_get_contents($url);
    if (!$res) return null;

    $json = json_decode($res, true);
    return $json['data'][0] ?? null;
}

foreach ($data as &$manga) {
    $chapter = fetchLatestChapter($manga['id']);
    if (!$chapter) {
        $manga['latest_chapter'] = 'Không có chương';
        continue;
    }

    $chapterNumber = $chapter['attributes']['chapter'] ?? '';
    $chapterTitle = $chapter['attributes']['title'] ?? '';
    $volume = $chapter['attributes']['volume'] ?? '';
    $lang = strtoupper($chapter['attributes']['translatedLanguage'] ?? '');

    // Hiển thị dạng thông minh
    if ($chapterNumber !== '') {
        $manga['latest_chapter'] = "Chapter $chapterNumber" . ($chapterTitle ? ": $chapterTitle" : '') . " [$lang]";
    } elseif ($chapterTitle !== '') {
        $manga['latest_chapter'] = $chapterTitle . " [$lang]";
    } elseif ($volume !== '') {
        $manga['latest_chapter'] = "Tập $volume [$lang]";
    } else {
        $manga['latest_chapter'] = 'Không rõ chương';
    }

    // Cập nhật thêm ngày nếu muốn
    $manga['updated_at'] = $chapter['attributes']['readableAt'] ?? null;

    usleep(300000);
}

file_put_contents($jsonFile, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
echo "✅ Đã cập nhật latest_chapter chuẩn nhất!";
