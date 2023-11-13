<?php

declare(strict_types=1);

namespace Core\Infrastructure\Persistence\Doctrine\Repository;

use Core\Domain\Shared\Repository\DbTransactionInterface;
use Core\Infrastructure\Persistence\Doctrine\Helper\EntityManagerHelperSingleton;
use Doctrine\ORM\Exception\MissingMappingDriverImplementation;
use Doctrine\ORM\Tools\ToolsException;

class DbTransaction implements DbTransactionInterface
{
    /**
     * @throws MissingMappingDriverImplementation
     * @throws ToolsException|\Exception
     */
    public function commit(): void
    {
        EntityManagerHelperSingleton::getInstance()->commit();
    }

    /**
     * @throws MissingMappingDriverImplementation
     * @throws ToolsException|\Exception
     */
    public function rollback(): void
    {
        EntityManagerHelperSingleton::getInstance()->rollBack();
    }

    public function beginTransaction(): void
    {
        EntityManagerHelperSingleton::getInstance()->beginTransaction();
    }
}