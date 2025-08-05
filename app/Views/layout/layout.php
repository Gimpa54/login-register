<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title ?? 'Registration' ?></title>
  
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  
  <!-- Bootstrap Select CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css" rel="stylesheet">
	
  <link href="/assets/css/theme.css" rel="stylesheet">
</head>
<?php $theme = $_SESSION['theme'] ?? 'light'; ?>
<body data-bs-theme="<?= $theme ?>">


  <?php App\Core\View::includePartial('layout/header', $data ?? []); ?>


  <main class="container my-4">
    <?php include $viewPath; ?>
  </main>

  <?php App\Core\View::includePartial('layout/footer'); ?>
  
  <!-- jQuery (necessario per Bootstrap Select) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Bootstrap Select JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>

<script>
    $(function() {
        $('.selectpicker').selectpicker();
    });
</script>
 
</html>

