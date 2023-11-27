<?php

namespace Core\Infrastructure\Persistence\MongoDb\Helpers;

use MongoDB\BSON\ObjectId;
use MongoDB\Client;
use MongoDB\Collection;
use MongoDB\Driver\ServerApi;

class MongoHelper
{
    private ?Client $client = null;

    public function connect(): void
    {
        $apiVersion = new ServerApi(ServerApi::V1);
        $this->client = new Client(getenv('MONGODB_URI'), [], ['serverApi' => $apiVersion]);
    }

    public function disconnect(): void
    {
        $this->client = null;
    }

    public function getCollection(string $name): Collection
    {
        if ( !$this->client ) {
            $this->connect();
        }

        return $this->client->selectDatabase(getenv('MONGODB_DATABASE'))->selectCollection($name);
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