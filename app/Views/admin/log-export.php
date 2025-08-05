<!-- app/Views/admin/logs/export.php -->
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Log Sicurezza - <?= htmlspecialchars($date) ?></title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h2>Log Sicurezza - <?= date('d/m/Y H:i:s') ?></h2>

    <table>
        <thead>
            <tr>
                <th>Timestamp</th>
                <th>Livello</th>
                <th>Messaggio</th>
                <th>IP</th>
                <th>User</th>
                <th>User-Agent</th>
                <th>File</th>
                <th>Linea</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $log): ?>
                <tr>
                    <td><?= htmlspecialchars($log['timestamp'] ?? '') ?></td>
                    <td><?= htmlspecialchars($log['level'] ?? '') ?></td>
                    <td><?= htmlspecialchars($log['message'] ?? '') ?></td>
                    <td><?= htmlspecialchars($log['ip'] ?? '') ?></td>
                    <td><?= htmlspecialchars($log['user'] ?? '') ?></td>
                    <td><?= htmlspecialchars($log['user_agent'] ?? '') ?></td>
                    <td><?= htmlspecialchars($log['file'] ?? '') ?></td>
                    <td><?= htmlspecialchars($log['line'] ?? '') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p style="margin-top: 30px;">Generato automaticamente da Registration - <?= date('d/m/Y H:i') ?></p>
</body>
</html>

