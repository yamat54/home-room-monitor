<?php

namespace App;

use Jupitern\CosmosDb\CosmosDb;
use Jupitern\CosmosDb\QueryBuilder;

class MeshData
{
    private static string $db_name = 'MeshData';
    private static string $collection_name = 'MeshData';
    private $collection;

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $conn = new CosmosDb(env('COSMOSDB_ENDPOINT'), env('COSMOSDB_PRIMARY_KEY'));
        $conn->setHttpClientOptions(['verify' => false]); # optional: set guzzle client options.
        $db = $conn->selectDB(self::$db_name);
        $this->collection = $db->selectCollection(self::$collection_name);
    }

    /**
     * データを全件取得
     *
     * @param int $offset
     * @param int $limit
     * @param string @order
     * @return $res
     */
    public function findAll(int $offset = 0, int $limit = 24, string $order = 'c.time DESC')
    {
        $res = QueryBuilder::instance()
            ->setCollection($this->collection)
            ->select('c.id, c.time, c.temp, c.humid')
            ->order($order)
            ->limit($limit)
            ->findAll()
            ->toArray();

        return $res;
    }

    /**
     * データを取得(time)
     *
     * @param string $time
     * @return $res
     */
    public function find(string $time)
    {
        $res = QueryBuilder::instance()
            ->setCollection($this->collection)
            ->select('c.id, c.time , c.temp, c.humid')
            ->where('c.time = @time')
            ->params(['@time' => $time])
            ->find()
            ->toArray();

        return $res;
    }

    /**
     * データを保存(UPSERT)
     *
     * @param array $params
     * @return $rid
     */
    public function save(array $params)
    {
        if (!isset($params['id'])) {
            $params = array_merge($params, ['id' => md5(uniqid(rand(), true))]);
        }

        $rid = QueryBuilder::instance()
        ->setCollection($this->collection)
        ->save($params);

        return $rid;
    }

    /**
     * データを削除
     *
     * @param string $id
     * @return $res
     */
    public function delete(string $id)
    {
        $res = QueryBuilder::instance()
            ->setCollection($this->collection)
            ->where('c.id = @id')
            ->params(['@id' => $id])
            ->delete();

        return $res;
    }
}
