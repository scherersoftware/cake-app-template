<?php
use Cake\Core\Configure;
use Cake\Error\Debugger;

$this->layout = 'error';

if (Configure::read('debug')):
    $this->layout = 'dev_error';

    $this->assign('title', $message);
    $this->assign('templateName', 'error400.ctp');

    $this->start('file');
?>
<?php if (!empty($error->queryString)) : ?>
    <p class="notice">
        <strong>SQL Query: </strong>
        <?= h($error->queryString) ?>
    </p>
<?php endif; ?>
<?php if (!empty($error->params)) : ?>
        <strong>SQL Query Params: </strong>
        <?php Debugger::dump($error->params) ?>
<?php endif; ?>
<?= $this->element('auto_table_warning') ?>
<?php
    if (extension_loaded('xdebug')):
        xdebug_print_function_stack();
    endif;

    $this->end();
endif;

$this->assign('title', __('error.404'));
$this->assign('bodyClasses', 'error-page');
?>

<div class="error-page-container">
    <h2 class="headline warning">404</h2>
    <div class="error-content">
        <h3><i class="fa fa-warning warning"></i> <?= __('error.404.not_found') ?></h3>
        <p>
            <?= __('error.404.message') ?>
        </p>
    </div>
</div>