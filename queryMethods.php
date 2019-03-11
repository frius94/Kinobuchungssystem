<?php
/**
 * Created by PhpStorm.
 * User: Umut
 * Date: 08.03.2019
 * Time: 11:14
 */

/**
 * @param mysqli $mysqli
 */
function createRows(mysqli $mysqli)
{
    $primaryKey = 1;
    for ($i = 1; $i <= 4; $i++) {
        for ($c = 'A'; $c <= 'F'; $c++) {
            $sql = "INSERT IGNORE INTO danie298_kinobuchung.row (idrow, row_letter, room_idroom) VALUES ($primaryKey, '$c', $i);";
            $mysqli->query($sql);
            $primaryKey++;
        }
    }
}

/**
 * @param mysqli $mysqli
 */
function createRooms(mysqli $mysqli)
{
    for ($i = 1; $i <= 4; $i++) {
        $sql = "INSERT IGNORE INTO room (idroom) VALUES ($i);";
        $mysqli->query($sql);
    }
}

/**
 * @param mysqli $mysqli
 */
function createSeats(mysqli $mysqli)
{
    $primaryKey = 1;
    $countRowsQuery = "SELECT count(*) from danie298_kinobuchung.row;";
    $countRows = $mysqli->query($countRowsQuery);
    $countRows = $countRows->fetch_array()[0];
    for ($row = 1; $row <= $countRows; $row++) {
        for ($i = 1; $i <= 10; $i++) {
            $sql = "INSERT IGNORE INTO seat (idseat, seatnumber, row_idrow) VALUES ($primaryKey, $i , $row);";
            $mysqli->query($sql);
            $primaryKey++;
        }
    }
}