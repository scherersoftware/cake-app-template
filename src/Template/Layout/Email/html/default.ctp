<?php
    use App\Lib\Environment;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?= $this->fetch('title') ?></title>
    </head>
    <body style="margin: 0;">
        <table style="background-color: #EEEEEE;" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
            <tr>
                <td align="center" valign="top">
                    <table border="0" cellpadding="20" cellspacing="0" width="800">
                        <tr>
                            <td valign="top" style="background-color: #FFF;">
                                <img src="<?= Environment::read('FULL_BASE_URL') ?>/img/scherer_software_logo.png" />
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <?php echo $this->fetch('content') ?>
        </table>
    </body>
</html>