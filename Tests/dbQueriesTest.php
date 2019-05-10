<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

require '../dbQueries.php';

class dbQueriesTest extends TestCase
{

    public function testCreateRooms() {
        $this->assertEquals(true, createRooms(connectDB()));
    }

    public function testCreateSeats() {
        $this->assertEquals(true, createSeats(connectDB()));
    }

    public function testConnectDB() {
        $this->assertNotNull(connectDB());
    }

    public function testCreateMovie() {
        $movieTitles = ['Harry Potter', 'Hunger games', 'Thor', 'Spider-man', 'Transformers', 'It', 'The matrix', 'Finding nemo', 'Toy story'];
        $this->assertEquals(true, createMovie(connectDB(), \Movie::getMovies($movieTitles), 1));
    }

    public function testGetAvailableSeats() {
        $this->assertIsInt(getAvailableSeats(connectDB(), 2));
    }

    public function testGetSeatIds() {
        $this->assertIsArray(getSeatIds(connectDB(), 1));
    }
}
