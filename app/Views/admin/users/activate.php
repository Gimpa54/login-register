<?php $this->layout('layout/admin', ['title' => 'Attiva Account']) ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient-primary text-white text-center rounded-top-4">
                    <h3 class="mb-0">Attiva Account Utente</h3>
                </div>
                <div class="card-body p-4">
                    <p class="mb-4">Vuoi attivare l'account dell'utente <strong><?= htmlspecialchars($user->email) ?></strong>?</p>

                    <form method="POST" action="/admin/users/activate/<?= $user->id ?>">
                        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

                        <div class="d-flex justify-content-between">
                            <a href="/admin/users" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Annulla
                            </a>

                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle"></i> Attiva Account
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
