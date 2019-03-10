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

function createRooms(mysqli $mysqli)
{
    for ($i = 1; $i <= 4; $i++) {
        $sql = "INSERT IGNORE INTO rooms (idroom) VALUES ($i);";
        $mysqli->query($sql);
    }
}
//fix this
function createSeats(mysqli $mysqli)
{
    $primaryKey = 1;
    $countRowsQuery = "SELECT count(*) from danie298_kinobuchung.row;";
    $countRows = $mysqli->query($countRowsQuery);
    for ($row = 1; $row <= $countRows; $row++) {
        for ($i = 1; $i <= 10; $i++) {
            $sql = "INSERT IGNORE INTO seat (idseat, row_idrow) VALUES ($primaryKey, $i);";
            $mysqli->query($sql);
            $primaryKey++;
        }
    }
}