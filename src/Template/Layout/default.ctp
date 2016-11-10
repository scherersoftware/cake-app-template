<?php
// This is also used to include the correct css file in assets.ctp
$this->assign('adminLTETheme', 'skin-blue-light');
?>
<!DOCTYPE html>
<html>
    <head>
        <?= $this->element('Layout/head') ?>
    </head>
    <body class="hold-transition <?= $this->fetch('adminLTETheme') ?> fixed <?= $this->fetch('bodyClasses') ?>">
        <div class="wrapper">
            <?= $this->element('Layout/header') ?>
            <?= $this->element('Layout/sidebar') ?>

            <div class="content-wrapper <?php echo $this->FrontendBridge->getMainContentClasses() ?>">
                <?= $this->fetch('contentHeader') ?>
                <section class="content">
                    <?= $this->Flash->render() ?>
                    <?= $this->Flash->render('auth') ?>
                    <?= $this->fetch('content') ?>
                </section>
            </div>
        </div>
    </body>
</html>