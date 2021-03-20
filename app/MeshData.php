<?php

namespace App;

use Jupitern\CosmosDb\CosmosDb;
use Jupitern\CosmosDb\QueryBuilder;
use App\Monkeypatch\CosmosDb\QueryBuilderCustom;

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
     * 検索データを取得
     *
     * @param array $filters
     * @param string $order
     * @return $res
     */
    public function findSearch(array $filters, string $order = 'c.time DESC')
    {
        $where = '';
        $params = [];
        if (isset($filters['time']) && !empty($filters['time'])) {
            $where .= 'c.time >= @time_start and c.time <= @time_end';
            $params['@time_start'] = "{$filters['time']} 00:00:00";
            $params['@time_end'] = "{$filters['time']} 23:59:59";
        }
        $res = QueryBuilderCustom::instance()
            ->setCollection($this->collection)
            ->select('c.id, c.time, c.temp, c.humid')
            ->where($where)
            ->params($params)
            ->order($order)
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
