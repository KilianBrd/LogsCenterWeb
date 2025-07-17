<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un utilisateur</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex">
    <?php include __DIR__ . '/components/sidebar.php'; ?>
    <main class="flex-1 flex items-center justify-center p-6">
        <div class="w-full max-w-lg bg-white rounded-lg shadow-lg p-8">
            <?php if (isset(
                $message) && $message): ?>
                <div class="p-4 mb-4 rounded <?php echo $type === 'success' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800'; ?> text-center font-semibold">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <form method="post" class="space-y-6">
                <h2 class="text-3xl font-bold mb-6 text-center text-gray-800">Créer un utilisateur</h2>
                <div>
                    <label for="username" class="block mb-1 font-medium text-gray-700">Nom d'utilisateur</label>
                    <input type="text" id="username" name="username" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>
                <div>
                    <label for="email" class="block mb-1 font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>
                <div>
                    <label for="password" class="block mb-1 font-medium text-gray-700">Mot de passe</label>
                    <input type="password" id="password" name="password" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>
                <div>
                    <label for="role" class="block mb-1 font-medium text-gray-700">Rôle</label>
                    <select id="role" name="role" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="user">Utilisateur</option>
                        <option value="admin">Administrateur</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded font-semibold hover:bg-blue-700 transition">Créer</button>
            </form>
        </div>
    </main>
</body>
</html> 