<?php
    use App\Lib\Status;
    use App\Model\Entity\User;
?>

<?= $this->AdminLteListFilter->renderFilterbox() ?>

<div class="users index">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">
                <?= __('users.index.title') ?>
            </h3>
            <div class="box-tools pull-right">
                <?= $this->CkTools->addButton(__('users.add'), [
                    'class' => 'btn btn-default btn-add btn-xs'
                ]) ?>
            </div>
        </div>
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
                            <th class="actions text-right"><?= __('lists.actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= h($user->firstname) ?></td>
                                <td><?= h($user->lastname) ?></td>
                                <td><?= h($user->email) ?></td>
                                <td><?= $this->Utils->statusLabel($user->status) ?></td>
                                <td><?= $this->Utils->roleLabel($user->role) ?></td>
                                <td class="actions text-right">
                                    <?= $this->CkTools->viewButton($user) ?>
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