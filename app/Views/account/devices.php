<h2>🌐 Dispositivi recenti</h2>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Dispositivo</th>
            <th>IP</th>
            <th>User Agent</th>
            <th>Ultimo accesso</th>
            <th>Stato</th>
            <th>Posizione</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($devices as $d): ?>
            <tr>
                <td><?= htmlspecialchars($d->device_info) ?></td>
                <td><?= htmlspecialchars($d->ip_address) ?></td>
                <td><small><?= htmlspecialchars($d->user_agent) ?></small></td>
                <td><?= date('d/m/Y H:i', strtotime($d->last_login)) ?></td>
                <td>
                    <?= $d->is_current
                        ? '<span class="badge bg-success">Attuale</span>'
                        : '<span class="text-muted">Precedente</span>' ?>
                </td>
                <td><?= htmlspecialchars($d->location ?? '—') ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

