<?php
    use App\Model\Entity\User;
?>
<aside class="main-sidebar">
    <section class="sidebar">
        <?php if ($this->Auth->loggedIn()): ?>
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="/img/avatar5.png" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>
                        <?php
                            echo $this->Html->link($this->Auth->user('firstname') . ' ' . $this->Auth->user('lastname'), [
                                'controller' => 'profile',
                                'action' => 'index'
                            ]); 
                        ?>
                    </p>
                    <i class="fa fa-circle text-success"></i> <?= User::getTypeDescription($this->Auth->user('role')); ?></a>
                </div>
            </div>
        <?php endif; ?>

        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Suchen...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>

        <ul class="sidebar-menu">
            <?php echo $this->Menu->renderSidebarMenuItems('menu') ?>
        </ul>
    </section>
</aside>