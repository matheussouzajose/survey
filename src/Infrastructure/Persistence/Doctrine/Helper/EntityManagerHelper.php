<?php

declare(strict_types=1);

namespace Core\Infrastructure\Persistence\Doctrine\Helper;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\MissingMappingDriverImplementation;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\ToolsException;

class EntityManagerHelper
{

    /**
     * @throws MissingMappingDriverImplementation
     * @throws Exception
     * @throws ToolsException
     */
    public function getEntityManager(): EntityManager
    {
        $isTesting = getenv('APP_ENV') === 'testing';
        $dbParams = $isTesting ? self::getTestingDbParams() : self::getDbParams();

        $entityManager = new EntityManager(self::connection(dbParams: $dbParams), self::configuration());

        if ( $isTesting ) {
            self::schemaTools(entityManager: $entityManager);
        }

        return $entityManager;
    }

    private function getTestingDbParams(): array
    {
        return [
            'driver' => 'pdo_sqlite',
            'memory' => true,
        ];
    }

    private function getDbParams(): array
    {
        return [
            'driver' => 'pdo_mysql',
            'host' => $_ENV['DB_HOST'],
            'user' => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASSWORD'],
            'dbname' => $_ENV['DB_NAME'],
        ];
    }

    /**
     * @throws Exception
     */
    private function connection(array $dbParams)
    {
        return DriverManager::getConnection($dbParams, self::configuration());
    }

    private function configuration(): Configuration
    {
        $paths = __DIR__ . "/../../../../../src/Infrastructure/Persistence/Doctrine/Mapping/";
        return ORMSetup::createAttributeMetadataConfiguration([$paths], true);
    }

    /**
     * @throws ToolsException
     */
    private function schemaTools(EntityManager $entityManager): void
    {
        $schemaTool = new SchemaTool($entityManager);
        $metadata = $entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool->createSchema($metadata);
    }
}