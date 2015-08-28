<?php
use App\Model\Entity\User;
use App\Lib\Status;

$this->assign('title', __('users.view.title'));

?>
<h1 class="page-header">
    <?= __('users.view.title') ?>
    <div class="pull-right">
        <?= $this->CkTools->editButton($user) ?>
        <?php if ($user->status == Status::SUSPENDED): ?>
            <?= $this->CkTools->button(__('users.action.activate'), [
                'controller' => $user->source(),
                'action' => 'activate',
                $user->id
            ], [
                'class' => 'btn btn-success btn-xs',
                'icon' => 'check'
            ]) ?>
        <?php else: ?>
            <?= $this->CkTools->button(__('users.action.suspend'), [
                'controller' => $user->source(),
                'action' => 'suspend',
                $user->id
            ], [
                'confirm' => __('users.action.confirm_suspend'),
                'class' => 'btn btn-danger btn-xs',
                'icon' => 'close'
            ]) ?>
        <?php endif; ?>

        <?= $this->ListFilter->backToListButton() ?>
    </div>
</h1>

<div class="col-sm-6">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><?= __('users.view.personal_information') ?></h3>
        </div>
        <table class="table table-striped table-bordered">
            <tr>
                <td><?= __('user.salutation') ?></td>
                <td><?= User::getTypeDescription($user->salutation) ?></td>
            </tr>
            <tr>
                <td><?= __('user.name') ?></td>
                <td><?= $user->full_name ?></td>
            </tr>
            <tr>
                <td><?= __('user.email') ?></td>
                <td><?= $user->email ?></td>
            </tr>
            <?php if (!empty($user->provider)) : ?>
                <tr>
                    <td><?= __('user.provider') ?></td>
                    <td><?= $user->provider ?></td>
                </tr>
            <?php endif; ?>
            <?php if (!empty($user->user_addresses)): ?>
                <tr>
                    <td><?= __('user.address') ?></td>
                    <td><?= $user->user_addresses[0]->getFullStreet() ?></td>
                </tr>
                <tr>
                    <td><?= __('user.location') ?></td>
                    <td><?= $user->user_addresses[0]->getFullAddress() ?></td>
                </tr>
                <tr>
                    <td><?= __('user.phone_private') ?></td>
                    <td><?= $user->user_addresses[0]->phone_private ?></td>
                </tr>
                <tr>
                    <td><?= __('user.phone_work') ?></td>
                    <td><?= $user->user_addresses[0]->phone_work ?></td>
                </tr>
            <?php endif; ?>
            <tr>
                <td><?= __('user.country') ?></td>
                <td><?= $this->CkTools->country($user->country) ?></td>
            </tr>
        </table>
    </div>
</div>

<div class="col-sm-6">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><?= __('users.view.information') ?></h3>
        </div>
        <table class="table table-striped table-bordered">
            <tr>
                <td><?= __('user.status') ?></td>
                <td><?= $this->Utils->statusLabel($user->status) ?></td>
            </tr>
            <tr>
                <td><?= __('user.role') ?></td>
                <td><?= $user->typeDescriptions()[$user->role] ?></td>
            </tr>
            <?php if ($user->date_of_birth !== null): ?>
                <tr>
                    <td><?= __('user.date_of_birth') ?></td>
                    <td><?= $user->date_of_birth->format('d.m.Y') ?></td>
                </tr>
            <?php endif; ?>
            <tr>
                <td><?= __('user.citizenship') ?></td>
                <td><?= $this->CkTools->country($user->citizenship) ?></td>
            </tr>
            <tr>
                <td><?= __('user.family_status') ?></td>
                <td><?= $user->family_status ?></td>
            </tr>
            <tr>
                <td><?= __('user.nonresidents_indicator') ?></td>
                <td><?= $user->nonresidents_indicator ?></td>
            </tr>
            <tr>
                <td><?= __('user.us_tax_liability') ?></td>
                <td><?= ($user->us_tax_liability) ? __('yes') : __('no') ?></td>
            </tr>
            <tr>
                <td><?= __('user.branch') ?></td>
                <td><?= $user->branch ?></td>
            </tr>
            <?php if ($user->failed_login_count > 0 && $user->failed_login_timestamp !== null): ?>
                <tr>
                    <td><?= __('user.failed_login_count') ?></td>
                    <td><?= $user->failed_login_count ?></td>
                </tr>
                <tr>
                    <td><?= __('user.failed_login_timestamp_reset') ?></td>
                    <td><?= $user->failed_login_timestamp->add(new DateInterval('PT1H'))->format('d.m.Y H:i:s') ?></td>
                </tr>
                <tr>
                    <td><?= __('user.reset_login_retries') ?></td>
                    <td>
                        <?= $this->CkTools->button(__('users.action.reset_login_retries'), [
                            'controller' => $user->source(),
                            'action' => 'reset_login_retries',
                            $user->id
                        ], [
                            'class' => 'btn btn-success btn-xs',
                        ]) ?>
                    </td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
</div>

<?php if($hasAttachments): ?>
    <div class="col-sm-6">
        <?php
            echo $this->Attachments->attachmentsArea($user, [
                'label' => false,
                'formFieldName' => 'attachment_uploads',
                'mode' => 'readonly'
            ]);
        ?>
    </div>
<?php endif; ?>

<?php if (count($brands) == 0): ?>
    <div class="col-sm-12">
        <div class="alert alert-info">
            <?= __('users.no_backed_brands_found') ?>
        </div>
    </div>
<?php else: ?>
    <div class="col-sm-12 table-responsive">
        <table class="table table-striped">
            <thead>
                <th><?= __('brand.name') ?></th>
                <th><?= __('brand.shares') ?></th>
                <th><?= __('brand.purchases') ?></th>
                <th><?= __('brand.wkn') ?></th>
            </thead>
            <tbody>
                <td>Super tolle Brand</td>
                <td>3,72</td>
                <td>2</td>
                <td>581005</td>
            </tbody>
        </table>
    </div>
<?php endif; ?>
