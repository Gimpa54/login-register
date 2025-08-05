<?php 
use App\Utils\Csrf;
use App\Utils\Helper;
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
            <div class="card shadow-lg p-4 rounded-4 border-0">
                <h2 class="text-center mb-4 fw-bold">
                    <i class="bi bi-box-arrow-in-right me-2"></i><?= \App\Utils\Lang::get('login')?>
                </h2>

                <?php include __DIR__ . '/../partials/flash.php'; ?>

                <form method="POST" action="/login" novalidate>
                    <input type="hidden" name="csrf_token" value="<?= Csrf::getToken() ?>">

                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="bi bi-envelope-fill me-1"></i> <?= __('email')?>
                        </label>
                        <input type="email" name="email" id="email" class="form-control" value="<?= Helper::old('email') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">
                            <i class="bi bi-lock-fill me-1"></i> <?= __('password')?>
                        </label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>

                    <div class="form-check mb-3">
                        <input type="checkbox" name="remember" id="remember" class="form-check-input" <?= Helper::old('remember') ? 'checked' : '' ?>>
                        <label for="remember" class="form-check-label"><?= __('remember_me')?></label>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-door-open me-1"></i><?= __('login')?>
                        </button>
                        <a href="/forgot-password" class="btn btn-link text-decoration-none">
                            <i class="bi bi-question-circle-fill me-1"></i><?= __('forgot_password')?>?
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>