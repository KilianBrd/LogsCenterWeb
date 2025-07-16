<!DOCTYPE html>
<html>
<head>
  <link href="./output.css" rel="stylesheet">
    <title>Logs simples</title>
</head>
<body>
    <h1 class="text-xl font-bold">Liste des logs statiques</h1>
    <ul>
        <?php foreach ($logs as $log): ?>
            <li><?= htmlspecialchars($log['message']) ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
