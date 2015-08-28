<h1 class="page-header">
    <?= __('user') ?>
    <div class="pull-right">
        <?= $this->CkTools->editButton($user) ?>
        <?= $this->ListFilter->backToListButton() ?>
    </div>
</h1>

<div class="users view">
    <dl class="dl dl-horizontal">
        
        <dt><?= __('user.id') ?></dt>
        <dd><?= h($user->id) ?></dd>
                    
        <dt><?= __('user.status') ?></dt>
        <dd><?= h($user->status) ?></dd>
                    
        <dt><?= __('user.role') ?></dt>
        <dd><?= h($user->role) ?></dd>
                    
        <dt><?= __('user.firstname') ?></dt>
        <dd><?= h($user->firstname) ?></dd>
                    
        <dt><?= __('user.lastname') ?></dt>
        <dd><?= h($user->lastname) ?></dd>
                    
        <dt><?= __('user.email') ?></dt>
        <dd><?= h($user->email) ?></dd>
                    
        <dt><?= __('user.password') ?></dt>
        <dd><?= h($user->password) ?></dd>
                            
                        <dt><?= __('user.failed_login_count') ?></dt>
        <dd><?= $this->Number->format($user->failed_login_count) ?></dd>
                
                    
        <dt><?= __('user.failed_login_timestamp') ?></dt>
        <dd><?= h($user->failed_login_timestamp) ?></dd>
            
        <dt><?= __('created') ?></dt>
        <dd><?= h($user->created) ?></dd>
            
        <dt><?= __('modified') ?></dt>
        <dd><?= h($user->modified) ?></dd>
                        
                
    </dl>
</div>


