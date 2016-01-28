<!DOCTYPE html>
<html>
<head>
    <?php echo $this->element('Admin.Layout/head') ?>
</head>
<body>
	<div id="wrapper">
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<?php echo $this->element('Admin.Layout/header') ?>
			<?php echo $this->element('Admin.Layout/sidebar') ?>
		</nav>
		<div id="page-wrapper">
			<div class="container-fluid">
				<div class="<?php echo $this->FrontendBridge->getMainContentClasses() ?>">
					<?= $this->Flash->render() ?>
					<?= $this->Flash->render('auth') ?>
					<?= $this->fetch('content') ?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
