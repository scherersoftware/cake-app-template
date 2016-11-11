<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\View;

use Cake\View\View;

/**
 * Application View
 *
 * Your application’s default view class
 *
 * @link http://book.cakephp.org/3.0/en/views.html#the-app-view
 */
class AppView extends View
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading helpers.
     *
     * e.g. `$this->loadHelper('Html');`
     *
     * @return void
     */
    public function initialize()
    {
        $this->loadHelper('Html', [
            'className' => 'BootstrapUI.Html'
        ]);
        $this->loadHelper('Form', [
            'className' => 'BootstrapForm'
        ]);
        $this->loadHelper('Paginator', [
            'className' => 'BootstrapUI.Paginator'
        ]);
        $this->loadHelper('Flash', [
            'className' => 'BootstrapUI.Flash'
        ]);
        $this->loadHelper('Auth', [
            'className' => 'AuthActions.Auth'
        ]);
        $this->loadHelper('ADmad/Glide.Glide', [
            'baseUrl' => '/images/',
            'secureUrls' => true,
        ]);
        $this->loadHelper('AdminLteListFilter');
        $this->loadHelper('AssetCompress.AssetCompress');
        $this->loadHelper('FrontendBridge.FrontendBridge');
        $this->loadHelper('ModelHistory.ModelHistory');
        $this->loadHelper('CkTools.CkTools');
        $this->loadHelper('ListFilter.ListFilter');
        $this->loadHelper('AssetCompress.AssetCompress');
        $this->loadHelper('Attachments.Attachments');
        $this->loadHelper('CkTools.Menu');
    }
}
