<?php
/**
 * Created by PhpStorm.
 * User: Umut
 * Date: 22.02.2019
 * Time: 10:44
 */

class Movie
{
    private $title;
    private $year;
    private $released;
    private $runtime;
    private $genre;
    private $director;
    private $actors;
    private $plot;
    private $language;
    private $country;

    /**
     * Film constructor.
     * @param $title
     * @param $year
     * @param $released
     * @param $runtime
     * @param $genre
     * @param $director
     * @param $actors
     * @param $plot
     * @param $language
     * @param $country
     */
    public function __construct($title, $year, $released, $runtime, $genre, $director, $actors, $plot, $language, $country)
    {
        $this->title = $title;
        $this->year = $year;
        $this->released = $released;
        $this->runtime = $runtime;
        $this->genre = $genre;
        $this->director = $director;
        $this->actors = $actors;
        $this->plot = $plot;
        $this->language = $language;
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return Movie
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param mixed $year
     * @return Movie
     */
    public function setYear($year)
    {
        $this->year = $year;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReleased()
    {
        return $this->released;
    }

    /**
     * @param mixed $released
     * @return Movie
     */
    public function setReleased($released)
    {
        $this->released = $released;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRuntime()
    {
        return $this->runtime;
    }

    /**
     * @param mixed $runtime
     * @return Movie
     */
    public function setRuntime($runtime)
    {
        $this->runtime = $runtime;
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
     * @return Movie
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDirector()
    {
        return $this->director;
    }

    /**
     * @param mixed $director
     * @return Movie
     */
    public function setDirector($director)
    {
        $this->director = $director;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getActors()
    {
        return $this->actors;
    }

    /**
     * @param mixed $actors
     * @return Movie
     */
    public function setActors($actors)
    {
        $this->actors = $actors;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPlot()
    {
        return $this->plot;
    }

    /**
     * @param mixed $plot
     * @return Movie
     */
    public function setPlot($plot)
    {
        $this->plot = $plot;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param mixed $language
     * @return Movie
     */
    public function setLanguage($language)
    {
        $this->language = $language;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     * @return Movie
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

}

