<?php
$this->assign('bodyClasses', 'login-page');
?>

<div class="login-box">
    <div class="login-logo">
        <a href="<?= $this->Url->build(['controller' => 'dashboard', 'action' => 'index']) ?>"><b>scherer</b>software</a>
    </div>
    <div class="login-box-body">
        <?= $this->Flash->render() ?>
        <p class="login-box-msg"><?= __('login.forgot_password') ?></p>
        <p>
            <?= __('restore_password_text') ?>
        </p>
        <?php
            echo $this->Form->create(null, [
                'role' => 'form',
                'novalidate'
            ]);
            echo $this->Form->input('email', [
                'placeholder' => __('login.email'),
                'class' => 'form-control autofocus',
                'label' => false
            ]);
            echo $this->Form->submit(__('login.restore_password'), [
                'class' => 'btn btn-lg btn-primary btn-block'
            ]);
            echo $this->Form->end();
        ?>
        <div class="social-auth-links text-center">
            <p>- <?= __('login.or') ?> -</p>
            <?= $this->Html->link(__('login.login'), ['plugin' => null, 'controller' => 'login', 'action' => 'login']) ?><br>
        </div>
    </div>
</div>
