
<h1 class="page-header">
    <?= __('users.add') ?>
    <div class="pull-right">
        <?= $this->CkTools->viewButton($user) ?>
        <?= $this->ListFilter->backToListButton() ?>
    </div>
</h1>

<?= $this->element('../Users/form') ?>

<div class="users form">
    <?= $this->Form->create($user, ['align' => 'horizontal', 'novalidate']); ?>
    <fieldset>
        <?php
            echo $this->Form->input('status', ['label' => __('user.status')]);
            echo $this->Form->input('role', ['label' => __('user.role')]);
            echo $this->Form->input('firstname', ['label' => __('user.firstname')]);
            echo $this->Form->input('lastname', ['label' => __('user.lastname')]);
            echo $this->Form->input('email', ['label' => __('user.email')]);
            echo $this->Form->input('password', ['label' => __('user.password')]);
            echo $this->Form->input('failed_login_count', ['label' => __('user.failed_login_count')]);
            echo $this->Form->input('failed_login_timestamp', ['label' => __('user.failed_login_timestamp')]);
        ?>
    </fieldset>
    <?= $this->CkTools->formButtons() ?>
    <?= $this->Form->end() ?>
</div>
