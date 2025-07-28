<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Rule\IsUnique;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Products Model
 *
 * @method \App\Model\Entity\Product newEmptyEntity()
 * @method \App\Model\Entity\Product newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Product[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Product get($primaryKey, $options = [])
 * @method \App\Model\Entity\Product findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Product patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Product[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Product|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Product saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Product[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Product[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Product[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Product[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ProductsTable extends Table
{
    /**
     * Initialize the table configuration
     *
     * @param array $config Table configuration options.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('products');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'last_updated' => 'always',
                ],
            ],
        ]);
    }

    /**
     * Set default validation rules for the Products table
     *
     * @param \Cake\Validation\Validator $validator The validator to define rules on.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('name')
            ->requirePresence('name', 'create')
            ->notEmptyString('name', 'Name is required')
            ->lengthBetween('name', [3, 50], 'Name must be between 3 and 50 characters');

        $validator
            ->integer('quantity')
            ->greaterThanOrEqual('quantity', 0, 'Quantity must be at least 0')
            ->lessThanOrEqual('quantity', 1000, 'Quantity must not exceed 1000');

        $validator
            ->decimal('price')
            ->greaterThan('price', 0, 'Price must be greater than 0')
            ->lessThanOrEqual('price', 10000, 'Price must not exceed 10,000');

        // Custom validation: price > 100 needs quantity >= 10
        $validator->add('quantity', 'priceQuantityCheck', [
            'rule' => function ($value, $context) {
                $price = $context['data']['price'] ?? 0;

                return $price <= 100 || $value >= 10;
            },
            'message' => 'Products with price > 100 must have a quantity of at least 10',
        ]);

        // Custom validation: name contains "promo" must have price < 50
        $validator->add('price', 'promoPriceCheck', [
            'rule' => function ($value, $context) {
                $name = strtolower($context['data']['name'] ?? '');

                return strpos($name, 'promo') === false || $value < 50;
            },
            'message' => 'Products with "promo" in the name must have a price below 50',
        ]);

        return $validator;
    }

    /**
     * Build application integrity rules
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to define rules on.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add(new IsUnique(['name']), ['errorField' => 'name', 'message' => 'Name must be unique']);

        return $rules;
    }

    /**
     * Seeds the products table with 10 sample products if it's empty
     *
     * @return void
     */
    public function seedIfEmpty(): void
    {
        if ($this->find()->count() === 0) {
            for ($i = 1; $i <= 10; $i++) {
                $quantity = rand(0, 20);
                $price = rand(100, 1000) / 10;
                $statusOptions = ['active', 'inactive', 'discontinued'];
                $status = $statusOptions[array_rand($statusOptions)];

                $product = $this->newEntity([
                    'name' => 'Product ' . $i,
                    'quantity' => $quantity,
                    'price' => $price,
                    'status' => $status,
                    'deleted' => false,
                ]);

                $this->save($product);
            }
        }
    }
}
