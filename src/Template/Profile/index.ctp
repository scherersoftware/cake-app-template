<?php
    use App\Lib\Status;
    use App\Model\Entity\User;

    $this->assign('title', __('profile.index.title'));
?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">
            <?= __('my_profile') ?>
        </h3>
    </div>
    <div class="box-body table-responsive">
        <fieldset>
            <dl class="dl-horizontal">
                <dt><?= __('user.firstname') ?></dt>
                <dd><?= h($user->firstname) ?></dd>

                <dt><?= __('user.lastname') ?></dt>
                <dd><?= h($user->lastname) ?></dd>

                <dt><?= __('user.email') ?></dt>
                <dd><?= h($user->email) ?></dd>

                <dt><?= __('user.role') ?></dt>
                <dd><?= $this->Utils->roleLabel($user->role) ?></dd>

                <dt><?= __('user.status') ?></dt>
                <dd><?= $this->Utils->statusLabel($user->status) ?></dd>
            </dl>
        </fieldset>

        <fieldset>
            <legend><?= __('profile.change_password') ?></legend>

            <?php echo $this->Form->create($user, [
                'align' =>
                    ['md' => [
                        'left' => 2,
                        'middle' => 4,
                        'right' => 6,
                    ]],
            ]) ?>

            <?php echo $this->Form->input('current_password', [
                'label' => __('profile.current_password'),
                'type' => 'password'
            ]) ?>
            <hr>
            <?php echo $this->Form->input('password', [
                'label' => __('profile.new_password'),
                'type' => 'password'
            ]) ?>
            <?php echo $this->Form->input('password_confirm', [
                'label' => __('profile.repeat_password'),
                'type' => 'password'
            ]) ?>

            <?php echo $this->Form->button(__('profile.save'), ['class' => 'btn btn-success']) ?>

            <?php echo $this->Form->end(); ?>
        </fieldset>
    </div>
</div>