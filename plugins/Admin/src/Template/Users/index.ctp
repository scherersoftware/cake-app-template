<?php
use Cake\Core\Configure;

$this->assign('title', __('users.index.title'));

?>
<h1 class="page-header">
    <?= __('users.index.title') ?>
    <div class="pull-right">
        <?= $this->CkTools->addButton() ?>
    </div>
</h1>

<?= $this->ListFilter->renderFilterbox(); ?>

<?php if ($users->count() == 0): ?>
    <div class="alert alert-info">
        <?= __('users.no_users_found') ?>
    </div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('forename', __('user.name')) ?></th>
                    <th><?= $this->Paginator->sort('email', __('user.email')) ?></th>
                    <th><?= $this->Paginator->sort('role', __('user.role')) ?></th>
                    <th><?= $this->Paginator->sort('status', __('user.status')) ?></th>
                    <th><?= $this->Paginator->sort('created', __('user.created')) ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr class="<?php if ($user->failed_login_count >= Configure::read('Authentication.max_login_retries')): ?>warning<?php endif; ?>">
                        <td><?= $user->full_name ?></td>
                        <td><?= $user->email ?></td>
                        <td><?= $user::getTypeDescription($user->role) ?></td>
                        <td><?= $this->Utils->statusLabel($user->status) ?></td>
                        <td><?= $this->Time->nice($user->created) ?></td>
                        <td>
                            <?= $this->CkTools->viewButton($user) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?= $this->Paginator->numbers() ?>
    </div>
<?php endif; ?>
