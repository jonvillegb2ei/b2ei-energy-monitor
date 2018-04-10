<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Users Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used in the layout to display some
    | messages to user.
    |
    */

    'table' => [
        'title' => 'User list',
        'firstname' => 'Firstname',
        'lastname' => 'Lastname',
        'email' => 'Email',
        'administrator' => 'Administrator',
        'change' => 'Change',
        'remove' => 'Remove',

    ],
    // trans('users.create.admin-success')
    'create' => [
        'title' => 'Add an user',
        'firstname' => ['name' => 'Firstname', 'help' => 'Put user first name'],
        'lastname' => ['name' => 'Lastname', 'help' => 'Put user last name'],
        'email' => ['name' => 'Email', 'help' => 'Put user email address'],
        'password' => ['name' => 'Password', 'help' => 'Put user password'],
        'password-confirmation' => ['name' => 'Password confirmation', 'help' => 'Confirm user password'],
        'administrator' => ['name' => 'Administrator', 'help' => 'Give an administrator status to user'],
        'button' => 'Add user',
        'success' => 'User created.',
        'error' => 'Error during user creation.',
        'admin-success' => 'Administrator state changed.',
        'admin-error' => 'Error during administrator state change.',
        'self-admin-error' => 'You can\'t change your administrator state.',

        'remove-success' => 'Administrator state changed.',
        'remove-error' => 'Error during administrator state change.',
        'self-remove-error' => 'You can\'t delete yourself.',

    ],

];