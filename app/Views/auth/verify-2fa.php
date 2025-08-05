<?php
use App\Utils\Flash;
?>
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-lg p-4 rounded-4 border-0">
        <h4 class="mb-4 text-center fw-bold text-gradient">
          <i class="bi bi-shield-lock-fill me-2"></i> <?= __('two_step_verification')?>
        </h4>

        <?php if ($errors = Flash::display('error')): ?>
          <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
            <div>
              <?php foreach ((array)$errors as $error): ?>
                <div><?= htmlspecialchars($error) ?></div>
              <?php endforeach; ?>
            </div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
          </div>
        <?php endif; ?>

        <?php if ($success = Flash::display('success')): ?>
          <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
            <div><?= htmlspecialchars($success) ?></div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
          </div>
        <?php endif; ?>

        <form method="POST" action="/verify-2fa" novalidate>
          <?= csrf() ?>
          <div class="mb-3">
            <label for="code" class="form-label fw-semibold">
              <i class="bi bi-envelope-fill me-1"></i> <?= __('code_received_by_email')?>
            </label>
            <input type="text" name="code" id="code" class="form-control text-center fs-4 fw-bold"
                   maxlength="6" pattern="\d{6}" placeholder="123456" autofocus required>
          </div>

          <button type="submit" class="btn btn-primary w-100">
            <i class="bi bi-check2-circle me-1"></i> <?= __('verify_code')?>
          </button>
        </form>

        <div class="text-center mt-3">
          <small class="text-muted">
            <?= __('didn_t_you_receive_the_code')?><br>
            <a href="/resend-2fa" id="resend-link"
               class="text-decoration-none d-inline-block mt-2 disabled"
               style="pointer-events: none; opacity: 0.5;">
              <?= __('resend_in')?> <span id="countdown">60</span> <?= __('seconds')?>
            </a>
          </small>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    let seconds = 60;
    const countdownEl = document.getElementById('countdown');
    const resendLink = document.getElementById('resend-link');

    if (countdownEl && resendLink) {
      const interval = setInterval(() => {
        seconds--;
        countdownEl.textContent = seconds;

        if (seconds <= 0) {
          clearInterval(interval);
          resendLink.classList.remove('disabled');
          resendLink.style.pointerEvents = 'auto';
          resendLink.style.opacity = '1';
          resendLink.textContent = <?= json_encode(__('resend_code')) ?>;
        }
      }, 1000);
    }
  });
</script>


