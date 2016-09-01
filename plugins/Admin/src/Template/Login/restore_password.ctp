<div class="container" style="margin-top: 50px">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">

            <h4 class="form-header text-center"><?= __('login.new_password') ?></h4>

            <div class="login-panel panel panel-default">

                <div class="panel-body">
                    <fieldset>
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
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</div>
