<?php

class Hotel
{
    protected string $name;
    protected string $address;
    protected int $grade;
    protected string $imgSrc;
    protected string $postingDate;
    protected string $hotelSrc;

    public function __construct(string $name, string $address, int $grade,
                                string $imgSrc, int $postingDate, string $hotelSrc)
    {
        $this->name = $name;
        $this->address = $address;
        $this->grade = $grade;
        $this->imgSrc = $imgSrc;
        $this->postingDate = $postingDate;
        $this->hotelSrc = $hotelSrc;
    }
}