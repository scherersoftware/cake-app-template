<?php
use App\Model\Entity\User;
?>

<div class="box-body">
    <?= $this->Form->create($user, ['align' => 'horizontal', 'novalidate']); ?>
    <fieldset>
        <?php
            echo $this->Form->control('status', [
                'label' => __('user.status'),
                'options' => User::getStatuses()
            ]);
            echo $this->Form->control('role', [
                'label' => __('user.role'),
                'options' => User::getRoles()
            ]);
            echo $this->Form->control('firstname', ['label' => __('user.firstname')]);
            echo $this->Form->control('lastname', ['label' => __('user.lastname')]);
            echo $this->Form->control('email', ['label' => __('user.email')]);
            echo $this->Form->control('password', ['label' => __('user.password')]);
        ?>
        <?=
            $this->Attachments->attachmentsArea($user, [
                'label' => __('user.attachments'),
                'formFieldName' => 'attachment_uploads',
            ]);
        ?>
    </fieldset>
    <?= $this->CkTools->formButtons() ?>
    <?= $this->Form->end() ?>
</div>
