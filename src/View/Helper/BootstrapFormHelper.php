<?php
namespace App\View\Helper;

use Cake\Utility\Hash;
use Cake\View\View;

/**
 * Wrapper class for BootstrapUI's FormHelper to modify some of the default templates
 *
 * @package default
 */
class BootstrapFormHelper extends \BootstrapUI\View\Helper\FormHelper
{

    /**
     * Construct the widgets and binds the default context providers.
     *
     * @param \Cake\View\View $View The View this helper is being attached to.
     * @param array $config Configuration settings for the helper.
     */
    public function __construct(View $View, array $config = [])
    {
        // adding {{type}} class to the form group divs
        $this->_templates = Hash::merge($this->_templates, [
            'inputContainer' => '<div class="form-group {{type}}{{required}}">{{content}}{{help}}</div>',
            'inputContainerError' => '<div class="form-group {{type}}{{required}} has-error">{{content}}{{error}}{{help}}</div>',
        ]);
        $this->_templateSet = Hash::merge($this->_templateSet, [
            'horizontal' => [
                'inputContainer' => '<div class="form-group {{type}}{{required}}">{{content}}</div>',
                'inputContainerError' => '<div class="form-group {{type}}{{required}} has-error">{{content}}</div>',
            ]
        ]);
        parent::__construct($View, $config);
    }
}
