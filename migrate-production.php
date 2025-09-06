<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

try {
    echo "Running database migrations...\n";
    Artisan::call('migrate', ['--force' => true]);
    echo "Migrations completed successfully!\n";

    echo "Running database seeders...\n";
    Artisan::call('db:seed', ['--force' => true]);
    echo "Seeders completed successfully!\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
