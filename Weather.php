<?php
/**
 * Created by PhpStorm.
 * User: Umut
 * Date: 01.03.2019
 * Time: 10:47
 */

class Weather
{
    private $date;
    private $description;
    private $city;

    /**
     * Weather constructor.
     * @param $date
     * @param $description
     * @param $city
     */
    public function __construct($date, $description, $city)
    {
        $this->date = $date;
        $this->description = $description;
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     * @return Weather
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return Weather
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     * @return Weather
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }
}