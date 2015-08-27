<?php

function renderInputs($view) {
    echo $view->Form->input('start_date', [
        'type' => 'date',
        'label' => 'Date'
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
    echo $view->Form->input('chosen', [
        'options' => [
            'one', 'two', 'three'
        ],
        'class' => 'chosen'
    ]);
    echo $view->Form->input('chosen_multi', [
        'multiple' => true,
        'options' => [
            'one', 'two', 'three'
        ],
        'class' => 'chosen'
    ]);
    echo $view->Form->input('multi_select', [
       'multiple' => true,
       'options' => [
           'one', 'two', 'three'
       ]
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


}
?>

<fieldset>
<legend>Standard form</legend>
    <?php
    echo $this->Form->create(null);
    renderInputs($this);
    echo $this->Form->end();
?>
</fieldset>


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
