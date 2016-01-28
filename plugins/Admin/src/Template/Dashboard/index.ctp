<?php
    use Cake\Routing\Router;
?>
<h1 class="page-header">
    <?= __('dashboard.index.title') ?>
</h1>
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-users fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?= $usersCount ?></div>
                        <div>User Count</div>
                    </div>
                </div>
            </div>
            <a href="<?= Router::url(['controller' => 'Users', 'action' => 'index', 'plugin' => 'Admin']) ?>">
                <div class="panel-footer">
                    <span class="pull-left">Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>
