<div class="container" style="margin-top: 50px">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h4 class="form-header text-center"><?= __('login.forgot_password') ?></h4>
            <div class="login-panel panel panel-default">
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
