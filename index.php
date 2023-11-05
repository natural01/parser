<?php

require 'app/Model/Hotel.php';
require 'app/Parser/SiteParser/BronevikParser.php';
require 'app/Parser/SiteParser/OstrovokParser.php';
require 'app/Parser/ParsersStorage.php';
require 'app/DB/DataBase.php';

//$dateStart = $argv[1]; // example: "2023-12-01"
//$dateFinish = $argv[2]; // example: "2023-12-02"

$bronevikParser = new BronevikParser("2023-12-01", "2023-12-02");
$ostrovokParser = new OstrovokParser("2023-12-01", "2023-12-02");

$parsers = new ParsersStorage();
$parsers->addParser($bronevikParser);
$parsers->addParser($ostrovokParser);
$parsers->parse();

$db = new DataBase();

$hotels = [];
$prices = [];
$result = $db->getAllHotels();
while ($row = $result->fetch_assoc())
    $hotels[] = $row["name"];
$result = $db->getAllPrice();
while ($row = $result->fetch_assoc())
    if (!in_array($row["site"], $prices))
    {
        $prices[] = $row["site"];
    }

foreach ($parsers->getParsers() as $parser)
{
    $sitesUrl = "";
    $isSiteChecked = true;
    if (!in_array($parser->baseUrl, $prices))
    {
        $isSiteChecked = false;
        $sitesUrl = $parser->baseUrl;
        $hotels[] = $sitesUrl;
    }
    foreach ($parser->getHotels() as $hotel)
    {
        var_dump($hotel);
//        echo $hotel[0]->name . " " . $hotel[0]->price . PHP_EOL;

        if (!in_array($hotel[0]->name, $hotels))
        {
            $db->addHotel($hotel[0]);
            $hotels[] = $hotel[0]->name;
        }
        if(!$isSiteChecked)
        {
            $db->addPrice($sitesUrl, $hotel[0]);
        }
    }
    $isSiteChecked = true;
}