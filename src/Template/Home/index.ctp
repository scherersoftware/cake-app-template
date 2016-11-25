<?php
    $this->assign('bodyClasses', 'demo-page');
?>
<div class="row">
    <div class="col-lg-12">
        <h1>
            Demos
            <div class="pull-right">
                <?=
                    $this->Html->link('Go to the Login-Page', [
                        'controller' => 'Login',
                        'action' => 'login'
                    ], [
                        'class' => 'btn btn-default'
                    ]);
                ?>
            </div>
        </h1>

        <div class="box box-danger">
            <div class="box-header">
                <h3 class="box-title">Reminder!</h3>
            </div>
            <div class="box-body">
                <p>
                    To ensure that you're able to login, run the following SQL-Statement. This will set the password for the default user to <code>password</code>.
                    <br>
                    This is neccesarry, as the <code>security salt</code> is generated after <code>composer install</code>.
                </p>
                <pre>UPDATE users SET password = "<?= (new \Cake\Auth\DefaultPasswordHasher)->hash('password'); ?>" WHERE email = "john.doe@example.com";</pre>
            </div>
        </div>

        <h2>Glide-resized Image</h2>

        <?= $this->Glide->image('cakephp_hero.png', ['h' => 50]) ?>

        <h2>FrontendBridge</h2>

        <p>See webroot/js/app/controllers/home/index_controller.js for explanations</p>

        <h3>Pass Variables from a CakePHP controller action to its JS Controller equivalent</h3>

        <strong>Test:</strong> <span class="set-json-demo"></span>

        <h3>AJAX JSON Requests</h3>

        <a class="btn btn-default ajax-json-demo">Click me</a>

        <h3>jsonAction Requests</h3>

        <p>Allows to load CakePHP-rendered views including all FrontendBridge-JS-related functionality.</p>

        <a class="btn btn-default json-action-demo">Click me</a>

        <div class="render-target"></div>

        <h3>Form Components</h3>

        <?php

        function renderInputs($view) {
            echo $view->Form->input('start_date', [
                'type' => 'date',
                'label' => 'Date'
            ]);
            echo $view->Form->input('static', [
                'type' => 'staticControl',
                'value' => 'Static Value'
            ]);
            echo $view->Form->input('standard_text');
            echo $view->Form->input('prepended_text', [
                'prepend' => 'prepend'
            ]);
            echo $view->Form->input('appended_text', [
               'append' => 'append'
            ]);
            echo $view->Form->input('prepended_and_appended_text', [
               'append' => 'append',
               'prepend' => 'prepend'
            ]);
            echo $view->Form->input('select', [
               'options' => [
                   'one', 'two', 'three'
               ]
            ]);
           echo $view->Form->input('multi_select', [
              'multiple' => true,
              'options' => [
                  'one', 'two', 'three'
              ]
           ]);
            echo $view->Form->input('selectize', [
                'options' => [
                    'one', 'two', 'three'
                ],
                'class' => 'selectize'
            ]);
            echo $view->Form->input('selectize_multi', [
                'multiple' => true,
                'options' => [
                    'one', 'two', 'three'
                ],
                'class' => 'selectize'
            ]);
            echo $view->Form->input('multi_checkboxes', [
               'multiple' => 'checkbox',
               'options' => [
                   'one', 'two', 'three'
               ]
            ]);
            echo $view->Form->input('published', [
               'type' => 'radio',
               'options' => ['Yes', 'No']
            ]);
            echo $view->Form->input('checkbox', [
                'type' => 'checkbox',
            ]);
            echo $view->Form->input('textarea', [
                'type' => 'textarea',
            ]);
            echo $view->CkTools->formButtons();
        }
        ?>

        <div class="box box-default">
            <div class="box-body">
                <fieldset>
                <legend>Horizontal form</legend>
                    <?php
                    echo $this->Form->create(null, [
                        'align' => 'horizontal'
                    ]);
                    renderInputs($this);
                    echo $this->Form->end();
                    ?>
                </fieldset>
            </div>
        </div>
        <hr>
        <div class="box box-default">
            <div class="box-body">
                <fieldset>
                <legend>Standard form</legend>
                    <?php
                    echo $this->Form->create(null);
                    renderInputs($this);
                    echo $this->Form->end();
                ?>
                </fieldset>
            </div>
        </div>
    </div>
</div>
