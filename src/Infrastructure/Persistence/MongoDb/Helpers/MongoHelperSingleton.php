<?php

namespace Core\Infrastructure\Persistence\MongoDb\Helpers;

use MongoDB\BSON\ObjectId;
use MongoDB\Client;
use MongoDB\Collection;
use MongoDB\Driver\ServerApi;

class MongoHelperSingleton
{
    protected static ?Client $client = null;

    public function __construct()
    {
    }

    public function __clone(): void
    {
    }

    /**
     * @throws \Exception
     */
    public static function getClient(): Client
    {
        if ( empty(self::$client) ) {
            self::$client = self::connect();
        }

        return self::$client;
    }

    public static function connect(): Client
    {
        $apiVersion = new ServerApi(ServerApi::V1);
        return new Client(getenv('MONGODB_URI'), [], ['serverApi' => $apiVersion]);
    }

    public function disconnect(): void
    {
        self::$client = null;
    }

    /**
     * @throws \Exception
     */
    public static function getCollection(string $name): Collection
    {
        return self::getClient()->selectDatabase(getenv('MONGODB_DATABASE'))->selectCollection($name);
    }

    public function map($data): array
    {
        $data = ['id' => (string)$data['_id'], ...$data];
        unset($data['_id']);

        return $data;
    }

    public function mapCollection($collection): array
    {
        return array_map(function ($item) {
            return $this->map($item);
        }, $collection->toArray());
    }

    public function objectId(string $id): ObjectId
    {
        return new ObjectId($id);
    }
}