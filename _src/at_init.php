<?php

// INIT AT API

require __DIR__.'/../vendor/autoload.php';

$ATPTENV = getenv('MIG_AT_PT');
$ATMGB = getenv('MIG_AT_B');

use \TANIOS\Airtable\Airtable;

$airtable = new Airtable(array(
    'api_key' => $ATPTENV,        // API PT
    'base'    => $ATMGB           // Migrapreneur Base

));


?>
