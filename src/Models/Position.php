<?php

namespace Bulbakh\Telenorma\Models;

class Position extends Entity
{
    public function __construct()
    {
        $this->table = 'position';
        parent::__construct();
    }
}
