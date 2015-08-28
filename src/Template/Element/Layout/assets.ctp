<?php
use Cake\Core\Configure;
use App\Lib\Environments;

echo $this->AssetCompress->css('styles.css', [
    'raw' => Configure::read('AssetCompress.rawMode')
]);
echo $this->fetch('meta');
echo $this->fetch('css');

$this->FrontendBridge->init($frontendData);
echo $this->FrontendBridge->getNamespaceDefinitions();
echo $this->FrontendBridge->getAppDataJs();
echo $this->AssetCompress->script('scripts.js', [
    'raw' => Configure::read('AssetCompress.rawMode')
]);
echo $this->fetch('script');
