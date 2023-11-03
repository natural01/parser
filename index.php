<?php

require __DIR__ . '/vendor/autoload.php';
require 'app/Model/Hotel.php';
require 'app/Parser/SiteParser/BronevikParser.php';
require 'app/Parser/SiteParser/OstrovokParser.php';
require 'app/Parser/ParsersStorage.php';

//$dateStart = $argv[1]; // example: "2023-12-01"
//$dateFinish = $argv[2]; // example: "2023-12-02"

//$p = new ParsersStorage;

$parser = new OstrovokParser("2023-12-01", "2023-12-02");
$parser->parse();