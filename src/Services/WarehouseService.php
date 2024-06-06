<?php

namespace Warehouse\Services;

use Warehouse\Models\Product;

class WarehouseService
{
    private $products;
    private $logService;

    public function __construct()
    {
        if (file_exists('products.json')) {
            $this->products = json_decode(file_get_contents('products.json'), true);
        } else {
            $this->products = [];
        }
        $this->logService = new LogService();
    }

    public function save()
    {
        file_put_contents('products.json', json_encode($this->products, JSON_PRETTY_PRINT));
    }

    public function addProduct($userId, $name, $amount, $expirationDate = null, $price = 0.0)
    {
        $product = new Product($name, $amount, $expirationDate, $price);
        $this->products[$product->id] = $product;
        $this->save();
        $this->logService->logChange($userId, $product->id, "Added product $name with amount $amount");
    }

    public function updateProduct($userId, $id, $name, $amount, $expirationDate, $price)
    {
        if (isset($this->products[$id])) {
            $this->products[$id]->updateProduct($name, $amount, $expirationDate, $price);
            $this->save();
            $this->logService->logChange($userId, $id, "Updated product $name with amount $amount");
        } else {
            echo "Product not found.\n";
        }
    }

    public function withdrawProduct($userId, $id, $amount)
    {
        if (isset($this->products[$id])) {
            if ($this->products[$id]->amount >= $amount) {
                $this->products[$id]->updateAmount($this->products[$id]->amount - $amount);
                $this->save();
                $this->logService->logChange($userId, $id, "Withdrew amount $amount");
            } else {
                echo "Not enough stock.\n";
            }
        } else {
            echo "Product not found.\n";
        }
    }

    public function deleteProduct($userId, $id)
    {
        if (isset($this->products[$id])) {
            unset($this->products[$id]);
            $this->save();
            $this->logService->logChange($userId, $id, "Deleted product");
        } else {
            echo "Product not found.\n";
        }
    }

    public function generateReport()
    {
        $totalProducts = count($this->products);
        $totalValue = array_reduce($this->products, function ($carry, $product) {
            return $carry + ($product->amount * $product->price);
        }, 0);

        echo "Total products: $totalProducts\n";
        echo "Total value: $totalValue\n";
    }
}
