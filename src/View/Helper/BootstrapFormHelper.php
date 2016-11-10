<?php
namespace App\View\Helper;

use Cake\Utility\Hash;
use Cake\View\View;

/**
 * Wrapper class for BootstrapUI's FormHelper to modify some of the default behavior
 *
 * @package default
 */
class BootstrapFormHelper extends \BootstrapUI\View\Helper\FormHelper
{

    /**
     * {@inheritDoc}
     */
    public function create($model = null, array $options = [])
    {
        if (!isset($options['novalidate'])) {
            $options['novalidate'] = true;
        }
        return parent::create($model, $options);
    }

    /**
     * Renders a field suitable for bootstrap-colorpicker
     *
     * @param string $field Field name
     * @param array $options Options
     * @return string
     */
    public function colorPickerInput($field, array $options = [])
    {
        $options = Hash::merge([
            'append' => '<i></i>',

        ], $options);

        $oldInputGroupContainer = $this->config('templates.inputGroupContainer');
        $inputGroupContainer = str_replace('input-group', 'input-group colorpicker-component', $oldInputGroupContainer);

        $this->templates([
            'inputGroupContainer' => $inputGroupContainer
        ]);

        $input = parent::input($field, $options);

        $this->templates([
            'inputGroupContainer' => $oldInputGroupContainer
        ]);
        return $input;
    }

    /**
     * Workaround for not supported display of nested errors
     *
     * @param string $field Field Name
     * @param string $text Text
     * @param array $options Options
     * @return string
     */
    public function error($field, $text = null, array $options = [])
    {
        $parts = explode('.', $field);

        if ($this->context() instanceof \Cake\View\Form\EntityContext
            && count($parts) > 1
            && (is_array($this->context()->entity()->get($parts[0])) || isset($this->request->data[$parts[0]]))) {
            $errors = $this->context()->entity()->errors();
            if (Hash::check($errors, $field)) {
                $error = Hash::extract($errors, $field);
                if (is_array($error)) {
                    if (count($error) > 1) {
                        $errorText = [];
                        foreach ($error as $err) {
                            $errorText[] = $this->formatTemplate('errorItem', ['text' => $err]);
                        }
                        $error = $this->formatTemplate('errorList', [
                            'content' => implode('', $errorText)
                        ]);
                    } else {
                        $error = array_pop($error);
                    }
                }
                return $this->formatTemplate('error', ['content' => $error]);
            }
        }
        return parent::error($field, $text, $options);
    }
}
