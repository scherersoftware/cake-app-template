<?php

use App\Lib\Environment;
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;

if (!Configure::read('debug')):
    throw new NotFoundException('Please replace src/Template/Pages/home.ctp with your own version.');
endif;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cake App Template</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <?= $this->Html->css('demo'); ?>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <?= $this->Html->image('scherer-software.png', [
                        'class' => 'img-responsive',
                        'srcset' => '/img/scherer-software.png 1x, /img/scherer-software@2x.png 2x, /img/scherer-software@3x.png 3x'
                    ]) ?>
                    <h1>
                        Cake App Template
                    </h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    Please be aware that this page will not be shown if you turn off debug mode unless you replace src/Template/Home/index.ctp with your own version.
                </div>
                <?php Debugger::checkSecurityKeys(); ?>
            </div>
            <div class="row checks">
                <div class="col-lg-12">
                    <h4>Environment</h4>
                    <?php if (version_compare(PHP_VERSION, '7.0.0', '>=')): ?>
                        <p ><i class="fa fa-check" aria-hidden="true"></i> Your version of PHP is 7.0.0 or higher (detected <?= PHP_VERSION ?>).</p>
                    <?php else: ?>
                        <p ><i class="fa fa-times" aria-hidden="true"></i> Your version of PHP is too low. You need PHP 7.0.0 or higher to use CakePHP (detected <?= PHP_VERSION ?>).</p>
                    <?php endif; ?>

                    <?php if (extension_loaded('mbstring')): ?>
                        <p ><i class="fa fa-check" aria-hidden="true"></i> Your version of PHP has the mbstring extension loaded.</p>
                    <?php else: ?>
                        <p ><i class="fa fa-times" aria-hidden="true"></i> Your version of PHP does NOT have the mbstring extension loaded.</p>;
                    <?php endif; ?>

                    <?php if (extension_loaded('openssl')): ?>
                        <p ><i class="fa fa-check" aria-hidden="true"></i> Your version of PHP has the openssl extension loaded.</p>
                    <?php elseif (extension_loaded('mcrypt')): ?>
                        <p ><i class="fa fa-check" aria-hidden="true"></i> Your version of PHP has the mcrypt extension loaded.</p>
                    <?php else: ?>
                        <p ><i class="fa fa-times" aria-hidden="true"></i> Your version of PHP does NOT have the openssl or mcrypt extension loaded.</p>
                    <?php endif; ?>

                    <?php if (extension_loaded('intl')): ?>
                        <p ><i class="fa fa-check" aria-hidden="true"></i> Your version of PHP has the intl extension loaded.</p>
                    <?php else: ?>
                        <p ><i class="fa fa-times" aria-hidden="true"></i> Your version of PHP does NOT have the intl extension loaded.</p>
                    <?php endif; ?>
                    <hr>

                    <h4>Filesystem</h4>
                    <?php if (is_writable(TMP)): ?>
                        <p ><i class="fa fa-check" aria-hidden="true"></i> Your tmp directory is writable.</p>
                    <?php else: ?>
                        <p ><i class="fa fa-times" aria-hidden="true"></i> Your tmp directory is NOT writable.</p>
                    <?php endif; ?>

                    <?php if (is_writable(LOGS)): ?>
                        <p ><i class="fa fa-check" aria-hidden="true"></i> Your logs directory is writable.</p>
                    <?php else: ?>
                        <p ><i class="fa fa-times" aria-hidden="true"></i> Your logs directory is NOT writable.</p>
                    <?php endif; ?>

                    <?php $settings = Cache::config('_cake_core_'); ?>
                    <?php if (!empty($settings)): ?>
                        <p ><i class="fa fa-check" aria-hidden="true"></i> The <em><?= $settings['className'] ?>Engine</em> is being used for core caching. To change the config edit config/app.php</p>
                    <?php else: ?>
                        <p ><i class="fa fa-times" aria-hidden="true"></i> Your cache is NOT working. Please check the settings in config/app.php</p>
                    <?php endif; ?>

                    <hr>
                    <h4>Database</h4>
                    <?php
                        try {
                            $connection = ConnectionManager::get('default');
                            $connected = $connection->connect();
                        } catch (Exception $connectionError) {
                            $connected = false;
                            $errorMsg = $connectionError->getMessage();
                            if (method_exists($connectionError, 'getAttributes')):
                                $attributes = $connectionError->getAttributes();
                                if (isset($errorMsg['message'])):
                                    $errorMsg .= '<br />' . $attributes['message'];
                                endif;
                            endif;
                        }
                    ?>
                    <?php if ($connected): ?>
                        <p ><i class="fa fa-check" aria-hidden="true"></i> CakePHP is able to connect to the database.</p>
                    <?php else: ?>
                        <p ><i class="fa fa-times" aria-hidden="true"></i> CakePHP is NOT able to connect to the database.<br /><br /><?= $errorMsg ?></p>
                    <?php endif; ?>

                    <hr>
                    <h4>DebugKit</h4>
                    <?php if (Plugin::loaded('DebugKit')): ?>
                        <p ><i class="fa fa-check" aria-hidden="true"></i> DebugKit is loaded.</p>
                    <?php else: ?>
                        <p ><i class="fa fa-times" aria-hidden="true"></i> DebugKit is NOT loaded. You need to either install pdo_sqlite, or define the "debug_kit" connection name.</p>
                    <?php endif; ?>

                    <hr>
                    <h4>App Migrations</h4>
                    <?php if ($migratedApp): ?>
                        <p ><i class="fa fa-check" aria-hidden="true"></i> Database is migrated.</p>
                    <?php else: ?>
                        <p ><i class="fa fa-times" aria-hidden="true"></i> Run the app migration with <code>$ bin/cake migrations migrate</code></p>
                    <?php endif; ?>

                    <h4>CakeQueuesadilla Migrations</h4>
                    <?php if ($migratedQueue): ?>
                        <p ><i class="fa fa-check" aria-hidden="true"></i> Database is migrated.</p>
                    <?php else: ?>
                        <p ><i class="fa fa-times" aria-hidden="true"></i> Run the migration with <code>$ bin/cake migrations migrate -p Josegonzalez/CakeQueuesadilla</code></p>
                    <?php endif; ?>

                    <h4>Seeds</h4>
                    <?php if ($seeded): ?>
                        <p ><i class="fa fa-check" aria-hidden="true"></i> Database is seeded.</p>
                    <?php else: ?>
                        <p ><i class="fa fa-times" aria-hidden="true"></i> Seed the Database with <code>$ bin/cake migrations seed</code></p>
                    <?php endif; ?>

                    <hr>
                    <h4>npm</h4>
                    <?php if (is_dir(ROOT . DS . 'node_modules')): ?>
                        <p ><i class="fa fa-check" aria-hidden="true"></i> npm packages are installed.</p>
                    <?php else: ?>
                        <p ><i class="fa fa-times" aria-hidden="true"></i> Install npm packages with <code>$ npm install</code></p>
                    <?php endif; ?>

                    <hr>
                    <h4>Bower</h4>
                    <?php if (is_dir(WWW_ROOT . DS . 'vendors')): ?>
                        <p ><i class="fa fa-check" aria-hidden="true"></i> Bower components are installed.</p>
                    <?php else: ?>
                        <p ><i class="fa fa-times" aria-hidden="true"></i> Install Bower components with <code>$ bower install</code></p>
                    <?php endif; ?>

                    <hr>
                    <h4>Important Environment Variable</h4>
                    <?php if (Environment::read('MAIN_DOMAIN') == $_SERVER['HTTP_HOST']): ?>
                        <p ><i class="fa fa-check" aria-hidden="true"></i> MAIN_DOMAIN</p>
                    <?php else: ?>
                        <p ><i class="fa fa-times" aria-hidden="true"></i> Change <code>MAIN_DOMAIN</code> to your setup inside the <code>.env</code> file.</p>
                    <?php endif; ?>
                </div>
            </div>
            <hr>
            <div class="row last-row">
                <div class="col-lg-12">
                    <h2>Everything looks good (<i class="fa fa-check" aria-hidden="true"></i>)?</i></h2>
                    <?=
                        $this->Html->link('Go to the Login-Page', [
                            'controller' => 'Login',
                            'action' => 'login'
                        ], [
                            'class' => 'btn btn-default'
                        ]);
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>
