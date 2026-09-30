<?php

/**
 * Vercel Serverless Function Bridge for Laravel 12
 * This entry point directs serverless incoming HTTP requests to Laravel's public/index.php
 */

// Forward Vercel serverless requests to public/index.php
require __DIR__ . '/../public/index.php';
