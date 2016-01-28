<!DOCTYPE html>
<html>
<head>
    <?php echo $this->element('Layout/head') ?>
</head>
<body>
    <div id="wrapper">
        <div class="container-fluid">
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
