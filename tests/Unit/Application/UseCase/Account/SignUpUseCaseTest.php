<?php

use Core\Application\Interfaces\Cryptography\HasherInterface;
use Core\Application\Interfaces\Validator\ValidatorInterface;
use Core\Application\UseCase\Account\SignUp\SignUpInputDto;
use Core\Application\UseCase\Account\SignUp\SignUpOutputDto;
use Core\Application\UseCase\Account\SignUp\SignUpUseCase;
use Core\Domain\Account\Entity\Account;
use Core\Domain\Account\Event\AccountCreatedEvent;
use Core\Domain\Account\Exceptions\EmailAlreadyInUseException;
use Core\Domain\Account\Repository\AccountRepositoryInterface;
use Core\Domain\Shared\Event\EventDispatcher;
use Core\Domain\Shared\Repository\DbTransactionInterface;

describe('Sign Up UseCase', function () {
    $signUpInputDto = new SignUpInputDto(
        firstName: 'Matheus',
        lastName: 'Jose',
        email: 'matheus.jose@mail.com',
        password: '123456789',
        passwordConfirmation: '123456789',
    );

    beforeEach(function () {
        $this->accountRepository = spy(AccountRepositoryInterface::class);
        $this->hasher = spy(HasherInterface::class);
        $this->dbTransaction = spy(DbTransactionInterface::class);
        $this->eventDispacther = spy(EventDispatcher::class);

        $this->accountRepository->shouldReceive('add')->andReturn(
            new Account(
                firstName: 'Matheus',
                lastName: 'Jose',
                email: 'matheus.jose@mail.com',
                password: '123456789'
            )
        );
        $this->hasher->shouldReceive('hash')->andReturn('hashed_password');

        $this->validator = spy(ValidatorInterface::class);
        $this->signUpUseCase = new SignUpUseCase(
            accountRepository: $this->accountRepository,
            hasher: $this->hasher,
            dbTransaction: $this->dbTransaction,
            eventDispatcher: $this->eventDispacther,
            validator: $this->validator
        );
    });

    it('Should invoke checkByEmail with the correct email', function () use ($signUpInputDto) {
        ($this->signUpUseCase)(input: $signUpInputDto);

        $this->accountRepository->shouldHaveReceived('checkByEmail')->with('matheus.jose@mail.com')->once();
    });

    it(
        'Should throw EmailAlreadyInUseException when checkByEmail indicates that the email is already in use',
        function () use ($signUpInputDto) {
            $this->accountRepository->shouldReceive('checkByEmail')->andReturn(true);

            expect(function () use ($signUpInputDto) {
                ($this->signUpUseCase)(input: $signUpInputDto);
            })->toThrow(EmailAlreadyInUseException::class);
        }
    );

    it('Should invoke hasher with correct plaintext', function () use ($signUpInputDto) {
        ($this->signUpUseCase)(input: $signUpInputDto);

        $this->hasher->shouldHaveReceived('hash')->with('123456789')->once();
    });

    it('Should throw Exception when hasher throws', function () use ($signUpInputDto) {
        $hasher = spy(HasherInterface::class);
        $hasher->shouldReceive('hash')->andThrow(new \Exception());

        $signUpUseCase = new SignUpUseCase(
            accountRepository: $this->accountRepository,
            hasher: $hasher,
            dbTransaction: $this->dbTransaction,
            eventDispatcher: $this->eventDispacther,
            validator: $this->validator
        );

        expect(function () use ($signUpInputDto, $signUpUseCase) {
            ($signUpUseCase)(input: $signUpInputDto);
        })->toThrow(\Exception::class);
    });

    it('Should invoke add account with correct values', function () use ($signUpInputDto) {
        ($this->signUpUseCase)(input: $signUpInputDto);

        $this->accountRepository->shouldHaveReceived('add')->with(Account::class)->once();
    });

    it('Should throw Exception when add account throws', function () use ($signUpInputDto) {
        $accountRepository = spy(AccountRepositoryInterface::class);
        $accountRepository->shouldReceive('add')->andThrow(new \Exception());
        $signUpUseCase = new SignUpUseCase(
            accountRepository: $accountRepository,
            hasher: $this->hasher,
            dbTransaction: $this->dbTransaction,
            eventDispatcher: $this->eventDispacther,
            validator: $this->validator
        );

        expect(function () use ($signUpInputDto, $signUpUseCase) {
            ($signUpUseCase)(input: $signUpInputDto);
        })->toThrow(\Exception::class);
    });

    it('Should return a valid SignUpOutputDto on success', function () use ($signUpInputDto) {
        $result = ($this->signUpUseCase)(input: $signUpInputDto);

        expect($result)->toBeInstanceOf(SignUpOutputDto::class);
        expect($result->id)->not->toBeEmpty();
        expect($result->createdAt)->not->toBeEmpty();

        expect($result->firstName)->toBe('Matheus');
        expect($result->lastName)->toBe('Jose');
        expect($result->email)->toBe('matheus.jose@mail.com');
    });

    it('Should invoke commit once', function () use ($signUpInputDto) {
        ($this->signUpUseCase)(input: $signUpInputDto);

        $this->dbTransaction->shouldHaveReceived('commit')->once();
    });

    it('Should invoke event dispatcher with correct value', function () use ($signUpInputDto) {
        ($this->signUpUseCase)(input: $signUpInputDto);

        $this->eventDispacther->shouldHaveReceived('notify')->with(AccountCreatedEvent::class)->once();
    });
});