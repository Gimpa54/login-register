<?php 
use App\Utils\Csrf; 
use App\Utils\Lang;
?>

<section class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <div class="card shadow-lg rounded-4 p-4 border-0">
        <h2 class="mb-4 text-center fw-bold text-gradient">
          <i class="bi bi-key-fill me-2"></i> <?= Lang::t('change_your_password')?>
        </h2>

        <?php include __DIR__ . '/../partials/flash.php'; ?>

        <form method="POST" action="/user/change-password/<?= $user->id ?>">
          <input type="hidden" name="csrf_token" value="<?= Csrf::getToken() ?>">

          <div class="mb-3">
            <label for="current_password" class="form-label"><?= Lang::t('current_password') ?></label>
            <input type="password" name="current_password" id="current_password" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="new_password" class="form-label"><?= Lang::t('new_password') ?></label>
            <input type="password" name="new_password" id="new_password" class="form-control" required>
          </div>

          <div class="mb-4">
            <label for="confirm_password" class="form-label"><?= Lang::t('confirm_new_password') ?></label>
            <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
          </div>

          <div class="text-center">
            <button type="submit" class="btn btn-success px-4">
              <i class="bi bi-shield-lock me-1"></i> <?= Lang::t('update_password')?>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
