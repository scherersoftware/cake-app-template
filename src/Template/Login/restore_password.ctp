<?php
$this->assign('bodyClasses', 'login-page');
?>

<div class="login-box">
    <div class="login-logo">
        <a href="<?= $this->Url->build(['controller' => 'dashboard', 'action' => 'index']) ?>"><b>scherer</b>software</a>
    </div>
    <div class="login-box-body">
        <?= $this->Flash->render() ?>
        <p class="login-box-msg"><?= __('login.new_password') ?></p>
        <p>
            <?= __('restore_password_text') ?>
        </p>
        <?php
            echo $this->Form->create($user, [
                'role' => 'form',
                'novalidate'
            ]);
            echo $this->Form->input('password', [
                'placeholder' => __('login.new_password'),
                'class' => 'form-control autofocus',
                'label' => false,
                'type' => 'password',
                'value' => ''
            ]);
            echo $this->Form->input('password_confirm', [
                'placeholder' => __('login.confirm_new_password'),
                'label' => false,
                'type' => 'password'
            ]);
            echo $this->Form->submit(__('login.set_password'), [
                'class' => 'btn btn-lg btn-primary btn-block'
            ]);
            echo $this->Form->end();
        ?>
    </div>
</div>
