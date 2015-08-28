<?php
use App\Model\Entity\User;

?>

<?= $this->Form->input('email', [
    'label' => __('user.email')
]) ?>

<?= $this->Form->input('salutation', [
    'label' => __('user.salutation')
]); ?>

<?= $this->Form->input('forename', [
    'label' => __('user.forename')
]); ?>

<?= $this->Form->input('surname', [
    'label' => __('user.surname')
]); ?>

<?= $this->Form->input('role', [
    'label' => __('user.role'),
    'options' => User::getRoles()
]) ?>

<?= $this->Form->input('new_password', [
    'type' => 'password',
    'label' => __('user.password')
]) ?>

<?= $this->Form->input('password_confirm', [
    'label' => __('user.password_confirm'),
    'type' => 'password'
]) ?>

<?=
    $this->Attachments->attachmentsArea($user, [
        'label' => __('user.attachments'),
        'formFieldName' => 'attachment_uploads',
    ]);
?>
