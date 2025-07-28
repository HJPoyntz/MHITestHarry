<div class="container mt-4">
    <h1 class="mb-4">Product Inventory</h1>

    <!-- Search & Filter -->
    <?= $this->Form->create(null, ['type' => 'get', 'class' => 'row g-2 mb-3']) ?>
        <div class="col-md-4">
            <?= $this->Form->control('search', ['label' => 'Search Name', 'value' => $this->request->getQuery('search'), 'class' => 'form-control']) ?>
        </div>
        <div class="col-md-3">
            <?= $this->Form->control('status', [
                'label' => 'Status',
                'type' => 'select',
                'options' => [
                    '' => 'All',
                    'in stock' => 'In Stock',
                    'low stock' => 'Low Stock',
                    'out of stock' => 'Out of Stock'
                ],
                'value' => $this->request->getQuery('status'),
                'class' => 'form-select'
            ]) ?>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <?= $this->Form->button('Filter', ['class' => 'btn btn-primary w-100']) ?>
        </div>
    <?= $this->Form->end() ?>

    <!-- Add a new product button -->
    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#productModal">
            ➕ Add Product
        </button>
    </div>

    <!-- Product Table -->
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price (£)</th>
                <th>Status</th>
                <th>Last Updated</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td class="fw-bold"><?= h($product->name) ?></td>
                    <td><?= h($product->quantity) ?></td>
                    <td><?= number_format($product->price, 2) ?></td>
                    <td><?= h(ucwords($product->status)) ?></td>
                    <td class="text-center">
                        <?= $this->Html->link('✏️ Edit', ['action' => 'edit', $product->id], ['class' => 'btn btn-sm btn-outline-secondary']) ?>
                        <button class="btn btn-sm btn-outline-danger" onclick="confirmDelete(<?= $product->id ?>)">🗑 Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?= $this->element('navigation') ?>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <?= $this->Form->create(null, ['url' => ['action' => 'delete'], 'id' => 'deleteForm']) ?>
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirm Deletion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this product?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <?= $this->Form->button('Delete', ['class' => 'btn btn-danger']) ?>
      </div>
    </div>
    <?= $this->Form->end() ?>
  </div>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <?= $this->Form->create($newProduct, ['url' => ['action' => 'add'], 'class' => 'modal-content']) ?>
      <div class="modal-header">
        <h5 class="modal-title">Add New Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
            <?= $this->Form->control('name', ['class' => 'form-control', 'label' => 'Product Name']) ?>
        </div>
        <div class="mb-3">
            <?= $this->Form->control('quantity', ['class' => 'form-control']) ?>
        </div>
        <div class="mb-3">
            <?= $this->Form->control('price', ['class' => 'form-control']) ?>
        </div>
        <div class="mb-3">
            <?= $this->Form->control('status', [
                'type' => 'select',
                'options' => [
                    'in stock' => 'In Stock',
                    'low stock' => 'Low Stock',
                    'out of stock' => 'Out of Stock'
                ],
                'class' => 'form-select'
            ]) ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <?= $this->Form->button('Save Product', ['class' => 'btn btn-success']) ?>
      </div>
    <?= $this->Form->end() ?>
  </div>
</div>