<?php
$this->TinyMce->includeAssets();

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
    echo $view->Form->input('textarea_' . rand(), [
        'type' => 'textarea',
        'class' => 'tinymce'
    ]);
    echo $view->TinyMce->picker('logo_' . rand());
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
