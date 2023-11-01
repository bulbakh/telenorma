<?php

require_once('../vendor/autoload.php');

use Bulbakh\Telenorma\Helpers\HtmlHelper;
use Bulbakh\Telenorma\Models\Position;

echo HtmlHelper::head(
    HtmlHelper::script('https://code.jquery.com/jquery-3.3.1.js') .
    HtmlHelper::script('js/ajax.js') .
    HtmlHelper::css('css/style.css')
);

$Position = new Position();
$positions = $Position->select();

$selectPositions = ['0' => 'Please select'];
foreach ($positions as $position) {
    $selectPositions[$position['id']] = $position['name'];
}

echo HtmlHelper::button('Add', ['id' => 'add']);

echo HtmlHelper::form(HtmlHelper::input('', ['type' => 'hidden', 'name' => 'id', 'id' => 'id'])
    . HtmlHelper::br() . HtmlHelper::input('Name', ['type' => 'text', 'name' => 'name', 'id' => 'name', 'required' => 'required'])
    . HtmlHelper::br() . HtmlHelper::input('Last Name', ['type' => 'text', 'name' => 'last_name', 'id' => 'last_name', 'required' => 'required'])
    . HtmlHelper::br() . HtmlHelper::select('Position', $selectPositions, ['name' => 'position', 'id' => 'position', 'required' => 'required'])
    . HtmlHelper::br() . HtmlHelper::submit('ОК') . HtmlHelper::button('Cancel', ['id' => 'cancel']),
    ['id' => 'workerform', 'method' => 'post']);

echo htmlHelper::table('');
