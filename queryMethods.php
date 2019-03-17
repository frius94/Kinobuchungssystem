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

/**
 * @return mysqli
 */
function connectDB()
{
    $dbdata = json_decode(file_get_contents("dbdata.json"), true);

    $host = $dbdata['host'];
    $username = $dbdata['username'];
    $password = $dbdata['pw'];
    $dbname = $dbdata['dbname'];

    $mysqli = new mysqli($host, $username, $password, $dbname);
    if ($mysqli->connect_error) {
        die("Es konnte keine Verbindung zur Datenbank hergestellt werden. Bitte kontaktieren Sie unseren Support unter +41786041237\n" . $mysqli->connect_error);
    }
    return $mysqli;
}

/**
 * @param $mysqli
 * @param $movies
 * @param $i
 */
function createMovie(mysqli $mysqli, $movies, $i)
{
    $dateTime = DateTime::createFromFormat("d M Y", $movies[$i]->getReleased());
    $sql = "INSERT IGNORE INTO `movie` (title, year, released, runtime, genre, plot, language) VALUES ('" . $movies[$i]->getTitle() . "', " . $movies[$i]->getYear() . ", '" . $dateTime->format('Y-m-d') . "', '" . $movies[$i]->getRuntime() . "', '" . $movies[$i]->getGenre() . "', '" . addslashes($movies[$i]->getPlot()) . "', '" . $movies[$i]->getLanguage() . "')";
    $mysqli->query($sql);
}

/**
 * @param $mysqli
 * @param $row
 * @return int
 */
function getAvailableSeats(mysqli $mysqli, $row)
{
    $availableSeatsQuery = "SELECT count(seat.occupied) FROM seat INNER JOIN danie298_kinobuchung.row ON danie298_kinobuchung.row.idrow = seat.row_idrow INNER JOIN room ON room.idroom = danie298_kinobuchung.row.room_idroom INNER JOIN danie298_kinobuchung.show ON show.room_idroom = room.idroom INNER JOIN reservation ON reservation.show_idshow = danie298_kinobuchung.show.idshow WHERE danie298_kinobuchung.seat.occupied = 0 AND show.idshow = " . $row['idshow'] . ";";
    $availableSeats = $mysqli->query($availableSeatsQuery)->fetch_assoc()['count(seat.occupied)'];
    if ($availableSeats == 0)
        $availableSeats = 60;
    return $availableSeats;
}

/**
 * @param mysqli $mysqli
 * @param $movies
 * @param $movieTitles
 * @param $i
 */
function printShow(mysqli $mysqli, $movies, $movieTitles, $i)
{
    $showQuery = "SELECT * FROM danie298_kinobuchung.show INNER JOIN danie298_kinobuchung.movie ON danie298_kinobuchung.show.movie_idmovie = movie.idmovie WHERE movie.title = '" . $movies[$i]->getTitle() . "' ORDER BY room_idroom;";
    if ($shows = $mysqli->query($showQuery)) {

        /* fetch associative array */
        while ($row = $shows->fetch_assoc()) {

            $availableSeats = getAvailableSeats($mysqli, $row);

            try {
                $dateTime = new DateTime($row['time']);
                $dateTime = $dateTime->format('d.m.Y H:i');
            } catch (Exception $e) {
                echo "Ein Fehler ist aufgetreten" . $e;
            }

            echo "<a href=\"https://kinobuchung.ch/reservation.php?name=" . urlencode($movieTitles[$i]) . "&room=" . $row['room_idroom'] . "&showid=" . $row['idshow'] . "\" class=\"list-group-item list-group-item-action list-group-item-secondary\">
                    Raum <span class=\"badge badge-primary badge-pill float-right\">" . $row['room_idroom'] . "</span><br>
                    Datum & Zeit <span class=\"badge badge-primary badge-pill float-right\">" . $dateTime . "</span><br>
                    verfügbare Plätze<span class=\"badge badge-primary badge-pill float-right\">$availableSeats</span></a>";
        }
        /* free result set */
        $shows->free();
    }
    echo "</div></div></div>";
}

/**
 * @param $movies
 * @param $movieTitles
 * @param $i
 */
function printMovie($movies, $movieTitles, $i)
{
    echo "<div class=\"card text-white\" id='$movieTitles[$i]' onclick='showShows(this)' onmouseleave='showInfo(this)'>
                    <img src=\"media/" . $movieTitles[$i] . ".jpg" . "\" class=\"card-img-top\" alt=\"movie picture\">
                    <div class='card-img-overlay ovl'>
                    <div class=\"card-body\">
                        <h5 class=\"card-title scaleTitle\">" . $movies[$i]->getTitle() . "</h5>
                       <p class='card-text font-weight-bold mb-0 scale'>Veröffentlichung</p><p class='scale'>" . $movies[$i]->getReleased() . "</p>
                       <p class='card-text font-weight-bold mb-0 scale'>Dauer</p><p class='scale'>" . $movies[$i]->getRuntime() . "</p>
                       <p class='card-text font-weight-bold mb-0 scale'>Genre</p><p class='scale'>" . $movies[$i]->getGenre() . "</p>
                       <p class='card-text font-weight-bold mb-0 scale'>Regisseur</p><p class='scale'>" . $movies[$i]->getDirector() . "</p>
                       <p class='card-text font-weight-bold mb-0 scale'>Schauspieler</p><p class='scale'>" . $movies[$i]->getActors() . "</p>
                    </div>
                    <div class=\"list-group d-none\">
                        <h5 class='card-title scaleTitle'>Wählen Sie eine Vorstellung aus.</h5>";
}