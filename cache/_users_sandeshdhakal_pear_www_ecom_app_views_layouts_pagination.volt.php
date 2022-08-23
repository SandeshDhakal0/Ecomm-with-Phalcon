
<!-- <nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item"><a class="page-link" href="#">Previous</a></li>
    <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item"><a class="page-link" href="#">Next</a></li>
  </ul>
</nav> -->


<?php $start = ($limit * ($page->current - 1)) + 1; ?>
<?php $end = ($limit * ($page->current - 1)) + $limit; ?>
<?php if ($end > $page->total_items) { ?>
  <?php $end = $page->total_items; ?>
<?php } ?>

<?php if ($limit) { ?>
  <div>Showing <?= $start ?> - <?= $end ?> of <?= $page->total_items ?></div>
<?php } ?>

<ul class="pagination">
  <?php if ($page->current != 1) { ?>
    <li><a href="<?= $this->callMacro('paginationPath', []) ?>1">&laquo;</a></li>
  <?php } ?>

  <?php foreach (range(1, $page->total_pages) as $i) { ?>
    <li><a <?php if ($i == $page->current) { ?>class="active"<?php } ?> href="<?= $this->callMacro('paginationPath', []) ?><?= $i ?>"><?= $i ?></a></li>
  <?php } ?>

  <?php if ($page->current != $page->last) { ?>
    <li><a href="<?= $this->callMacro('paginationPath', []) ?><?= $page->last ?>">&raquo;</a></li>
  <?php } ?>
</ul>