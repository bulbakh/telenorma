<?php

namespace Bulbakh\Telenorma\Core;

interface EntityInterface
{
    public function select(array $where): array|bool;
    public function get(array $where): array;
}
