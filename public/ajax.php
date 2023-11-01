<?php

require_once('../vendor/autoload.php');

use Bulbakh\Telenorma\Services\Ajax;

$Ajax = new Ajax($_REQUEST);

$validate = $Ajax->validate();
if ($validate !== true) {
    echo $Ajax->getResponse('ERROR', $validate);
    die;
}

echo $Ajax->getData();