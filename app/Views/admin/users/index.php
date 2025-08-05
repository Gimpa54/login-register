<?php use App\Utils\Flash; ?>

<section class="container py-5">
  <h2 class="mb-4 text-center fw-bold">
    <i class="bi bi-people-fill me-2"></i> <?= __('user_management')?>
  </h2>

  <?php Flash::display(); ?>

  <div class="card p-4 shadow-sm mb-4">
    <form method="GET" class="row g-3">
      <div class="col-md-4">
        <input type="text" name="search" class="form-control" placeholder="<?= __('search_lasr_name_or_email')?>..." value="<?= e($_GET['search'] ?? '') ?>">
      </div>
      <div class="col-md-4">
        <select name="role" class="form-select">
          <option value=""><?= __('all_roles')?></option>
          <option value="admin" <?= selected('admin', $_GET['role'] ?? '') ?>><?= __('admin')?></option>
          <option value="moderator" <?= selected('moderator', $_GET['role'] ?? '') ?>><?= __('moderator')?></option>
          <option value="user" <?= selected('user', $_GET['role'] ?? '') ?>><?= __('user')?></option>
        </select>
      </div>
      <div class="col-md-4 text-end">
        <button type="submit" class="btn btn-outline-primary">
          <i class="bi bi-funnel-fill me-1"></i> <?= __('filter')?>
        </button>
      </div>
    </form>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered align-middle table-hover">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Avatar</th>
          <th><?= __('name')?> e <?= __('surname')?></th>
          <th><?= __('email')?></th>
          <th><?= __('role')?></th>
          <th><?= __('active')?></th>
          <th class="text-center"><?= __('actions')?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $user): ?>
          <?php include __DIR__ . '/../../partials/user_row.php'; ?>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <?php if (!empty($pagination)) : ?>
  <nav class="mt-4"><?= $pagination ?></nav>
<?php endif; ?>
</section>
