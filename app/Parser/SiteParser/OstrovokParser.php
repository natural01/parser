<?php

class OstrovokParser extends ApiParser
{
    private string $baseUrl = "https://ostrovok.ru";
    private string $url;
    private int $countHotelsReceived = 100;
    private int $page = 1;
    private int $cityId = 5580;
    private array $hotels;
    private string $guid;
    private string $dateStart;
    private string $dateFinish;

    public function __construct($dateStart, $dateFinish, $city = "Сочи")
    {
        $this->dateStart = $dateStart;
        $this->dateFinish = $dateFinish;
        $this->guid = $this->uuidGenerate();
        $this->url = $this->baseUrl . "/hotel/search/v2/site/serp?session=" . $this->guid;
    }

    public function parse()
    {
        for ($page = 0; $page < $this->countHotelsReceived / 20; $page++)
        {
            foreach (parent::requestAPI($this->url, "POST", $this->getPostRequestBody())->hotels as $value)
            {
                $this->hotels[][] = new Hotel(
                    $value->static_vm->name_en,
                    $value->static_vm->address,
                    $value->static_vm->rating->total,
                    $this->getImgUrl($value->static_vm->images[0]->tmpl),
                    0,
                    $this->getHotelUrl($value)
                );
            }
            $this->page++;
        }
        $this->page = 0;
        print_r($this->hotels);
    }

    private function uuidGenerate()
    {
        $data = random_bytes(16);
        assert(strlen($data) == 16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    private function getPostRequestBody()
    {
        $request = array(
            "session_params" => array(
                "currency" => "RUB",
                "language" => "ru",
                "search_uuid" => $this->uuidGenerate(),
                "arrival_date" => $this->dateStart,
                "departure_date" => $this->dateFinish,
                "region_id" => $this->cityId,
                "paxes" => array(array(
                    "adults" => 1
                )),
            ),
            "page" => $this->page,
            "map_hotels" => false,
            "session_id" => $this->guid
        );
        return json_encode($request);
    }

    private function getImgUrl($url)
    {
        return substr($url, 0, 27) . "640x400" . substr($url, 33, strlen($url));
    }

    private function getHotelUrl($hotel)
    {
        return $this->baseUrl . "/hotel/russia/sochi/mid"
            . $hotel->master_id . "/" . $hotel->ota_hotel_id . "/?dates="
            . $this->reverseDate($this->dateStart) . "-" . $this->reverseDate($this->dateFinish) . "&"
            . "guests=1&price=one&q=" . $hotel->static_vm->region_id . "&sid="
            . $this->uuidGenerate() . "&room=" . $hotel->rates[0]->shash
            . "&serp_price=" . $hotel->ota_hotel_id . "."
            . $hotel->rates[0]->payment_options->payment_types[0]->amount . "."
            . $hotel->rates[0]->payment_options->payment_types[0]->currency_code . "."
            . $hotel->rates[0]->hash;
    }

    private function reverseDate($date)
    {
        return substr($date, 8, strlen($date)) . "."
            . substr($date, 5, 2) . "."
            . substr($date, 0, 4);
    }
}