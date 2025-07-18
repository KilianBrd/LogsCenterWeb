<!DOCTYPE html>
<html>
<head>
  <link href="./output.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

  <title>Logs simples</title>
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">
  <?php include(__DIR__ . '/components/sidebar.php'); ?>

  <main class="flex-1 p-8">
    <h2 class="text-3xl font-semibold mb-6 text-center text-gray-800">Logs récents</h2>
    <form method="get" class="mb-6 flex flex-wrap gap-4 items-end">
      <input type="hidden" name="page" value="dashboard">
      <div>
        <label for="filter_message" class="block text-gray-700 text-sm font-semibold mb-1">Message</label>
        <input type="text" id="filter_message" name="filter_message" value="<?= htmlspecialchars($_GET['filter_message'] ?? '') ?>" class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gray-500" placeholder="Rechercher un message...">
      </div>
      <div>
        <label for="filter_severity" class="block text-gray-700 text-sm font-semibold mb-1">Sévérité</label>
        <select id="filter_severity" name="filter_severity" class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gray-500">
          <option value="">Toutes</option>
          <?php $severities = array_unique(array_map(fn($l) => $l->getSeverity(), $logs)); foreach ($severities as $sev): if (!$sev) continue; ?>
            <option value="<?= htmlspecialchars($sev) ?>" <?= (($_GET['filter_severity'] ?? '') === $sev) ? 'selected' : '' ?>><?= htmlspecialchars($sev) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <label for="filter_host" class="block text-gray-700 text-sm font-semibold mb-1">Hôte</label>
        <select id="filter_host" name="filter_host" class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gray-500">
          <option value="">Tous</option>
          <?php $hosts = array_unique(array_map(fn($l) => $l->getFromHost(), $logs)); foreach ($hosts as $host): if (!$host) continue; ?>
            <option value="<?= htmlspecialchars($host) ?>" <?= (($_GET['filter_host'] ?? '') === $host) ? 'selected' : '' ?>><?= htmlspecialchars($host) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <button type="submit" class="bg-gray-700 text-white px-4 py-2 rounded font-semibold hover:bg-gray-800 transition">Filtrer</button>
      <a href="index.php?page=dashboard" class="ml-2 bg-gray-300 text-gray-800 px-4 py-2 rounded font-semibold hover:bg-gray-400 transition text-center">Réinitialiser</a>
    </form>
    <?php
      // Application des filtres côté PHP
      $filteredLogs = $logs;
      if (!empty($_GET['filter_message'])) {
        $filteredLogs = array_filter($filteredLogs, function($log) {
          return stripos($log->getMessage(), $_GET['filter_message']) !== false;
        });
      }
      if (!empty($_GET['filter_severity'])) {
        $filteredLogs = array_filter($filteredLogs, function($log) {
          return $log->getSeverity() === $_GET['filter_severity'];
        });
      }
      if (!empty($_GET['filter_host'])) {
        $filteredLogs = array_filter($filteredLogs, function($log) {
          return $log->getFromHost() === $_GET['filter_host'];
        });
      }
    ?>
    <div class="overflow-x-auto rounded-lg shadow-lg">
      <table class="min-w-full text-sm text-gray-800">
        <thead class="bg-gray-700 text-white sticky top-0 z-10">
          <tr>
            <th class="py-3 px-4 border-b font-semibold">Date reçue</th>
            <th class="py-3 px-4 border-b font-semibold">Hôte</th>
            <th class="py-3 px-4 border-b font-semibold">Tag</th>
            <th class="py-3 px-4 border-b font-semibold">Message</th>
            <th class="py-3 px-4 border-b font-semibold">Sévérité</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($filteredLogs)): ?>
            <tr><td colspan="5" class="text-center py-8 text-gray-400">Aucun log trouvé.</td></tr>
          <?php else: foreach ($filteredLogs as $log): ?>
            <tr class="hover:bg-blue-50 transition">
              <td class="py-2 px-4 border-b text-center font-mono"><?php echo htmlspecialchars($log->getReceivedAtFormatted()); ?></td>
              <td class="py-2 px-4 border-b text-center"><?php echo htmlspecialchars($log->getFromHost()); ?></td>
              <td class="py-2 px-4 border-b text-center font-mono"><?php echo htmlspecialchars($log->getSyslogTag()); ?></td>
              <td class="py-2 px-4 border-b font-mono"><?php echo htmlspecialchars($log->getMessage()); ?></td>
              <td class="py-2 px-4 border-b text-center font-semibold">
                <?php echo htmlspecialchars($log->getSeverity()); ?>
              </td>
            </tr>
          <?php endforeach; endif; ?>
        </tbody>
      </table>
    </div>
    <!-- Pagination -->
    <div class="flex justify-center mt-6">
      <?php
        // Construction de l'URL de base en conservant les filtres
        $query = $_GET;
        unset($query['p']);
        $baseUrl = 'index.php?page=dashboard';
        if (!empty($query)) {
          $baseUrl .= '&' . http_build_query($query);
        }
      ?>
      <nav class="inline-flex rounded-md shadow-sm" aria-label="Pagination">
        <?php if ($page > 1): ?>
          <a href="<?= $baseUrl . '&p=' . ($page - 1) ?>" class="px-3 py-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-100 rounded-l-md">&laquo; Précédent</a>
        <?php else: ?>
          <span class="px-3 py-2 border border-gray-200 bg-gray-100 text-gray-400 rounded-l-md cursor-not-allowed">&laquo; Précédent</span>
        <?php endif; ?>
        <span class="px-4 py-2 border-t border-b border-gray-300 bg-white text-gray-700 font-semibold">Page <?= $page ?> / <?= $totalPages ?></span>
        <?php if ($page < $totalPages): ?>
          <a href="<?= $baseUrl . '&p=' . ($page + 1) ?>" class="px-3 py-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-100 rounded-r-md">Suivant &raquo;</a>
        <?php else: ?>
          <span class="px-3 py-2 border border-gray-200 bg-gray-100 text-gray-400 rounded-r-md cursor-not-allowed">Suivant &raquo;</span>
        <?php endif; ?>
      </nav>
    </div>
  </main>
</div>

</body>
</html>
