<?php

require 'vendor/autoload.php';

use Warehouse\Services\WarehouseService;
use Warehouse\Services\UserService;

$userService = new UserService();
$warehouseService = new WarehouseService();

echo "Enter your access code: ";
$accessCode = trim(fgets(STDIN));
$user = $userService->authenticate($accessCode);

if ($user) {
    echo "Welcome, {$user->username}!\n";

    $warehouseService->addProduct($user->id, "Example Product", 10, "2024-12-31", 19.99);
    $warehouseService->generateReport();
    $warehouseService->updateProduct($user->id, 'product_id_here', "Updated Product", 5, "2024-12-31", 24.99);
    $warehouseService->withdrawProduct($user->id, 'product_id_here', 2);
    $warehouseService->deleteProduct($user->id, 'product_id_here');
    $warehouseService->generateReport();
} else {
    echo "Access denied.\n";
}
