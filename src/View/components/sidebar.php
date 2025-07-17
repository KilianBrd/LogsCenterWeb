<?php
session_start();
$currentPage = $_GET['page'] ?? 'dashboard';
?>

<aside class="w-64 bg-gray-800 text-white p-6 flex flex-col justify-between min-h-screen">
  <div>
    <h1 class="text-center text-2xl font-bold mb-8">LogsCenter</h1>
    <nav class="space-y-2 text-center">
      <a href="index.php?page=dashboard" 
         class="block px-4 py-2 rounded hover:bg-gray-700 <?= ($currentPage === 'dashboard') ? 'bg-gray-900 font-bold' : '' ?>">
         Voir les logs
      </a>

      <a href="index.php?page=mon_compte" class="block px-4 py-2 rounded hover:bg-gray-700 <?= ($currentPage === 'mon_compte') ? 'bg-gray-900 font-bold' : '' ?>">Mon compte</a>
      <?php if ($_SESSION['role'] === 'admin'): ?>
        <div class="mb-4">
          <h2 class="inline-block text-white text-xl font-semibold px-3 py-1 rounded-full shadow underline">
            Administrateur
          </h2>
        </div>
        <a href="index.php?page=create_user" 
           class="block px-4 py-2 rounded hover:bg-gray-700 <?= ($currentPage === 'create_user') ? 'bg-gray-900 font-bold' : '' ?>">
           Créer un utilisateur
        </a>
      <?php endif; ?>
    </nav>
  </div>

    <div class="text-center">
    <a href="index.php?page=logout" class="block px-4 py-2 mt-8 text-red-400 rounded hover:bg-gray-700 hover:text-red-300">
      Déconnexion
    </a>
  </div>
</aside>
