<?php

require 'vendor/autoload.php';

use Warehouse\Models\Product;
use Warehouse\Utils\UUID;

if (file_exists('products.json')) {
    $products = json_decode(file_get_contents('products.json'), true);
    foreach ($products as &$product) {
        $product['id'] = UUID::v4();
        $product['creationDate'] = $product['creationDate'] ?? date('Y-m-d H:i:s');
        $product['lastUpdated'] = $product['lastUpdated'] ?? date('Y-m-d H:i:s');
        $product['expirationDate'] = $product['expirationDate'] ?? null;
        $product['price'] = $product['price'] ?? 0.0;
    }
    file_put_contents('products.json', json_encode($products, JSON_PRETTY_PRINT));
    echo "Upgrade completed.\n";
} else {
    echo "No products.json file found.\n";
}
