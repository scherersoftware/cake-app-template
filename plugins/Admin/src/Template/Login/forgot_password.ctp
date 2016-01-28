<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= __('login.forgot_password') ?></h3>
                </div>
                <div class="panel-body">
                    <p>
                        <?= __('restore_password_text') ?>
                    </p>
                    <fieldset>
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
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</div>
