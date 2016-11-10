<tr>
    <td align="center" valign="top">
        <table border="0" cellpadding="20" cellspacing="0" width="800">
            <tr>
                <td align="left" valign="top" style="background-color: #FFF;font-family: Arial;">
                    <h3 style="margin-top: 0;"><?= __('forgot_password.salutation {0}', [h($fullName)]) ?>,</h3>
                    <p style="font-size:14px;"><?= __('forgot_password.new_password_requested') ?><br><?= __('forgot_password.click_on_link_below') ?></p>
                    <p style="font-size:14px;"><a href="<?= h($resetPasswordUrl) ?>" style="width: 360px; text-decoration: none; display: inline-block; text-align: center; text-transform: uppercase; font-family: Arial; background-color: #A0C40C; color: #FFF; padding: 20px 0 20px;border-radius: 6px;"><?= __('forgot_password.click_here') ?></a></p>
                </td>
            </tr>
        </table>
    </td>
</tr>
