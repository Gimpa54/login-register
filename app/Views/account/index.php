<?php use App\Utils\Flash; ?>
<section class="container py-5">
  <h2 class="mb-4 text-center fw-bold">Profilo Utente #<?= $user->id ?></h2>

  <div class="card shadow-lg rounded-4 p-4 mb-4">
    <div class="row g-4">
      <div class="col-md-3 text-center">
        <?php if ($user->avatar): ?>
          <img src="/storage/avatars/<?= e($user->avatar) ?>" alt="Avatar" width="120" class="rounded-circle border shadow-sm">
        <?php else: ?>
          <div class="text-muted fst-italic">Nessun avatar</div>
        <?php endif; ?>
      </div>

      <div class="col-md-9">
        <ul class="list-group list-group-flush">
          <li class="list-group-item">
            <i class="bi bi-person-fill me-2 text-primary"></i>
            <strong><?= e($user->firstname) ?> <?= e($user->lastname) ?></strong>
          </li>
          <li class="list-group-item">
            <i class="bi bi-envelope-fill me-2 text-secondary"></i>
            Email: <?= e($user->email) ?>
          </li>
          <li class="list-group-item">
            <i class="bi bi-person-badge-fill me-2 text-info"></i>
            Username: <?= e($user->username) ?>
          </li>
          <li class="list-group-item">
            <i class="bi bi-shield-lock-fill me-2 text-dark"></i>
            Ruolo: <strong><?= ucfirst($user->role) ?></strong>
          </li>
          <li class="list-group-item">
            <i class="bi bi-check-circle-fill me-2 <?= $user->is_active ? 'text-success' : 'text-danger' ?>"></i>
            Attivo: <?= $user->is_active ? 'Sì' : 'No' ?>
          </li>
          <li class="list-group-item">
            <i class="bi bi-telephone-fill me-2 text-muted"></i>
            Telefono: <?= e($user->phone ?? '-') ?>
          </li>
          <li class="list-group-item">
            <i class="bi bi-journal-text me-2 text-warning"></i>
            Bio:<br><small class="text-muted"><?= nl2br(e($user->bio ?? '-')) ?></small>
          </li>
          <li class="list-group-item">
            <i class="bi bi-geo-alt-fill me-2 text-danger"></i>
            Città: <?= e($user->city ?? '-') ?> (<?= e($user->province ?? '-') ?>)
          </li>
          <li class="list-group-item">
            <i class="bi bi-mailbox me-2 text-primary"></i>
            CAP: <?= e($user->postal_code ?? '-') ?>
          </li>
          <li class="list-group-item">
            <i class="bi bi-globe2 me-2 text-info"></i>
            Nazione: <?= e($user->country ?? '-') ?>
          </li>
        </ul>
      </div>
    </div>
  </div>

  
</section>
