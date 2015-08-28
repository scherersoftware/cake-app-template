<?php
use App\Model\Entity\User;

?>

<div class="users form">
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
            echo $this->Form->input('password_confirm', ['label' => __('user.password_confirm'), 'type' => 'password']);
        ?>
    </fieldset>
    <?= $this->CkTools->formButtons() ?>
    <?= $this->Form->end() ?>
</div>
