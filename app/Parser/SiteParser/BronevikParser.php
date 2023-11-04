<?php

require 'app/Parser/ApiParser.php';

class BronevikParser extends ApiParser
{
    public string $baseUrl = "https://bronevik.com";
    private string $url;
    private int $countHotelsReceived = 100;
    private int $cityId = 48;
    private array $hotels;

    public function __construct($dateStart, $dateFinish, $city = "Сочи")
    {
        $decode = urlencode($city);
        $this->url = $this->baseUrl . "/hotel/json/search/search.json.php?check_in=$dateStart&check_out=$dateFinish&target_id=$this->cityId&target_type=city&target_name=$decode&client_show=WWW&guests=1&page=1&limit=$this->countHotelsReceived&is_filtering=true&is_searching=true";
    }

    public function parse()
    {
        foreach (parent::requestAPI($this->url,"GET")->hotels as $value)
        {
            $this->hotels[][] = new Hotel(
                $value->dossier->name,
                $value->location->address,
                $value->reviews->rating,
                $this->baseUrl . $value->dossier->photos[0],
                !empty($value->lastBookingMinutes) ? $value->lastBookingMinutes : 0,
                $this->baseUrl . $value->dossier->url,
                $value->offers[0]->pricing->gross
            );
        }
    }

    public function getHotels()
    {
        return $this->hotels;
    }
}