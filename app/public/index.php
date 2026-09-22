<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Database.php';

use App\Database;

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) === '/') {
    try {
        $pdo = Database::getConnection();

        $stmt = $pdo->query('SELECT id, name, location, description FROM hiking_spots ORDER BY id ASC');
        $spots = $stmt->fetchAll();

        http_response_code(200);

        echo json_encode([
            'status' => 'ok',
            'database' => 'connected',
            'message' => 'Retkikohteet API toimii',
            'data' => $spots,
        ], JSON_UNESCAPED_UNICODE);

        exit;
    } catch (Throwable $e) {
        http_response_code(500);

        echo json_encode([
            'status' => 'error',
            'message' => 'Database query failed',
            'details' => $e->getMessage(),
        ], JSON_UNESCAPED_UNICODE);

        exit;
    }
}

http_response_code(404);

echo json_encode([
    'error' => 'Reittiä ei löytynyt',
], JSON_UNESCAPED_UNICODE);