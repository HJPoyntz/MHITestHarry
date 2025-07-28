<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\ProductsController Test Case
 *
 * @uses \App\Controller\ProductsController
 */
class ProductsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    public $fixtures = ['app.Products'];

    public function testIndex()
    {
        $this->get('/products');
        $this->assertResponseOk();
        $this->assertResponseContains('Product Inventory');
    }

    public function testAdd()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $data = [
            'name' => 'New Product',
            'quantity' => 15,
            'price' => 25.50,
            'deleted' => 0,
            'status' => 'in stock',
        ];

        $this->post('/products/add', $data);
        $this->assertResponseSuccess();

        $products = $this->getTableLocator()->get('Products');
        $product = $products->find()->where(['name' => 'New Product'])->first();
        $this->assertNotEmpty($product);
    }

    public function testDelete()
    {
        $productId = 1;

        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $this->post("/products/delete/$productId");
        $this->assertRedirect('/products');

        $products = $this->getTableLocator()->get('Products');
        $product = $products->find()->where(['id' => $productId])->first();
        $this->assertEmpty($product);
    }
}
