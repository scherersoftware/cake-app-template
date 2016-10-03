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
        $options['novalidate'] = true;

        return parent::create($model, $options);
    }
}
