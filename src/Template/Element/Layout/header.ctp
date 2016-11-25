<?php
use App\Model\Entity\User;

?>
<header class="main-header">
    <a href="<?= $this->Url->build(['controller' => 'dashboard', 'action' => 'index']) ?>" class="logo">
        <span class="logo-lg"><b>scherer</b>software</span>
    </a>

    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <?= $this->LanguageSwitcher->renderLanguageSwitcher(); ?>
                <?php if ($this->Auth->loggedIn()): ?>
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="/img/avatar5.png" class="user-image" alt="User Image">
                            <span class="hidden-xs"><?= $this->Auth->user('firstname') ?> <?= $this->Auth->user('lastname') ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header">
                                <img src="/img/avatar5.png" class="img-circle" alt="User Image">
                                <p>
                                    <?= $this->Auth->user('firstname') ?> <?= $this->Auth->user('lastname') ?> - <?= User::getTypeDescription($this->Auth->user('role')) ?>
                                    <small><?= $this->Auth->user('mandator.company_name') ?></small>
                                </p>
                            </li>
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="/profile/index" class="btn btn-default btn-flat"><?= __('my_profile'); ?></a>
                                </div>
                                <div class="pull-right">
                                    <a href="/login/logout" class="btn btn-default btn-flat"><?= __('logout'); ?></a>
                                </div>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</header>
