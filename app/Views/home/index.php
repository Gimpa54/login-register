<section class="container py-5">
  <div class="card shadow-lg border-0 rounded-4 p-5 text-center ">
    <div class="mb-4">
      <h1 class="display-4 fw-bold text-gradient mb-4">
        <i class="bi bi-person-check-fill text-primary me-2"></i> <span><?= __('welcome_to_the_user_login_and_registration_system') ?></span>
      </h1>
      <p class="lead text-muted"><?= __('a_secure_modern_multilingual_registration_system')?>
      </p>
    </div>

    <div class="d-flex flex-wrap justify-content-center gap-3 mt-4">
      <?php if (!App\Utils\Auth::check()): ?>
        <a href="/register" class="btn btn-outline-success btn-lg px-4 shadow-sm">
          <i class="bi bi-person-plus-fill me-1"></i> <?= __('register')?>
        </a>
        <a href="/login" class="btn btn-outline-primary btn-lg px-4 shadow-sm">
          <i class="bi bi-box-arrow-in-right me-1"></i> <?= __('login')?>
        </a>
      <?php else: ?>
        <a href="/account/<?= $user->id ?>" class="btn btn-primary btn-lg px-4 shadow-sm">
          <i class="bi bi-person-circle me-1"></i> <?= __('profile')?>
        </a>
        <?php if (\App\Utils\Auth::user()?->role === 'admin'): ?>
          <a href="/admin/users" class="btn btn-dark btn-lg px-4 shadow-sm">
            <i class="bi bi-people-fill me-1"></i> <?= __('user_management')?>
          </a>
        <?php endif; ?>
      <?php endif; ?>
    </div>
  </div>
</section>