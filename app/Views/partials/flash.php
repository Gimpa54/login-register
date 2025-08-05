<?php use App\Utils\Flash; ?>
<?php if ($message = Flash::display()): ?>
  <?php
    $type = e($message['type']);
    $text = e($message['text']);

    $icons = [
      'success' => 'bi-check-circle-fill',
      'error'   => 'bi-exclamation-triangle-fill',
      'warning' => 'bi-exclamation-circle-fill',
      'info'    => 'bi-info-circle-fill',
    ];

    $icon = $icons[$type] ?? 'bi-info-circle-fill';
  ?>
  <div class="alert alert-<?= $type ?> d-flex align-items-center alert-dismissible fade show shadow-sm" role="alert">
    <i class="bi <?= $icon ?> me-2"></i>
    <div><?= $text ?></div>
    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

