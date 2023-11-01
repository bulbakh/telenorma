<?php

namespace Bulbakh\Telenorma\Models;

class Worker extends Entity
{
    public function __construct()
    {
        $this->table = 'worker';
        parent::__construct();
    }

    /**
     * @return array|bool
     */
    public function selectWithPosition(): array|bool
    {
        return $this->db->execute('
        SELECT worker.*, position.name position_name 
        FROM worker 
        JOIN position on worker.position_id = position.id 
        ORDER BY id');
    }

    /**
     * @param array $params
     * @return bool
     */
    public function save(array $params): bool
    {
        $worker = [
            'id' => $params['id'] ?? null,
            'name' => $params['name'] ?? null,
            'last_name' => $params['last_name'] ?? null,
            'position_id' => $params['position'] ?? null,
        ];
        if ($worker['id']) {
            return $this->db->update($this->table, $worker, ['id' => $worker['id']]);
        } else {
            return $this->db->insert($this->table, $worker);
        }
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }
}
