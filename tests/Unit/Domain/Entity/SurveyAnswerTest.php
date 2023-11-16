<?php

namespace Tests\Unit\Domain\Entity;

use Core\Domain\Account\Entity\Account;
use Core\Domain\Shared\Exceptions\NotificationErrorException;

describe('Survey Answer', function () {
    it('Should throws error when given invalid data', function ($firstName, $lastName, $email, $password) {
        new Account(
            firstName: $firstName,
            lastName: $lastName,
            email: $email,
            password: $password
        );
    })
        ->throws(exception: NotificationErrorException::class)
        ->with([
            ['', 'Jose', 'matheus.jose@mail.com', '123456789'],
            ['Matheus', '', 'matheus.jose@mail.com', '123456789'],
            ['Matheus', 'Jose', '', '123456789'],
            ['Matheus', 'Jose', 'matheus.jose@mail.com', ''],
        ])->only();

    it('Should ensure account are correct values', function () {
        $account = new Account(
            firstName: 'Matheus',
            lastName: 'Jose',
            email: 'matheus.jose@mail.com',
            password: '123456789'
        );

        expect($account->id())->not->toBeEmpty();
        expect($account->createdAt())->not->toBeEmpty();

        expect($account->firstName)->toBe('Matheus');
        expect($account->lastName)->toBe('Jose');
        expect($account->email)->toBe('matheus.jose@mail.com');
        expect($account->password)->toBe('123456789');
    });

    it('Should ensure change full name', function () {
        $account = new Account(
            firstName: 'Matheus',
            lastName: 'Jose',
            email: 'matheus.jose@mail.com',
            password: '123456789'
        );

        expect($account->firstName)->toBe('Matheus');
        expect($account->lastName)->toBe('Jose');

        $account->changeName(firstName: 'João', lastName:  'Souza');

        expect($account->firstName)->toBe('João');
        expect($account->lastName)->toBe('Souza');
    });

    it('Should ensure change email', function () {
        $account = new Account(
            firstName: 'Matheus',
            lastName: 'Jose',
            email: 'matheus.jose@mail.com',
            password: '123456789'
        );

        expect($account->email)->toBe('matheus.jose@mail.com');

        $account->changeEmail(email: 'joao@mail.com');

        expect($account->email)->toBe('joao@mail.com');
    });

    it('Should ensure change password', function () {
        $account = new Account(
            firstName: 'Matheus',
            lastName: 'Jose',
            email: 'matheus.jose@mail.com',
            password: '123456789'
        );

        expect($account->password)->toBe('123456789');

        $account->changePassword(password: 'password');

        expect($account->password)->toBe('password');
    });
});