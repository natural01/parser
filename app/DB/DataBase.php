<?php

class DataBase
{
    private $db;

    public function __construct()
    {
        $this->db = new mysqli('localhost:8889', 'root', 'root', 'parser');
        if ($this->db->connect_error)
        {
            echo mysqli_connect_error();
            exit();
        }
    }

    public function getAllPrice()
    {
        return $this->db->query("SELECT * FROM `price`");
    }

    public function getPriceByName($name)
    {
        $name = str_replace('"', '\'', $name);
        return $this->db->query("SELECT * FROM `price` WHERE `name` = \"$name\"");
    }

    public function addPrice($baseUrl, &$hotel)
    {
        $site = $baseUrl;
        $name = str_replace('"', '\'', $hotel->name);
        $price = str_replace('"', '\'', $hotel->price);
        $this->db->query("INSERT INTO `price` (`name`, `site`, `price`) VALUES (\"$name\", \"$site\", \"$price\")");
    }

    public function deletePrice($name)
    {
        $updatedName = str_replace('"', '\'', $name);
        $this->db->query("DELETE FROM `price` WHERE `name` = \"$updatedName\"");
    }

    public function getAllHotels()
    {
        return $this->db->query("SELECT * FROM `hotel`");
    }

    public function getHotelByName($name)
    {
        $updatedName = str_replace('"', '\'', $name);
        return $this->db->query("SELECT * FROM `hotel` WHERE `name` = \"$updatedName\"");
    }

    public function addHotel($hotel)
    {
        $name = str_replace('"', '\'', $hotel->name);
        $address = str_replace('"', '\'', $hotel->address);
        $grade = $hotel->grade;
        $imgSrc = $hotel->imgSrc;
        $postingDate = $hotel->postingDate;
        $hotelSrc = $hotel->hotelSrc;
        $this->db->query("INSERT INTO `hotel` (`name`, `address`, `grade`, `imgSrc`, `postingDate`, `hotelSrc`) VALUES (\"$name\", \"$address\", $grade, \"$imgSrc\", $postingDate, \"$hotelSrc\")");
    }

    public function deleteHotel($name)
    {
        $updatedName = str_replace('"', '\'', $name);
        $this->db->query("DELETE FROM `hotel` WHERE `name` = \"$updatedName\"");
    }
}