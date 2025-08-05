<?php use App\Utils\Helper; ?>

<div class="container py-5">
  <div class="card shadow-lg p-4 border-0 rounded-4">
    <h2 class="mb-4 text-center fw-bold text-gradient">
      <i class="bi bi-journal-text me-2"></i> <?= __('system_logs')?>
    </h2>

    <form method="GET" class="row g-3 mb-4 justify-content-between align-items-end">
      <div class="col-md-3">
        <label class="form-label"><i class="bi bi-calendar-date me-1"></i> <?= __('date')?></label>
        <input type="date" name="date" class="form-control" value="<?= htmlspecialchars($date) ?>">
      </div>

      <div class="col-md-5">
        <label class="form-label"><i class="bi bi-search me-1"></i> <?= __('search_logs')?></label>
        <input type="text" name="search" class="form-control" placeholder="Errore, warning, messaggi..." value="<?= htmlspecialchars($search ?? '') ?>">
      </div>

      <div class="col-md-4 d-flex gap-2">
        <button class="btn btn-primary shadow-sm">
          <i class="bi bi-search me-1"></i> <?= __('filter')?>
        </button>
        <a href="<?= \App\Utils\Helper::url('admin/logs/export-csv', ['date' => $date, 'search' => $search]) ?>" class="btn btn-outline-secondary">
           <i class="bi bi-filetype-csv me-1"></i>CSV
        </a>
        
        <a href="<?= Helper::url('admin/logs/export-pdf', ['date' => $date, 'search' => $search]) ?>" class="btn btn-outline-secondary">
   			<i class="bi bi-file-earmark-pdf me-1"></i>PDF
		</a>
      </div>
    </form>

    <?php if (empty($logs)): ?>
      <div class="alert alert-warning text-center">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>Nessun log trovato per la data selezionata.
      </div>
    <?php else: ?>
      <div class="table-responsive" style="max-width: 100%; overflow-x: auto;">
  <table class="table table-hover table-bordered table-sm align-middle shadow-sm rounded overflow-hidden">
    <thead class="table-dark">
      <tr>
        <th style="width: 120px;"><?= __('now')?></th>
        <th style="width: 120px;"><?= __('level')?></th>
        <th style="width: 200px;"><?= __('message')?></th>
        <th><?= __('data')?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($logs as $entry): ?>
        <tr>
          <td class="text-nowrap small"><?= htmlspecialchars($entry['timestamp'] ?? '') ?></td>
          <td class="text-nowrap small">
            <span class="badge bg-<?= 
              ($entry['level'] ?? 'info') === 'error' ? 'danger' : 
              (($entry['level'] ?? 'info') === 'warning' ? 'warning text-dark' : 'info') ?>">
              <i class="bi <?= 
                ($entry['level'] ?? 'info') === 'error' ? 'bi-x-octagon-fill' : 
                (($entry['level'] ?? 'info') === 'warning' ? 'bi-exclamation-triangle-fill' : 'bi-info-circle-fill') ?> me-1"></i>
              <?= strtoupper($entry['level'] ?? 'INFO') ?>
            </span>
          </td>
          <td class="text-truncate small" style="max-width: 200px;">
            <?= htmlspecialchars($entry['message'] ?? '') ?>
          </td>
          <td class="small">
            <pre class="bg-light p-2 rounded text-muted mb-0" style="max-height: 120px; overflow: auto; font-size: 0.75rem; white-space: pre-wrap;">
<?= htmlspecialchars(json_encode($entry['context'] ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) ?>
            </pre>
          </td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</div>
<?php if (!empty($logs) && $totalPages > 1): ?>
    <?php
    $page = isset($page) ? (int)$page : 1;
    $maxLinks = 10;

    $start = max(1, $page - floor($maxLinks / 2));
    $end = min($totalPages, $start + $maxLinks - 1);

    if ($end - $start + 1 < $maxLinks) {
        $start = max(1, $end - $maxLinks + 1);
    }
    ?>

    <nav aria-label="Log pagination">
        <ul class="pagination justify-content-center mt-4">
            <!-- Precedente -->
            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= $page > 1 ? '?' . http_build_query(array_merge($_GET, ['page' => $page - 1])) : '#' ?>">
                    &laquo; <?= __('previous') ?>
                </a>
            </li>

            <!-- Prima pagina -->
            <?php if ($start > 1): ?>
                <li class="page-item <?= $page === 1 ? 'active' : '' ?>">
                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => 1])) ?>">1</a>
                </li>
                <?php if ($start > 2): ?>
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                <?php endif; ?>
            <?php endif; ?>

            <!-- Pagine centrali -->
            <?php for ($i = (int)$start; $i <= (int)$end; $i++): ?>
                <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>">
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
                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $totalPages])) ?>">
                        <?= $totalPages ?>
                    </a>
                </li>
            <?php endif; ?>

            <!-- Successivo -->
            <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= $page < $totalPages ? '?' . http_build_query(array_merge($_GET, ['page' => $page + 1])) : '#' ?>">
                    <?= __('next') ?> &raquo;
                </a>
            </li>
        </ul>
    </nav>
<?php endif; ?>
      </div>
    <?php endif; ?>
  </div>
</div>
