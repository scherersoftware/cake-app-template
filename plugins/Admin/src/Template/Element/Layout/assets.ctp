<?php
use Cake\Core\Configure;

echo $this->AssetCompress->css('admin_styles.css', [
    'raw' => Configure::read('AssetCompress.rawMode')
]);
echo $this->fetch('meta');
echo $this->fetch('css');

$this->FrontendBridge->init($frontendData);
echo $this->FrontendBridge->getNamespaceDefinitions();
echo $this->FrontendBridge->getAppDataJs();
echo $this->AssetCompress->script('admin_scripts.js', [
    'raw' => Configure::read('AssetCompress.rawMode')
]);
echo $this->fetch('script');
