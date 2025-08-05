<?php 
use App\Utils\Csrf;
use App\Utils\Helper;
?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card p-4 shadow-lg rounded-4 border-0">
                <h2 class="mb-4 text-center fw-bold text-gradient">
                    <i class="bi bi-person-plus-fill me-2"></i> <?= __('create_your_account')?>
                </h2>
                
                <?php include __DIR__ . '/../partials/flash.php'; ?>
                
                <form method="POST" action="/register" enctype="multipart/form-data" novalidate>
                    <input type="hidden" name="csrf_token" value="<?= Csrf::getToken() ?>">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="firstname" class="form-label">
                                <i class="bi bi-person-fill me-1"></i> <?= __('name')?>
                            </label>
                            <input type="text" name="firstname" id="firstname" class="form-control" value="<?= Helper::old('firstname') ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lastname" class="form-label">
                                <i class="bi bi-person-fill me-1"></i> <?= __('surname')?>
                            </label>
                            <input type="text" name="lastname" id="lastname" class="form-control" value="<?= Helper::old('lastname') ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">
                            <i class="bi bi-person-badge-fill me-1"></i> <?= __('username')?>
                        </label>
                        <input type="text" name="username" id="username" class="form-control" value="<?= Helper::old('username') ?>" required>
                    </div>

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

                    <div class="mb-3">
                        <label for="password_confirm" class="form-label">
                            <i class="bi bi-lock-fill me-1"></i> <?= __('confirm_password')?>
                        </label>
                        <input type="password" name="password_confirm" id="password_confirm" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="avatar" class="form-label">
                            <i class="bi bi-image-fill me-1"></i> <?= __('avatar_optional')?>
                        </label>
                        <input type="file" name="avatar" id="avatar" class="form-control">
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-person-plus-fill me-1"></i> <?= __('register')?>
                        </button>
                    </div>
                </form>

                <div class="text-center mt-3">
                    <small><?= __('do_you_already_have_an_account')?> <a href="/login"><?= __('login')?></a></small>
                </div>
            </div>
        </div>
    </div>
</div>
