<?php
/**
 * @var \App\View\AppView $this
 */
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

        <ul class="sidebar-menu">
            <?php echo $this->Menu->renderSidebarMenuItems('menu') ?>
        </ul>
    </section>
</aside>