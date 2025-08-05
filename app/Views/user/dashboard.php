<?php 
use App\Utils\Auth;
?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card p-4 shadow-lg rounded-4 border-0">
                <h2 class="mb-4 text-center fw-bold text-gradient"><i class="bi bi-stars me-1"></i> <?= __('welcome')?>, <?= e(Auth::user()?->firstname ?? 'Utente') ?></h2>

                <?php include __DIR__ . '/../partials/flash.php'; ?>

                <div class="d-flex align-items-center mb-4">
                    <img src="/storage/avatars/<?= htmlspecialchars(Auth::user()->avatar ?? 'default.png') ?>"
                         class="rounded-circle me-3 border border-2 border-primary shadow-sm"
                         width="80" height="80" alt="Avatar">

                    <div>
                        <h5 class="mb-1"><?= htmlspecialchars(Auth::user()->username) ?></h5>
                        <p class="text-muted mb-0"><?= htmlspecialchars(Auth::user()->email) ?></p>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <a href="/account/edit/<?= e(Auth::user()->id) ?>" class="btn btn-outline-primary me-2 px-4"><i class="bi bi-pencil-square"></i> <?= __('edit_profile')?></a>
                    <a href="/user/change-password/<?= e(Auth::user()->id) ?>" class="btn btn-outline-warning me-2 px-4"><i class="bi bi-lock"></i> <?= __('change_password')?></a>
                    <a href="/logout" class="btn btn-danger px-4"><i class="bi bi-door-closed"></i> <?=__('logout')?></a>
                </div>
            </div>
        </div>
    </div>
</div>


