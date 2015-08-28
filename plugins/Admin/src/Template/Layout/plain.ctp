<!DOCTYPE html>
<html lang="en">
<head>
	<?php echo $this->element('Layout/head') ?>
</head>
<body class="<?php echo $this->FrontendBridge->getMainContentClasses() ?>">
	<?= $this->Flash->render() ?>
	<?= $this->Flash->render('auth') ?>
	<?= $this->fetch('content') ?>
</body>
</html>