<?php
use App\Model\Entity\User;

$this->assign('title', __('users.view.title'));
?>

<div class="users view box">
    <div class="box-header with-border">
        <h3 class="box-title">
            <?= __('users.view.title') ?>
        </h3>
        <div class="box-tools pull-right">
            <?= $this->CkTools->editButton($user) ?>
            <?= $this->ListFilter->backToListButton() ?>
        </div>
    </div>
    <div class="box-body">
        <dl class="dl dl-horizontal">
            <dt><?= __('user.firstname') ?></dt>
            <dd><?= h($user->firstname) ?></dd>

            <dt><?= __('user.lastname') ?></dt>
            <dd><?= h($user->lastname) ?></dd>

            <dt><?= __('user.status') ?></dt>
            <dd><?= $this->Utils->statusLabel($user->status) ?></dd>

            <dt><?= __('user.email') ?></dt>
            <dd><?= h($user->email) ?></dd>

            <dt><?= __('user.role') ?></dt>
            <dd><?= $this->Utils->roleLabel($user->role) ?></dd>

            <dt><?= __('user.failed_login_count') ?></dt>
            <dd><?= $this->Number->format($user->failed_login_count) ?></dd>
        </dl>
    </div>
</div>
