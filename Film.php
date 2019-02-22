<?php
/**
 * Created by PhpStorm.
 * User: Umut
 * Date: 22.02.2019
 * Time: 10:44
 */

class Film
{
    protected $name;
    protected $genre;
    protected $releaseDate;
    protected $minimumAge;

    /**
     * Film constructor.
     * @param $name
     * @param $genre
     * @param $releaseDate
     * @param $minimumAge
     */
    public function __construct($name, $genre, $releaseDate, $minimumAge)
    {
        $this->name = $name;
        $this->genre = $genre;
        $this->releaseDate = $releaseDate;
        $this->minimumAge = $minimumAge;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Film
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @param mixed $genre
     * @return Film
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * @param mixed $releaseDate
     * @return Film
     */
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMinimumAge()
    {
        return $this->minimumAge;
    }

    /**
     * @param mixed $minimumAge
     * @return Film
     */
    public function setMinimumAge($minimumAge)
    {
        $this->minimumAge = $minimumAge;
        return $this;
    }


}

