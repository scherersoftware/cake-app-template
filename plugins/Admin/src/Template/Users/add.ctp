<?php
use App\Model\Entity\User;

$this->assign('title', __('users.add.title'));

?>
<h1 class="page-header">
    <?= __('users.add.title') ?>
    <div class="pull-right">
        <?= $this->ListFilter->backToListButton() ?>
    </div>
</h1>

<?= $this->Form->create($user, ['align' => 'horizontal']) ?>
<fieldset>
    <?= $this->element('../Users/form') ?>
    <hr>
</fieldset>
<?= $this->CkTools->formButtons(['useReferer' => true]) ?>
<?= $this->Form->end() ?>
