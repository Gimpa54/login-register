<form method="GET" class="row g-3 align-items-end mb-4">
  <div class="col-md-3">
    <label for="ip" class="form-label"><?= __('ip_address')?></label>
    <input type="text" name="ip" id="ip" class="form-control" placeholder="Es: 192.168.1.1" value="<?= htmlspecialchars($filters['ip'] ?? '') ?>">
  </div>

  <div class="col-md-3">
    <label for="route" class="form-label"><?= __('route')?></label>
    <input type="text" name="route" id="route" class="form-control" placeholder="Es: /login" value="<?= htmlspecialchars($filters['route'] ?? '') ?>">
  </div>

  <div class="col-md-3">
    <label for="level" class="form-label"><?= __('level')?></label>
   <select name="level" id="level" 
        class="selectpicker" 
        data-live-search="true" 
        data-width="100%">
    <option value="" data-icon="bi bi-journal-text"><?= __('all_levels') ?></option>
    <option value="info" data-icon="bi bi-info-circle" <?= $filters['level'] === 'info' ? 'selected' : '' ?>><?= __('info')?></option>
    <option value="warning" data-icon="bi bi-exclamation-triangle" <?= $filters['level'] === 'warning' ? 'selected' : '' ?>><?= __('warning')?></option>
    <option value="error" data-icon="bi bi-x-circle" <?= $filters['level'] === 'error' ? 'selected' : '' ?>>Error</option>
</select>
  </div>

  <div class="col-md-3 d-grid">
    <button type="submit" class="btn btn-primary">
      <i class="bi bi-funnel-fill me-1"></i> <?= __('filter')?>
    </button>
  </div>
</form>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th><?= __('date')?></th>
            <th><?= __('level')?></th>
            <th><?= __('message')?></th>
            <th><?= __('ip')?></th>
            <th><?= __('file')?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($logs as $log): ?>
        
            <tr>
                <td><?= htmlspecialchars($log->created_at) ?></td>
                <td><span class="badge bg-<?= match ($log->level) {
                    'error' => 'danger', 'warning' => 'warning', default => 'secondary'
                } ?>"><?= strtoupper($log->level) ?></span></td>
                <td><?= htmlspecialchars($log->message) ?></td>
                <td><?= htmlspecialchars($log->ip) ?></td>
                <td><?= htmlspecialchars($log->file) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php 
$perPage = $perPage ?? 20;
$perPage = max(1, (int)$perPage);
$page = isset($page) ? (int)$page : 1; // Cast a intero per sicurezza
$totalPages = ceil($total / $perPage);

$maxLinks = 10;

// Calcola intervallo visibile
$start = max(1, $page - floor($maxLinks / 2));
$end = min($totalPages, $start + $maxLinks - 1);

// Corregge se l'intervallo è troppo corto
if ($end - $start + 1 < $maxLinks) {
    $start = max(1, $end - $maxLinks + 1);
}
?>

<?php if ($totalPages > 1): ?>
<nav aria-label="Navigazione pagine">
    <ul class="pagination justify-content-center mt-4">

        <!-- Pulsante Precedente -->
        <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="<?= $page > 1 ? '?' . http_build_query(array_merge($filters, ['page' => $page - 1])) : '#' ?>">
                &laquo; <?= __('previous') ?>
            </a>
        </li>

        <!-- Prima pagina -->
        <?php if ($start > 1): ?>
            <li class="page-item <?= $page == 1 ? 'active' : '' ?>">
                <a class="page-link" href="?<?= http_build_query(array_merge($filters, ['page' => 1])) ?>">1</a>
            </li>
            <?php if ($start > 2): ?>
                <li class="page-item disabled"><span class="page-link">...</span></li>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Pagine centrali -->
        <?php for ($i = (int)$start; $i <= (int)$end; $i++): ?>
            <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                <a class="page-link" href="?<?= http_build_query(array_merge($filters, ['page' => $i])) ?>">
                    <?= $i ?>
                </a>
            </li>
        <?php endfor; ?>

        <!-- Ultima pagina -->
        <?php if ($end < $totalPages): ?>
            <?php if ($end < $totalPages - 1): ?>
                <li class="page-item disabled"><span class="page-link">...</span></li>
            <?php endif; ?>
            <li class="page-item <?= $page === $totalPages ? 'active' : '' ?>">
                <a class="page-link" href="?<?= http_build_query(array_merge($filters, ['page' => $totalPages])) ?>">
                    <?= $totalPages ?>
                </a>
            </li>
        <?php endif; ?>

        <!-- Pulsante Successivo -->
        <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
            <a class="page-link" href="<?= $page < $totalPages ? '?' . http_build_query(array_merge($filters, ['page' => $page + 1])) : '#' ?>">
                <?= __('next') ?> &raquo;
            </a>
        </li>

    </ul>
</nav>
<?php endif; ?>
