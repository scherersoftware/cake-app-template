<?php
use App\Model\Entity\User;

$this->assign('title', __('users.edit.title'));

?>
<h1 class="page-header">
    <?= __('users.edit.title') ?>
    <div class="pull-right">
        <?= $this->CkTools->button(__('back_to_details'), [
            'action' => 'view',
            $user->id
        ], [
            'icon' => 'arrow-left'
        ]) ?>
    </div>
</h1>


<?= $this->Form->create($user, ['align' => 'horizontal']) ?>

<?= $this->element('../Users/form', [
    'edit' => true
]) ?>

<?= $this->CkTools->formButtons(['useReferer' => true]) ?>
<?= $this->Form->end(); ?>
