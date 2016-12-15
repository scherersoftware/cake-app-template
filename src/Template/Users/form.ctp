<?php
use App\Model\Entity\User;
?>

<div class="box-body">
    <?= $this->Form->create($user, ['align' => 'horizontal', 'novalidate']); ?>
    <fieldset>
        <?php
            echo $this->Form->input('status', [
                'label' => __('user.status'),
                'options' => User::getStatuses()
            ]);
            echo $this->Form->input('role', [
                'label' => __('user.role'),
                'options' => User::getRoles()
            ]);
            echo $this->Form->input('firstname', ['label' => __('user.firstname')]);
            echo $this->Form->input('lastname', ['label' => __('user.lastname')]);
            echo $this->Form->input('email', ['label' => __('user.email')]);
            echo $this->Form->input('password', ['label' => __('user.password')]);
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
