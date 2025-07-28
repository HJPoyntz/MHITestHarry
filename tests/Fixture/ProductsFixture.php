<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProductsFixture
 */
class ProductsFixture extends TestFixture
{
    public $import = ['table' => 'products'];

    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'name' => 'Harry Test Product',
                'quantity' => 20,
                'price' => 100.00,
                'deleted' => 0,
                'status' => 'in stock',   
                'created' => '2025-07-28 10:00:00',
                'modified' => '2025-07-28 10:00:00',
                'last_updated' => '2025-07-28 10:00:00',
            ],
        ];
        parent::init();
    }
}
