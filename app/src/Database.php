<?php

declare(strict_types=1);

namespace App;

use PDO;
use PDOException;

final class Database
{
    private static ?PDO $connection = null;

    public static function getConnection(): PDO
    {
        if (self::$connection instanceof PDO) {
            return self::$connection;
        }

        $host = $_ENV['DB_HOST'] ?? 'db';
        $db   = $_ENV['DB_NAME'] ?? 'retkikohteet';
        $user = $_ENV['DB_USER'] ?? 'retki_user';
        $pass = $_ENV['DB_PASSWORD'] ?? 'retki_password';
        $port = $_ENV['DB_PORT'] ?? '3306';

        $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', $host, $port, $db);

        try {
            self::$connection = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode([
                'error' => 'Database connection failed',
                'message' => $e->getMessage(),
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        return self::$connection;
    }
}