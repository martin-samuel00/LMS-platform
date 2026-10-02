<?php

/**
 * Vercel Serverless Function Bridge for Laravel 12
 */

// Normalize HTTPS server variables from Vercel edge reverse proxy
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
    $_SERVER['SERVER_PORT'] = '443';
}
if (isset($_SERVER['HTTP_X_FORWARDED_HOST'])) {
    $_SERVER['HTTP_HOST'] = $_SERVER['HTTP_X_FORWARDED_HOST'];
    $_SERVER['SERVER_NAME'] = $_SERVER['HTTP_X_FORWARDED_HOST'];
}

// Ensure session cookies are sent with Secure attribute on Vercel HTTPS
putenv('SESSION_SECURE_COOKIE=true');
$_ENV['SESSION_SECURE_COOKIE'] = 'true';

// If DB_DATABASE is set to 'sys' (MySQL system catalog), correct it to 'test'
$dbName = getenv('DB_DATABASE');
if (!$dbName || $dbName === 'sys') {
    putenv('DB_DATABASE=test');
    $_ENV['DB_DATABASE'] = 'test';
}

// If running on Vercel without an external cloud database configured yet,
// use an auto-initialized SQLite database in /tmp so the site works immediately.
$cloudHost = getenv('DB_HOST');
if (!$cloudHost || $cloudHost === '127.0.0.1' || $cloudHost === 'localhost') {
    putenv('DB_CONNECTION=sqlite');
    putenv('DB_DATABASE=/tmp/database.sqlite');
    $_ENV['DB_CONNECTION'] = 'sqlite';
    $_ENV['DB_DATABASE'] = '/tmp/database.sqlite';
    if (!file_exists('/tmp/database.sqlite')) {
        @touch('/tmp/database.sqlite');
    }
}

// Ensure session and cache don't fail without a database
if (!getenv('SESSION_DRIVER')) {
    putenv('SESSION_DRIVER=cookie');
    $_ENV['SESSION_DRIVER'] = 'cookie';
}
if (!getenv('CACHE_STORE')) {
    putenv('CACHE_STORE=array');
    $_ENV['CACHE_STORE'] = 'array';
}

// Forward Vercel serverless requests to public/index.php
require __DIR__ . '/../public/index.php';
