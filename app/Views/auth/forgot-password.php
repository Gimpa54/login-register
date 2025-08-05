<section class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-5">
      <div class="card shadow-lg p-4 rounded-4 border-0">
        <h2 class="mb-4 text-center fw-bold">
          <i class="bi bi-question-circle-fill me-2"></i> <?= __('forgot_password')?>
        </h2>

        <?php include __DIR__ . '/../partials/flash.php'; ?>

        <form method="POST" action="/forgot-password" novalidate>
          <?= csrf() ?>

          <div class="mb-3">
            <label for="email" class="form-label">
              <i class="bi bi-envelope-at-fill me-1"></i> <?= __('please_enter_your_email')?>
            </label>
            <input type="email" name="email" id="email" class="form-control" required>
          </div>

          <div class="d-grid">
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-send-fill me-1"></i> <?= __('send_recovery_link')?>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>


