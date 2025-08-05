<?php use App\Utils\Helper; ?>

<section class="container py-5">
  <h2 class="mb-4 text-center fw-bold">
    <i class="bi bi-pencil-square me-2"></i><?= __('edit_user')?> #<?= $user->id ?>
  </h2>

  <?php include __DIR__ . '/../../partials/flash.php'; ?>

  <form action="/admin/users/edit/<?= $user->id ?>" method="POST" enctype="multipart/form-data" class="card p-4 shadow-lg" style="max-width: 600px; margin: 0 auto;">
    <input type="hidden" name="csrf_token" value="<?= \App\Utils\Csrf::getToken() ?>">

    <div class="mb-3">
      <label for="firstname" class="form-label">
        <i class="bi bi-person-fill me-1"></i> <?= __('name')?>
      </label>
      <input type="text" id="firstname" name="firstname" class="form-control" value="<?= Helper::old('firstname', $user->firstname) ?>" required>
    </div>

    <div class="mb-3">
      <label for="lastname" class="form-label">
        <i class="bi bi-person-fill me-1"></i> <?= __('surname')?>
      </label>
      <input type="text" id="lastname" name="lastname" class="form-control" value="<?= Helper::old('lastname', $user->lastname) ?>" required>
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">
        <i class="bi bi-envelope-fill me-1"></i> <?= __('email')?>
      </label>
      <input type="email" id="email" name="email" class="form-control" value="<?= Helper::old('email', $user->email) ?>" required>
    </div>

    <div class="mb-3">
      <label for="role" class="form-label">
        <i class="bi bi-person-badge-fill me-1"></i> <?= __('role')?>
      </label>
      <select name="role" id="role" class="form-select" required>
        <option value="user" <?= Helper::selected('user', $user->role) ?>><?= __('user')?></option>
        <option value="moderator" <?= Helper::selected('moderator', $user->role) ?>><?= __('moderator')?></option>
        <option value="admin" <?= Helper::selected('admin', $user->role) ?>><?= __('admin')?></option>
      </select>
    </div>

    <div class="form-check form-switch mb-3">
      <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" <?= Helper::checked($user->is_active, 1) ?>>
      <label class="form-check-label" for="is_active">
        <i class="bi bi-check-circle-fill me-1 text-success"></i> <?= __('active_user')?>
      </label>
    </div>

    <div class="d-grid">
      <button type="submit" class="btn btn-primary">
        <i class="bi bi-save2-fill me-1"></i> <?= __('save_changes')?>
      </button>
    </div>
  </form>
</section>
