<?php
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

    <?= $this->element('../Users/form') ?>

</div>
