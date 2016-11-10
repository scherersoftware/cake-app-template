<?php
    use App\Lib\Status;
    use App\Model\Entity\User;

    $this->Utils->contentHeader(__('users'), [
        'backToListButton' => false,
        'actions' => [
            $this->CkTools->addButton(__('users.add'))
        ]
    ]);
?>

<?= $this->AdminLteListFilter->renderFilterbox() ?>

<div class="users index">
    <div class="box">
        <div class="box-body">
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
                                    <?php if($user->status !== Status::DELETED): ?>
                                        <?= $this->CkTools->deleteButton($user, ['usePostLink' => true]) ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
	<?= $this->Paginator->numbers() ?>
</div>