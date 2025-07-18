<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des utilisateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex">
    <?php include __DIR__ . '/components/sidebar.php'; ?>
    <main class="flex-1 p-8">
        <h2 class="text-3xl font-bold mb-6 text-center text-gray-800">Gestion des utilisateurs</h2>
        <?php if (isset(
            $message) && $message): ?>
            <div class="p-4 mb-4 rounded <?php echo $type === 'success' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800'; ?> text-center font-semibold">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow-lg">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">ID</th>
                        <th class="py-2 px-4 border-b">Nom d'utilisateur</th>
                        <th class="py-2 px-4 border-b">Email</th>
                        <th class="py-2 px-4 border-b">Rôle</th>
                        <th class="py-2 px-4 border-b">Créé le</th>
                        <th class="py-2 px-4 border-b">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td class="py-2 px-4 border-b text-center"><?php echo htmlspecialchars($user->getId()); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($user->getUsername()); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($user->getEmail()); ?></td>
                            <td class="py-2 px-4 border-b text-center"><?php echo htmlspecialchars($user->getRole()); ?></td>
                            <td class="py-2 px-4 border-b text-center"><?php $date = $user->getCreatedAt(); if ($date) { $dt = new DateTime($date); echo $dt->format('d/m/Y à H:i'); } else { echo '-'; } ?></td>
                            <td class="py-2 px-4 border-b text-center">
                                <?php if ($user->getRole() !== 'admin'): ?>
                                <form method="post" action="index.php?page=supprimer_utilisateur" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($user->getId()); ?>">
                                    <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Supprimer</button>
                                </form>
                                <?php else: ?>
                                    <span class="text-gray-400">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html> 