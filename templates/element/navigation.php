<nav aria-label="Page navigation">
    <ul class="pagination">
        <?= $this->Paginator->prev('← Previous', ['class' => 'page-item'], null, ['class' => 'page-item disabled']) ?>
        <?= $this->Paginator->numbers(['class' => 'page-item']) ?>
        <?= $this->Paginator->next('Next →', ['class' => 'page-item'], null, ['class' => 'page-item disabled']) ?>
    </ul>
</nav>