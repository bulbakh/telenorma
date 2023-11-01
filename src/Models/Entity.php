<?php

namespace Bulbakh\Telenorma\Models;

use Bulbakh\Telenorma\Core\Db;
use Bulbakh\Telenorma\Core\EntityInterface;
use Exception;

class Entity implements EntityInterface
{
    protected Db $db;
    protected string $table;

    public function __construct()
    {
        $this->db = new Db(HOST, USER, PASSWORD, DATABASE);
    }

    /**
     * @param array $where
     * @return array|bool
     */
    public function select(array $where = []): array|bool
    {
        return $this->db->select($this->table, $where);
    }

    /**
     * @throws Exception
     */
    public function get(array|int $where): array
    {
        if (is_int($where)) {
            $where = ['id' => $where];
        }

        $res = $this->select($where);

        if (count($res) > 1) {
            throw new Exception('More than one item selected');
        }
        return reset($res);
    }
}
