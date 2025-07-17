<!DOCTYPE html>
<html>
<head>
  <link href="./output.css" rel="stylesheet">
  <title>Logs simples</title>
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">
  <?php include(__DIR__ . '/components/sidebar.php'); ?>

  <main class="flex-1 p-8">
    <h2 class="text-xl font-semibold mb-4">Logs récents</h2>
    <div class="bg-black text-green-400 font-mono text-sm p-4 h-[400px] overflow-y-auto rounded shadow-inner">
      <ul>
        <?php foreach ($logs as $log): ?>
          <li><?= htmlspecialchars($log['message']) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </main>
</div>

</body>
</html>
