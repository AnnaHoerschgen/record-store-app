<?php
function get_pdo() {
    static $pdo;
    if (!$pdo) {
        $pdo = require __DIR__ . '/db.php';
    }
    return $pdo;
}

function formats_all() {
    $pdo = get_pdo();
    $stmt = $pdo->query('SELECT id, name FROM formats ORDER BY name');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function records_all() {
    $pdo = get_pdo();
    $sql = 'SELECT r.id, r.title, r.artist, r.price, f.name AS format_name, g.name AS genre_name
            FROM records r
            JOIN formats f ON r.format_id = f.id
            LEFT JOIN genres g ON r.genre_id = g.id
            ORDER BY r.created_at DESC';
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function record_create($title, $artist, $price, $format_id) {
    if (!$title || !$artist || !$price || !$format_id) {
        return false;
    }
    $pdo = get_pdo();
    $stmt = $pdo->prepare('INSERT INTO records (title, artist, price, format_id) VALUES (:title, :artist, :price, :format_id)');
    $stmt->execute([
        ':title' => trim($title),
        ':artist' => trim($artist),
        ':price' => $price,
        ':format_id' => $format_id
    ]);
    return true;
}
?>