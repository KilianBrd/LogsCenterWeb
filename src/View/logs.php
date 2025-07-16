<!DOCTYPE html>
<html>
<head>
    <title>Logs simples</title>
</head>
<body>
    <h1>Liste des logs statiques</h1>
    <ul>
        <?php foreach ($logs as $log): ?>
            <li><?= htmlspecialchars($log['message']) ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
