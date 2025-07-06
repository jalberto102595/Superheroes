<?php

$input = json_decode(file_get_contents("php://input"), true) ?? [];
$token = $_GET['token'] ?? $input['token'] ?? null;
$query = $_GET['query'] ?? $input['query'] ?? 'Marvel';

if (!$token) {
    echo json_encode(['error' => 'Token de Twitter requerido.'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

function getTweetsFromTwitter($query, $bearerToken) {
    $url = "https://api.twitter.com/2/tweets/search/recent?query=" . urlencode($query)
        . "&max_results=10&expansions=author_id&user.fields=username,name";

    $headers = [
        "Authorization: Bearer {$bearerToken}",
        "Content-Type: application/json"
    ];

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => $headers
    ]);

    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpcode !== 200 || $response === false) {
        return [
            'error' => 'Twitter API error',
            'status' => $httpcode,
            'response' => $response
        ];
    }

    $data = json_decode($response, true);
    $tweets = [];
    $users = [];

    if (isset($data['includes']['users'])) {
        foreach ($data['includes']['users'] as $user) {
            $users[$user['id']] = $user;
        }
    }

    if (isset($data['data'])) {
        foreach ($data['data'] as $tweet) {
            $author = $users[$tweet['author_id']] ?? null;
            $tweets[] = [
                'id' => $tweet['id'],
                'text' => $tweet['text'],
                'author' => $author ? [
                    'username' => $author['username'],
                    'name' => $author['name']
                ] : null
            ];
        }
    }

    return $tweets;
}

$tweets = getTweetsFromTwitter($query, $token);

header('Content-Type: application/json');
echo json_encode([
    'query' => $query,
    'tweets' => $tweets
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);