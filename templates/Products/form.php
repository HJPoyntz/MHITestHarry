<?= $this->Form->create($product, ['class' => 'card p-4']) ?>
    <?= $this->Form->control('name', ['class' => 'form-control mb-3']) ?>
    <?= $this->Form->control('quantity', ['class' => 'form-control mb-3']) ?>
    <?= $this->Form->control('price', ['class' => 'form-control mb-3']) ?>
    <?= $this->Form->control('status', [
        'type' => 'select',
        'options' => ['in stock' => 'In Stock', 'low stock' => 'Low Stock', 'out of stock' => 'Out of Stock'],
        'class' => 'form-select mb-3'
    ]) ?>
    <?= $this->Form->button('Save', ['class' => 'btn btn-success']) ?>
<?= $this->Form->end() ?>