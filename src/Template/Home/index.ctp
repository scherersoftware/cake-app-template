<h1>Home</h1>

<?php echo $this->CkTools->button('Logout', ['plugin' => false, 'controller' => 'login', 'action' => 'logout']) ?>

<?= $this->Cms->renderPage($page); ?>
