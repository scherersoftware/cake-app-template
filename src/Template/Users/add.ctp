<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', __('users.add.title'));
?>

<div class="users form box">
    <div class="box-header with-border">
        <h3 class="box-title">
            <?= __('users.add.title') ?>
        </h3>
        <div class="box-tools pull-right">
            <div class="pull-right">
                <?= $this->ListFilter->backToListButton() ?>
            </div>
        </div>
    </div>
    <?= $this->element('Forms/user_form') ?>
</div>
