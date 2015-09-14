<?php
use App\Lib\Status;
use App\Model\Entity\User;

?>

<h1 class="page-header">
    <?= __('users') ?>
    <div class="pull-right">
        <?= $this->CkTools->addButton(__('users.add')) ?>
    </div>
</h1>

<?= $this->ListFilter->renderFilterbox() ?>

<div class="users index">
    <div class="table-responsive">
        <table class="table table-striped">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('firstname', __('user.firstname')) ?></th>
                <th><?= $this->Paginator->sort('lastname', __('user.lastname')) ?></th>
                <th><?= $this->Paginator->sort('email', __('user.email')) ?></th>
                <th><?= $this->Paginator->sort('status', __('user.status')) ?></th>
                <th><?= $this->Paginator->sort('role', __('user.role')) ?></th>
                <th class="actions"><?= __('lists.actions') ?></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= h($user->firstname) ?></td>
                <td><?= h($user->lastname) ?></td>
                <td><?= h($user->email) ?></td>
                <td><?= $this->Utils->statusLabel($user->status) ?></td>
                <td><?= User::getTypeDescription($user->role) ?></td>
                <td class="actions">
                    <?= $this->CkTools->viewButton($user) ?>
                    <?= $this->CkTools->editButton($user) ?>
                    <?= $this->CkTools->deleteButton($user, ['usePostLink' => true]) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        </table>
    </div>
	<?= $this->Paginator->numbers() ?>
</div>