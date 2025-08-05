<footer class="text-center py-3 mt-5">
	<div class="text-end small text-center">
  		<a href="/lang/it" class="<?= ($_SESSION['lang'] ?? 'it') === 'it' ? 'fw-bold' : '' ?>">🇮🇹 <?= __('italian') ?></a> |
        <a href="/lang/en" class="<?= ($_SESSION['lang'] ?? 'it') === 'en' ? 'fw-bold' : '' ?>">🇬🇧 <?= __('english') ?></a> |
        <a href="/lang/fr" class="<?= ($_SESSION['lang'] ?? 'it') === 'fr' ? 'fw-bold' : '' ?>">🇫🇷 <?= __('french') ?></a> |
        <a href="/lang/de" class="<?= ($_SESSION['lang'] ?? 'it') === 'de' ? 'fw-bold' : '' ?>">🇩🇪 <?= __('german') ?></a> |
        <a href="/lang/es" class="<?= ($_SESSION['lang'] ?? 'it') === 'es' ? 'fw-bold' : '' ?>">🇪🇸 <?= __('spanish') ?></a> |
        <a href="/lang/pt" class="<?= ($_SESSION['lang'] ?? 'it') === 'pt' ? 'fw-bold' : '' ?>">🇵🇹 <?= __('portuguese') ?></a> |
        
  		<a href="/theme/toggle">
    		<?= ($_SESSION['theme'] ?? 'light') === 'dark' ? '<i class="bi bi-moon-stars-fill"></i> ' . __('dark_theme')  : '<i class="bi bi-brightness-high-fill"></i>'. __('light_theme')  ?>
  		</a>
	</div>
  <small>&copy; <?= date('Y') ?> <?= __('registration')?>. <?= __('all_rights_reserved')?>.</small>
</footer>

