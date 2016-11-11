<?php
// This is also used to include the correct css file in assets.ctp
$this->assign('adminLTETheme', 'skin-blue-light');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $this->element('Layout/head') ?>
</head>
<body class="<?= $this->fetch('bodyClasses') ?>">
    <div class="container <?php echo $this->FrontendBridge->getMainContentClasses() ?>">
        <?= $this->Flash->render() ?>
        <?= $this->Flash->render('auth') ?>
        <?= $this->fetch('content') ?>
    </div>
</body>
</html>