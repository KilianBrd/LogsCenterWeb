<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center text-white">

  <div class="bg-gray-800 shadow-md rounded-3xl p-8 w-full max-w-md">
    <h2 class="text-xl font-semibold text-white mb-6 text-center">Connexion</h2>

    <form method="POST" action="#">
      <div class="mb-4">
        <label for="email" class="block text-white mb-1">Adresse email</label>
        <input type="email" id="email" name="email" required
               class="w-full px-4 py-2 border border-gray-600 rounded bg-gray-700 text-white placeholder-gray-300 focus:outline-none focus:ring-2">
      </div>

      <div class="mb-6">
        <label for="password" class="block text-white mb-1">Mot de passe</label>
        <input type="password" id="password" name="password" required
               class="w-full px-4 py-2 border border-gray-600 rounded bg-gray-700 text-white placeholder-gray-300 focus:outline-none focus:ring-2">
      </div>

      <button type="submit"
              class="w-full bg-black py-2 rounded hover:bg-gray-900 transition duration-200">
        Se connecter
      </button>
        <?php if (!empty($message)): ?>
      <div class="p-4 mb-6 rounded-lg text-sm font-medium mt-8
                  <?= $type === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
        <?= htmlspecialchars($message) ?>
      </div>
    <?php endif; ?>
    </form>
  </div>

</body>
</html>
