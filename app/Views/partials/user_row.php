
<tr>
  <td><?= $user->id ?></td>
  <td>
    <?php if ($user->avatar): ?>
      <img src="/storage/avatars/<?= e($user->avatar) ?>" width="40" class="rounded-circle" alt="avatar">
    <?php else: ?>
      <span class="text-muted">N/D</span>
    <?php endif; ?>
  </td>
  <td><?= e($user->firstname) ?> <?= e($user->lastname) ?></td>
  <td><?= e($user->email) ?></td>
  <td><?= ucfirst($user->role) ?></td>
  <td>
    <span class="badge <?= $user->is_active ? 'bg-success' : 'bg-danger' ?>">
      <?= $user->is_active ? __('active') : __('deactivated') ?>
    </span>
  </td>
  <td>
    <a href="/admin/users/edit/<?= $user->id ?>" class="btn btn-sm btn-primary"><?= __('edit')?></a>
    <a href="/admin/users/profile/<?= $user->id ?>" class="btn btn-sm btn-secondary"><?= __('profile')?></a>
  </td>
</tr>

