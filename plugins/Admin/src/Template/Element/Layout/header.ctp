<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <?php
    echo $this->Html->link('CakePHP App Template - Administration', [
        'controller' => 'Dashboard',
        'action' => 'index',
        'plugin' => 'Admin'
    ], [
        'class' => 'navbar-brand'
    ]);
    ?>
    <div class="clearfix"></div>
</div>
<ul class="nav navbar-top-links navbar-right">
    <?php if(isset($this->Auth) && $this->Auth->user() !== null) : ?>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li>
                    <?= $this->Html->link('<i class="fa fa-user fa-fw"></i> My Profile', ['controller' => 'Profile', 'action' => 'index', 'plugin' => 'Admin'], [
                        'escape' => false
                    ]) ?>
                </li>
                <li class="divider"></li>
                <li>
                    <?= $this->Html->link('<i class="fa fa-sign-out fa-fw"></i> Sign Out', ['controller' => 'Login', 'action' => 'logout', 'plugin' => 'Admin'], [
                        'escape' => false
                    ]) ?>
                </li>
            </ul>
        </li>
    <?php endif; ?>
</ul>
