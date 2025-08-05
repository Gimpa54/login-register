<?php 
use App\Utils\Auth;
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<div class="container">
		<a class="navbar-brand" href="/"><?= __('login_registration')?></a>
		<button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="nav">
			<ul class="navbar-nav me-auto">
				<li class="nav-item"><a class="nav-link" href="/"><?= __('home')?></a></li>
				<?php if (Auth::check()): ?>
					<li class="nav-item"><a class="nav-link" href="/user/dashboard"><?= __('dashboard')?></a></li>
				<?php endif; ?>
			</ul>
        	<ul class="navbar-nav">
        		
        	<?php if (!Auth::check()): ?>
          		<li class="nav-item"><a class="nav-link" href="/login"><?= __('login')?></a></li>
          		<li class="nav-item"><a class="nav-link" href="/register"><?= __('register')?></a></li>
        	<?php else: ?>
          	<?php if (Auth::user()?->role === 'admin'): ?>
            	<li class="nav-item"><a class="nav-link" href="/admin/logs"><?= __('log')?></a></li>
            	<li class="nav-item"><a class="nav-link" href="/admin/security-log"><?= __('security')?></a></li>
          	<?php endif; ?>
          	<li class="nav-item">
            	<a class="nav-link" href="/account/edit/<?= Auth::user()->id ?>">
              	<?= e(Auth::user()?->username ?? 'Utente') ?>
            	</a>
          	</li>
          	<li class="nav-item"><a class="nav-link" href="/logout"><?= __('logout')?></a></li>
        	<?php endif; ?>
        	<li class="nav-item">
                  <a class="nav-link" href="/theme/toggle" title="Tema">
                    <?php if (($_SESSION['theme'] ?? 'light') === 'dark'): ?>
                      <i class="bi bi-moon-stars-fill"></i> <?= __('dark')?>
                    <?php else: ?>
                      <i class="bi bi-brightness-high-fill"></i> <?= __('light')?>
                    <?php endif; ?>
                  </a>
                </li>
        	<li class="nav-item dropdown">
          			<a class="nav-link dropdown-toggle" href="#" id="langDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
    					<i class="bi bi-globe"></i> <?= strtoupper($_SESSION['lang'] ?? 'IT') ?>
  					</a>
  					<ul class="dropdown-menu" aria-labelledby="langDropdown">
    					<li><a class="dropdown-item" href="/lang/it">🇮🇹 <?= __('italian')?></a></li>
    					<li><a class="dropdown-item" href="/lang/en">🇬🇧 <?= __('english') ?></a></li>
    					<li><a class="dropdown-item" href="/lang/fr">🇫🇷 <?= __('french') ?></a></li>
    					<li><a class="dropdown-item" href="/lang/de">🇩🇪 <?= __('german') ?></a></li>
    					<li><a class="dropdown-item" href="/lang/es">🇪🇸 <?= __('spanish') ?></a></li>
    					<li><a class="dropdown-item" href="/lang/pt">🇵🇹 <?= __('portuguese') ?></a></li>
  					</ul>
				</li>
				
      	</ul>
    </div>
  </div>
</nav>


