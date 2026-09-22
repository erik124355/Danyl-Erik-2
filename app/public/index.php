<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Database.php';

use App\Database;

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

if ($path === '/api/spots' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json; charset=utf-8');

    $input = json_decode((string) file_get_contents('php://input'), true);

    $name = trim((string) ($input['name'] ?? ''));
    $location = trim((string) ($input['location'] ?? ''));
    $description = trim((string) ($input['description'] ?? ''));

    if ($name === '' || $location === '') {
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'message' => 'Name and location are required',
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    try {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('INSERT INTO hiking_spots (name, location, description) VALUES (?, ?, ?)');
        $stmt->execute([$name, $location, $description]);

        http_response_code(201);
        echo json_encode([
            'status' => 'ok',
            'message' => 'Hiking spot created',
            'data' => [
                'name' => $name,
                'location' => $location,
                'description' => $description,
            ],
        ], JSON_UNESCAPED_UNICODE);
        exit;
    } catch (Throwable $e) {
        http_response_code(500);
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to insert hiking spot',
            'details' => $e->getMessage(),
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
}

if ($path === '/api/spots' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json; charset=utf-8');

    try {
        $pdo = Database::getConnection();
        $stmt = $pdo->query('SELECT id, name, location, description FROM hiking_spots ORDER BY id ASC');
        $spots = $stmt->fetchAll();

        http_response_code(200);
        echo json_encode([
            'status' => 'ok',
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

if (preg_match('#^/api/spots/(\d+)$#', $path, $matches) && $_SERVER['REQUEST_METHOD'] === 'DELETE') {
    header('Content-Type: application/json; charset=utf-8');

    $id = (int) $matches[1];

    if ($id <= 0) {
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid hiking spot id',
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    try {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('DELETE FROM hiking_spots WHERE id = ?');
        $stmt->execute([$id]);

        http_response_code(200);
        echo json_encode([
            'status' => 'ok',
            'message' => 'Hiking spot deleted',
            'id' => $id,
        ], JSON_UNESCAPED_UNICODE);
        exit;
    } catch (Throwable $e) {
        http_response_code(500);
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to delete hiking spot',
            'details' => $e->getMessage(),
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
}

if (preg_match('#^/api/spots/(\d+)$#', $path, $matches) && $_SERVER['REQUEST_METHOD'] === 'PUT') {
    header('Content-Type: application/json; charset=utf-8');

    $id = (int) $matches[1];
    $input = json_decode((string) file_get_contents('php://input'), true);

    $name = trim((string) ($input['name'] ?? ''));
    $location = trim((string) ($input['location'] ?? ''));
    $description = trim((string) ($input['description'] ?? ''));

    if ($name === '' || $location === '') {
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'message' => 'Name and location are required',
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    try {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('UPDATE hiking_spots SET name = ?, location = ?, description = ? WHERE id = ?');
        $stmt->execute([$name, $location, $description, $id]);

        http_response_code(200);
        echo json_encode([
            'status' => 'ok',
            'message' => 'Hiking spot updated',
            'id' => $id,
        ], JSON_UNESCAPED_UNICODE);
        exit;
    } catch (Throwable $e) {
        http_response_code(500);
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to update hiking spot',
            'details' => $e->getMessage(),
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
}

if ($path === '/') {
    header('Content-Type: text/html; charset=utf-8');

    try {
        $pdo = Database::getConnection();
        $stmt = $pdo->query('SELECT id, name, location, description FROM hiking_spots ORDER BY id ASC');
        $spots = $stmt->fetchAll();
    } catch (Throwable $e) {
        $spots = [];
    }

    include __DIR__ . '/../views/home.php';
    exit;
}

http_response_code(404);
header('Content-Type: application/json; charset=utf-8');
echo json_encode([
    'error' => 'Route not found',
], JSON_UNESCAPED_UNICODE);