<?php

use Core\Application\Exception\InvalidCredentialsException;
use Core\Application\Interfaces\Cryptography\EncrypterInterface;
use Core\Application\Interfaces\Cryptography\HasherInterface;
use Core\Application\Interfaces\Validator\ValidatorInterface;
use Core\Application\UseCase\Account\SignIn\SignInInputDto;
use Core\Application\UseCase\Account\SignIn\SignInOutputDto;
use Core\Application\UseCase\Account\SignIn\SignInUseCase;
use Core\Domain\Account\Entity\Account;
use Core\Domain\Account\Repository\AccountRepositoryInterface;
use Core\Domain\Shared\Event\EventDispatcherInterface;
use Core\Domain\Shared\ValueObject\Uuid;
use Tests\Etc\Fixtures\AccountFixtures;

describe('Sign In UseCase', function () {
    $signInInputDto = new SignInInputDto(
        email: 'matheus.jose@mail.com',
        password: '123456789'
    );

    beforeEach(function () {
        $this->validator = spy(ValidatorInterface::class);
        $this->accountRepository = spy(AccountRepositoryInterface::class);
        $this->hasher = spy(HasherInterface::class);
        $this->encrypter = spy(EncrypterInterface::class);
        $this->eventDispatcher = spy(EventDispatcherInterface::class);

        $this->accountRepository->shouldReceive('loadByEmail')->andReturn(
            new Account(
                firstName: AccountFixtures::MATHEUS_FIRST_NAME,
                lastName: AccountFixtures::MATHEUS_LAST_NAME,
                email: AccountFixtures::MATHEUS_EMAIL,
                password: AccountFixtures::PASSWORD_DEFAULT,
                id: new Uuid(AccountFixtures::MATHEUS_JOSE_ID),
                createdAt: new \DateTime(AccountFixtures::CREATED_AT_DEFAULT)
            )
        );
        $this->hasher->shouldReceive('compare')->andReturnTrue();
        $this->encrypter->shouldReceive('encrypt')->andReturn('token');

        $this->signUpUseCase = new SignInUseCase(
            validator: $this->validator,
            accountRepository: $this->accountRepository,
            hasher: $this->hasher,
            encrypter: $this->encrypter,
            eventDispatcher: $this->eventDispatcher
        );
    });

    it('Should throw InvalidCredentialsException when loadByEmail return null', function () use ($signInInputDto) {
        $accountRepository = spy(AccountRepositoryInterface::class);
        $accountRepository->shouldReceive('loadByEmail')->andThrow(InvalidCredentialsException::class);

        $this->signUpUseCase = new SignInUseCase(
            validator: $this->validator,
            accountRepository: $accountRepository,
            hasher: $this->hasher,
            encrypter: $this->encrypter,
            eventDispatcher: $this->eventDispatcher
        );

        expect(function () use ($signInInputDto) {
            ($this->signUpUseCase)(input: $signInInputDto);
        })->toThrow(InvalidCredentialsException::class);
    });

    it('Should invoke loadByEmail with the correct email', function () use ($signInInputDto) {
        ($this->signUpUseCase)(input: $signInInputDto);

        $this->accountRepository->shouldHaveReceived('loadByEmail')->with('matheus.jose@mail.com')->once();
    });

    it('Should throw InvalidCredentialsException when hash comparer return null', function () use ($signInInputDto) {
        $hasher = spy(HasherInterface::class);
        $hasher->shouldReceive('compare')->andThrow(InvalidCredentialsException::class);

        $this->signUpUseCase = new SignInUseCase(
            validator: $this->validator,
            accountRepository: $this->accountRepository,
            hasher: $hasher,
            encrypter: $this->encrypter,
            eventDispatcher: $this->eventDispatcher
        );

        expect(function () use ($signInInputDto) {
            ($this->signUpUseCase)(input: $signInInputDto);
        })->toThrow(InvalidCredentialsException::class);
    });

    it('Should invoke hasher compare with the correct value', function () use ($signInInputDto) {
        ($this->signUpUseCase)(input: $signInInputDto);

        $this->hasher->shouldHaveReceived('compare')->once();
    });

    it('Should invoke encrypt with the correct value', function () use ($signInInputDto) {
        ($this->signUpUseCase)(input: $signInInputDto);

        $this->encrypter->shouldHaveReceived('encrypt')->with(AccountFixtures::MATHEUS_JOSE_ID)->once();
    });

    it('Should invoke updateAccessToken with the correct value', function () use ($signInInputDto) {
        ($this->signUpUseCase)(input: $signInInputDto);

        $this->accountRepository->shouldHaveReceived('updateAccessToken')->once();
    });

    it('Should ensure that user logged success', function () use ($signInInputDto) {
        $result = ($this->signUpUseCase)(input: $signInInputDto);

        expect($result)->toBeInstanceOf(SignInOutputDto::class);
    });
});