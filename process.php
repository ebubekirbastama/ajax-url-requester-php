<?php
session_start();

if (!isset($_SESSION['urls'])) $_SESSION['urls'] = [];
if (!isset($_SESSION['wait'])) $_SESSION['wait'] = 120;
if (!isset($_SESSION['index'])) $_SESSION['index'] = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $urls = array_filter(array_map('trim', explode("\n", $_POST['urls'] ?? '')));
    $wait = floatval(str_replace(',', '.', $_POST['wait'] ?? '2'));

    if (empty($urls)) {
        echo json_encode(['success' => false, 'message' => "⚠️ Geçerli URL giriniz."]);
        exit;
    }

    $_SESSION['urls'] = array_values($urls);
    $_SESSION['wait'] = max(1, intval($wait * 60));
    $_SESSION['index'] = 0;

    echo json_encode(['success' => true, 'total' => count($urls)]);
    exit;
}

if (isset($_GET['next'])) {
    $i = $_SESSION['index'];
    $urls = $_SESSION['urls'];

    if ($i >= count($urls)) {
        session_destroy();
        echo json_encode(['done' => true]);
        exit;
    }

    $url = $urls[$i];
    $result = makeRequest($url, $statusCode);

    $_SESSION['index']++;

    if ($_SESSION['index'] < count($urls)) {
        sleep($_SESSION['wait']);
    }

    echo json_encode(['log' => $result, 'status' => $statusCode, 'done' => false]);
    exit;
}

function makeRequest($url, &$statusCode) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_FOLLOWLOCATION => true
    ]);

    $response = curl_exec($ch);
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        $statusCode = 0;
        return "❌ Hata: {$error}";
    } else {
        $snippet = mb_substr($response, 0, 200);
        if (strlen($response) > 200) $snippet .= '...';
        return "🔗 İstek yapıldı: {$url}\n📩 Cevap ({$statusCode}): {$snippet}\n";
    }
}
