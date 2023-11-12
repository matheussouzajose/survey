<?php

namespace Core\Infrastructure\Persistence\Doctrine\Repository;

use Core\Domain\Shared\Repository\DbTransactionInterface;
use Core\Infrastructure\Persistence\Doctrine\Helper\EntityManagerHelperSingleton;
use Doctrine\ORM\Exception\MissingMappingDriverImplementation;
use Doctrine\ORM\Tools\ToolsException;

class DbTransaction implements DbTransactionInterface
{
    /**
     * @throws MissingMappingDriverImplementation
     * @throws ToolsException
     */
    public function __construct()
    {
        EntityManagerHelperSingleton::getInstance()->beginTransaction();
    }

    /**
     * @throws MissingMappingDriverImplementation
     * @throws ToolsException
     */
    public function commit(): void
    {
        EntityManagerHelperSingleton::getInstance()->commit();
    }

    /**
     * @throws MissingMappingDriverImplementation
     * @throws ToolsException
     */
    public function rollback(): void
    {
        EntityManagerHelperSingleton::getInstance()->rollBack();
    }
}