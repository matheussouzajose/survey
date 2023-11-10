<?php

use Core\Application\Interfaces\Cryptography\HasherInterface;
use Core\Application\UseCase\Account\SignUp\SignUpInputDto;
use Core\Application\UseCase\Account\SignUp\SignUpOutputDto;
use Core\Application\UseCase\Account\SignUp\SignUpUseCase;
use Core\Domain\Account\Entity\Account;
use Core\Domain\Account\Exceptions\EmailAlreadyInUseException;
use Core\Domain\Account\Repository\AccountRepositoryInterface;

describe('Sign Up UseCase', function () {
    $signUpInputDto = new SignUpInputDto(
        firstName: 'Matheus',
        lastName: 'Jose',
        email: 'matheus.jose@mail.com',
        password: '123456789'
    );

    beforeEach(function () {
        $this->accountRepository = spy(AccountRepositoryInterface::class);
        $this->accountRepository->shouldReceive('add')->andReturn(new Account(
            firstName: 'Matheus',
            lastName: 'Jose',
            email: 'matheus.jose@mail.com',
            password: '123456789'
        ));

        $this->hasher = spy(HasherInterface::class);
        $this->hasher->shouldReceive('hash')->andReturn('hashed_password');
    });

    it('Should invoke checkByEmail with the correct email', function () use ($signUpInputDto) {
        $signUpUseCase = new SignUpUseCase(accountRepository: $this->accountRepository, hasher: $this->hasher);
        ($signUpUseCase)(input: $signUpInputDto);

        $this->accountRepository->shouldHaveReceived('checkByEmail')->with('matheus.jose@mail.com')->once();
    });

    it(
        'Should throw EmailAlreadyInUseException when checkByEmail indicates that the email is already in use',
        function () use ($signUpInputDto) {
            $this->accountRepository->shouldReceive('checkByEmail')->andReturn(true);

            $signUpUseCase = new SignUpUseCase(accountRepository: $this->accountRepository, hasher: $this->hasher);
            ($signUpUseCase)(input: $signUpInputDto);
        }
    )->throws(EmailAlreadyInUseException::class);

    it('Should invoke hasher with correct plaintext', function () use ($signUpInputDto) {
        $signUpUseCase = new SignUpUseCase(accountRepository: $this->accountRepository, hasher: $this->hasher);
        ($signUpUseCase)(input: $signUpInputDto);

        $this->hasher->shouldHaveReceived('hash')->with('123456789')->once();
    });

    it('Should throw Exception when hasher throws', function () use ($signUpInputDto) {
        $hasher = spy(HasherInterface::class);
        $hasher->shouldReceive('hash')->andThrow(new \Exception());

        $signUpUseCase = new SignUpUseCase(accountRepository: $this->accountRepository, hasher: $hasher);
        ($signUpUseCase)(input: $signUpInputDto);
    })->throws(\Exception::class);

    it('Should invoke add account with correct values', function () use ($signUpInputDto) {
        $signUpUseCase = new SignUpUseCase(accountRepository: $this->accountRepository, hasher: $this->hasher);
        ($signUpUseCase)(input: $signUpInputDto);

        $this->accountRepository->shouldHaveReceived('add')->with(Account::class)->once();
    });

    it('Should throw Exception when add account throws', function () use ($signUpInputDto) {
        $accountRepository = spy(AccountRepositoryInterface::class);
        $accountRepository->shouldReceive('add')->andThrow(new \Exception());

        $signUpUseCase = new SignUpUseCase(accountRepository: $accountRepository, hasher: $this->hasher);
        ($signUpUseCase)(input: $signUpInputDto);
    })->throws(\Exception::class);

    it('Should return a valid SignUpOutputDto on success', function () use ($signUpInputDto) {
        $signUpUseCase = new SignUpUseCase(accountRepository: $this->accountRepository, hasher: $this->hasher);
        $result = ($signUpUseCase)(input: $signUpInputDto);

        expect($result)->toBeInstanceOf(SignUpOutputDto::class);
        expect($result->id)->not->toBeEmpty();
        expect($result->createdAt)->not->toBeEmpty();

        expect($result->firstName)->toBe('Matheus');
        expect($result->lastName)->toBe('Jose');
        expect($result->email)->toBe('matheus.jose@mail.com');
    });
})->only();