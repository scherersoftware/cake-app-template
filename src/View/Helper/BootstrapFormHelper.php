<?php
declare(strict_types = 1);
namespace App\View\Helper;

use BootstrapUI\View\Helper\FormHelper;
use Cake\Utility\Hash;
use Cake\View\View;

/**
 * Wrapper class for BootstrapUI's FormHelper to modify some of the default behavior
 *
 * @package default
 * @property \Cake\View\Helper\UrlHelper $Url
 * @property \Cake\View\Helper\HtmlHelper $Html
 */
class BootstrapFormHelper extends FormHelper
{

    /**
     * Construct the widgets and binds the default context providers.
     *
     * @param \Cake\View\View $View The View this helper is being attached to.
     * @param string:mixed[] $config Configuration settings for the helper.
     */
    public function __construct(View $View, array $config = [])
    {
        $config = Hash::merge($config, [
            'grid' => [
                'left' => 3,
                'middle' => 6,
                'right' => 3
            ],
        ]);

        parent::__construct($View, $config);
    }

    /**
     * Returns an HTML FORM element.
     *
     * @param mixed $model The context for which the form is being defined. Can
     *   be an ORM entity, ORM resultset, or an array of meta data. You can use false or null
     *   to make a model-less form.
     * @param string:mixed[] $options An array of html attributes and options.
     * @return string An formatted opening FORM tag.
     */
    public function create($model = null, array $options = []): string
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
     * @param string:mixed[] $options Options
     * @return string
     */
    public function colorPickerInput(string $field, array $options = []): string
    {
        $options = Hash::merge([
            'append' => '<i></i>',

        ], $options);

        $oldInputGroupContainer = $this->getConfig('templates.inputGroupContainer');
        $inputGroupContainer = str_replace('input-group', 'input-group colorpicker-component', $oldInputGroupContainer);

        $this->setTemplates([
            'inputGroupContainer' => $inputGroupContainer
        ]);

        $input = parent::control($field, $options);

        $this->setTemplates([
            'inputGroupContainer' => $oldInputGroupContainer
        ]);

        return $input;
    }

    /**
     * {@inheritDoc}
     *
     * @param string:mixed[] $options Options
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     */
    public function error($field, $text = null, array $options = []): string
    {
        $parts = explode('.', $field);

        if ($this->context() instanceof \Cake\View\Form\EntityContext
            && count($parts) > 1
            && (is_array($this->context()->entity()->get($parts[0])) || $this->request->getData($parts[0]) !== null)
        ) {
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
