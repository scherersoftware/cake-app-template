<?php
use App\Lib\Environment;
$this->assign('bodyClasses', 'login-page');
?>

<div class="login-box">
    <div class="login-logo">
        <a href="<?= $this->Url->build(['controller' => 'dashboard', 'action' => 'index']) ?>"><b>scherer</b>software</a>
    </div>
    <div class="login-box-body">
        <?= $this->Flash->render() ?>
        <p class="login-box-msg"><?= __('login.please_login') ?></p>
        <?php
            echo $this->Form->create($user);
            echo $this->Form->input('email', [
                'placeholder' => __('user.email'),
                'class' => 'form-control autofocus',
                'label' => false,
            ]);
            echo $this->Form->input('password', [
                'placeholder' => __('user.password'),
                'label' => false,
            ]);
            echo $this->Form->input('cookie', [
                'type' => 'checkbox',
                'label' => __('login.login_for_two_weeks'),
            ]);
            echo $this->Form->submit(__('login.login'), [
                'class' => 'btn btn-lg btn-primary btn-block'
            ]);
            echo $this->Form->end();
        ?>
        <div class="social-auth-links text-center">
            <p>- <?= __('login.or') ?> -</p>
            <?= $this->Html->link(__('login.forgot_password'), ['plugin' => null, 'controller' => 'login', 'action' => 'forgot-password']) ?><br>
        </div>
        <?php if (ENVIRONMENT === Environment::DEVELOPMENT) : ?>
            <hr>
            <dl>
                <dt><?= __('user.email') ?></dt>
                <dd><code>john.doe@example.com</code></dd>
                <dt><?= __('user.password') ?></dt>
                <dd><code>password</code></dd>
            </dl>
        <?php endif; ?>
    </div>
</div>

