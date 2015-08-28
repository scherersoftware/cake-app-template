<?php
$this->layout = 'Admin.plain';

?>

<div class="container" style="margin-top: 50px">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <h4 class="form-header text-center"><?= __('login.please_login') ?></h4>
            <div class="login-panel panel panel-default">
                <div class="panel-body">
                    <fieldset>
                        <?php
                        echo $this->Form->create($user, [
                            'novalidate'
                        ]);
                        echo $this->Form->input('email', [
                            'placeholder' => __('user.email'),
                            'class' => 'form-control autofocus',
                            'label' => false
                        ]);
                        echo $this->Form->input('password', [
                            'placeholder' => __('user.password'),
                            'label' => false
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
                    </fieldset>
                    <br>
                    <?= $this->Html->link(__('login.forgot_password'), ['plugin' => false, 'action' => 'forgot-password']) ?>
                </div>
            </div>
        </div>
    </div>
</div>



