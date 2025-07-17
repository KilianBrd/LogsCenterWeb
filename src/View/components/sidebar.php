<?php
session_start();
?>

<aside class="w-64 bg-gray-800 text-white p-6 flex flex-col justify-between min-h-screen">
    <div>
    <h1 class="text-center text-2xl font-bold mb-8">LogsCenter</h1>
    <nav class="space-y-2 text-center">
      <a href="index.php?page=dashboard" class="block px-4 py-2 rounded hover:bg-gray-700">Voir les logs</a>
      <a href="index.php?page=mon_compte" class="block px-4 py-2 rounded hover:bg-gray-700">Mon compte</a>
      <?php 
        if ($_SESSION['role'] === 'admin') {
           ?>
          <span class="inline-block text-xl font-semibold rounded-full shadow">
            Administrateur
          </span>
          <a href="index.php?page=create_user" class="block px-4 rounded hover:bg-gray-700 mt-7">Créer un utilisateur</a>
        <?php } ?>
      
      
    </nav>
  </div>

    <div class="text-center">
    <a href="index.php?page=logout" class="block px-4 py-2 mt-8 text-red-400 rounded hover:bg-gray-700 hover:text-red-300">
      Déconnexion
    </a>
  </div>
</aside>
