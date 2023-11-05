<?php

class Hotel
{
    public string $name;
    public string $address;
    public int $grade;
    public string $imgSrc;
    public int $postingDate;
    public string $hotelSrc;
    public string $price;

    public function __construct(string $name, string $address, int $grade,
                                string $imgSrc, int $postingDate, string $hotelSrc,
                                string $price)
    {
        $this->name = $name;
        $this->address = $address;
        $this->grade = $grade;
        $this->imgSrc = $imgSrc;
        $this->postingDate = $postingDate;
        $this->hotelSrc = $hotelSrc;
        $this->price = $price;
    }
}