<?php

use Core\Domain\Shared\Notification\NotificationError;

describe('Notification Error Suite Test', function () {
    it('Should ensure that errors is an array', function () {
        $notificationError = new NotificationError();

        $errors = $notificationError->getErrors();

        expect($errors)->toBeArray();
    });

    it('Should add a single error when an error is added', function () {
        $notificationError = new NotificationError();
        $notificationError->addError([
            'context' => 'account',
            'message' => 'name is required'
        ]);

        expect($notificationError->getErrors())->toHaveCount(1);
    });

    it('Should ensure that has an error results when adding error', function () {
        $notificationError = new NotificationError();

        expect($notificationError->hasErrors())->toBeFalse();

        $notificationError->addError([
            'context' => 'account',
            'message' => 'name is required'
        ]);

        expect($notificationError->hasErrors())->toBeTrue();
    });

    it('Should return a formatted string with concatenated error messages for all contexts', function () {
        $notificationError = new NotificationError();
        $notificationError->addError([
            'context' => 'account',
            'message' => 'name is required'
        ]);

        $notificationError->addError([
            'context' => 'account',
            'message' => 'email is required'
        ]);

        $message = $notificationError->messages();

        expect($message)->toBeString();
        expect($message)->toBe('account: name is required,account: email is required');

    });

    it('Should return a formatted string with concatenated error messages for all contexts filtered', function () {
        $notificationError = new NotificationError();
        $notificationError->addError([
            'context' => 'account',
            'message' => 'name is required'
        ]);
        $notificationError->addError([
            'context' => 'survey',
            'message' => 'question is required'
        ]);

        expect($notificationError->getErrors())->toHaveCount(2);

        $message = $notificationError->messages(context: 'account');

        expect($message)->toBeString();
        expect($message)->toBe('account: name is required');
    });
});