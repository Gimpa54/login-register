<section class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
      <div class="card shadow-lg p-4 rounded-4 border-0">
        <h2 class="mb-4 text-center fw-bold text-gradient">
          <i class="bi bi-key-fill me-2"></i> Imposta nuova password
        </h2>

        <?php include __DIR__ . '/../partials/flash.php'; ?>

        <form method="POST" action="/reset-password" novalidate>
          <input type="hidden" name="csrf_token" value="<?= \App\Utils\Csrf::getToken() ?>">
          <input type="hidden" name="token" value="<?= e($token) ?>">

          <div class="mb-3">
            <label class="form-label" for="password">
              <i class="bi bi-lock-fill me-1"></i> Nuova Password
            </label>
            <input type="password" name="password" id="password" class="form-control" required>
          </div>

          <div class="mb-4">
            <label class="form-label" for="password_confirm">
              <i class="bi bi-lock-fill me-1"></i> Conferma Password
            </label>
            <input type="password" name="password_confirm" id="password_confirm" class="form-control" required>
          </div>

          <div class="text-center">
            <button type="submit" class="btn btn-success w-100">
              <i class="bi bi-check-circle me-1"></i> Reimposta Password
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>


