<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Database.php';

use App\Database;

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

function jsonError(int $code, string $message, ?string $details = null): void
{
    http_response_code($code);
    $payload = [
        'status' => 'error',
        'message' => $message,
    ];

    if ($details !== null) {
        $payload['details'] = $details;
    }

    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
    exit;
}

function readJsonBody(): array
{
    $raw = file_get_contents('php://input');
    $data = json_decode((string) $raw, true);

    return is_array($data) ? $data : [];
}

if (
    ($path === '/api/spots' || $path === '/api/destinations')
    && $_SERVER['REQUEST_METHOD'] === 'POST'
) {
    header('Content-Type: application/json; charset=utf-8');

    $input = readJsonBody();

    $name = trim((string) ($input['name'] ?? ''));
    $location = trim((string) ($input['location'] ?? ''));
    $description = trim((string) ($input['description'] ?? ''));
    $latitude = $input['latitude'] ?? null;
    $longitude = $input['longitude'] ?? null;
    $type = trim((string) ($input['type'] ?? ''));
    $difficulty = trim((string) ($input['difficulty'] ?? ''));
    $plannedDate = trim((string) ($input['planned_date'] ?? ''));

    if (
        $name === '' ||
        $location === '' ||
        $description === '' ||
        $type === '' ||
        $difficulty === '' ||
        $plannedDate === '' ||
        !is_numeric($latitude) ||
        !is_numeric($longitude)
    ) {
        jsonError(400, 'All fields are required');
    }

    $latitude = (float) $latitude;
    $longitude = (float) $longitude;

    if ($latitude < -90 || $latitude > 90) {
        jsonError(400, 'Latitude must be between -90 and 90');
    }

    if ($longitude < -180 || $longitude > 180) {
        jsonError(400, 'Longitude must be between -180 and 180');
    }

    $date = DateTime::createFromFormat('Y-m-d', $plannedDate);

    if (!$date || $date->format('Y-m-d') !== $plannedDate) {
        jsonError(400, 'Invalid planned date');
    }

    try {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare(
            'INSERT INTO hiking_spots
            (name, location, description, latitude, longitude, type, difficulty, planned_date)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
        );

        $stmt->execute([
            $name,
            $location,
            $description,
            $latitude,
            $longitude,
            $type,
            $difficulty,
            $plannedDate,
        ]);

        http_response_code(201);
        echo json_encode([
            'status' => 'ok',
            'message' => 'Hiking spot created',
        ], JSON_UNESCAPED_UNICODE);
        exit;
    } catch (Throwable $e) {
        jsonError(500, 'Failed to insert hiking spot', $e->getMessage());
    }
}

if (
    ($path === '/api/spots' || $path === '/api/destinations')
    && $_SERVER['REQUEST_METHOD'] === 'GET'
) {
    header('Content-Type: application/json; charset=utf-8');

    try {
        $pdo = Database::getConnection();
        $stmt = $pdo->query(
            'SELECT id, name, location, description,
                   latitude, longitude, type, difficulty, planned_date
            FROM hiking_spots
            ORDER BY id ASC'
        );
        $spots = $stmt->fetchAll();

        http_response_code(200);
        echo json_encode([
            'status' => 'ok',
            'data' => $spots,
        ], JSON_UNESCAPED_UNICODE);
        exit;
    } catch (Throwable $e) {
        jsonError(500, 'Database query failed', $e->getMessage());
    }
}

if (
    preg_match('#^/api/(destinations|spots)/(\d+)$#', $path, $matches)
    && $_SERVER['REQUEST_METHOD'] === 'GET'
) {
    header('Content-Type: application/json; charset=utf-8');

    $id = (int) $matches[2];

    try {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare(
            'SELECT id, name, location, description FROM hiking_spots WHERE id = ?'
        );
        $stmt->execute([$id]);

        $spot = $stmt->fetch();

        if (!$spot) {
            jsonError(404, 'Hiking spot not found');
        }

        http_response_code(200);
        echo json_encode([
            'status' => 'ok',
            'data' => $spot,
        ], JSON_UNESCAPED_UNICODE);
        exit;
    } catch (Throwable $e) {
        jsonError(500, 'Database query failed', $e->getMessage());
    }
}

if (
    preg_match('#^/api/(destinations|spots)/(\d+)$#', $path, $matches)
    && $_SERVER['REQUEST_METHOD'] === 'PUT'
) {
    header('Content-Type: application/json; charset=utf-8');

    $id = (int) $matches[2];
    $input = readJsonBody();

    $name = trim((string) ($input['name'] ?? ''));
    $location = trim((string) ($input['location'] ?? ''));
    $description = trim((string) ($input['description'] ?? ''));
    $latitude = $input['latitude'] ?? null;
    $longitude = $input['longitude'] ?? null;
    $type = trim((string) ($input['type'] ?? ''));
    $difficulty = trim((string) ($input['difficulty'] ?? ''));
    $plannedDate = trim((string) ($input['planned_date'] ?? ''));

    if (
        $name === '' ||
        $location === '' ||
        $description === '' ||
        $type === '' ||
        $difficulty === '' ||
        $plannedDate === '' ||
        !is_numeric($latitude) ||
        !is_numeric($longitude)
    ) {
        jsonError(400, 'All fields are required');
    }

    $latitude = (float) $latitude;
    $longitude = (float) $longitude;

    if ($latitude < -90 || $latitude > 90) {
        jsonError(400, 'Latitude must be between -90 and 90');
    }

    if ($longitude < -180 || $longitude > 180) {
        jsonError(400, 'Longitude must be between -180 and 180');
    }

    $date = DateTime::createFromFormat('Y-m-d', $plannedDate);

    if (!$date || $date->format('Y-m-d') !== $plannedDate) {
        jsonError(400, 'Invalid planned date');
    }

    try {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare(
            'UPDATE hiking_spots SET name = ?, location = ?, description = ?, latitude = ?, longitude = ?, type = ?, difficulty = ?, planned_date = ? WHERE id = ?'
        );
        $stmt->execute([$name, $location, $description, $latitude, $longitude, $type, $difficulty, $plannedDate, $id]);

        http_response_code(200);
        echo json_encode([
            'status' => 'ok',
            'message' => 'Hiking spot updated',
            'id' => $id,
        ], JSON_UNESCAPED_UNICODE);
        exit;
    } catch (Throwable $e) {
        jsonError(500, 'Failed to update hiking spot', $e->getMessage());
    }
}

if (
    preg_match('#^/api/(destinations|spots)/(\d+)$#', $path, $matches)
    && $_SERVER['REQUEST_METHOD'] === 'DELETE'
) {
    header('Content-Type: application/json; charset=utf-8');

    $id = (int) $matches[2];

    if ($id <= 0) {
        jsonError(400, 'Invalid hiking spot id');
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
        jsonError(500, 'Failed to delete hiking spot', $e->getMessage());
    }
}

if ($path === '/') {
    header('Content-Type: text/html; charset=utf-8');

    try {
        $pdo = Database::getConnection();
        $stmt = $pdo->query(
            'SELECT id, name, location, description FROM hiking_spots ORDER BY id ASC'
        );
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