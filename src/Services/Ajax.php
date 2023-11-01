<?php

namespace Bulbakh\Telenorma\Services;

use Bulbakh\Telenorma\Models\Position;
use Bulbakh\Telenorma\Models\Worker;
use Bulbakh\Telenorma\Helpers\JsonHelper;
use Exception;
use PDOException;

class Ajax
{
    private ?string $entity;
    private ?string $method;
    private ?string $id;
    private ?array $params;

    public function __construct($request)
    {
        $this->entity = $request['entity'] ?? null;
        $this->method = $request['method'] ?? null;
        $this->id = $request['id'] ?? null;
        $this->params = $request ?? null;
    }

    /**
     * @return bool|string
     */
    public function validate(): bool|string
    {
        if (!$this->entity || !$this->method) {
            return 'Entity and method are required';
        }

        if ($this->method == 'get' && !$this->id) {
            return 'Id for method get is required';
        }
        return true;
    }

    /**
     * @return string
     */
    public function getData(): string
    {
        switch ($this->entity) {
            case 'worker':
                $model = new Worker();
                break;
            case 'position':
                $model = new Position();
                break;
        }

        if (isset($model)) {
            try {
                switch ($this->method) {
                    case 'select':
                        $response = $model->select();
                        break;
                    case 'selectWithPosition':
                        $response = $model->selectWithPosition();
                        break;
                    case 'get':
                        $response = $model->get($this->id);
                        break;
                    case 'save':
                        $response = $model->save($this->params);
                        break;
                    case 'delete':
                        $response = $model->delete($this->id);
                        break;
                    default:
                        return $this->getResponse('ERROR', 'Not Implemented');
                }
                return $this->getResponse('OK', $response);
            } catch (PDOException) {
                return $this->getResponse('ERROR', "Database error");
            } catch (Exception $e) {
                return $this->getResponse('ERROR', $e->getMessage());
            }
        }
        return $this->getResponse('ERROR', 'Not Implemented');
    }

    public function getResponse(string $status, array|string $data): string
    {
        $data = !is_array($data) ? [$data] : $data;
        return JsonHelper::toJson(['status' => $status, 'data' => $data]);
    }
}
