<?php

namespace GihovaniDemetrio\BoasPraticas;

class ProductRepositoryDataBase implements ProductRepository
{
    public function getProduct(int $productId): array
    {
        $db = new \mysqli('127.0.0.1', 'magento', 'magento', 'test');
        $query = 'SELECT * FROM test.product WHERE product_id = ?';
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $db->close();
        return $product;
    }
}