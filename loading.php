<!-- loading.php (NEW FILE) -->
<?php
session_start();
$_SESSION['form_data'] = $_POST;
$_SESSION['file'] = $_FILES;
?>
<!DOCTYPE html>
<html>
<head>
  <title>Analyzing...</title>
  <style>
    body { text-align: center; padding: 50px; font-family: sans-serif; }
    .loader {
      border: 8px solid #f3f3f3;
      border-top: 8px solid #4CAF50;
      border-radius: 50%;
      width: 80px;
      height: 80px;
      animation: spin 1s linear infinite;
      margin: 0 auto 20px;
    }
    @keyframes spin { 100% { transform: rotate(360deg); } }
  </style>
  <script>
    setTimeout(() => { document.getElementById('realSubmit').submit(); }, 2000);
  </script>
</head>
<body>
  <div class="loader"></div>
  <h2>Analyzing your crop data...</h2>

  <form id="realSubmit" action="submit.php" method="POST" enctype="multipart/form-data" style="display: none;">
    <?php foreach ($_SESSION['form_data'] as $key => $value): ?>
      <input type="hidden" name="<?= htmlspecialchars($key) ?>" value="<?= htmlspecialchars($value) ?>" />
    <?php endforeach; ?>
  </form>
</body>
</html>
