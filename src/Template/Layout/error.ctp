<?php
// This is also used to include the correct css file in assets.ctp
$this->assign('adminLTETheme', 'skin-blue-light');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $this->element('Layout/head') ?>
</head>
<body class="<?php echo $this->FrontendBridge->getMainContentClasses() ?> <?= $this->fetch('bodyClasses') ?>">
    <?= $this->Flash->render() ?>
    <?= $this->Flash->render('auth') ?>
    <?= $this->fetch('content') ?>
</body>
</html>