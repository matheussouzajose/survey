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

class EntityManagerHelperSingleton
{
    protected static EntityManager $entityManagerInstance;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /**
     * @throws MissingMappingDriverImplementation
     * @throws ToolsException
     * @throws \Exception
     */
    public static function getInstance(): EntityManager
    {
        if ( empty(self::$entityManagerInstance) ) {
            self::$entityManagerInstance = self::getEntityManager();
        }

        return self::$entityManagerInstance;
    }

    /**
     * @throws MissingMappingDriverImplementation
     * @throws Exception
     * @throws ToolsException
     */
    private static function getEntityManager(): EntityManager
    {
        $isTesting = getenv('APP_ENV') === 'testing';
        $dbParams = $isTesting ? self::getTestingDbParams() : self::getDbParams();

        $entityManager = new EntityManager(self::connection(dbParams: $dbParams), self::configuration());

//        if ( $isTesting ) {
//            self::schemaTools(entityManager: $entityManager);
//        }

        return $entityManager;
    }

    private static function getTestingDbParams(): array
    {
        return [
            'driver' => 'pdo_sqlite',
            'memory' => true,
        ];
    }

    private static function getDbParams(): array
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
    private static function connection(array $dbParams)
    {
        return DriverManager::getConnection($dbParams, self::configuration());
    }

    private static function configuration(): Configuration
    {
        $paths = __DIR__ . "/../../../../../src/Infrastructure/Persistence/Doctrine/Mapping/";
        return ORMSetup::createAttributeMetadataConfiguration([$paths], true);
    }


    /**
     * @throws ToolsException
     */
    private static function schemaTools(EntityManager $entityManager): void
    {
        $schemaTool = new SchemaTool($entityManager);
        $metadata = $entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool->createSchema($metadata);
    }
}