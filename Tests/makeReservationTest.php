<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

require '../makeReservation.php';

class makeReservationTest extends TestCase
{
    public function testInsertPerson()
    {
        $this->assertNotNull(insertPerson(connectDB(), "Peter", "Meier", "Musterstrasse", 15, "testmail@gmail.com", '+41793214567', 1));
    }

    public function testInsertCity()
    {
        $this->assertNotNull(insertCity(connectDB(), 'Zurich', 8000));
    }

    public function testGetPersonID()
    {
        $this->assertIsInt(getPersonID(connectDB(), 'Peter', 'Meier', '+41793214'));
    }

    public function testInsertReservation()
    {
        $this->assertNotNull(insertReservation(connectDB(), 1, 1));
    }

    public function testGetReservationID()
    {
        $this->assertNotNull(getReservationID(connectDB()));
    }

    public function testInsertReservedSeats()
    {
        $this->assertNotNull(insertReservedSeats(connectDB(), 1, 1));
    }
}
