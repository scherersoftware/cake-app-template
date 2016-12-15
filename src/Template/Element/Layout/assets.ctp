<?php
use Cake\Core\Configure;
use App\Lib\Environments;

echo $this->Html->css('/vendors/bower_components/font-awesome/css/font-awesome.min.css');
echo $this->Html->css('/vendors/bower_components/source-sans-pro/css/source-sans-pro.min.css');

echo $this->AssetCompress->css('styles.css', [
    'raw' => Configure::read('AssetCompress.rawMode')
]);
echo $this->fetch('meta');

echo $this->Html->css('skins/' . $this->fetch('adminLTETheme') . '.css');

echo $this->fetch('css');

$this->FrontendBridge->init($frontendData);
echo $this->FrontendBridge->getNamespaceDefinitions();
echo $this->FrontendBridge->getAppDataJs();
echo $this->AssetCompress->script('scripts.js', [
    'raw' => Configure::read('AssetCompress.rawMode')
]);
echo $this->fetch('script');
