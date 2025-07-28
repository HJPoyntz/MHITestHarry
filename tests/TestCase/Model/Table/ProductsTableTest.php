<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Model\Table\ProductsTable Test Case
 */
class ProductsTableTest extends TestCase
{
    public $Products;

    public $fixtures = ['app.Products'];

    public function setUp(): void
    {
        parent::setUp();
        $this->Products = TableRegistry::getTableLocator()->get('Products');
    }

    public function tearDown(): void
    {
        unset($this->Products);
        parent::tearDown();
    }

    public function testValidationSuccess()
    {
        $product = $this->Products->newEntity([
            'name' => 'Test Product',
            'quantity' => 20,
            'price' => 50.00,
        ]);
        $this->assertEmpty($product->getErrors());
    }

    public function testValidationFailure()
    {
        $product = $this->Products->newEntity([
            'name' => '',
            'quantity' => -5,
            'price' => 0,
        ]);
        $this->assertNotEmpty($product->getErrors());
    }
}
