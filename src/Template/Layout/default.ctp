<!DOCTYPE html>
<html>
<head>
    <?php echo $this->element('Layout/head') ?>
</head>
<body>
    <div id="wrapper">
        <?php echo $this->element('Layout/header') ?>
        <div class="container" id="main">
            <div class="<?php echo $this->FrontendBridge->getMainContentClasses() ?>">
                <?= $this->Flash->render() ?>
                <?= $this->Flash->render('auth') ?>
                <?= $this->fetch('content') ?>
            </div>
        </div>
    </div>
</body>
</html>
