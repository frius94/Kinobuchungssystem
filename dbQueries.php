<?php

/**
 * Create the rooms in the database if they do not exist
 * @param mysqli $mysqli
 * @return bool
 */
function createRooms(mysqli $mysqli)
{
    for ($i = 1; $i <= 4; $i++) {
        $sql = "INSERT IGNORE INTO room (idroom) VALUES ($i);";
        $result = $mysqli->query($sql);
    }
    if (isset($result))
        return true;
    return false;
}

/**
 * Create the seats in the database if they do not exist
 * @param mysqli $mysqli
 * @return bool
 */
function createSeats(mysqli $mysqli)
{
    $success = true;
    $primaryKey = 1;
    for ($roomId = 1; $roomId <= 4; $roomId++) {
        for ($row = 'A'; $row <= 'F'; $row++) {
            for ($seatNumber = 1; $seatNumber <= 10; $seatNumber++) {
                $query = "INSERT IGNORE INTO seat (idseat, seatnumber, row_letter, room_idroom) VALUES ($primaryKey, $seatNumber , '$row', $roomId);";
                $result = $mysqli->query($query);
                if (!$result)
                    $success = false;
                $primaryKey++;
            }
        }
    }
    return $success;
}

/**
 * Connect to the database with the credentials from json file
 * @return mysqli
 */
function connectDB()
{
    $dbdata = json_decode(file_get_contents(__DIR__ . "/dbdata.json"), true);

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
 * Create the movies in the database if they do not exist
 * @param $mysqli
 * @param $movies
 * @param $i
 * @return bool
 */
function createMovie(mysqli $mysqli, $movies, $i)
{
    $dateTime = DateTime::createFromFormat("d M Y", $movies[$i]->getReleased());
    $sql = "INSERT IGNORE INTO `movie` (title, year, released, runtime, genre, plot, language) VALUES ('" . $movies[$i]->getTitle() . "', " . $movies[$i]->getYear() . ", '" . $dateTime->format('Y-m-d') . "', '" . $movies[$i]->getRuntime() . "', '" . $movies[$i]->getGenre() . "', '" . addslashes($movies[$i]->getPlot()) . "', '" . $movies[$i]->getLanguage() . "')";
    $result = $mysqli->query($sql);

    if ($result)
        return true;
    return false;
}

/**
 * Get the available seats for the according show
 * @param $mysqli
 * @param $row
 * @return int
 */
function getAvailableSeats(mysqli $mysqli, $row)
{
    $availableSeatsQuery = "SELECT count(*) FROM reserved_seats INNER JOIN reservation ON reservation_idreservation = idreservation INNER JOIN danie298_kinobuchung.show ON show_idshow = idshow WHERE idshow = " . $row['idshow'] . ";";
    $availableSeats = $mysqli->query($availableSeatsQuery)->fetch_assoc()['count(*)'];
    return 60 - $availableSeats;
}

/**
 * Get the show information from the database and print it
 * @param mysqli $mysqli
 * @param $movies
 * @param $movieTitles
 * @param $i
 */
function printShow(mysqli $mysqli, $movies, $movieTitles, $i)
{
    $showQuery = "SELECT * FROM danie298_kinobuchung.show INNER JOIN danie298_kinobuchung.movie ON danie298_kinobuchung.show.movie_idmovie = movie.idmovie WHERE movie.title = '" . $movies[$i]->getTitle() . "' ORDER BY room_idroom;";
    if ($mysqli->query($showQuery)) {

        $shows = $mysqli->query($showQuery);

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
 * Get the movie information from the database and print it
 * @param $movies
 * @param $movieTitles
 * @param $i
 */
function printMovie($movies, $movieTitles, $i)
{
    echo "<div class=\"card text-white\" id='$movieTitles[$i]' onclick='showShows(this)' onmouseleave='showInfo(this)'>
                    <img src=\"media/" . $movieTitles[$i] . ".jpg\" class=\"card-img-top\" alt=\"movie picture\">
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

/**
 * Get the seat availability information from the database with the show ID
 * Print a black seat if it is not occupied, otherwise print a gray seat
 * @param mysqli $mysqli
 */
function printSeats(mysqli $mysqli)
{
    $showId = $mysqli->real_escape_string($_GET['showid']);
    $showId = htmlspecialchars($showId);
    $showId = strip_tags($showId);
    $reservedIdSeatsQuery = "SELECT idseat FROM seat INNER JOIN reserved_seats ON idseat = seat_idseat INNER JOIN reservation ON reservation_idreservation = idreservation WHERE show_idshow = " . $showId . ";";
    $reservedSeats = $mysqli->query($reservedIdSeatsQuery)->fetch_all();
    $seatIds = getSeatIds($mysqli, $showId);
    $seatCounter = 0;

    foreach (range('A', 'F') as $c) {
        echo "<tr><th class='align-middle'>$c</th>";

        for ($seatNumber = 1; $seatNumber <= 10; $seatNumber++) {
            $id = $c . $seatNumber;
            $occupied = false;

            foreach ($reservedSeats as $reservedSeat) {
                if (in_array($reservedSeat[0], $seatIds[$seatCounter]))
                    $occupied = true;
            }

            if ($occupied) {
                echo "<td><a href='#'><img id='$id' src='media/seatGray.png' class='img-fluid' alt='" . $seatIds[$seatCounter][0] . "' onclick='fillSeat(this)'></a>" . $seatNumber . "</td>";
            } else {
                echo "<td><a href='#'><img id='$id' src='media/seatBlack.png' class='img-fluid' alt='" . $seatIds[$seatCounter][0] . "' onclick='fillSeat(this)'></a>" . $seatNumber . "</td>";
            }
            $seatCounter++;
        }
        echo "</tr>";
    }
}

/**
 * Return the seat IDs of the according show
 * @param mysqli $mysqli
 * @param $showId
 * @return mixed
 */
function getSeatIds(mysqli $mysqli, $showId)
{
    $query = "SELECT idseat FROM seat INNER JOIN room ON seat.room_idroom = idroom INNER JOIN danie298_kinobuchung.show AS s ON s.room_idroom = idroom WHERE idshow = $showId;";
    return $mysqli->query($query)->fetch_all();
}