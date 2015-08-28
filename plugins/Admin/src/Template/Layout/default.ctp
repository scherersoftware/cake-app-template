<!DOCTYPE html>
<html>
<head>
    <?php echo $this->element('Admin.Layout/head') ?>
</head>
<body>
	<div id="wrapper">
		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
			<?php echo $this->element('Admin.Layout/header') ?>
			<?php echo $this->element('Admin.Layout/sidebar') ?>
		</nav>
		<div id="page-wrapper">
			<div class="row">
				<div class="col-lg-12 <?php echo $this->FrontendBridge->getMainContentClasses() ?>">
					<?= $this->Flash->render() ?>
					<?= $this->Flash->render('auth') ?>
					<?= $this->fetch('content') ?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
