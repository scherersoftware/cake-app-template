<?php
    use App\Lib\Status;
    use App\Model\Entity\User;
    use Cake\Routing\Router;

    $this->assign('title', __('users.edit.title'));
?>

<div class="users form box">
    <div class="box-header with-border">
        <h3 class="box-title">
            <?= __('users.edit.title') ?>
        </h3>
        <div class="box-tools pull-right">
            <div class="pull-right">
                <?= $this->CkTools->viewButton($user) ?>
                <?php if($user->status !== Status::DELETED && $this->Auth->user('id') !== $user->id) : ?>
                    <?= $this->CkTools->deleteButton($user, ['usePostLink' => true]) ?>
                <?php endif; ?>
                <?= $this->ListFilter->backToListButton(null, ['action' => 'view', $user->id]) ?>
            </div>
        </div>
    </div>
    <?= $this->element('../Users/form') ?>
</div>
