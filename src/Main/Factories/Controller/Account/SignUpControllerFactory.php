<?php

namespace Core\Main\Factories\Controller\Account;

use Core\Application\UseCase\Account\SignUp\SignUpUseCase;
use Core\Domain\Shared\Event\EventDispatcher;
use Core\Infrastructure\Cryptography\PasswordAdapter\PasswordAdapter;
use Core\Infrastructure\Persistence\Doctrine\Helper\EntityManagerHelper;
use Core\Infrastructure\Persistence\Doctrine\Helper\EntityManagerHelperSingleton;
use Core\Infrastructure\Persistence\Doctrine\Mapping\Account;
use Core\Infrastructure\Persistence\Doctrine\Repository\AccountRepository;
use Core\Infrastructure\Persistence\Doctrine\Repository\DbTransaction;
use Core\Ui\Api\Controller\Account\SignUpController;
use Core\Ui\Api\ControllerInterface;
use Core\Ui\Api\Validator\SignUpValidatorRequest;
use Doctrine\ORM\Mapping\ClassMetadata;

class SignUpControllerFactory
{
    public static function create(): ControllerInterface
    {
        $useCase = new SignUpUseCase(
            accountRepository: new AccountRepository(
                em: EntityManagerHelperSingleton::getInstance(),
                class: new ClassMetadata(Account::class)
            ),
            hasher: new PasswordAdapter(),
            dbTransaction: new DbTransaction(),
            eventDispatcher: new EventDispatcher()
        );
        $validator = new SignUpValidatorRequest();
        return new SignUpController(useCase: $useCase, validation: $validator);
    }
}