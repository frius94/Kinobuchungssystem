<?php

require 'dbQueries.php';
if (isset($_GET['reservationId']) && filter_var($_GET['reservationId'], FILTER_SANITIZE_NUMBER_INT)) {

    $reservationId = filter_var($_GET['reservationId'], FILTER_SANITIZE_NUMBER_INT);

    $mysqli = connectDB();

    $getReservationQuery = "SELECT * FROM danie298_kinobuchung.show INNER JOIN reservation ON reservation.show_idshow = danie298_kinobuchung.show.idshow WHERE reservation.idreservation = $reservationId;";
    $reservation = $mysqli->query($getReservationQuery)->fetch_assoc();

    if ($reservation) {
        $movieId = $reservation['movie_idmovie'];
        $movieQuery = "SELECT title FROM movie WHERE idmovie = $movieId;";
        $movie = $mysqli->query($movieQuery)->fetch_assoc();

        $price = $reservation['price'];
        $time = $reservation['time'];
        $room = $reservation['room_idroom'];
        $title = $movie['title'];

        $getSeatsQuery = "SELECT seatnumber, row_letter FROM seat WHERE idseat IN (SELECT seat_idseat FROM reserved_seats WHERE reservation_idreservation = $reservationId);";
        $seats = $mysqli->query($getSeatsQuery)->fetch_all();
        $seatIds = $seats[0];
        $rows = $seats[1];

        echo "<table class=\"table table-striped table-dark\">
  <thead>
    <tr>
      <th scope=\"col\">Film</th>
      <th scope=\"col\">Datum &amp; Zeit</th>
      <th scope=\"col\">Preis</th>
      <th scope=\"col\">Raum</th>
      <th scope=\"col\">Sitze</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>$title</td>
      <td>$time</td>
      <td>$price</td><td>";
        foreach ($rows as $row) {
            echo "$row, ";
        }
        echo "</td>
    </tr>
  </tbody>
</table>";

    } else {
        echo "Ihre Reservation konnte nicht gefunden werden.";
    }
}